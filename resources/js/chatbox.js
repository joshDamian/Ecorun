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
            this.options.whispers_callback.typing_callback();
        })
        .listenForWhisper('doneTyping', () => {
            this.options.whispers_callback.doneTyping_callback();
        })
        .listenForWhisper('readMessages', () => {
            this.options.whispers_callback.readMessages_callback();
        });
        return this;
    }
    whisper(message) {
        Echo.join(`private_conversation.${this.options.conversation_id}`).whisper(message);
    }
    close() {
        Echo.leaveChannel(`private_conversation.${this.options.conversation_id}`);
        window.location = '/chat';
    }
    goToBottom() {
        this.options.messages_cont.scrollTo(0, this.options.messages_cont.scrollHeight);
        window.scrollTo(0, document.body.scrollHeight);
    }
    atBottom() {
        return (Math.ceil(this.options.messages_cont.scrollHeight - this.options.messages_cont.scrollTop - this.options.messages_cont.clientHeight) < 1);
    }
    goToTop() {
        this.options.messages_cont.scrollTo(0, 0);
        window.scrollTo(0, 0);
    }
}