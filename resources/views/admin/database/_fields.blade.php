@php $row = $row ?? null; @endphp

@foreach ($columns as $column)
    @php
        $name = $column['name'];
        $type = $column['type_name'];
        $current = $row->{$name} ?? $column['default'];
        $old = old("field.$name", $current);
        $isBoolean = in_array($type, ['boolean', 'tinyint'], true);
        $isLong = in_array($type, ['text', 'longtext', 'mediumtext'], true);
        $isNumber = in_array($type, ['integer', 'bigint', 'smallint', 'decimal', 'float', 'double'], true);
    @endphp

    <div>
        <label for="field-{{ $name }}" class="flex items-center gap-2 text-sm font-medium text-gray-700">
            {{ $name }}
            <span class="font-normal text-gray-400">{{ $type }}@if (! $column['nullable']) &middot; required @endif</span>
        </label>

        @if ($isBoolean)
            <div class="mt-2">
                <input type="checkbox" name="field[{{ $name }}]" id="field-{{ $name }}" value="1" {{ $old ? 'checked' : '' }}
                    class="rounded border-gray-300 text-[#2271b1] focus:ring-[#2271b1]">
            </div>
        @elseif ($isLong)
            <textarea name="field[{{ $name }}]" id="field-{{ $name }}" rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] sm:text-sm font-mono">{{ $old }}</textarea>
        @else
            <input type="{{ $isNumber ? 'number' : 'text' }}" name="field[{{ $name }}]" id="field-{{ $name }}" value="{{ $old }}"
                {{ $isNumber ? 'step=any' : '' }}
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] sm:text-sm font-mono">
        @endif
        @error("field.$name")<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
@endforeach
