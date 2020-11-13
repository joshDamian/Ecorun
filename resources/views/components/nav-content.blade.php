<div>
    <div @click=" active_item = null " class="text-right md:hidden p-3">
        <i class="fas text-lg text-blue-800 fa-times"></i>
    </div>

    <div x-show="active_item === 'categories'" class="font-light text-black nav-content">
        {{-- <div class="text-center font-medium text-lg rounded-lg p-2 shadow border border-gray-400">
            Shop By Categories
        </div>

        <div class="py-3 border-b text-center hover:border-black md:cursor-pointer border-gray-300">
            Mobile Phones
        </div>

        <div class="py-3 border-b text-center hover:border-black md:cursor-pointer border-gray-300">
            Shirts
        </div>

        <div class="py-3 border-b text-center hover:border-black md:cursor-pointer border-gray-300">
            Trousers
        </div> --}}
    </div>

    <div x-show="active_item === 'user'" class="font-light nav-content">
        <div class="flex border-gray-400 border bg-white flex-wrap items-center md:rounded-t-lg px-2 py-2 shadow">
            @if($profileImage)
            <div style="background-image: url('{{ $profileImage }}'); background-size: cover; background-position: center center;" class="w-16 rounded-full mr-3 h-16">
            </div>
            @else
            <div>
                <span class="fa-stack fa-2x">
                    <i class="fas fa-circle text-blue-800 fa-stack-2x"></i>
                    <i class="fa-stack-1x fas text-white @auth fa-user-shield @endauth @guest fa-user @endguest"></i>
                </span>
            </div>
            @endif

            <div class="grid grid-cols-1 gap-1">
                <div class="text-left">
                    <div class="font-normal">
                        {{ $name }}
                    </div>

                    <div class="font-hairline">
                        {{ $email }}
                    </div>
                </div>

                <div class="flex font-hairline flex-wrap">
                    <span class="mr-3">
                        <span class="font-normal">319</span> Following
                    </span>

                    <span>
                        <span class="font-normal">9</span> Followers
                    </span>
                </div>
            </div>
        </div>

        <div class="py-3 border text-center bg-gray-100 font-medium text-lg text-blue-800 hover:border-blue-800 md:cursor-pointer border-gray-400">
            <i class="fa fa-clipboard-list"></i> Timeline
        </div>

        <div class="py-3 border text-center  bg-gray-100 font-medium text-lg text-blue-800 hover:border-blue-800 md:cursor-pointer border-gray-400">
            <i class="fa fa-clipboard-check"></i> Orders
        </div>

        <div class="py-3 border text-center  bg-gray-100 font-medium text-lg text-blue-800 hover:border-blue-800 md:cursor-pointer border-gray-400">
            <i class="fa fa-shopping-cart"></i> Cart
        </div>

        <a href="/user/profile">
            <div class="py-3 border text-center  bg-gray-100 font-medium text-lg text-blue-800 hover:border-blue-800 md:cursor-pointer border-gray-400">
                <i class="fa fa-user"></i> Profile
            </div>
        </a>

        <div class="py-3 border  bg-gray-100 text-center font-medium text-lg text-blue-800 hover:border-blue-800 md:rounded-b-lg md:cursor-pointer border-gray-400">
            <span class="font-bold">&#8358;</span> Auction Sale
        </div>
    </div>
</div>
