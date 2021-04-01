function content_data() {
    return {
        ready: false,
        edit_case: false,
        preview_ready: {
            videos: false,
            audio: false,
            cover_art: false
        },
        message: '',
        view_status: {
            videos: false,
            photos: false,
            audio: false,
            music: true,
        },
        set_view_status: function(view) {
            for (index in this.view_status) {
                if (index === view) {
                    this.view_status[index] = true;
                    continue;
                }
                this.view_status[index] = false;
            }
            return;
        },
        file_display_elements: {
            videos: 'video',
            audio: 'audio',
            music: 'audio',
            cover_art: 'img'
        },
        current_mention: '',
        canNowDisplayTrackData: false,
        current_hashtag: '',
        large_content: false,
        mentions: [],
        hashtags: [],
        hashtag_match: /(^|\s)#([A-Za-z0-9_-]{1,100}(?!\w))$/,
        mentions_match: /(^|\s)@([A-Za-z0-9_-]{1,30}(?!\w))$/,
        mention_matches: [],
        hashtag_matches: [],
        match: function() {
            this.mention_matches = this.message.match(this.mentions_match);
            this.hashtag_matches = this.message.match(this.hashtag_match);
        },
        resetHeight: function() {
            this.message = '';
            this.large_content = false;
            this.$refs.content.style.cssText = 'height:auto;';
            this.$refs.content.rows = '1';
        },
        replaceText: function(initial, replacement) {
            let setMessage = new Promise((resolve, reject) => {
                if (this.message !== '') {
                    this.message = this.message.replace(new RegExp(initial + '$'), replacement + ' ');
                    this.$refs.content.focus();
                    resolve(this.message);
                } else {
                    reject('couldn\'t update message property');
                }
            });
            setMessage.then(result => {
                setTimeout(() => {
                    document.getElementById('text_content_').dispatchEvent(new Event('input'))
                }, 50);
            }).catch(x => console.error(x))
        },
        initialize: function() {
            var type = '{{$type}}';
            this.edit_case = (type.match('edit'));
            if (this.edit_case) {
                this.ready = true;
                this.message = this.$wire.text_content;
                window.addEventListener('DOMContentLoaded', () => {
                    this.$refs.content.style.cssText = 'height:' + this.$refs.content.scrollHeight + 'px;';
                })
            }
            Livewire.on('addedContent',
                () => {
                    this.ready = false;
                    this.resetHeight();
                }
            );
            this.$watch('ready',
                value => {
                    Livewire.emit('toggled', this.ready);
                    if (!value) {
                        this.mentions = [];
                        this.hashtags = []
                    }
                }
            );
            /** autosuggest mentions **/
            this.$watch('mention_matches',
                value => {
                    if (value && value.length > 0) {
                        this.current_mention = value[2];
                        this.$wire.hintMentions(this.current_mention).then(result => {
                            this.mentions = result
                        });
                    } else {
                        this.current_mention = '';
                        this.mentions = [];
                    }
                }
            );
            /** autosuggest hashtags **/
            this.$watch('hashtag_matches',
                value => {
                    if (value && value.length > 0) {
                        this.current_hashtag = value[2];
                        this.$wire.hintHashtags(this.current_hashtag).then(result => {
                            this.hashtags = result
                        });
                    } else {
                        this.current_hashtag = '';
                        this.hashtags = [];
                    }
                }
            );
            /** watch message **/
            this.$watch('message',
                value => {
                    window.UiHelpers.autosizeTextarea(this.$refs.content, 140)
                    if (value !== '') {
                        this.ready = true;
                        this.match();
                    }
                    if (this.$refs.content.scrollHeight > 140) {
                        this.large_content = true;
                    } else {
                        this.large_content = false;
                    }
                }
            );
        },
        clearDisplay: function(display) {
            return display.innerHTML = '';
        },
        selectReadDisplay: function(type, files, append_to, const_element = null) {
            append_to.innerHTML = '';
            this.preview_ready[type] = false;
            if (files.length > 0) {
                this.preview_ready[type] = true;
                for (const index in files) {
                    if (Object.hasOwnProperty.call(files, index)) {
                        let file = files[index];
                        let reader = new FileReader();
                        //create elements
                        let display_element = document.createElement(this.file_display_elements[type]);
                        let div_element = document.createElement('div');
                        let name_card = document.createElement('div');
                        let progress_bar = document.createElement('progress');
                        name_card.innerText = file.name;
                        name_card.classList.add('px-2', 'py-1', 'bg-white', 'mt-2', 'truncate', 'dont-break-out');
                        div_element.classList.add('p-2', 'bg-gray-100');
                        div_element.setAttribute('wire:ignore', true);
                        display_element.classList.add('w-full');
                        progress_bar.classList.add('pt-2');

                        // append elements to DOM
                        div_element.appendChild(display_element);
                        div_element.appendChild(progress_bar);
                        div_element.appendChild(name_card);
                        append_to.appendChild(div_element);

                        //read file
                        let readFile = new Promise((resolve, reject) => {
                            reader.onload = (event) => {
                                let src = event.target.result;
                                if (src !== '') {
                                    resolve(src);
                                    progress_bar.classList.add('hidden');
                                    progress_bar.value = 0;
                                } else {
                                    reject('couldn\'t read file properly');
                                }
                            };
                            reader.onprogress = (event) => {
                                if (event.total && event.loaded) {
                                    progress_bar.value = Math.round((event.loaded / event.total) * 100)
                                }
                            }
                            reader.readAsDataURL(file);
                        });
                        readFile.then(result => {
                            display_element.setAttribute('src', result);
                            display_element.setAttribute('controls', true);
                            if (type === 'music') {
                                //var audioCtx = new (window.AudioContext || window.webkitAudioContext);
                                if(this.canNowDisplayTrackData) {
                                    let readAsBuffer = new Promise((resolve, reject) => {
                                        reader.onload = (event) => {
                                            let buffer = event.target.result;
                                            if (buffer !== '') {
                                                resolve(buffer);
                                            } else {
                                                reject('couldn\'t read file properly');
                                            }
                                        }
                                        reader.readAsArrayBuffer(file);
                                    });
                                    readAsBuffer.then(result => {
                                        var dataView = new window.jDataView(result)
                                        console.log(dataView.getString(4, dataView.tell()));
                                    }).catch(error => console.log(error));
                                }
                                this.$refs.music_title.value = file.name;
                            }
                        }).catch(error => console.error(error));
                    }
                }
            }
            return;
        },
    }
}
