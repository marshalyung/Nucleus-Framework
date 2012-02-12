<?php
/**
 * Security authentication
 *
 * @package             Security
 * @since               14-Dec-2009
 * @version
 * @author		Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright           Synapses Systems Sdn Bhd. All rights reserved
 */
class NUCLEUS_Authentication extends NUCLEUS_Core
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
     * Sign in process by username/password authentication
     *
     * @param   string      $sql
     *
     * @access  public
     * @return  boolean
     */
    public function authenticate($sql)
    {
        global $mysql;
        $mysql->query($sql);
        
        if ($mysql->countNumRows() == 0) {
            NUCLEUS_Exceptions::catcher(SIGN_IN_FAILED);
            NUCLEUS_Logger::entry('Sign in failed', LOG_ERROR);
            return false;
        }

        $_SESSION['authenticated_identity'] = $mysql->fetchData();
        return true;
    }
    
    /**
     * Add new field and its respective value into Authenticated Identity Data
     * session
     *
     * @param	string		$data_field
     * 	Field name of the new entry
     *
     * @param	mixed		$data
     * 	Value of the new entry field
     *
     * @access	public
     * @return	void
     */
    public function addAuthenticatedIdentityData($data_field, $data)
    {
        $_SESSION['authenticated_identity'][$data_field] = $data;
    }

    /**
     * Get specific data of the authenticated user from
     * $_SESSION['authenticated_identity']
     *
     * @param   string      $data_field
     *  Field name containing the data to be retrieved
     *
     * @access  public
     * @return  mixed
     */
    public function getAuthenticatedIdentityData($data_field)
    {
        if (!isset($_SESSION['authenticated_identity']) || !is_array($_SESSION['authenticated_identity'])) {
            return '';
        }
        
        return $_SESSION['authenticated_identity'][$data_field];
    }

    /**
     * Check if user has already signed in to system by checking for the
     * existence of $_SESSION['authenticated_identity']
     *
     * @access  public
     * @return  boolean
     */
    public function isAuthenticated()
    {
        if (!isset($_SESSION['authenticated_identity']) ||
                empty($_SESSION['authenticated_identity'])) {
            if (isset(parent::$module) && isset(parent::$view)) {
                NUCLEUS_Exceptions::catcher(SESSION_EXPIRED);
            }
            
            return false;
        }

        return true;
    }

    /**
     * Sign out user
     *
     * @param   mixed       [$status]
     * @access  public
     * @return  void
     */
    public static function signOut($status = null)
    {
        if (isset($_SESSION['authenticated_identity']) &&
                !empty($_SESSION['authenticated_identity']))
        {
            session_unset();
            session_destroy();
        }
        
        if (!is_null($status) && !empty($status)) {
            session_start();
            NUCLEUS_Exceptions::catcher($status);
        }
        
        header('Location: '.URI);
        exit;
    }
}
?>