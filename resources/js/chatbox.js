export default class Chatbox {
    constructor() {
        //
    }
    build(options) {
        this.options = options;

        Echo.join(`private_conversation.${this.options.conversation_id}`)
        .here((profiles) => {
            console.log(profiles);
            Livewire.emitTo('connect.conversation.talk', 'markReceivedMessagesRead');
        })
        .joining((profile) => {
            console.log(profile.name + ' just joined');
            Livewire.emitTo('connect.conversation.talk', 'markReceivedMessagesRead');
        })
        .leaving((profile) => {
            console.log(profile.name + ' is leaving');
        })
        .listen('SentMessage', (e) => {
            var atBottom = this.atBottom();
            Livewire.emitTo('connect.conversation.talk', 'reloadMessages');
            Livewire.hook('message.processed', (message, compo) => {
                if (atBottom) {
                    window.scrollTo(0, document.body.scrollHeight);
                }
            });
            Livewire.emitTo('connect.conversation.talk', 'markReceivedMessagesRead');
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
