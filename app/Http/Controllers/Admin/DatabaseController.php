<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DatabaseController extends Controller
{
    /**
     * Tables that back framework internals (sessions, queues, cache, migrations).
     * Still browsable, but flagged so it's obvious editing them can break the app.
     */
    private const SYSTEM_TABLES = [
        'migrations', 'sessions', 'cache', 'cache_locks',
        'jobs', 'job_batches', 'failed_jobs', 'password_reset_tokens',
    ];

    /**
     * Column types offered when creating a table or adding a field, mapped to
     * the Blueprint method used to create them.
     */
    public const COLUMN_TYPES = [
        'string' => 'String (short text)',
        'text' => 'Text (long)',
        'integer' => 'Integer',
        'bigInteger' => 'Big integer',
        'boolean' => 'Boolean',
        'decimal' => 'Decimal',
        'date' => 'Date',
        'datetime' => 'Date & time',
        'timestamp' => 'Timestamp',
    ];

    public function index(): View
    {
        $tables = collect(Schema::getTables())
            ->map(function ($table) {
                $name = $table['name'];

                return [
                    'name' => $name,
                    'columns' => count(Schema::getColumns($name)),
                    'rows' => DB::table($name)->count(),
                    'system' => in_array($name, self::SYSTEM_TABLES, true),
                ];
            })
            ->sortBy('name')
            ->values();

        return view('admin.database.index', compact('tables'));
    }

    public function show(Request $request, string $table): View
    {
        $this->ensureTableExists($table);

        $columns = Schema::getColumns($table);
        $primaryKey = $this->primaryKey($table);

        $query = DB::table($table);

        if ($primaryKey) {
            $query->orderByDesc($primaryKey);
        }

        $rows = $query->paginate(20)->withQueryString();

        return view('admin.database.show', [
            'table' => $table,
            'columns' => $columns,
            'primaryKey' => $primaryKey,
            'rows' => $rows,
            'isSystem' => in_array($table, self::SYSTEM_TABLES, true),
        ]);
    }

    public function create(string $table): View
    {
        $this->ensureTableExists($table);

        $columns = collect(Schema::getColumns($table))
            ->reject(fn ($column) => $column['auto_increment'])
            ->values();

        return view('admin.database.create', [
            'table' => $table,
            'columns' => $columns,
        ]);
    }

    public function store(Request $request, string $table): RedirectResponse
    {
        $this->ensureTableExists($table);

        $data = $this->extractColumnData($request, $table);

        DB::table($table)->insert($data);

        return redirect()->route('admin.database.show', $table)->with('status', 'Row created.');
    }

    public function edit(string $table, string $id): View
    {
        $this->ensureTableExists($table);
        $primaryKey = $this->primaryKey($table);
        abort_if(! $primaryKey, 404, 'This table has no primary key to edit by.');

        $row = DB::table($table)->where($primaryKey, $id)->first();
        abort_if(! $row, 404);

        $columns = collect(Schema::getColumns($table))
            ->reject(fn ($column) => $column['auto_increment'])
            ->values();

        return view('admin.database.edit', [
            'table' => $table,
            'columns' => $columns,
            'row' => $row,
            'primaryKey' => $primaryKey,
            'id' => $id,
        ]);
    }

    public function update(Request $request, string $table, string $id): RedirectResponse
    {
        $this->ensureTableExists($table);
        $primaryKey = $this->primaryKey($table);
        abort_if(! $primaryKey, 404);

        $data = $this->extractColumnData($request, $table);

        DB::table($table)->where($primaryKey, $id)->update($data);

        return redirect()->route('admin.database.show', $table)->with('status', 'Row updated.');
    }

    public function destroy(string $table, string $id): RedirectResponse
    {
        $this->ensureTableExists($table);
        $primaryKey = $this->primaryKey($table);
        abort_if(! $primaryKey, 404);

        DB::table($table)->where($primaryKey, $id)->delete();

        return redirect()->route('admin.database.show', $table)->with('status', 'Row deleted.');
    }

    public function createTable(): View
    {
        return view('admin.database.create-table', ['types' => self::COLUMN_TYPES]);
    }

    public function storeTable(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:64', 'regex:/^[a-zA-Z][a-zA-Z0-9_]*$/'],
            'timestamps' => ['sometimes', 'boolean'],
            'columns' => ['required', 'array', 'min:1'],
            'columns.*.name' => ['required', 'string', 'max:64', 'regex:/^[a-zA-Z][a-zA-Z0-9_]*$/'],
            'columns.*.type' => ['required', Rule::in(array_keys(self::COLUMN_TYPES))],
            'columns.*.nullable' => ['sometimes', 'boolean'],
            'columns.*.default' => ['nullable', 'string', 'max:255'],
        ]);

        $name = strtolower($validated['name']);

        if (str_starts_with($name, 'sqlite_')) {
            return back()->withInput()->withErrors(['name' => 'Table names starting with "sqlite_" are reserved.']);
        }

        if (Schema::hasTable($name)) {
            return back()->withInput()->withErrors(['name' => 'A table with that name already exists.']);
        }

        $columnNames = collect($validated['columns'])->pluck('name')->map(fn ($n) => strtolower($n));

        if ($columnNames->contains('id')) {
            return back()->withInput()->withErrors(['name' => 'A column named "id" is added automatically — choose another name.']);
        }

        if ($columnNames->duplicates()->isNotEmpty()) {
            return back()->withInput()->withErrors(['name' => 'Column names must be unique: '.$columnNames->duplicates()->unique()->implode(', ')]);
        }

        Schema::create($name, function (Blueprint $table) use ($validated) {
            $table->id();

            foreach ($validated['columns'] as $column) {
                $this->applyColumn($table, $column);
            }

            if (! empty($validated['timestamps'])) {
                $table->timestamps();
            }
        });

        return redirect()->route('admin.database.show', $name)->with('status', "Table \"{$name}\" created.");
    }

    public function manage(string $table): View
    {
        $this->ensureTableExists($table);

        $columns = Schema::getColumns($table);
        $primaryKey = $this->primaryKey($table);

        $sampleQuery = DB::table($table);
        if ($primaryKey) {
            $sampleQuery->orderByDesc($primaryKey);
        }
        $sampleRow = $sampleQuery->first();

        return view('admin.database.manage', [
            'table' => $table,
            'columns' => $columns,
            'primaryKey' => $primaryKey,
            'types' => self::COLUMN_TYPES,
            'isSystem' => in_array($table, self::SYSTEM_TABLES, true),
            'sampleRow' => $sampleRow,
            'rowCount' => DB::table($table)->count(),
        ]);
    }

    public function storeColumn(Request $request, string $table): RedirectResponse
    {
        $this->ensureTableExists($table);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:64', 'regex:/^[a-zA-Z][a-zA-Z0-9_]*$/'],
            'type' => ['required', Rule::in(array_keys(self::COLUMN_TYPES))],
            'nullable' => ['sometimes', 'boolean'],
            'default' => ['nullable', 'string', 'max:255'],
        ]);

        $name = strtolower($validated['name']);

        if (in_array($name, Schema::getColumnListing($table), true)) {
            return back()->withInput()->withErrors(['name' => 'That column already exists.']);
        }

        Schema::table($table, function (Blueprint $blueprint) use ($validated, $name) {
            $this->applyColumn($blueprint, $validated + ['name' => $name]);
        });

        return redirect()->route('admin.database.manage', $table)->with('status', "Column \"{$name}\" added.");
    }

    public function dropColumn(string $table, string $column): RedirectResponse
    {
        $this->ensureTableExists($table);

        if (! in_array($column, Schema::getColumnListing($table), true)) {
            abort(404);
        }

        if ($column === $this->primaryKey($table)) {
            return back()->withErrors(['column' => 'Cannot drop the primary key column.']);
        }

        Schema::table($table, function (Blueprint $blueprint) use ($column) {
            $blueprint->dropColumn($column);
        });

        return redirect()->route('admin.database.manage', $table)->with('status', "Column \"{$column}\" dropped.");
    }

    public function dropTable(string $table): RedirectResponse
    {
        $this->ensureTableExists($table);

        if ($table === 'migrations') {
            return back()->withErrors(['table' => 'The migrations table can\'t be dropped from here — it tracks schema history for the whole app.']);
        }

        Schema::drop($table);

        return redirect()->route('admin.database.index')->with('status', "Table \"{$table}\" dropped.");
    }

    public function query(Request $request): View
    {
        $sql = trim((string) $request->input('sql'));
        $results = null;
        $error = null;
        $elapsed = null;

        if ($sql !== '') {
            if (! preg_match('/^select\s/i', $sql)) {
                $error = 'Only SELECT queries are allowed here. Use the row editor for changes.';
            } elseif (str_contains($sql, ';')) {
                $error = 'Only a single statement is allowed (remove the semicolon).';
            } else {
                try {
                    $start = microtime(true);
                    $results = DB::select("select * from ({$sql}) as query_result limit 200");
                    $elapsed = round((microtime(true) - $start) * 1000, 1);
                } catch (\Throwable $e) {
                    $error = $e->getMessage();
                }
            }
        }

        return view('admin.database.query', compact('sql', 'results', 'error', 'elapsed'));
    }

    private function ensureTableExists(string $table): void
    {
        abort_unless(Schema::hasTable($table), 404, 'Unknown table.');
    }

    private function primaryKey(string $table): ?string
    {
        $primary = collect(Schema::getIndexes($table))->firstWhere('primary', true);

        return $primary['columns'][0] ?? null;
    }

    /**
     * Add a column to a Blueprint from a validated [name, type, nullable, default] array.
     */
    private function applyColumn(Blueprint $table, array $column): void
    {
        $name = strtolower($column['name']);
        $type = $column['type'];
        $nullable = ! empty($column['nullable']);
        $default = $column['default'] ?? null;

        $col = match ($type) {
            'string' => $table->string($name),
            'text' => $table->text($name),
            'integer' => $table->integer($name),
            'bigInteger' => $table->bigInteger($name),
            'boolean' => $table->boolean($name),
            'decimal' => $table->decimal($name, 8, 2),
            'date' => $table->date($name),
            'datetime' => $table->dateTime($name),
            'timestamp' => $table->timestamp($name),
            default => throw new \InvalidArgumentException("Unsupported column type: {$type}"),
        };

        if ($nullable) {
            $col->nullable();
        }

        if ($default !== null && $default !== '') {
            $col->default(match (true) {
                $type === 'boolean' => filter_var($default, FILTER_VALIDATE_BOOLEAN),
                in_array($type, ['integer', 'bigInteger'], true) => (int) $default,
                $type === 'decimal' => (float) $default,
                default => $default,
            });
        }
    }

    private function extractColumnData(Request $request, string $table): array
    {
        $columnNames = Schema::getColumnListing($table);
        $columns = collect(Schema::getColumns($table))->keyBy('name');

        $data = [];

        foreach ($columnNames as $name) {
            if (! $request->has("field.{$name}") && $columns[$name]['type_name'] !== 'boolean' && $columns[$name]['type_name'] !== 'tinyint') {
                continue;
            }

            if ($columns[$name]['auto_increment']) {
                continue;
            }

            $type = $columns[$name]['type_name'];
            $value = $request->input("field.{$name}");

            if (in_array($type, ['boolean', 'tinyint'], true)) {
                $data[$name] = $request->boolean("field.{$name}");
            } elseif ($value === '' && $columns[$name]['nullable']) {
                $data[$name] = null;
            } else {
                $data[$name] = $value;
            }
        }

        return $data;
    }
}
