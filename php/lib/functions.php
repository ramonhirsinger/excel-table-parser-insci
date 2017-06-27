<?php

function getStyleClassById($id) {
    
    if ($id === "0") {
        print_r("other-event");
    }
    
    if(substr($id, 0,2) === "S-") {
        print_r ("symposium-event");
    }
    
    if(preg_match('/^P[0-9]$/', substr($id, 0,2))) {
        print_r ("poster-session");
    }
    
    if(substr($id, 0,2) === "PL") {
        print_r ("plenar-event");
    }
}

function stringNotZero( $val ) {
    if($val === "0") {
        return "";
    } else {
        return $val . ": ";
    }
}

function getTimeString( $time ) {
   return substr($time, 0,2) . ":" . substr($time, 2,4) . " Uhr";
}

function getAuthorlist( $authors ) {
    $authorlist = explode(',', $authors);
    
    echo "<ul class='author-list'>";
    foreach($authorlist as $key => $author) {
        echo "<li>" . $author . ".</li>";
    }
    echo "</ul>";
}

function getCoAuthorlist( $coauthors ) {
    $coauthorlist = explode(',', $coauthors);
    
    $i = 0;
    $indexcounter = 0;
    
    echo "<ul class='coauthor-list'>";
    foreach($coauthorlist as $key => $coauthor) {
        if($coauthor !== "") {
            echo "<li>" . $coauthor . ".</li>";
        }
    }
    echo "</ul>";
}