<?php
/**
 * Application logging system.
 *
 * Log message entry format:
 *  Tue Nov 17 2009 16:19:00 - LOG_TYPE - LOG_MESSAGE [Module: MODULE_NAME][HTTP: HTTP_REQUEST_METHOD]
 *
 * Supported LOG_TYPES:
 *  INFO: General information messages
 *  ERROR: Error messages
 *
 * @package             Logger
 * @since               16-Nov-2009
 * @version		1.0
 * @author		Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright           Synapses Systems Sdn Bhd. All rights reserved
 */
class NUCLEUS_Logger extends NUCLEUS_Core
{
    /**
     * Class constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create log message
     *
     * @param   string      $message
     *  Message to be logged
     *
     * @param   int         $log_type
     *  One of the following supported log type:
     *      - LOG_INFO (default)
     *      - LOG_ERROR
     *
     * @access  public
     * @return  string
     */
    public static function entry($message, $log_type = LOG_INFO)
    {
        if ($log_type == LOG_ERROR) {
            $type = 'Error';
        }
        else {
            $type = $log_type;
        }

        $entry = date('D M d Y H:i:s').' - '.$type.' - ';
        $entry .= $message.' [Module: '.parent::$module.']';
        $entry .= '[HTTP: '.$_SERVER['REQUEST_METHOD'].']'."\r\n";
    }

    /**
     * Write log message to log file, nucleus.log
     *
     * @access  protected
     * @return  void
     */
    protected function writeLog()
    {
        if (is_file('logs/nucleus.log')) {

        }
    }
}
?>