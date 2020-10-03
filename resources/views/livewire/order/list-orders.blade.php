<div>
    @forelse (Auth::user()->orders as $order)

    @empty
    <div class="flex py-4 px-4 justify-center">
        <div>
            <i style="font-size: 10rem;" class="text-blue-700 fa fa-shopping-bag"></i>
            <div class="text-center mt-4 text-lg font-bold text-blue-700">
                nothing here
            </div>
        </div>
    </div>
    @endforelse
</div>
