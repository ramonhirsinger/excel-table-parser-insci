
<?php

/**
 * Diese Datei parsed meine standadisierte Eventlisten in xlsx Format
 */
// If you need to parse XLS files, include php-excel-reader
require('script/spreadsheet-reader/php-excel-reader/excel_reader2.php');
require('script/spreadsheet-reader/SpreadsheetReader.php');

try {
    $reader = new SpreadsheetReader('files/exliste.xlsx');
    $baseMem = memory_get_usage();
} catch (Exception $E) {
    echo $E->getMessage();
}

//PARAMETER
//Wenn die ID_NEU Der Row = 0 ist, handelt es sich nicht um ein Symposion, sondern um
//z.B. eine Pause oder ein sonstiges Event
$param_no_symposium = 0;


//Zweidimensionale Arrays
// Listenararray->Symposiumarray(ID,Titel,Autoren..etc.)
$symposium_list = array();
$non_symposium_list = array();

$header_keys = array("title_symposium", "day", "starttime", "symposium_id", "id", "title_contribution", "presenter", "other_presenters","room","chair");

foreach ($reader as $key => $row) {
    //Key = 0 sind die Tabellenköpfe
    if ($key > 0) {
        $combined = array_combine($header_keys, $row);
        //if ($combined['id'] === '0') {
        //    array_push($non_symposium_list, $combined);
        // } else {
        array_push($symposium_list, $combined);
        //}
    }
}


//SYMPOSIUM LIST
$j = 1;
print_r("\$sympositum_events = array(");

$numEvents = count($symposium_list);
foreach ($symposium_list as $key => $event) {

    $numItems = count($event);
    print_r("array(");

    $i = 1;
    foreach ($event as $key_name => $content) {

        if ($content === "" || $content == null) {
            $content = '-';
        }
        if ($i < $numItems) {
            print_r("'" . $key_name . "'" . " => " . "'" . trim(addslashes($content)) . "',");
        } else {
            print_r("'" . $key_name . "'" . " => " . "'" . trim(addslashes($content)) . "'");
        }
        $i++;
    }

    if ($j < $numEvents) {
        print_r("),");
    } else {
        print_r(")");
    }

    $j++;
}


print_r(");");
echo "<br>";
echo "<br>";

//NON SYMPOSIUM LIST
//$j = 1;
//print_r("\$non_sympositum_events = array(");
//
//$numEvents = count($non_symposium_list);
//foreach ($non_symposium_list as $key => $event) {
//
//    $numItems = count($event);
//    print_r("array(");
//
//    $i = 1;
//    foreach ($event as $key_name => $content) {
//
//        if ($content === "" || $content == null) {
//            $content = '-';
//        }
//        if ($i < $numItems) {
//            print_r("'" . $key_name . "'" . " => " . "'" . trim(addslashes($content)) . "',");
//        } else {
//            print_r("'" . $key_name . "'" . " => " . "'" . trim(addslashes($content)) . "'");
//        }
//        $i++;
//    }
//
//    if ($j < $numEvents) {
//        print_r("),");
//    } else {
//        print_r(")");
//    }
//
//    $j++;
//}
//
//
//print_r(");");



