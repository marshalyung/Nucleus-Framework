<?php
/**
 * Nuclues Framework bootstrap file. This file must be included in end-user
 * applications, preceeding all other application specific modules
 *
 * @package     Nucleus
 * @since       Feb 3, 2010
 * @version     1.0
 * @author      Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright   Synapses Systems Sdn Bhd. All rights reserved
 */

/*
 * PHP environment
 */
session_start();
ob_start();

/*
 * Waking up all Nuclues modules
 */
require_once 'Config/Config.php';
require_once 'Config/messages.php';
require_once 'Core/Core.php';
require_once 'Exceptions/Exceptions.php';
require_once 'Helpers/Helpers.php';
require_once 'Database/MySQL.php';
require_once 'Toolkits/Elements.php';
require_once 'Toolkits/Pagination.php';
require_once 'Toolkits/Menus.php';
require_once 'Logger/Logger.php';
require_once 'Security/Authentication.php';
require_once 'Url/Url.php';
require_once 'Controllers/Controllers.php';
require_once 'Filesystems/Upload.php';
require_once 'Filesystems/Files.php';

/**
 * Auto-loading Nucleus modules
 */
$helper     = new NUCLEUS_Helpers();
$menu       = new NUCLEUS_Menus();
$element    = new NUCLEUS_Elements();
$auth       = new NUCLEUS_Authentication();
$mysql      = new NUCLEUS_MySQL();
$url        = new NUCLEUS_Url();
$controller = new NUCLEUS_Controllers();
$file       = new NUCLEUS_Files();
?>