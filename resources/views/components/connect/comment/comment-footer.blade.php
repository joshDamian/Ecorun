@props(['comment'])
<div {{ $attributes->
    merge(['class' => 'flex items-center']) }}>
    <p class="mr-2">
        {{ $comment->created_at->diffForHumans(null, null, true) }}
    </p>
    @can('update', [$comment, auth()->user()->currentProfile])
    <a class="mr-2" href="{{ $comment->url->edit }}">
        <i class="text-gray-600 fas fa-edit"></i>
    </a>

    <a class="mr-2" href="{{ $comment->url->delete }}">
        <i class="text-gray-600 fas fa-trash"></i>
    </a>
    @endcan

    @if(!request()->routeIs('comment.show'))
    <a class="" href="{{ $comment->url->show }}">
        <i class="fas text-blue-700 fa-expand"></i>
    </a>
    @endif
</div>