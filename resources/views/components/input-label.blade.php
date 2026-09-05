@props(['value'])

<label {{ $attributes->merge(['class' => 'block mb-1.5 text-sm font-medium text-slate-700']) }}>
    {{ $value ?? $slot }}
</label>
