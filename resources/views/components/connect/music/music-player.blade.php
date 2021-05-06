@props(['playlist'])
<div wire:key="music_player_{{ $playlist->first()->id }}" wire:ignore x-data="{
    playlist: ({{ $playlist->toJson() }}),
    currentlyPlaying: null,
    cover_art: '',
    isPlaying: false,
    audioPlayer: null,
    context: null,
    revertTime: 10,
    music_headline: '',
    playPause: function() {
    if (this.context.state === 'suspended') {
    this.context.resume();
    }
    if(this.isPlaying) {
    this.audioPlayer.pause();
    this.isPlaying = false;
    } else {
    window.MediaHelpers.stopAllMedia();
    this.audioPlayer.play();
    this.isPlaying = true;
    }
    },
    setPlayer: function() {
    this.audioPlayer = this.$refs.audioPlayer;
    this.audioPlayer.src = '/storage/' + this.currentlyPlaying.audio.url;
    this.cover_art = this.currentlyPlaying.cover_art ?? '';
    this.music_headline = this.currentlyPlaying.artiste + ' - ' + this.currentlyPlaying.title;
    let context = this.context = new (window.AudioContext || window.webkitAudioContext)();
    let analyser = context.createAnalyser();
    let canvas = this.$refs.visualizer;
    let ctx = canvas.getContext('2d');
    let source = context.createMediaElementSource(this.audioPlayer);

    source.connect(analyser);
    analyser.connect(context.destination);
    frameLooper();
    function frameLooper() {
    window.requestAnimationFrame(frameLooper);
    let fbc_array = new Uint8Array(analyser.frequencyBinCount);
    analyser.getByteFrequencyData(fbc_array);
    // Clear the canvas
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = '#00CCFF'; // Color of the bars
    let bars = 100;
    for (var i = 0; i < bars; i++) {
    let bar_x = i * 3;
    let bar_width = 2;
    let bar_height = -(fbc_array[i] / 2);
    //  fillRect( x, y, width, height ) // Explanation of the parameters below
    ctx.fillRect(bar_x, canvas.height, bar_width, bar_height);
    }
    }
    },
    initialize: function(currentlyPlaying = null) {
    this.currentlyPlaying = currentlyPlaying ?? this.playlist[0];
    this.setPlayer();
    this.audioPlayer.onpause = (event) => {
    this.isPlaying = false;
    }
    this.audioPlayer.onplay = (event) => {
    this.isPlaying = true;
    }
    this.audioPlayer.onended = (event) => {
    this.isPlaying = false;
    }
    this.audioPlayer.ontimeupdate = (event) => {
    this.calculateDurationAndPlayed();
    }
    },
    calculateDurationAndPlayed: function() {
    let seekPosition = 0;
    // Check if the current track duration is a legible number
    if (!isNaN(this.audioPlayer.duration)) {
    seekPosition = this.audioPlayer.currentTime * (100 / this.audioPlayer.duration);
    this.$refs.seek_slider.value = seekPosition;
    let currentMinutes = Math.floor(this.audioPlayer.currentTime / 60);
    let currentSeconds = Math.floor(this.audioPlayer.currentTime - currentMinutes * 60);
    let durationMinutes = Math.floor(this.audioPlayer.duration / 60);
    let durationSeconds = Math.floor(this.audioPlayer.duration - durationMinutes * 60);

    // Add a zero to the single digit time values
    if (currentSeconds < 10) { currentSeconds = '0' + currentSeconds; }
    if (durationSeconds < 10) { durationSeconds = '0' + durationSeconds; }
    if (currentMinutes < 10) { currentMinutes = '0' + currentMinutes; }
    if (durationMinutes < 10) { durationMinutes = '0' + durationMinutes; }

    // Display the updated duration
    this.$refs.played.textContent = currentMinutes + ':' + currentSeconds;
    this.$refs.duration.textContent = durationMinutes + ':' + durationSeconds;
    }
    },

    revertAudio: function(position, time = this.revertTime) {
    let canRevertForward = (this.audioPlayer.duration >= this.audioPlayer.currentTime + time);
    let canRevertBackward = ((this.audioPlayer.currentTime - time) >= 0);
    let moveForward = canRevertForward ? this.audioPlayer.currentTime + time : this.audioPlayer.currentTime + (this.audioPlayer.duration - this.audioPlayer.currentTime);
    let moveBackward = canRevertBackward ? this.audioPlayer.currentTime - time  : 0;
    if(position === 'forward') {
    this.audioPlayer.currentTime = moveForward;
    }
    if(position === 'backward') {
    this.audioPlayer.currentTime = moveBackward;
    }
    },
    seekTo: function() {
    let seekto = this.audioPlayer.duration * (this.$refs.seek_slider.value / 100);
    this.audioPlayer.currentTime = seekto;
    }
    }" x-init="initialize()" class="music_player">
    <div>
        <div class="flex items-center justify-center p-4 bg-black">
            <div x-show="cover_art.length !== 0"
                :style="'background-size: cover; background-position: center center; background-image: url(' + cover_art + ')'"
                class="border border-white shadow-lg h-44 w-44">
            </div>
            <div class="text-gray-100" x-show="cover_art.length === 0">
                <i style="font-size: 5rem;" class="fas fa-music"></i>
            </div>
        </div>
        <div class="p-3 text-lg font-bold text-white bg-black border-t border-white">
            <div class="grid grid-cols-3">
                <div></div>
                <div class="flex items-center justify-center text-2xl">
                    <span class="mr-1 text-xs">10s</span>
                    <i x-on:click="revertAudio('backward')" class="mr-6 cursor-pointer fas fa-undo"></i>
                    <i x-on:click="playPause" :class="(isPlaying) ? 'fa-pause' : 'fa-play'"
                        class="mr-6 cursor-pointer fas"></i>
                    <i x-on:click="revertAudio('forward')" class="cursor-pointer fas fa-redo"></i>
                    <span class="ml-1 text-xs">10s</span>
                </div>
            </div>
            <canvas x-show="isPlaying" class="w-full h-15" x-ref="visualizer"></canvas>
            <div class="flex justify-between w-full mt-3">
                <div x-ref="played" class="mr-2">
                </div>
                <input x-ref="seek_slider" type="range" min="1" max="100" value="0" class="w-10/12 mr-2"
                    x-on:change="seekTo()">
                <div x-ref="duration">
                </div>
            </div>
            <div class="flex mt-3">
                <div class="items-center flex-1 mr-3" x-text="music_headline"></div>
                <div class="flex items-center justify-end">
                    <x-jet-secondary-button x-on:click="$wire.downloadMusic(currentlyPlaying)"
                        class="bg-gray-900 text-md">
                        <span class="text-white">
                            download <i class="fas fa-download"></i>
                        </span>
                    </x-jet-secondary-button>
                </div>
            </div>
        </div>
    </div>
    <audio x-ref="audioPlayer" hidden controls></audio>
</div>
