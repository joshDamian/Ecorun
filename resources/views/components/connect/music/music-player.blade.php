@props(['playlist'])
<div wire:ignore x-data="{
    playlist: ({{ $playlist->toJson() }}),
    currentlyPlaying: null,
    cover_art: '',
    isPlaying: false,
    audioPlayer: null,
    context: null,
    canRevertForward: true,
    canRevertBackward: true,
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
    this.stopAllTracks();
    this.audioPlayer.play();
    this.isPlaying = true;
    }
    },

    setPlayer: function() {
    this.audioPlayer = this.$refs.audioPlayer;
    this.audioPlayer.src = '/storage/' + this.currentlyPlaying.audio.url;
    this.cover_art = this.currentlyPlaying.cover_art_url;
    this.music_headline = this.currentlyPlaying.title + ' - ' + this.currentlyPlaying.artiste;
    let context = this.context = new (window.AudioContext || window.webkitAudioContext)();
    let analyser = context.createAnalyser();
    let canvas = this.$refs.visualizer;
    let ctx = canvas.getContext('2d');
    let source = context.createMediaElementSource(this.audioPlayer);

    source.connect(analyser);
    analyser.connect(context.destination);
    frameLooper();
    function frameLooper() {
    window.webkitRequestAnimationFrame(frameLooper);
    let fbc_array = new Uint8Array(analyser.frequencyBinCount);
    analyser.getByteFrequencyData(fbc_array);
    ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas
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

    stopAllTracks: function() {
    let audio_elements = document.querySelectorAll('audio');
    audio_elements.forEach((audio) => {
    audio.pause();
    });
    },
    revertAudio: function(position, time = this.revertTime) {
    this.canRevertForward = (this.audioPlayer.duration >= this.audioPlayer.currentTime + time);
    this.canRevertBackward = ((this.audioPlayer.currentTime - time) >= 0);
    let moveForward = this.canRevertForward ? this.audioPlayer.currentTime + time : this.audioPlayer.currentTime + (this.audioPlayer.duration - this.audioPlayer.currentTime);
    let moveBackward = this.canRevertBackward ? this.audioPlayer.currentTime - time  : 0;
    console.log(this.audioPlayer.currentTime);
    if(position === 'forward') {
    this.audioPlayer.currentTime = moveForward;
    }
    if(position === 'backward') {
    this.audioPlayer.currentTime = moveBackward;
    }
    console.log(this.audioPlayer.currentTime);
    },
    seekTo: function() {
    console.log(this.audioPlayer.duration);
    let seekto = this.audioPlayer.duration * (this.$refs.seek_slider.value / 100);
    console.log(this.$refs.seek_slider.value, seekto);
    // Set the current track position to the calculated seek position
    this.audioPlayer.currentTime = seekto;
    console.log(this.audioPlayer.currentTime)
    }
    }" x-init="initialize()">
    <div>
        <div class="flex bg-black p-4 justify-center items-center">
            <div :class="{ 'fa-spin': isPlaying }" :style="'background-size: cover; background-position: center center; background-image: url(/storage/' + cover_art + ')'" class="h-52 shadow-lg border border-white rounded-full w-52">
            </div>
        </div>

        <div class="p-3 border-t border-white bg-black text-white text-lg font-bold">
            <div class="grid grid-cols-3">
                <div></div>
                <div class="flex text-2xl items-center justify-center">
                    <span class="text-xs mr-1">10s</span>
                    <i x-on:click="revertAudio('backward')" class="fas mr-6 fa-undo"></i>
                    <i x-on:click="playPause" :class="(isPlaying) ? 'fa-pause' : 'fa-play'" class="fas mr-6 cursor-pointer"></i>
                    <i x-on:click="revertAudio('forward')" class="fas fa-redo"></i>
                    <span class="text-xs ml-1">10s</span>
                </div>
                <div></div>
            </div>
            <canvas x-show="isPlaying" class="w-full h-20" x-ref="visualizer"></canvas>
            <div class="flex justify-between mt-3 w-full">
                <div x-ref="played" class="mr-2">
                </div>
                <input x-ref="seek_slider" type="range" min="1" max="100"
                value="0" class="w-10/12 mr-2" x-on:change="seekTo()">
                <div x-ref="duration">
                </div>
            </div>
            <div class="mt-3" x-text="music_headline"></div>
        </div>

    </div>
    <audio x-ref="audioPlayer" hidden controls></audio>
</div>