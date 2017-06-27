<fieldset class="row mt-20 pt-20 mb-20 pb-20" id="table-filter-head">
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