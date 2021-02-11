@props(['content', 'encode' => false, 'collapsible' => 'false', 'clamp' => 8 ])
<div x-data="{ collapse: Boolean('{{ $collapsible }}'), overflow: false, line_clamp: {{ $clamp }} }" x-init="() => {
        let renderContent = new Promise(
            function (resolve, reject) {
                var object = $refs.content;
                if (object) {
                    object.innerHTML = object.innerHTML.trim();
                    resolve(object);
                } else {
                    reject('element object not present');
                }
            }
        );
        if(collapse) {
            renderContent.then(content => {
                overflow = content.clientHeight < content.scrollHeight;
            }).catch(x => console.error(x));
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
            }}>
            <x-jet-secondary-button x-on:click="collapse = !collapse" class="lowercase">
                see more
            </x-jet-secondary-button>
        </div>
    </template>
</div>
