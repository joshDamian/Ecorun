require('./bootstrap');
require('flickity/js/flickity.js');

import Uihelpers from './uihelpers';
import Chatbox from './chatbox';
import MediaHelpers from './mediahelpers';

window.UiHelpers = new Uihelpers();
window.ChatBox = new Chatbox();
window.MediaHelpers = new MediaHelpers();
