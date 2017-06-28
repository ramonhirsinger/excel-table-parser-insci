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
        initResetBtn();
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
                subrowGroup.toggleClass('open');
                subrowGroup.toggleClass('closed');
                var glyph = $this.find('.toggle-arrow');
                if (glyph.hasClass('glyphicon-chevron-down')) {
                    glyph.removeClass('glyphicon-chevron-down');
                    glyph.addClass('glyphicon-chevron-up');
                } else {
                    glyph.addClass('glyphicon-chevron-down');
                    glyph.removeClass('glyphicon-chevron-up');
                }
            }
        });
    }

    function initResetBtn() {
        $('#perform_reset').click(function () {
            resetAll();
        });
    }

    function initSearchBtn() {
        $('#perform_search').click(function () {

            dayRows.removeClass('row-hidden');
            headRows.removeClass('row-hidden');
            $('.' + $subrows_group_class).addClass('closed');

            //FILTERS
            var dateFilter = $('select[name=in_date]').val();
            var timeFilter = $('select[name=in_time]').val();
            var plainTextFilter = $('input[name=in_plain_text]').val();
            var authorFilter = $('select[name=in_author]').val();

            //FILTER FOR DAYS

            if (dateFilter !== "null" || timeFilter !== "null" || "undefined" !== typeof plainTextFilter || authorFilter !== "null") {

                var resultless = $('.result-column');

                if (!resultless.hasClass('hidden')) {
                    resultless.addClass('hidden');
                }

                if (dateFilter !== null && dateFilter !== "null") {
                    parseRowsByParam("date", dateFilter);
                }

                if (timeFilter !== null && timeFilter !== "null") {
                    parseRowsByParam("time", timeFilter);
                }

                if (plainTextFilter !== "" && "undefined" !== typeof plainTextFilter) {
                    parseRowsByParam("text", plainTextFilter);
                }

                if (headRows.length === $('.row-hidden.head-rows').length) {
                    resultless.removeClass('hidden');
                }

                $('.day-rows').each(function () {
                    $this = $(this);
                    var rowset = $this.nextUntil('.day-rows');

                    if (rowset.filter('tr').length === rowset.filter('tr.row-hidden').length) {
                        $this.addClass('row-hidden');
                    }
                });


            } else {
                resetAll();
            }

        });
    }

    function resetAll() {
        dayRows.removeClass('row-hidden');
        headRows.removeClass('row-hidden');
    }

    function parseRowsByParam($param, $filterVal) {
        if ($param === "date") {
            //Date
            dayRows.each(function () {
                $this = $(this);
                dayVal = $this.find("input[type=hidden]").val();
                if ($filterVal === dayVal) {
                    $this.removeClass('row-hidden');
                } else {
                    $this.addClass('row-hidden');
                }
            });

            headRows.each(function () {
                $this = $(this);
                dayVal = $this.find(".head-row-anchor").attr('day');
                if ($filterVal === dayVal) {
                    $this.removeClass('row-hidden');
                } else {
                    $this.addClass('row-hidden');
                }

                if ($this.next().hasClass($subrows_group_class)) {
                    subrowGroup = $this.next();
                    subrowGroup.find('.' + $subrows_class).removeClass('row-hidden');
                } else {
                    subrowGroup = $this.next();
                    subrowGroup.find('.' + $subrows_class).addClass('row-hidden');
                }
            });
        }

        if ($param === "time") {
            dayRows.each(function () {
                $this = $(this);
                if (!$this.hasClass('row-hidden')) {
                    $this.nextUntil('.day-rows').each(function () {
                        var search_time = $(this).find('.search-anchor.head-row-anchor').attr('starttime');
                        if ("undefined" !== typeof search_time && search_time !== $filterVal) {
                            $(this).addClass('row-hidden');
                        } else {
                            $(this).removeClass('row-hidden');
                        }
                    });
                }
            });
        }

        if ($param === "text") {

            dayRows.each(function () {
                $this = $(this);
                if (!$this.hasClass('row-hidden')) {

                    $this.nextUntil('.day-rows').each(function () {
                        $this = $(this);

                        if ($this.hasClass('head-rows')) {

                            var title_symposium = $(this).find('.search-anchor.head-row-anchor').attr('title-symposium');
                            var chair = $(this).find('.search-anchor.head-row-anchor').attr('chair');

                            var headText = title_symposium + " " + chair;

                            if (headText.indexOf($filterVal) !== -1) {
                                $(this).removeClass('row-hidden');
                            } else {
                                $(this).addClass('row-hidden');
                            }
                        }

                        var text = $filterVal;

                        // Suche auf Ebene der Headrow
//                        if ("undefined" !== typeof search_time && search_time !== $filterVal) {
//                            $(this).addClass('row-hidden');
//                        } else {
//                            $(this).removeClass('row-hidden');
//                        }
                    });

                    console.log("---");
                }
            });
        }
    }

    return {
        init: init,
        printPage: printPage
    };

})();

