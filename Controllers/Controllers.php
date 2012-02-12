<?php
/**
 * Action and view controller as part of MVC architecture
 *
 * @package     Controllers
 * @since       Feb 6, 2010
 * @version     1.0
 * @author      Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright   Synapses Systems Sdn Bhd. All rights reserved
 */

class NUCLEUS_Controllers extends NUCLEUS_Core
{
    /**
     * Container for raw HTTP POST parameters and data
     *
     * @access  private
     * @var     array
     */
    private $_post;

    /**
     * Class constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_post = $_POST;
    }

    /**
     * Check for HTTP POST method existence
     *
     * @access  public
     * @return  boolean
     */
    public function isPOST()
    {
        if (!isset($this->_post) || empty($this->_post)) {
            return false;
        }

        return true;
    }

    /**
     * Expose HTTP POST data for "_action" variable
     *
     * @access  public
     * @return  string
     */
    public function getAction()
    {
        return parent::$action;
    }

    /**
     * Expose HTTP GET data for "_view" variable
     *
     * @access  public
     * @return  string
     */
    public function getView()
    {
        return parent::$view;
    }
}
?>