<?php
/**
 * ${PROJECT_NAME} application configuration settings
 *
 * @since
 * @author
 */

/**
 * Application environment constants
 */
define('CSS_DIR',       'styles/');
define('JS_DIR',        'js/');
define('IMG_DIR',       'images/');
define('UPLOAD_DIR',    'files/');
define('MODULE_DIR',    'modules/');
define('BASE_URI',      'http://'.$_SERVER['HTTP_HOST']);
define('URI',           'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);

/*
 * Change the following database connection parameters to suit your project
 *
 * IMPORTANT: FOR YOUR NEW PROJECT CONVENIENCE, DO NOT DROP OR RENAME THE BELOW
 * DATABASE AND USER. CREATE A NEW DATABASE AND USER FOR YOUR CURRENT PROJECT
 */
define('DB_HOST',       'localhost');
define('DB_USER',		'nu_test_user');
define('DB_PWD', 		'nu_test_user');
define('DB_NAME', 		'nucleus_testDB');

/*
 * Load Nucleus Framework
 * IMPORTANT: DO NOT REMOVE
 */
require_once 'nucleus_bootstrap.php';

/*
 * Place your "require_once"/"require"/"include_once"/"include" statements here
 */
require_once 'config/menus.php';

/*
 * Check for sign in process trigger
 */
if ($_POST['_action'] == 'authenticate') {
    /*
     * Tips: Call your function to sign in user here
     */
}

/*
 * Check for sign out process trigger
 */
if ($_GET['action'] == 'signout') {
    /*
     * Tips: Call your function to sign out user here
     */
}
?>