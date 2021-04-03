<div>
    @if(!empty($brands))
    <x-jet-label for="profile_brand"
        value="{{ $profile->isBusiness() ? __('Business Type') : __('Personality Branding') }}" />
    <select wire:model="label" class="mt-1 form-select" id="profile_branding">
        <option>select an option</option>
        @foreach($brands as $key => $brand)
        <option value="{{ $brand }}" @if($selectedOption===$brand) {{ __('selected') }} @endif>{{ $brand }}</option>
        @endforeach
    </select>
    @endif
</div>
