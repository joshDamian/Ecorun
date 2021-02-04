export default class Chatbox {
    constructor() {
        //
    }
    build(options) {
        this.options = options;

        Echo.join(`private_conversation.${this.options.conversation_id}`)
        .here((profiles) => {
            console.log(profiles);
            Livewire.emit('markReceivedMessagesRead');
        })
        .joining((profile) => {
            console.log(profile.name + ' just joined');
            Livewire.emit('markReceivedMessagesRead');
        })
        .leaving((profile) => {
            console.log(profile.name + ' is leaving');
        })
        .listen('SentMessage', (e) => {
            var atBottom = this.atBottom();
            Livewire.emit('reloadMessages');
            Livewire.hook('message.processed', (message, compo) => {
                if (atBottom) {
                    window.scrollTo(0, document.body.scrollHeight);
                }
            });
            Livewire.emit('markReceivedMessagesRead');
        })
        .listenForWhisper('typing', () => {
            return this.options.whispers_callback.typing_callback();
        })
        .listenForWhisper('doneTyping', () => {
            return this.options.whispers_callback.doneTyping_callback();
        })
        .listenForWhisper('readMessages', () => {
            return this.options.whispers_callback.readMessages_callback();
        });
        return this;
    }
    whisper(message) {
        Echo.join(`private_conversation.${this.options.conversation_id}`).whisper(message);
    }
    close() {
        Livewire.emit('showAll');
        window.UiHelpers.modifyUrl('/chat');
        Livewire.emit('hide', false);
    }
    goToBottom() {
        window.scrollTo(0, document.body.scrollHeight)
    }
    atBottom() {
        return (window.innerHeight + Math.ceil(window.pageYOffset + 1 + this.options.textbox_cont.scrollHeight)) >= document.body.offsetHeight;
    }
}
