@props(['status'])

<span {{ $attributes }}>
    @switch($status)
    @case('seen')
    <i class="fas fa-check-double"></i>
    @break
    @case('sent')
    @default
    <i class="fas fa-check"></i>
    @break
    @endswitch
</span>