@props(['content', 'encode' => false])
<div {{
    $attributes->
    merge(['class' => 'text-content break-words whitespace-pre-line'])
    }}>@if(!$encode) {!!$content!!} @else {{$content}} @endif
</div>