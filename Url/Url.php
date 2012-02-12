<?php
/**
 * URL standardisation and management
 *
 * @package             URL
 * @since               14-Dec-2009
 * @version		1.0
 * @author		Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright           Synapses Systems Sdn Bhd. All rights reserved
 */
class NUCLEUS_Url extends NUCLEUS_Core
{
    /**
     * Class constuctor
     *
     * @access  public
     * @return  void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Redirect page.
     *
     * @param   string      $module
     *  Name of module to redirect to
     *
     * @param   string      $view
     *  Name of view to redirect to
     *
     * @param   string      $extended_query_string = null
     *  Other query string parameters. The "&" symbol would be prefixed
     *  automatically
     *
     * @access  public
     * @return  void
     */
    public function redirect($module, $view, $extended_query_string = null)
    {
        $url_str = URI.'?module='.$module.'&view='.$view;

        if (!is_null($extended_query_string) && !empty($extended_query_string)) {
            $url_str .= '&'.$extended_query_string;
        }
        
        header('Location: '.$url_str);
        exit;
    }

    /**
     * Append new URL parameter with its value to the end of an existing query
     * string and ensuring it is not repeated. The function returns a fully
     * qualified URL
     *
     * @param   array       $param_array
     *  An array where its key represents the query string variable name and its
     *  value represents the query string variable value
     * 
     * @param   int         $append_type = APPEND_REPLACE
     *  Accepts either APPEND_REPLACE to replace old parameter variable with new
     *  value or APPEND_RETAIN to retain old parameter variable
     * 
     * @access  public
     * @return  string
     */
    public function appendQueryString($param_array, $append_type = APPEND_REPLACE)
    {
        $current_query_str = explode('&', $_SERVER['QUERY_STRING']);
        $new_query_str = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        if (!empty($current_query_str) && is_array($current_query_str)) {
            foreach ($current_query_str as $current_query) {
                list($key, $value) = explode('=', $current_query);

                if (array_key_exists($key, $param_array)) {
                    if ($param_array[$key]) {
                        if ($append_type == APPEND_REPLACE) {
                            $new_query_str = preg_replace('/'.$key.'='.$value.'/', $key.'='.$param_array[$key], $new_query_str);
                        }
                    }
                }
            }

            foreach ($param_array as $key => $value) {
                if ($value && !preg_match('/'.$key.'=/', $new_query_str)) {
                    $new_query_str .= '&'.$key.'='.$value;
                }
            }
        }
        else {
            NUCLEUS_Exceptions::catcher('Caught Nucleus Exception: Exploded query string is not an array');
        }
        
        return 'http://'.$new_query_str;
    }
}
?>
