<div>
    @if(!empty($brands))
    <x-jet-label for="profile_brand"
        value="{{ $profile->isBusiness() ? __('Business brand') : __('Personality Branding') }}" />
    <select class="mt-1 form-select" id="profile_branding">
        @foreach($brands as $key => $brand)
        <option>{{ $brand }}</option>
        @endforeach
    </select>
    @endif
</div>
