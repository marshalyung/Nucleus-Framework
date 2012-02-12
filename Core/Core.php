<?php
/**
 * Nucleus Framework kernel. Preparing all fundamental framework initialisation
 * and processing for framework modules and user application modules.
 *
 * @abstract
 * @package             Core
 * @since               15-Nov-2009
 * @version		1.0
 * @author		Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright           Synapses Systems Sdn Bhd. All rights reserved
 */
abstract class NUCLEUS_Core
{
    /**
     * Name of current module in focus.
     *
     * @access  protected
     * @var     string
     */
    protected static $module;

    /**
     * Name of current view in focus, submitted through POST method
     *
     * @access  protected
     * @var     string
     */
    protected static $view;

    /**
     * Action identifier acknowledging system action, sumitted through POST
     * method
     *
     * @access  protected
     * @var     string
     */
    protected static $action;

    /**
     * Current record's primary key value, if a record has been selected for
     * editing, else, a new GUID value would be generated
     *
     * @access  protected
     * @var     string
     */
    protected static $record;

    /**
     * Class constructor. Obtain MVC variables which decides what Nucleus
     * should do to the user's application. Data from HTTP POST method is given
     * higher priority than HTTP GET method. Data from HTTP GET method would
     * only be used if data is not available from HTTP POST method
     *
     * @access  public
     * @return  void
     */
    public function __construct()
    {
        self::$action = $_POST['_action'];

        if (array_key_exists('_module', $_POST)) {
            self::$module = $_POST['_module'];
        }
        else {
            self::$module = $_GET['module'];
        }

        if (array_key_exists('_view', $_POST)) {
            self::$view = $_POST['_view'];
        }
        else {
            self::$view = $_GET['view'];
        }

        if (array_key_exists('_record', $_POST)) {
            self::$record = $_POST['_record'];
        }
        else {
            self::$record = $_GET['record'];
        }
    }

    /**
     * Generate GUID value for primary key storage in database. Function would
     * first check whether an existing GUID value exists in session, if not,
     * function would then check if an existing GUID value exists in
     * query string. If GUID value does not exist in session and query string,
     * a new GUID value would be generated. If an existing GUID value exists in
     * session, the existing GUID value would be used instead. If GUID does not
     * exist in session but exist in query string, then the GUID value from
     * query string would be used.
     *
     * @access  protected
     * @return  string
     */
    protected function getGUID()
    {
        if (isset(self::$record) && !empty(self::$record)) {
            $guid = self::$record;
        }
        else {
            $guid = uniqid(rand(), true);
        }

        return $guid;
    }

    /**
     * Explicitly clear GUID value from session
     *
     * @access  protected
     * @return  void
     */
    protected function clearGUID()
    {
        self::$record = null;
    }

    /**
     * Load module controller based on predefined module structure. All modules
     * must be placed in the directory path "app_root/modules/" where app_root
     * is the root directory of the application
     *
     * Example of module structure:
     *  $module_structure = array('physical_module_name1' => 'Logical module name 1');
     *
     * @access  public
     * @return  string
     * @todo    Function logic needs to be revised to ensure workability with
     *          menu structure
     */
    public static function loadModuleController()
    {
        if (is_file(MODULE_DIR.self::$module.'/index.php')) {
            return MODULE_DIR.self::$module.'/index.php';
        }
        else {
            global $auth;
            NUCLEUS_Logger::entry('Module "'.self::$module.'" configuration error', LOG_ERROR);
            $auth->signOut(MOD_CFG_ERR);
        }
    }
}
?>