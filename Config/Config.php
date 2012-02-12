<?php
/**
 * Configuration management and loader for userspace application.
 *
 * @package             Nucleus
 * @since               14-Dec-2009
 * @version		1.0
 * @author		Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright           Synapses Systems Sdn Bhd. All rights reserved
 *
 * @todo    Consider writing config/config.php file as an XML file (config/XXX.xml)
 *          where XXX represents the user's project name (spacing replaced with
 *          underscore symbol "_").
 */

/**
 * Global constants variable
 */
define('NUCLEUS_BASE_URI',      'http://'.$_SERVER['HTTP_HOST']);
define('NUCLEUS_URI',           NUCLEUS_BASE_URI.'index.php');
define('NUCLEUS_POPUP_URI',     NUCLEUS_BASE_URI.'popup.php');
define('NUCLEUS_IMG_DIR',       'resources/images/');
define('NUCLEUS_JS_DIR',        'JS/');

class NUCLEUS_Config {
    /**
     * Class constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct() {

    }

    /**
     * Auto-generate userspace application configuration file. This file would
     * be copied to userspace application's config/config.php automatically
     * when user creates a new project space. config/config.php would be a
     * text/plain format.
     *
     * Centric predefined configuration parameters:
     *  - BASE_URI:     http://$_SERVER['HTTP_HOST']
     *  - URI:          http://$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']
     *  - MODULE_DIR    modules/
     *  - IMG_DIR:      images/
     *  - JS_DIR:       js/
     *  - UPLOAD_DIR:   upload/
     *  - CSS_DIR:      styles/
     *
     * User defined configuration parameters:
     *  - DB_HOSTNAME (only defined during pack-and-go)
     *  - DB_USERNAME (only defined during pack-and-go)
     *  - DB_PWD (only defined during pack-and-go)
     *  - DB_NAME (only defined during pack-and-go)
     *  - APP_NAME
     *  - PROJECT_NAME
     *  - INITIAL_VERSION
     *
     * @access  public
     * @return  mixed
     * @todo    Accept user defined configuration parameters and write to plain
     *          text file config.php. File must be written to userspace
     *          application's config/config.php during project space setup
     */
    public static function generateConfigFile() {
        $cfg = 'define(\'BASE_URI\', \'http://$_SERVER[\'HTTP_HOST\'])';
        $cfg .= 'define(\'URI\', \'http://$_SERVER[\'HTTP_HOST\'].$_SERVER[\'PHP_SELF\')';
        $cfg .= 'define(\'MODULE_DIR\', \'modules/\')';
        $cfg .= 'define(\'IMG_DIR\', \'images/\')';
        $cfg .= 'define(\'JS_DIR\', \'js/\')';
        $cfg .= 'define(\'UPLOAD_DIR\', \'upload/\')';
        $cfg .= 'define(\'CSS_DIR\', \'styles/\')';
    }
}
?>