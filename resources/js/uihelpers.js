import Flickity from 'flickity';
export default class Uihelpers {
    constructor() {
        //
    }
    modifyUrl(url) {
        var state = {
            id: "100"
        }
        return window.history.replaceState(state, url, url);
    }
    buildCarousel(el, options) {
        return new Flickity(el, options);
    }
    autosizeTextarea(object, maxSize) {
        object.style.cssText = 'height:auto;';
        var scrollHeight = object.scrollHeight;
        if(scrollHeight <= maxSize) {
            object.style.cssText = 'height:' + scrollHeight + 'px;';
        } else {
            object.style.cssText = 'height:' + maxSize + 'px;';
        }
        return;
    }
}
