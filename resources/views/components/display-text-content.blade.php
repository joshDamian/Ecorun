@props(['content', 'encode' => false ])
<div x-data x-init="() => {
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
    //
    }).catch(x => console.error(x));

    }">
    <div x-ref="content" {{
        $attributes->
        merge(['class' => 'text-content dont-break-out whitespace-pre-line'])
        }}>@if(!$encode) {!!$content!!} @else {{$content}} @endif
    </div>
</div>
