<div class="sm:pt-13 md:pt-6 relative bg-gray-300 pt-13 px-3 mt-12 md:mt-2 pb-4 md:pb-4">
    <div x-data="{show: false}" class="sm:flex sm:justify-center">
        <div class="sticky mb-3 sm:mb-0 top-0 sm:relative shadow py-3 px-3 bg-white sm:mr-3">
            <div class="flex md:hidden flex-shrink justify-between">
                <span @click=" show = ! show " class="font-bold flex-shrink truncate cursor-pointer mr-3">
                    <i :class="show ? 'fas fa-times' : 'fas fa-bars'" class="text-blue-900"></i>
                </span>
                <span class="font-bold flex-shrink-0 cursor-pointer mr-3 text-blue-900">
                    <i class="fas fa-shopping-cart"></i> Cart
                </span>
                <span class="font-bold flex-shrink-0 cursor-pointer mr-3 text-blue-900">
                    <i class="fas fa-user"></i> Dashboard
                </span>
                <span class="font-bold flex-shrink truncate cursor-pointer mr-3 text-blue-900">
                    <i class="fas fa-user-tie"></i> Manager Account
                </span>
            </div>
            <div x-show="show" class="bg-gray-300 mt-2 py-3 px-3">
            </div>
            <div class="">
            </div>
        </div>
        <div class="flex-shrink-0">
            {{ $slot }}
        </div>
    </div>
</div>
