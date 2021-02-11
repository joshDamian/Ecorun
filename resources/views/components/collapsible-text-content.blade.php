@props(['content', 'encode' => false, 'clamp' => 8 ])
<div>
    <div wire:key="{{ random_int(3, 687654333) }}" x-data x-init="() => {
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
        renderContent.then(content => {
        $refs.content.addEventListener('click', (event) => {
        $refs.content.classList.toggle('line-clamp-{{$clamp}}');
        $refs.content.clientHeight = $refs.content.scrollHeight;
        })
        }).catch(x => console.error(x));
        }" x-ref="parent">
        <div x-ref="content" {{
            $attributes->
            merge(['class' => "text-content me cursor-pointer hover:bg-blue-100 bg-opacity-75 focus:bg-blue-100 line-clamp-{$clamp} break-words whitespace-pre-line"])
            }} ">@if(!$encode) {!!$content!!} @else {{$content}} @endif
        </div>
    </div>
</div>