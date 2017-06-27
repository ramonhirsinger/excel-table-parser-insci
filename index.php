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
        ?>
        <div class="wrapper container">
            <section class="insci-search-form">
                <fieldset class="row mt-20 pt-20 mb-20 pb-20">
                    <div class="col-xs-12">
                        <legend>Suche</legend>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <div class='input-group date' id='event-date-picker'>
                                <select type='text' name="in_date" class="form-control">
                                    <option value="null">Datum</option>
                                    <option value="18.09.2017">Montag - 18.09.2017</option>
                                    <option value="19.09.2017">Dienstag - 19.09.2017</option>
                                    <option value="20.09.2017">Mittwoch - 20.09.2017</option>

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
                                    <option value="null">Uhrzeit</option>
                                    <option>10:00 Uhr (a.m)</option>
                                    <option>10:45 Uhr (a.m)</option>
                                    <option>13:15 Uhr (p.m)</option>
                                    <option>15:15 Uhr (p.m)</option>
                                    <option>17:00 Uhr (p.m)</option>
                                </select>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-hourglass"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <input class="form-control" name="in_plain_text" placeholder="Stichwortsuche" />
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <div class="input-group">
                                <select class="form-control" name="in_author" placeholder="Autoren" id="search_author" >
                                    <option value="null">Verfügbare Autoren</option>
                                    <?php foreach ($authors as $key => $author_name): ?>
                                        <?php if ($author_name !== "."): ?>
                                            <option value="<?php echo $key; ?>"><?php echo $author_name; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                            </div>
                        </div>
                        <label class="mt-10 pull-right">Nach Co-Autoren Filtern <input name="check_co_authors" class="ml-10" type="checkbox" /></label>
                    </div>
                    <div class="col-xs-12">
                        <a class="btn btn-default pull-right mt-20" href="" id="perform_search">Suchen</a>
                    </div>
                </fieldset>
                <div class="insci-search-body">
                    <div class="row">
                        <div class="col-xs-12 hidden">
                            <h4>Keine Suchergebnisse</h4>
                        </div>
                        <div class="col-xs-12">
                            <table>
                                <tbody>
                                    <?php $last_used_symposium_id = "empty"; ?>
                                    <?php $last_used_plenar_id = "empty"; ?>
                                    <tr><td><input type="hidden" name="event_day" value="18" /><time class="date_table_head">Montag, 18.09.2017</time></td></tr>
                                    <?php foreach ($events as $event_key => $event): ?>
                                        <!------->
                                        <?php if ($event['day'] === "18"): ?>
                                            <?php if ($last_used_symposium_id === "empty" || $last_used_symposium_id !== $event['symposium_id'] && substr($event['symposium_id'], 0, 1) !== "P"): ?>
                                                <?php $current_symposium_id = $event['symposium_id']; ?>
                                                <tr>
                                                    <td>
                                                        <div class="table_row_box <?php if($event['symposium_id'] === "0"){ echo "id_zero"; }?>">
                                                             <?php echo "<span>" . stripslashes($event['title_symposium']) . "</span>"; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php
                                            $last_used_symposium_id = $current_symposium_id;
                                            $last_used_plenar_id = $current_plenar_id;
                                            ?>
                                        <?php endif; ?>
                                        <!------->        
                                    <?php endforeach; ?>
                                        <tr><td><input type="hidden" name="event_day" value="19" /><time class="date_table_head">Dienstag, 19.09.2017</time></td></tr>
                                    <?php foreach ($events as $event_key => $event): ?>
                                        <!------->
                                        <?php if ($event['day'] === "19"): ?>
                                            <?php if ($last_used_symposium_id === "empty" || $last_used_symposium_id !== $event['symposium_id'] && substr($event['symposium_id'], 0, 1) !== "P"): ?>
                                                <?php $current_symposium_id = $event['symposium_id']; ?>
                                                <tr>
                                                    <td>
                                                        <div class="table_row_box <?php if($event['symposium_id'] === "0"){ echo "id_zero"; }?>">
                                                             <?php echo "<span>" . stripslashes($event['title_symposium']) . "</span>"; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php
                                            $last_used_symposium_id = $current_symposium_id;
                                            $last_used_plenar_id = $current_plenar_id;
                                            ?>
                                        <?php endif; ?>
                                        <!------->        
                                    <?php endforeach; ?>
                                    <tr><td><input type="hidden" name="event_day" value="20" /><time class="date_table_head">Mittwoch, 20.09.2017</time></td></tr>
                                    <?php foreach ($events as $event_key => $event): ?>
                                        <!------->
                                        <?php if ($event['day'] === "20"): ?>
                                            <?php if ($last_used_symposium_id === "empty" || $last_used_symposium_id !== $event['symposium_id'] && substr($event['symposium_id'], 0, 1) !== "P"): ?>
                                                <?php $current_symposium_id = $event['symposium_id']; ?>
                                                <tr>
                                                    <td>
                                                       <div class="table_row_box <?php if($event['symposium_id'] === "0"){ echo "id_zero"; }?>">
                                                             <?php echo "<span>" . stripslashes($event['title_symposium']) . "</span>"; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php
                                            $last_used_symposium_id = $current_symposium_id;
                                            $last_used_plenar_id = $current_plenar_id;
                                            ?>
                                        <?php endif; ?>
                                        <!------->        
                                    <?php endforeach; ?>
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
