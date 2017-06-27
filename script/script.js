$(document).ready(function () {
    generalScript.init();
});

var generalScript = (function () {

    $NAV_ANIMATION_DELAY = 50;
    $NAV_TRANSITION_TIME = 200;

    $headrow_field_classes = "head-row-anchor";
    $subrow_field_classes = "sub-row-anchor";

    $subrows_group_class = "sub-row-group";
    $subrows_toggled_class = "open";
    $subrows_hidden_class = "closed";



    var init = function () {
        startSelectric();
        wrapSubRows();
    }

    function startSelectric() {
        $('select').selectric();
    }

    function wrapSubRows() {

        var found = {};

        $('input[type=hidden].head-row-anchor').each(function () {

            var $this = $(this);
            var rel = $this.attr("event-id");

            var rowstobewrapped = $('input[event-id=' + rel + '].sub-row-anchor').parent().parent();
            console.log(rowstobewrapped);

        });
    }

    return {
        init: init
    };

})();

