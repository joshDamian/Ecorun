<x-app-layout>
    <div class="bg-gray-100 text-center font-bold text-blue-700 text-lg p-3">
        <div class="flex justify-center items-center">
            <span class="fa-stack fa-3x">
                <i class="text-blue-700 fas fa-square fa-stack-2x"></i>
                <i class="text-white fa-stack-1x fas fa-lock"></i>
            </span>
        </div>
        we couldn't display what you requested for, you probably don't have enough permissions to view it.
    </div>

    <div class="">
        <div class="border-t border-gray-200 p-3 border-b">
            <div class="font-semibold mb-3 text-blue-700 text-center text-3xl">
                Let's take you
            </div>
            <div class="text-center">
                <a href="/">
                    <x-jet-button class="bg-blue-700">
                        home
                    </x-jet-button>
                </a>
            </div>
        </div>

        <div class="text-center text-gray-500 font-bold p-3 text-xl">
            Or
        </div>

        <div class="border-t border-gray-200 p-3">
            <div class="font-semibold mb-3 text-blue-700 text-center text-3xl">
                Help you
            </div>
            <div class="text-center">
                <a href="/search">
                    <x-jet-button class="bg-blue-700">
                        search
                    </x-jet-button>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>