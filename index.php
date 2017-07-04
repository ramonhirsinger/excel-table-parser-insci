<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>excel-parser</title>
        <link rel="stylesheet" type="text/css" href="css/main.min.css" />
    </head>
    <body>
        <?php
        include './php/data/authorlist.php';
        include './php/data/events.php';
        include './php/lib/functions.php';
        ?>
        <div class="wrapper container">
            <section class="insci-search-form">
                <fieldset class="row mt-20 pt-20 mb-20 pb-20" id="table-filter-head">
                    <div class="col-xs-12">
                        <legend>Suche</legend>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <div class='input-group date' id='event-date-picker'>
                                <select type='text' name="in_date" class="form-control">
                                    <option value="null">Datum w&auml;hlen</option>
                                    <option value="18">Montag - 18.09.2017</option>
                                    <option value="19">Dienstag - 19.09.2017</option>
                                    <option value="20">Mittwoch - 20.09.2017</option>
                                </select>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="form-group">
                            <div class="input-group date">
                                <select class="form-control" name="in_time">
                                    <option value="null">Uhrzeit w&auml;hlen</option>
                                    <option value="09:00 Uhr">09:00 Uhr (a.m)</option>
                                    <option value="10:00 Uhr">10:00 Uhr (a.m)</option>
                                    <option value="11:00 Uhr">11:00 Uhr (a.m)</option>
                                    <option value="10:45 Uhr">10:45 Uhr (a.m)</option>
                                    <option value="12:15 Uhr">12:15 Uhr (p.m)</option>
                                    <option value="12:30 Uhr">12:30 Uhr (p.m)</option>
                                    <option value="13:15 Uhr">13:15 Uhr (p.m)</option>
                                    <option value="13:30 Uhr">13:30 Uhr (p.m)</option>
                                    <option value="13:45 Uhr">13:45 Uhr (p.m)</option>
                                    <option value="14:45 Uhr">14:45 Uhr (p.m)</option>
                                    <option value="15:15 Uhr">15:15 Uhr (p.m)</option>
                                    <option value="17:00 Uhr">17:00 Uhr (p.m)</option>
                                    <option value="18:15 Uhr">18:15 Uhr (p.m)</option>
                                    <option value="20:00 Uhr">20:00 Uhr (p.m)</option>
                                </select>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-hourglass"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <input type="text" class="form-control" name="in_plain_text" placeholder="Stichwortsuche" value=""/>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <div class="input-group">
                                <select class="form-control" name="in_author" placeholder="Autoren" id="search_author" >
                                    <option value="null">Verfügbare Autoren</option>
                                    <?php foreach ($authors as $key => $author_name): ?>
                                        <?php if ($author_name !== "."): ?>
                                            <option value="<?php echo $author_name; ?>"><?php echo $author_name; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                            </div>
                        </div>
                        <label class="mt-10 pull-right">Nach Co-Autoren Filtern <input id="check_coauthor" name="check_co_authors" class="ml-10" type="checkbox" /></label>
                    </div>
                    <div class="col-xs-6">
                        <button type="button" class="btn btn-default pull-left foot-button" aria-label="Ansicht drucken"  onClick="javascript:generalScript.printPage()">
                            <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="col-xs-6">
                        <button type="button" class="btn btn-default pull-right foot-button" id="perform_search" aria-label="Search">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span><span>
                                Suche
                            </span>
                        </button>
                        <button type="button" class="btn btn-default pull-right foot-button mr-20" id="perform_reset" aria-label="reset">
                            <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span><span>
                                Zur&uuml;cksetzen
                            </span>
                        </button>
                    </div>
                </fieldset>
                <div class="insci-search-body">
                    <div class="row">

                        <?php
                        $days = array(
                            "18" => "Montag, 18.09.2017",
                            "19" => "Dienstag, 19.09.2017",
                            "20" => "Mittwoch, 20.09.2017"
                        );
                        ?>
                        <div class="col-xs-12">
                            <table class="result-table">
                                <tbody>
                                    <?php $last_used_id = "empty"; ?>
                                    <!--DAYS FOREACH-->
                                    <?php foreach ($days as $day_key => $title): ?>
                                        <tr class="day-rows">
                                            <td>
                                                <input type="hidden" name="event_day" value="<?php echo $day_key; ?>" /><time class="date_table_head"><?php echo $title; ?></time>
                                            </td>
                                        </tr>
                                        <?php foreach ($events as $event_key => $event): ?>
                                            <?php if ($event['day'] === (string) $day_key): ?>
                                                <?php if ($last_used_id === "empty" || $last_used_id !== $event['symposium_id']): ?>
                                                    <?php $current_id = $event['symposium_id']; ?>
                                                    <tr class="head-rows">
                                                        <td>
                                                            <?php if ($event['symposium_id'] !== "0"): ?>
                                                                <input class="search-anchor head-row-anchor" 
                                                                       type="hidden"
                                                                       day="<?php echo $day_key; ?>" 
                                                                       starttime="<?php echo getTimeString($event['starttime']); ?>"
                                                                       room="<?php echo $event['room']; ?>"
                                                                       chair="<?php echo $event['chair']; ?>"
                                                                       row-type="head" 
                                                                       event-id="<?php echo $event['symposium_id']; ?>"
                                                                       title-symposium='<?php echo stripslashes($event['title_symposium']); ?>'
                                                                       />
                                                                   <?php else: ?>
                                                                <input class="search-anchor head-row-anchor" 
                                                                       type="hidden" 
                                                                       day="<?php echo $day_key; ?>" 
                                                                       starttime="<?php echo getTimeString($event['starttime']); ?>" 
                                                                       row-type="head" 
                                                                       room="<?php echo $event['room']; ?>"
                                                                       title-symposium='<?php echo stripslashes($event['title_symposium']); ?>'
                                                                       />
                                                                   <?php endif; ?>
                                                            <table class="table_row_box <?php getStyleClassById($current_id) ?>">
                                                                <tbody>
                                                                    <tr>

                                                                        <?php if ($event['title_symposium'] !== "Lesung"): ?>
                                                                            <td>
                                                                                <?php if ($event['symposium_id'] !== "0"): ?>
                                                                                    <i class="toggle-arrow glyphicon glyphicon-chevron-down mr-30"></i>
                                                                                <?php endif; ?>
                                                                                <?php echo "<span><b>" . stringNotZero($event['symposium_id']) . "</b>" . stripslashes($event['title_symposium']) . "</span>"; ?></td>
                                                                        <?php else: ?>
                                                                            <td><?php echo "<a class='full-link' target='_blank' href='https://www.suchtkongress2017.de/programm/oeffentliche-lesung/'><b>" . stringNotZero($event['symposium_id']) . "</b>" . stripslashes($event['title_symposium']) . "</a>"; ?></td>
                                                                        <?php endif; ?>
                                                                        <td class="t-c-20">
                                                                            <div class="container-fluid">
                                                                                <div class="col-xs-6"><span>Zeit:</span></div>
                                                                                <div class="col-xs-6"><?php echo "<b>" . getTimeString($event['starttime']) . "</b>"; ?></div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <?php if ($event['title_symposium'] !== "Pause" && $event['title_symposium'] !== "Posterpause"): ?>
                                                                        <tr>
                                                                            <!--<td class="w44px"></td>-->
                                                                            <td>
                                                                                <?php if ($event['chair'] !== "-"): ?>
                                                                                    <?php echo "<span class='ml-49'>Chairs: </span> " . $event['chair']; ?>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                            <td class="t-c-20">
                                                                                <?php if ($event['room'] !== "-"): ?>
                                                                                    <div class="container-fluid">
                                                                                        <div class="col-xs-6"><span>Raum:</span></div>
                                                                                        <div class="col-xs-6"><?php echo "<b>" . $event['room'] . "</b>"; ?></div>
                                                                                    </div>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                <?php else: ?>
                                                    <tr class="sub-rows <?php echo $event['symposium_id']; ?>">
                                                        <td>
                                                            <input class="search-anchor sub-row-anchor" 
                                                                   type="hidden"
                                                                   day="<?php $day_key; ?>" 
                                                                   starttime="<?php echo getTimeString($event['starttime']); ?>"
                                                                   row-type="sub" 
                                                                   event-id="<?php echo $event['symposium_id']; ?>" 
                                                                   reading-id="<?php echo $event['id']; ?>" 
                                                                   contribution-title="<?php echo $event['title_contribution']; ?>" 
                                                                   presenter-name="<?php echo $event['presenter']; ?>" 
                                                                   copresenters-name="<?php echo $event['other_presenters']; ?>" 

                                                                   />
                                                            <table class="table_row_box">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="t-c-10 align-top"><?php echo "<span class='reading-id'><b>" . $event['id'] . "</b></span>"; ?></td>
                                                                        <td colspan="3"><?php echo "<p><b>" . $event['title_contribution'] . "</b></p>"; ?></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="t-c-10 align-top"><span>Autor(in): </span></td>
                                                                        <td class="t-c-20 align-top">
                                                                            <?php echo "<span>" . $event['presenter'] . "</span>"; ?>
                                                                        </td>
                                                                        <td class="t-c-20 align-top">
                                                                            <?php if ($event['other_presenters'] !== "" && $event['other_presenters'] !== "-"): ?>
                                                                                <span>Weitere Autoren(innen):</span>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td class="t-c-50 align-top">
                                                                            <?php if ($event['other_presenters'] !== "" && $event['other_presenters'] !== "-"): ?>
                                                                                <?php echo "<span>" . $event['other_presenters'] . "</span>"; ?>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>

                                                <?php
                                                $last_used_id = $current_id;
                                                if ($last_used_id === "0") {
                                                    $last_used_id = "empty";
                                                }
                                                ?>

                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    <!--END DAYS FOREACH-->
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xs-12 hidden result-column">
                            <h4>Keine Suchergebnisse</h4>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script type="text/javascript" src="js/main.js"></script>
    </body>
</html>
