<?php
/**
 * Application exceptions handling inclusive of:
 *  - Graceful fail-over
 *  - On-screen output of user friendly system error messages
 *  - Error logging using Logger class
 *
 * The Exceptions::catcher() is able to capture both single and multiple
 * errors in an array.
 *
 * @package             Exceptions
 * @since               16-Nov-2009
 * @version             1.0
 * @author		Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright           Synapses Sdn Bhd. All rights reserved
 */
class NUCLEUS_Exceptions
{
    /**
     * Class constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct()
    {
        /*
         * Do nothing yet
         */
    }

    /**
     * Capture potential error
     *
     * @param   mixed       $message
     *  User friendly error message. This parameter can handle string based
     *  messages as well as integer based identifier for messages. Each error
     *  type would be checked to avoid duplicate entries
     *
     * @access  public
     * @return  void
     */
    public static function catcher($message)
    {
        if (self::_isExist($message)) {
            $_SESSION['errors'][] = $message;
        }
    }

    private function _isExist($message)
    {
        if (isset($_SESSION['errors']) && is_array($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error_message) {
                if ($error_message == $message) {
                    unset($message);
                }
            }
        }

        if (!isset($message)) {
            return false;
        }

        return true;
    }

    /**
     * Output user friendly error messages. Errors stored in session must be
     * destroyed completely, so that it would not be shown again on the next
     * page refresh.
     *
     * Error messages would be returned as an HTML bullet list, without
     * specific style definition
     *
     * @access  public
     * @return  string
     */
    public static function showError()
    {
        if (self::countError() > 0) {
            $output = '<div class="notice" align="center">';

            if (self::countError() > 1) {
                $output .= '<ul>';

                for ($i = 0; $i < count($_SESSION['errors']); $i++) {
                    $output .= '<li>'.$_SESSION['errors'][$i].'</li>';
                }

                $output .= '</ul>';
            }
            else {
                $output .= $_SESSION['errors'][0];
            }

            $output .= '</div>';
            unset($_SESSION['errors']);
            return $output;
        }
    }

    /**
     * Get the number of errors that has not been shown yet
     *
     * @access  public
     * @return  int
     */
    public static function countError()
    {
        return count($_SESSION['errors']);
    }
}
?>