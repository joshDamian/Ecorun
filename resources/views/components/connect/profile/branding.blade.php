<div>
    @if(!empty($brands))
    <x-jet-label for="profile_brand"
        value="{{ $profile->isBusiness() ? __('Business Type') : __('Personality Branding') }}" />
    <select wire:model="brand" class="mt-1 form-select" id="profile_branding">
        @foreach($brands as $key => $brand)
        <option value="{{ $brand->label }}">{{ $brand->label }}</option>
        @endforeach
    </select>
    @endif
</div>
