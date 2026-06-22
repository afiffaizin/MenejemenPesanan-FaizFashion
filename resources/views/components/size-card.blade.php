@props(['label', 'value'])

<div class="bg-gray-50/70 rounded-xl p-4 border border-gray-100 transition-colors hover:bg-gray-50">
    <p class="text-xs text-gray-500 font-medium mb-1">{{ $label }}</p>
    <p class="text-base font-bold text-slate-800">
        {{ $value ? $value . ' cm' : '-' }}
    </p>
</div>