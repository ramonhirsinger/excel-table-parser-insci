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
        <script type="text/javascript" src="js/main.min.js"></script>
    </head>
    <body>
        <div class="wrapper container">
            <section class="insci-search-form">
                <fieldset class="row mt-20 pt-20 mb-20 pb-20">
                    <div class="col-xs-12">
                        <legend>Suche</legend>
                    </div>
                    <div class="col-xs-2">
                        <div class="form-group">
                            <div class='input-group date' id='event-date-picker'>
                                <select type='text' name="in_date" class="form-control">
                                    <option value="0">Datum</option>
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
                        <select class="form-control" name="in_time">
                            <option>10:00 Uhr (a.m)</option>
                            <option>10:45 Uhr (a.m)</option>
                            <option>13:15 Uhr (p.m)</option>
                            <option>15:15 Uhr (p.m)</option>
                            <option>17:00 Uhr (p.m)</option>
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <input class="form-control" name="in_plain_text" placeholder="Stichwortsuche" />
                    </div>
                    <div class="col-xs-4">
                        <select class="form-control" name="in_author" placeholder="Autoren">

                        </select>
                        <label class="mt-10 pull-right">Nach Co-Autoren Filtern <input name="check_co_authors" class="ml-10" type="checkbox" /></label>
                    </div>
                    <div class="col-xs-12">
                        <a class="btn btn-default pull-right mt-20" href="" id="perform_search">Suchen</a>
                    </div>
                </fieldset>
                <div class="insci-search-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4>Keine Suchergebnisse</h4>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
