require('./bootstrap');
require('flickity/js/flickity.js');

import Flickity from 'flickity';

class ModifyUrl {
    modify(url) {
        var state = {
            id: "100"
        }
        return window.history.replaceState(state, url, url);
    }
}

class Carousel {
    build(el, options) {
        return new Flickity(el, options);
    }
}

window.modifyUrl = new ModifyUrl();
window.Carousel = new Carousel();