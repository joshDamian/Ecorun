<div>
    @auth
    <div x-data="sub_data()" x-init="init()">
        <template x-if="should_show">
            <div class="pb-3 bg-gray-300">
                <div class="flex justify-between px-3 py-3 text-xl font-bold text-blue-700 bg-white sm:px-5">
                    <span>
                        <i class="fas fa-clock"></i> Reminder
                    </span>

                    <span class="flex justify-end">
                        <x-jet-secondary-button x-on:click="should_show = false">
                            <i class="fas fa-times"></i>
                        </x-jet-secondary-button>
                    </span>
                </div>

                <div class="px-3 py-3 bg-gray-100 sm:px-5">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Enable push notifications.
                    </h3>

                    <div class="font-medium text-gray-600">
                        enabling push notifications keeps you up to date with eco-vibes 🤭🤭.
                    </div>
                </div>

                <div class="flex items-center justify-end px-3 py-3 bg-white sm:px-5">
                    <x-jet-secondary-button x-on:click="should_show = false" class="mr-3 text-red-500 border-red-500">
                        i no want😑
                    </x-jet-secondary-button>


                    <x-jet-secondary-button x-on:click="initPush()" class="text-green-500 border-green-500">
                        I like 😊
                    </x-jet-secondary-button>
                </div>
            </div>
        </template>
    </div>

    @once
    @push('scripts')
    <script>
        function sub_data() {
            return {
                should_show: true,
                init: function () {
                    if (!('Notification' in window)) {
                        console.log('notifications not supported');
                        return;
                    }
                    if (Notification.permission === 'granted') {
                        this.should_show = false;
                        return;
                    }
                },
                initPush: function() {
                    if (!navigator.serviceWorker.ready) {
                        return;
                    }

                    new Promise(function (resolve, reject) {
                        const permissionResult = Notification.requestPermission(function (result) {
                            resolve(result);
                        });

                        if (permissionResult) {
                            permissionResult.then(resolve, reject);
                        }
                    })
                    .then((permissionResult) => {
                        if (permissionResult !== 'granted') {
                            throw new Error('We weren\'t granted permission.');
                        }
                        this.subscribeUser();
                    });

                },
                subscribeUser: function() {
                    navigator.serviceWorker.ready
                    .then((registration) => {
                        const subscribeOptions = {
                            userVisibleOnly: true,
                            applicationServerKey: this.urlBase64ToUint8Array(
                                'BLXPSvPqq_mpasah-ov8k1tlT5hb322gQxsW-RM08oUu2r-lnY7QldYLwyjawQVT2IW6jSm6SUbH4vk77_9_G0k'
                            )
                        };

                        return registration.pushManager.subscribe(subscribeOptions);
                    })
                    .then((pushSubscription) => {
                        console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
                        this.storePushSubscription(pushSubscription);
                    });
                },

                urlBase64ToUint8Array: function(base64String) {
                    var padding = '='.repeat((4 - base64String.length % 4) % 4);
                    var base64 = (base64String + padding)
                    .replace(/\-/g,
                        '+')
                    .replace(/_/g,
                        '/');

                    var rawData = window.atob(base64);
                    var outputArray = new Uint8Array(rawData.length);

                    for (var i = 0; i < rawData.length; ++i) {
                        outputArray[i] = rawData.charCodeAt(i);
                    }
                    return outputArray;
                },

                storePushSubscription: function(pushSubscription) {
                    const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

                    fetch('/push', {
                        method: 'POST',
                        body: JSON.stringify(pushSubscription),
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': token
                        }
                    })
                    .then((res) => {
                        return res.json();
                    })
                    .then((res) => {
                        console.log(res);
                        this.should_show = false;
                    })
                    .catch((err) => {
                        console.log(err)
                    });
                }
            }
        }
    </script>
    @endpush
    @endonce
    @endauth
</div>
