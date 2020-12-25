@props(['profile'])
<div x-data x-init="() => { Echo.private('App.Models.Profile.{{ $profile->id }}').notification((notification) => {}); }">
</div>
