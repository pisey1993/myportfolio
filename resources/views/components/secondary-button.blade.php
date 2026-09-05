<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-slate-200 bg-white font-semibold text-sm text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-200 disabled:opacity-40 transition']) }}>
    {{ $slot }}
</button>
