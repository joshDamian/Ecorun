@props(['data'])
@if($data->links()->paginator->hasPages())
<div class="mt-2 text-white">
    {{ $data->links() }}
</div>
@endif
