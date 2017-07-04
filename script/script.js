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
    var subrowgroups = $('.' + $subrows_group_class);
    var subRows = $('.sub-rows');
    var toggle_arrows = $('.toggle-arrow');

    var coauthorFilter = $('#check_coauthor');

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
            resetFields();
        });
    }

    function resetFields() {
        $('select').selectric('init');
        $('input[name=in_plain_text]').val("");
        $('#check_coauthor').prop("checked", false);
    }

    function initSearchBtn() {
        $('#perform_search').click(function () {

            dayRows.removeClass('row-hidden');
            headRows.removeClass('row-hidden');
            subRows.removeClass('row-hidden');

            $arrows = $('.toggle-arrow');
            $arrows.removeClass('glyphicon-chevron-up');
            $arrows.addClass('glyphicon-chevron-down');
            $('.' + $subrows_group_class).removeClass('open').addClass('closed');

            //FILTERS
            var dateFilter = $('select[name=in_date]').val();
            var timeFilter = $('select[name=in_time]').val();
            var plainTextFilter = $('input[name=in_plain_text]').val();
            var authorFilter = $('select[name=in_author]').val();


            //FILTER FOR DAYS
            if (dateFilter !== "null" || timeFilter !== "null" || plainTextFilter !== "" || authorFilter !== "null") {
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

                if (plainTextFilter !== "") {
                    console.log("hallo");
                    parseRowsByParam("text", plainTextFilter);
                }

                if (authorFilter !== null && authorFilter !== "null") {
                    parseRowsByParam("author", authorFilter);
                }

                $('.day-rows').each(function () {
                    $this = $(this);
                    var rowset = $this.nextUntil('.day-rows');

                    if (rowset.filter('tr').length === rowset.filter('tr.row-hidden').length) {
                        $this.addClass('row-hidden');
                    }
                });

                if (headRows.length === $('.row-hidden.head-rows').length) {
                    resultless.removeClass('hidden');
                }
            } else {
                resetAll();
            }
        });
    }

    function resetAll() {
        dayRows.removeClass('row-hidden');
        headRows.removeClass('row-hidden');
        $('.' + $subrows_group_class).removeClass('open').addClass('closed');
        subRows.removeClass('row-hidden');
        resetArrows();

    }

    function resetArrows() {
        toggle_arrows.removeClass('glyphicon-chevron-up');
        toggle_arrows.addClass('glyphicon-chevron-down');
    }

    function parseRowsByParam($param, $filterVal) {

        resetArrows();

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
                        $headrow = $(this);
                        if (!$headrow.hasClass('row-hidden')) {
                            var search_time = $headrow.find('.search-anchor.head-row-anchor').attr('starttime');
                            if ("undefined" !== typeof search_time && search_time !== $filterVal) {
                                $headrow.addClass('row-hidden');
                            } else {
                                $headrow.removeClass('row-hidden');
                            }
                        }
                    });
                }
            });
        }

        if ($param === "text") {
            dayRows.each(function () {
                $this = $(this);

//                subRows.removeClass('.row-hidden');
//                $('.' + $subrows_group_class).addClass('closed');

                if (!$this.hasClass('row-hidden')) {
                    $this.nextUntil('.day-rows').each(function () {
                        $headrow = $(this);
                        if ($headrow.hasClass('head-rows') && !$headrow.hasClass('row-hidden')) {

                            var title_symposium = $(this).find('.search-anchor.head-row-anchor').attr('title-symposium');
                            var chair = $(this).find('.search-anchor.head-row-anchor').attr('chair');
                            var contribution_title = $(this).find('.search-anchor.head-row-anchor').attr('contribution-title');

                            $headrow = $(this);
                            $subrowgroup = $headrow.next();
                            $arrow = $headrow.find('.toggle-arrow');

                            var headText = title_symposium + " " + chair;
                            if (headText.indexOf($filterVal) !== -1) {
                                $(this).removeClass('row-hidden');
                            } else {
                                $(this).addClass('row-hidden');
                            }

                            if ($subrowgroup.hasClass($subrows_group_class)) {
                                var subrows = $subrowgroup.find('.' + $subrows_class);
                                $subrow = null;
                                subrows.each(function () {
                                    $subrow = $(this);
                                    var contribution_title = $subrow.find('.search-anchor.sub-row-anchor').attr('contribution-title');
                                    if (contribution_title.indexOf($filterVal) !== -1) {
                                        $headrow.removeClass('row-hidden');
                                        $arrow.removeClass('glyphicon-chevron-down');
                                        $arrow.addClass('glyphicon-chevron-up');
                                        $subrow.closest('.sub-row-group').removeClass('closed');
                                        $subrow.closest('.sub-row-group').addClass('open');
                                        $subrow.removeClass('row-hidden');
                                    } else {
                                        $(this).addClass('row-hidden');
                                    }
                                });
                            }

                            if (!$headrow.hasClass('row-hidden')) {
                                if ($subrowgroup.find('.row-hidden').length === $subrowgroup.find('.sub-rows').length) {
                                    $subrowgroup.find('.sub-rows').removeClass('row-hidden');
                                }
                            }
                        }
                    });
                }
            });
        }
        if ($param === "author") {
            $('.other-event').parent().parent().addClass('row-hidden');
            dayRows.each(function () {
                $this = $(this);
                if (!$this.hasClass('row-hidden')) {
                    $this.nextUntil('.day-rows').each(function () {
                        $headrow = $(this);
                        $subrowgroup = $headrow.next();
                        if (!$headrow.hasClass('row-hidden')) {
                            if ($subrowgroup.hasClass($subrows_group_class)) {
                                var subrows = $subrowgroup.find('.' + $subrows_class);
                                $subrow = null;
                                subrows.each(function () {
                                    $subrow = $(this);
                                    $presenter = $subrow.find('.search-anchor.sub-row-anchor').attr("presenter-name").split(',');
                                    $copresenterlist = null;

                                    if (!$subrow.hasClass('row-hidden')) {
                                        if (coauthorFilter.is(':checked')) {
                                            $copresenter = $subrow.find('.search-anchor.sub-row-anchor').attr("copresenters-name");
                                            if ($copresenter.indexOf(',') > -1) {
                                                $copresenterlist = $copresenter.split(',');
                                                for ($j = 0; $j < $copresenterlist.length; $j++) {
                                                    $copresenterlist[$j] = $.trim($copresenterlist[$j]) + ".";
                                                }
                                            } else {
                                                $copresenter = $copresenterlist;
                                            }
                                        }
                                        if (coauthorFilter.is(':checked')) {
                                            $presenter = $presenter[0] + ".";
                                            if ($.inArray($filterVal, $copresenterlist) > -1 || $presenter === $filterVal) {
                                                $subrow.parent().removeClass('closed');
                                                $subrow.removeClass('row-hidden');
                                                $arrow = $headrow.find('.toggle-arrow');
                                                $arrow.removeClass('glyphicon-chevron-down');
                                                $arrow.addClass('glyphicon-chevron-up');
                                                $headrow.removeClass('row-hidden');
                                            } else {
                                                $subrow.addClass('row-hidden');
                                            }
                                        } else {
                                            $presenter = $presenter[0] + ".";
                                            if ($presenter === $filterVal) {
                                                $subrow.parent().removeClass('closed');
                                                $subrow.removeClass('row-hidden');
                                                $arrow = $headrow.find('.toggle-arrow');
                                                $arrow.removeClass('glyphicon-chevron-down');
                                                $arrow.addClass('glyphicon-chevron-up');
                                                $headrow.removeClass('row-hidden');
                                            } else {
                                                $subrow.addClass('row-hidden');
                                            }
                                        }

                                    }
                                });

                                if ($subrowgroup.find('.row-hidden').length === $subrowgroup.find('.' + $subrows_class).length) {
                                    $headrow.addClass('row-hidden');
                                }
                            }
                        }
                    });
                }
            });
        }
    }

    return {
        init: init,
        printPage: printPage
    };

})();

