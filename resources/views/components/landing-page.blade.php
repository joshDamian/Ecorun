<div class="sm:pt-13 md:pt-6 relative bg-gray-300 pt-13 md:px-3 px-2 mt-12 md:mt-2 pb-2 md:pb-4">
    <div x-data="{show: false}" class="md:flex md:justify-center">
        <div class="mb-3 md:mb-0 md:relative flex-shrink-0 shadow bg-white md:mr-3">
            <div :class="{'border-gray-300 border-b-2' : show }" class="flex md:hidden py-3 px-3 justify-between">
                <span @click=" show = ! show " class="font-bold flex-shrink-0 truncate cursor-pointer mr-3">
                    <i :class="show ? 'fas fa-times' : 'fas fa-bars'" class="text-blue-700"></i>
                </span>
                <span class="font-bold flex-shrink-0 cursor-pointer mr-3 text-blue-700">
                    <i class="fas fa-shopping-cart"></i> Cart
                </span>
                <span class="font-bold flex-shrink-0 cursor-pointer mr-3 text-blue-700">
                    <i class="fas fa-user"></i> Dashboard
                </span>
                <span class="font-bold flex-shrink truncate cursor-pointer mr-3 text-blue-700">
                    <i class="fas fa-user-tie"></i> Manager Account
                </span>
            </div>
            <div x-show="show" class="bg-white py-3">
                <x-category.category-listing />
            </div>
            <div class="hidden sticky top-15 bg-white md:block">
                <div class="border-b-2 py-2 px-3  border-gray-300">
                    <span class="font-bold cursor-pointer text-blue-700">
                        <i class="fas fa-user"></i> Dashboard
                    </span>
                </div>

                <div class="border-b-2 py-2 px-3  border-gray-300">
                    <span class="font-bold cursor-pointer text-blue-700">
                        <i class="fas fa-shopping-cart"></i> Cart
                    </span>
                </div>

                <div class="border-b-2 py-2  border-gray-300">
                    <x-category.category-listing />
                </div>
            </div>
        </div>
        <div class="flex-grow flex-shrink">
            {{ $slot }}
        </div>
    </div>
</div>
