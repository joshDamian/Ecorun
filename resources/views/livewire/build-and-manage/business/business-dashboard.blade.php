<div>
    @can('manage-business', $business)
    <div class="py-4 md:py-0 md:pb-4">
        @switch($active_action['title'])
        @case('add product')
        <div>
            @livewire('build-and-manage.product.create-new-product', ['businessId' => $business->id], key(time().$business->id))
        </div>
        @break

        @case('products')
        <div>
            @livewire('build-and-manage.business.business-product-list', ['business' => $business])
        </div>
        @break

        @case('orders')
        <div>

        </div>
        @break

        @case('gallery')
        <div>

        </div>
        @break

        @case('management team')
        <div>
            @include('teams.show', ['team' => $business->team])
        </div>
        @default
        @break
        @endswitch
    </div>
    @push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {

            setTimeout(() => {
                window.modifyUrl("/business/{{ $business->profile->full_tag() }}/{{ $business->id }}/{{ array_keys($actions, $active_action)[0] }}")
            }, 10);

            Livewire.on('actionSwitch', (action) => {
                window.modifyUrl(action)
            })
        })

    </script>
    @endpush
    @endcan

    @cannot('manage-business', $business)
    <div>
        @livewire('build-and-manage.business.setup-business', ['business' => $business])
    </div>
    @endcannot
</div>