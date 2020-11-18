require('./bootstrap');

window.modifyUrl = function (url) {
    var state = {
        id: "100"
    };
    
    window.history.replaceState(
        state
        , url
        , url
    );
};
