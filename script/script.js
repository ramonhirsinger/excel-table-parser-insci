$(document).ready(function () {
    generalScript.init();
});

var generalScript = (function () {

    $NAV_ANIMATION_DELAY = 50;
    $TRANSITION_TIME = 200;

    $headrow_field_classes = "head-row-anchor";
    $subrow_field_classes = "sub-row-anchor";

    $subrows_group_class = "sub-row-group";
    $subrows_toggled_class = "open";
    $subrows_hidden_class = "closed";
    
    $subrows_class = "sub-rows";

    var dayRows = $('.day-rows');
    var headRows = $('.head-rows');
    var subRows = $('.sub-rows');

    var init = function () {
        startSelectric();
        wrapSubRows();
        initIeadRowToggle();
        initSearchBtn();
    }


    var printPage = function () {
        focus();
        if (window.print) {
            isConfirmed = confirm('Wollen Sie den abgebildeten Zeitplan drucken?');
            if (isConfirmed)
                window.print();
        }
    }

    function startSelectric() {
        $('select').selectric();
    }

    function wrapSubRows() {
        $('input[type=hidden].' + $headrow_field_classes).each(function () {
            var $this = $(this);
            var rel = $this.attr("event-id");
            var rowstobewrapped = $('input[event-id=' + rel + '].' + $subrow_field_classes).parent().parent();
            rowstobewrapped.wrapAll("<div class='" + $subrows_group_class + " closed' rel-parent-id='" + rel + "'/>");
        });
    }

    function initIeadRowToggle() {
        $('.head-rows').click(function () {
            var $this = $(this);
            var subrowGroup = null;
            if ($this.next().hasClass($subrows_group_class)) {
                subrowGroup = $this.next();
                subrowGroup.slideToggle($TRANSITION_TIME);
            }
        });
    }

    function initSearchBtn() {
        $('#perform_search').click(function () {

            //FILTERS
            var dateFilter = $('select[name=in_date]').val();
            var timeFilter = $('select[name=in_time]').val();
            var plainTextFilter = $('select[name=in_plain_text]').val();
            var authorFilter = $('select[name=in_author]').val();

            dayRows.addClass('row-hidden');
            headRows.addClass('row-hidden');
            subRows.addClass('row-hidden');

            //FILTER FOR DAYS
            if (dateFilter !== null && dateFilter !== "null") {
                parseRowsByParam("date", dateFilter);
            }
        });
    }

    function parseRowsByParam($param, $filterVal) {
        if ($param === "date") {
            //Date
            dayRows.each(function () {
                $this = $(this);
                dayVal = $this.find("input[type=hidden]").val();
                if ($filterVal === dayVal) {
                    $this.removeClass('row-hidden');
                }
            });

            headRows.each(function () {
                $this = $(this);
                dayVal = $this.find(".head-row-anchor").attr('day');
                if ($filterVal === dayVal) {
                    $this.removeClass('row-hidden');
                }

                if ($this.next().hasClass($subrows_group_class)) {
                    subrowGroup = $this.next();
                    subrowGroup.find('.' + $subrows_class).removeClass('row-hidden');
                }
            });
        }
    }

    return {
        init: init,
        printPage: printPage
    };

})();

