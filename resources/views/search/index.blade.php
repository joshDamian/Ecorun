<x-social-layout>
    <div>
        @livewire('general.user.search-component', ['query' => $query, 'data_set' => $data_set],
        key(['search_component_'
        . mt_rand(1000000, 1000000000)]))
    </div>
</x-social-layout>
