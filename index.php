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
                <?php include './filter.php '; ?>
                <div class="insci-search-body">
                    <div class="row">
                        <div class="col-xs-12 hidden">
                            <h4>Keine Suchergebnisse</h4>
                        </div>
                        <?php
                        $days = array(
                            "18" => "Montag, 18.09.2017",
                            "19" => "Dienstag, 19.09.2017",
                            "20" => "Mittwoch, 20.09.2017"
                        );
                        ?>
                        <div class="col-xs-12">
                            <table>
                                <tbody>
                                    <?php $last_used_id = "empty"; ?>
                                    <!--DAYS FOREACH-->
                                    <?php foreach ($days as $day_key => $title): ?>
                                        <tr><td><input type="hidden" name="event_day" value="<?php echo $day_key; ?>" /><time class="date_table_head"><?php echo $title; ?></time></td></tr>
                                        <?php foreach ($events as $event_key => $event): ?>
                                            <?php if ($event['day'] === (string) $day_key): ?>
                                                <?php if ($last_used_id === "empty" || $last_used_id !== $event['symposium_id']): ?>
                                                    <?php $current_id = $event['symposium_id']; ?>
                                                    <!------->
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
                                                                       />
                                                                   <?php else: ?>
                                                                <input class="search-anchor pause-row-anchor" type="hidden" day="<?php $day_key; ?>" row-type="head" />
                                                            <?php endif; ?>
                                                            <table class="table_row_box <?php getStyleClassById($current_id) ?>">
                                                                <tbody>
                                                                    <tr>
                                                                        <td><?php echo "<span><b>" . stringNotZero($event['symposium_id']) . "</b>" . stripslashes($event['title_symposium']) . "</span>"; ?></td>
                                                                        <td class="t-c-10"><?php echo "<span><b>" . getTimeString($event['starttime']) . "</b></span>"; ?></td>
                                                                    </tr>
                                                                    <?php if ($event['title_symposium'] !== "Pause" && $event['title_symposium'] !== "Posterpause"): ?>
                                                                        <tr>
                                                                            <td>
                                                                                <?php if ($event['chair'] !== "-"): ?>
                                                                                    <?php echo "<span>Chairs: </span> " . $event['chair']; ?>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                            <td class="t-c-10">
                                                                                <?php if ($event['room'] !== "-"): ?>
                                                                                    <?php echo "<span>Raum: <b>" . $event['room'] . "</b></span>"; ?>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <!------->  
                                                <?php else: ?>
                                                    <!---SUBROW START---->
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
                                                                        <td class="t-c-10 align-top"><span>Autor: </span></td>
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
                                                    <!---SUBROW END---->
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
                    </div>
                </div>
            </section>
        </div>
        <script type="text/javascript" src="js/main.js"></script>
    </body>
</html>
