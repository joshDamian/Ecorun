require('./bootstrap');

class ModifyUrl {
    modify(url) {
        var state = {
            id: 100
        }
        return window.history.replaceState(state, url, url);
    }
}

window.modifyUrl = new ModifyUrl();