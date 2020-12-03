<div>
    @switch($active_action['title'])
    @case('orders')
    <div>

    </div>
    @break
    @case('cart')
    <div>

    </div>
    @break
    @case('manager account')
    <div>
        @livewire('build-and-manage.manager.manager-dashboard')
    </div>
    @break
    @case('messages')
    <div>

    </div>
    @break
    @default
    @break
    @endswitch
</div>

</div>
@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {

        setTimeout(() => {
            modifyUrl("/account.me/{{ array_keys($actions, $active_action)[0] }}")
        }, 10);

        function modifyUrl(url) {
            var state = {
                id: "100"
            };
            window.history.replaceState(
                state
                , url
                , url
            );
        }

        Livewire.on('actionSwitch', (action) => {
            modifyUrl(action)
            scrollTo(0, 0)
        })
    })

</script>
@endpush
