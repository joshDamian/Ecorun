<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div class="relative">
        <select wire:model="activeCategory"
            class="block appearance-none w-full bg-gray-700 border border-gray-700 text-white py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-green-700 focus:border-green-700"
            id="grid-state">
            @foreach($categories as $category)
            <option value="{{ $category->title }}">{{ $category->title }}</option>
            @endforeach
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
            </svg>
        </div>
    </div>

    <div class="relative">
        <select
            class="block appearance-none w-full bg-gray-700 border border-gray-700 text-white py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-green-700 focus:border-green-700"
            id="grid-state">
            @foreach(Category::find($activeCategory)->sub_categories as $category)
            <option value="{{ $category->title }}">{{ $category->title }}</option>
            @endforeach
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
            </svg>
        </div>
    </div>
</div>