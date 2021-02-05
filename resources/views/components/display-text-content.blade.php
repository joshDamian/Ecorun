@props(['content', 'encode' => false])
<div wire:ignore x-data x-init="() => {
        $refs.content.innerHTML = $refs.content.innerHTML.trim();
    }" x-ref="content" {{
    $attributes->
    merge(['class' => 'text-content break-words whitespace-pre-line'])
    }}>@if(!$encode) {!!$content!!} @else {{$content}} @endif
</div>
