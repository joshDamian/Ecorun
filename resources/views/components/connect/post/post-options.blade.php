@props(['post'])
<div class="grid grid-cols-1 bg-gray-200 border-b border-gray-300">
    @can('update', [$post, Auth::user()->currentProfile])
    <a href="{{ $post->url->edit }}"
        class="px-3 py-3 font-semibold text-gray-600 bg-gray-100 hover:bg-blue-200 focus:bg-blue-200 sm:px-5">
        <i class="fas fa-edit"></i>&nbsp; Edit
    </a>

    <a href="{{ $post->url->delete }}"
        class="px-3 py-3 font-semibold text-gray-600 bg-gray-100 hover:bg-blue-200 focus:bg-blue-200 sm:px-5">
        <i class="fas fa-trash"></i>&nbsp; Delete
    </a>
    @endcan
</div>
