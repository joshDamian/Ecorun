<div>
    <x-landing-page>
        <div class="grid grid-cols-1 gap-4">
            <!-- Billboard -->

            <!-- Store Products -->
            <div>
                @livewire('user-components.product.store-product-list')
            </div>

            <div>
                @livewire('user-components.product.service-product-list')
            </div>
        </div>
    </x-landing-page>
</div>
