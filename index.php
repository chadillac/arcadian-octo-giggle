<?php
require 'lib/flight-master/flight/Flight.php';
require 'lib/Parsedown.php';
require 'lib/ParsedownExtra.php';

Flight::set('cbase','./content/');
Flight::set('flight.views.path', './template/');

Flight::register('Parsedown', 'ParsedownExtra');

Flight::map('render_page',function($page_content) {
    $page_vars = array(
        'page_content'=>$page_content
    );
    $layout = array(
        'nav'=>Flight::get('cbase')."nav.md",
    );
    foreach ($layout as $section_name=>$content_path) {
        if (strpos($content_path, '.md') !== false) {
            $page_vars[$section_name] = Flight::Parsedown()->text(file_get_contents($content_path));
        }
    }
    Flight::render('layout', $page_vars);
});

Flight::route('/', function(){
    $markdown = file_get_contents(Flight::get('cbase')."index.md");
    $page_contents = Flight::Parsedown()->text($markdown);
    Flight::render_page($page_contents);
});

Flight::route('/@section(/@page)', function($section, $page){
    $markdown = "#SORRY";
    if (!empty($section) && empty($page)) {
        $file_path = Flight::get('cbase').$section.".md";
        if (file_exists($section) && is_dir($section)) {

        } else if (file_exists($file_path)) {
            $markdown = file_get_contents($file_path);
        }
    } else {
        $file_path = Flight::get('cbase').$section."/".$page.".md";
        if (file_exists($file_path)) {
            $markdown = file_get_contents($file_path);
        }
    }
    $page_contents = Flight::Parsedown()->text($markdown);
    Flight::render_page($page_contents);
});

Flight::start();
?>
