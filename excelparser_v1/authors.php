
<?php

/**
 * Diese Datei parsed meine standadisierte Autorentabelle in xlsx Format
 */
// If you need to parse XLS files, include php-excel-reader
require('script/spreadsheet-reader/php-excel-reader/excel_reader2.php');
require('script/spreadsheet-reader/SpreadsheetReader.php');

$sheet_names = array();

try {
    $reader = new SpreadsheetReader('files/Autoren.xlsx');
    $baseMem = memory_get_usage();
    $sheets = $reader->Sheets();

    foreach ($sheets as $sheet_index => $sheet_name) {
        $sheet_names[$sheet_index] = $sheet_name;
    }
} catch (Exception $E) {
    echo $E->getMessage();
}


foreach ($sheets as $sheet_index => $sheet_name) {
    $reader->ChangeSheet($sheet_index);

    $auth = "";
    $coauthlist = array();
    $zippedArray = array();

    foreach ($reader as $key => $row) {
        foreach ($row as $column_index => $column) {
            if ($column_index == 0) {
                $auth = substr($column, 0, strpos($column, ','));
                array_push($zippedArray, trim($auth));
            }
            if ($column_index == 1) {
                $coauthlist = explode(',', $column);
                foreach ($coauthlist as $index => $value) {
                    array_push($zippedArray, trim($value));
                }
            }
        }
    }
}

//array_unique($zippedArray, SORT_STRING);
$input = $zippedArray;
$result = array_unique($input, SORT_STRING);
asort($result);

print_r("\$authors = array(");
$numItems = count($result);
$i = 1;
foreach ($result as $key => $author) {
    if ($i < $numItems) {
        print_r($i ." => " . "'" . $author . ".',");
    } else {
        print_r($i . " => " . "'" . $author . ".'");
    }
    $i++;
}

print_r(");");



