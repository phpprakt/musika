<?php

require_once '../config.php';

// initialize variables
$template_data = array();

// handle login
if (isset($_REQUEST['add_user'])) {
    Session::create_user($_REQUEST['username'], $_REQUEST['password']);
} else if (isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
    if (!Session::check_credentials($_REQUEST['username'], $_REQUEST['password'])) {
        $template_data['message'] = 'Login failed!';
    }
}

switch ($_REQUEST['action']) {
    case 'create_album':
        Album::create(array(
            'artist' => $_REQUEST['artist'],
            'album'  => $_REQUEST['album'],
            'year'   => $_REQUEST['year']
        ));
    break;

    case 'delete_album':
        Album::delete($_REQUEST['id']);
    break;
}



if (isset($_REQUEST['logout'])) {
    Session::logout();
}

if (Session::authenticated()) {
    $template_data['albums'] = Album::getAll();
    Template::render('list', $template_data);
} else {
    $template_data['title'] = 'Login';
    Template::render('login', $template_data);
}

/*

TODO:

* store enrycpted versions of password

* read and display albums from database
* add an ORM-class for albums
* create input mask for adding an album to the database
*/
