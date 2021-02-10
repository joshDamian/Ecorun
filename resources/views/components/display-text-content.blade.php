@props(['content', 'encode' => false, 'collapsible' => 'false', 'clamp' => 8 ])
<div x-data="{ collapse: false, overflow: false, line_clamp: {{ $clamp }} }" x-init="() => {
    $refs.content.innerHTML = $refs.content.innerHTML.trim();
    if('{{ $collapsible }}' === 'true') {
    collapse = true;
    }
    if(collapse) {
    overflow = $refs.content.clientHeight < $refs.content.scrollHeight;
    console.log(overflow, $refs.content.clientHeight, $refs.content.scrollHeight);
    }
    }">
    <div x-ref="content" {{
        $attributes->
        merge(['class' => 'text-content break-words whitespace-pre-line'])
        }} :class="(collapse) ? 'line-clamp-' + line_clamp : ''">@if(!$encode) {!!$content!!} @else {{$content}} @endif
    </div>
    <template x-if="collapse && overflow">
        <div x-show="collapse && overflow" {{  $attributes->
            merge(['class' => 'border-t border-gray-200'])
            }} >
            <x-jet-secondary-button x-on:click="collapse = !collapse" class="lowercase">
                see more
            </x-jet-secondary-button>
        </div>
    </template>
</div>