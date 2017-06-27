$(document).ready(function () {
    generalScript.init();
});

var generalScript = (function () {

    $NAV_ANIMATION_DELAY = 50;
    $NAV_TRANSITION_TIME = 200;


    var init = function () {
        startSelectric();
    }

    function startSelectric() {
        $('select').selectric();
    }
    
    return {
        init: init
    };

})();

