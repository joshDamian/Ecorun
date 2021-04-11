export default class {
    constructor() {
        //
    }
    stopAllMedia(object = null) {
        let audio_elements = document.querySelectorAll('audio');
        let video_elements = document.querySelectorAll('video');
        audio_elements.forEach(element => {
            if(element !== object) {
                element.pause();
            }
        });
        video_elements.forEach(element => {
            if(element !== object) {
                element.pause();
            }
        })
    }
}
