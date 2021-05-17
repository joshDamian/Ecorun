@props(['bgColor' => 'bg-blue-800', 'hover' => 'hover:bg-blue-700', 'active' => 'active:bg-blue-900', 'focus' =>
'focus:outline-none focus:border-blue-900 focus:shadow-outline-blue', 'disabled' => 'disabled:opacity-25', 'color' =>
'text-white'])
<button {{ $attributes->merge(['type' => 'button', 'class' => "inline-flex items-center px-4 py-2 {$bgColor} border
    border-transparent rounded-md font-semibold text-xs {$color} uppercase tracking-widest  {$hover}
    {$disabled} {$focus} transition ease-in-out duration-150"]) }}>
    {{ $slot }}
</button>