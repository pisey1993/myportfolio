<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-indigo-600 font-semibold text-sm text-white shadow-sm shadow-indigo-600/30 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 active:scale-[.99] transition']) }}>
    {{ $slot }}
</button>
