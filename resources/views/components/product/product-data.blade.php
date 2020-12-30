@props(['product'])
<div>
    <div class="py-2 md:mt-3 bg-green-600 rounded grid grid-cols-5 px-3">
        <span class="text-white flex items-center col-span-3 font-semibold text-lg">
            {{ ucwords($product->name) }}
        </span>
        <span class="text-white col-span-2 text-right font-semibold text-lg">
            {!! $product->price() !!}
        </span>
    </div>
    <div x-data="{ show_spec: null, show_desc: true }">
        <div class="mt-3 bg-white items-baseline overflow-x-scroll justify-between flex">
            <span class="flex-shrink-0 mr-3">
                @livewire('user-components.cart.add-to-cart', ['product' => $product->id], key('add_to_cart'))
            </span>

            <span @click=" show_spec = null; show_desc = true " :class="{ 'text-blue-700 border-b-2 border-blue-700' : show_desc }" class="mr-3 cursor-pointer hover:text-blue-700 text-lg font-bold">
                Description
            </span>

            <span @click=" show_desc = null; show_spec = true " :class="{ 'text-blue-700 border-b-2 border-blue-700' : show_spec }" class="mr-3 text-lg cursor-pointer hover:text-blue-700 font-bold">
                Specifications
            </span>
        </div>
        <div class="text-md mt-3 font-semibold">
            <template x-if="show_desc">
                <div style="max-height: 240px;" class="overflow-y-scroll">
                    {{ $product->description }}
                </div>
            </template>
            <template x-if="show_spec">
                @if($product->attributes->count() > 0)
                <div class="">
                    <div style="max-height: 240px;" class="grid overflow-y-scroll grid-cols-1 gap-3">
                        @foreach($product->attributes as $attribute)
                        <table style="width: 100%;" class="border-collapse">
                            <tr>
                                <th class="p-2 text-center bg-gray-300 border border-gray-300" colspan="{{ count($attribute->value) }}">{{ $attribute->name }}</th>
                            </tr>
                            <tr>
                                @foreach($attribute->value as $value)
                                <td class="p-2 text-center border border-gray-400">{{ $value }}</td>
                                @endforeach
                            </tr>
                        </table>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="text-center">
                    there are no specs for this product
                </div>
                @endif
            </template>
        </div>
    </div>
</div>
