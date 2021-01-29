<x-social-layout>
    <div>
        @livewire('general.search.search-component', ['query' => $query, 'data_set' => $data_set],
        key('search_component_'))
    </div>
</x-social-layout>
