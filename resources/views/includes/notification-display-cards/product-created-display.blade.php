<div>
    @php
    $product = $model;
    $profile = $product->business->profile;
    @endphp
    <div class="p-2 @if($notification->read_at) bg-gray-200 @else bg-white @endif">
        <div class="flex flex-wrap">
            <div style="background-image: url('{{ $profile->profile_photo_url }}'); background-size: cover; background-position: center center;"
                class="flex-shrink-0 w-10 h-10 mr-2 border border-blue-700 rounded-full">
            </div>
            <div class="flex-1 flex-shrink-0">
                <div class="grid grid-cols-1">
                    <div class="flex justify-between">
                        <span class="text-lg font-extrabold text-blue-800">{{ $notification->data['title'] }}</span>
                        <span
                            class="text-gray-700">{{ $notification->created_at->diffForHumans(null, null, true) }}</span>
                    </div>
                    <div>
                        <span class="font-bold text-black">{{ $profile->name }}</span>
                        added a new product.
                    </div>
                    <div class="flex items-center">
                        <i class="mr-2 text-sm text-blue-800 fas fa-arrow-alt-circle-right"></i>
                        <div class="flex-1 flex-shrink-0 break-words truncate line-clamp">
                            {{ $product->name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>