<div class="grid grid-cols-2 sm:grid-cols-3">
    <div x-data="{show_category_sub: false}">
        <h4 @click=" show_category_sub = ! show_category_sub "
            class="text-lg font-extrabold text-blue-800 cursor-pointer">
            <i :class="(show_category_sub) ? 'fa-chevron-down' : 'fa-chevron-right'"
                class="fas"></i>&nbsp;Electronics
        </h4>

        <div x-show="show_category_sub" class="grid grid-cols-1 gap-2 font-semibold">
            <h4 class="text-lg text-blue-700">
                Laptops.
            </h4>
            @for($i = 0; $i < 6; $i++) <h4 class="text-lg text-blue-700">
                Some category.
            </h4>
                @endfor
            </div>
        </div>

        <div x-data="{show_category_sub_2: false}">
            <h4 @click=" show_category_sub_2 = ! show_category_sub_2 "
                class="text-lg font-extrabold text-blue-800 cursor-pointer">
                <i :class="(show_category_sub_2) ? 'fa-chevron-down' : 'fa-chevron-right'"
                    class="fas"></i>&nbsp;Electronics
            </h4>

            <div x-show="show_category_sub_2" class="grid grid-cols-1 gap-2 font-semibold">
                <h4 class="text-lg text-blue-700">
                    Laptops.
                </h4>
                @for($i = 0; $i < 6; $i++) <h4 class="text-lg text-blue-700">
                    Some category.
                </h4>
                    @endfor
                </div>
            </div>

            <div x-data="{show_category_sub_2: false}">
                <h4 @click=" show_category_sub_2 = ! show_category_sub_2 "
                    class="text-lg font-extrabold text-blue-800 cursor-pointer">
                    <i :class="(show_category_sub_2) ? 'fa-chevron-down' : 'fa-chevron-right'"
                        class="fas"></i>&nbsp;Electronics
                </h4>

                <div x-show="show_category_sub_2" class="grid grid-cols-1 gap-2 font-semibold">
                    <h4 class="text-lg text-blue-700">
                        Laptops.
                    </h4>
                    @for($i = 0; $i < 6; $i++) <h4 class="text-lg text-blue-700">
                        Some category.
                    </h4>
                        @endfor
                    </div>
                </div>
            </div>