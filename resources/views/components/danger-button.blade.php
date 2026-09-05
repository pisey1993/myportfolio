<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-rose-600 font-semibold text-sm text-white shadow-sm shadow-rose-600/30 hover:bg-rose-700 focus:outline-none focus:ring-4 focus:ring-rose-500/30 transition']) }}>
    {{ $slot }}
</button>
