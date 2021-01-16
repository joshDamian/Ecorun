@props(['type' => 'indeterminate'])

@switch($type)
@case('determinate')
<div class="linear-activity">
    <div class="determinate" style="width: 50%"></div>
</div>
@break
@case('indeterminate')
<div class="linear-activity">
    <div class="indeterminate"></div>
</div>
@break
@default

@endswitch
