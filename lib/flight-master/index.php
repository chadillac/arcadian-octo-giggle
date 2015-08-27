<?php
require 'flight/Flight.php';
require 'Parsedown.php';

Flight::set('cbase','./content/');

Flight::register('Parsedown', 'Parsedown');

Flight::route('/', function(){
    $md = file_get_contents(Flight::get('cbase')."index.md");
    echo Flight::Parsedown()->text($md);
});

Flight::route('/@section(/@page)', function($section, $page){
    $contents = "#SORRY";
    if (!empty($section) && empty($page)) {
        $file_path = Flight::get('cbase').$section.".md";
        if (file_exists($section) && is_dir($section)) {

        } else if (file_exists($file_path)) {
            $contents = file_get_contents($file_path);
        }
    } else {
        $file_path = Flight::get('cbase').$section."/".$page.".md";
        if (file_exists($file_path)) {
            $contents = file_get_contents($file_path);
        }
    }
    echo Flight::Parsedown()->text($contents);
});

Flight::start();
?>
