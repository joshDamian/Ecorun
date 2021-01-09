@props(['content'])
<div {{
$attributes->merge(['class' => 'text-content break-words whitespace-pre-line'])
}}>{!!$content!!}</div>
