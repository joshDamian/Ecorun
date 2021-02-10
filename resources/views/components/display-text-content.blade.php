@props(['content', 'encode' => false, 'collapsible' => false, 'clamp' => 8 ])
<div x-data="{ collapsible: ('{{ $collapsible }}' === '') ? false : true, overflowing: false }" x-init="() => {
    $refs.content.innerHTML = $refs.content.innerHTML.trim();
    if(collapsible) {
        overflowing = $refs.content.clientHeight < $refs.content.scrollHeight;
    }
}">
    <div x-ref="content" {{
        $attributes->
        merge(['class' => 'text-content break-words whitespace-pre-line'])
        }} :class="{ 'line-clamp-{{ $clamp }}': collapsible  }">@if(!$encode) {!!$content!!} @else {{$content}} @endif
    </div>
    <div {{  $attributes->merge(['class' => 'border-t border-gray-200'])
        }} x-show="collapsible && overflowing">
        <x-jet-secondary-button x-on:click="collapsible = !collapsible" class="lowercase">
            see more
        </x-jet-secondary-button>
    </div>
</div>
