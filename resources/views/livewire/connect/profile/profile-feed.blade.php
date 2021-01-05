<div class="grid grid-cols-1 gap-3 sm:gap-4">
    @forelse($this->displaying_feed as $key => $feed_item)
    @include($this->viewIncludeFolder . $this->feed_display_cards[get_class($feed_item)], ['model' => $feed_item])
    @empty
    @endforelse
</div>
