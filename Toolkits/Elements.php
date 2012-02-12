<?php
/**
 * HTML elements standardisation as according to HTML 4.01 Transitional
 *
 * @package     Toolkits
 * @since       Jan 15, 2010
 * @version     1.0
 * @author      Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright   Synapses Systems Sdn Bhd. All rights reserved
 */

class NUCLEUS_Elements extends NUCLEUS_Core
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
     * Generate standard hidden HTML fields used during form submission
     *
     * @param   string      $action_value
     *  Form action identifier
     *
     * @param   string      $update_action = ''
     *  If not empty, either the $action_value and $update_action would be
     *  automatically selected for creating new or updating existing record
     *
     * @access  public
     * @return  string
     */
    public function getFormControllers($action_value, $update_action_value = '')
    {
        global $element;
        $fields = $element->hidden('_module', parent::$module, '_module');
        $fields .= $element->hidden('_view', parent::$view, '_view');

        if (!empty($update_action_value)) {
            $fields .= $this->toggleAction($action_value, $update_action_value);
        }
        else {
            $fields .= $element->hidden('_action', $action_value, '_action');
        }
        
        $fields .= $element->hidden('_record', parent::$record, '_record');
        return $fields;
    }

    /**
     * Generate HTML button
     *
     * @param   string      $name
     *  HTML element name
     *
     * @param   string      $value
     *  Text to be shown on button face
     *
     * @param   boolean     $submit = false
     *  Default to false. Indicate whether the button is a submit button
     *
     * @param   string      $id = null
     *  Default parameter. ID value for button
     *
     * @param   string      $other_attributes = null
     *  Default parameter. Other HTML element attributes to be added
     *
     * @access  public
     * @return  string
     */
    public function button($name, $value, $submit = false, $id = null,
            $other_attributes = null)
    {
        $button = '<input class="button" name="'.$name.'" id="'.$id.'" ';
        $button .= 'value="'.$value.'" ';

        if ($submit) {
            $button .= 'type="submit" ';
        }
        else {
            $button .= 'type="button" ';
        }

        $button .= $other_attributes.' /> ';
        return $button;
    }

    /**
     * Generate big sized HTML button
     *
     * @param   string      $name
     *  HTML element name
     *
     * @param   string      $value
     *  Text to be shown on button face
     *
     * @param   boolean     $submit = false
     *  Default to false. Indicate whether the button is a submit button
     *
     * @param   string      $id = null
     *  Default parameter. ID value for button
     *
     * @param   string      $other_attributes = null
     *  Default parameter. Other HTML element attributes to be added
     *
     * @access  public
     * @return  string
     */
    public function bigButton($name, $value, $submit = false, $id = null,
            $other_attributes = null)
    {
        $button = '<input class="big-button" name="'.$name.'" id="'.$id.'" ';
        $button .= 'value = "'.$value.'" ';

        if ($submit) {
            $button .= 'type = "submit" ';
        }
        else {
            $button .= 'type = "button" ';
        }

        $button .= $other_attributes.' /> ';
        return $button;
    }

    /**
     * Date and time picker. This control generates a read-only textbox and
     * an icon which pops up a date and time picker window
     *
     * @param   string      $name
     *  HTML element name
     *
     * @param   string      $default_value
     *  Default value to be shown in the textbox
     *
     * @param   boolean     $show_time = false
     *  Default to false. Indicate whether a time picker should be used.
     *
     * @param   string      $default_value_format
     *  Date/time formatting for $default_value. Formatting characters must
     *  comply to PHP's official formatting characters
     *
     * @param	string		$other_attributes = null
     * 	Other HTML element attributes to be added to the input element
     *
     * @access  public
     * @return  string
     * @todo	Need to recode. Current implementation is not compatible with
     * 			HTML5 browsers. Temporary replacement using jquery-ui library
     * 			implemented in the respective view page where a datepicker is
     * 			required
     */
    public function dateTimePicker($name, $default_value, $show_time = false,
            $default_value_format = 'd-m-Y', $other_attributes = null)
    {
        global $helper;
        
        if ($show_time) {
            $show_time = 'true';
        }
        else {
            $show_time = 'false';
        }
        
        $dtp = '<input class="default" type="text" name="'.$name.'" id="'.$name.'" ';
        $dtp .= 'value = "'.$helper->convertToLiteralDate($default_value, $default_value_format).'" ';
        
        if (!is_null($other_attributes)) {
            $dtp .= $other_attributes.' ';
        }
        
        $dtp .= 'readonly /> ';
        $dtp .= '<a href="javascript:NewCal(\''.$name.'\', \'ddmmyyyy\', '.$show_time.', \'12\')">';
        $dtp .= $this->img('Show calendar', 'cal.gif', 'border="0"').'</a>';
        return $dtp;
    }
    
    /**
     * Time selector using a drop down box. Time is incremted in 30 minutes
     * interval
     *
     * @param	string		$name
     * 	HTML element name
     *
     * @param	string		$default_value
     * 	Default value to be selected
     *
     * @param	string		$time_format = 'h:ia'
     * 	Default to 12 hour format. Defines the time format
     *
     * @param	string		$other_attributes = null
     * 	Other HTML element attributes to be added to the input element
     *
     * @access	public
     * @return	string
     */
    public function timeScroller($name, $default_value, $time_format = 'h:ia',
            $other_attributes = null)
    {
        $ts = '<select name="'.$name.'" id="'.$name.'" '.$other_attributes.'>';
        
        for ($minute = 0; $minute <= 1410; $minute += 30) {
            $time = date($time_format, mktime(0, $minute));
            
            if ($default_value == $time) {
                $ts .= '<option value="'.$time.'" selected="selected">'.$time.'</option>';
            }
            else {
                $ts .= '<option value="'.$time.'">'.$time.'</option>';
            }
        }
        
        $ts .= '</select>';
        return $ts;
    }
    
    /**
     * HTML hidden textbox
     *
     * @param   string  $name
     *  HTML element name
     *
     * @param   string  $value = ''
     *
     * @param   string  $id = ''
     *  HTML element id value
     *
     * @access  public
     * @return  string
     */
    public function hidden($name, $value = '', $id = '')
    {
        $hidden = '<input type="hidden" name="'.$name.'" id="'.$id.'" ';
        $hidden .= 'value="'.$value.'" />';
        return $hidden;
    }

    /**
     * HTML drop down box
     *
     * @param   string      $name
     *  HTML element name
     *
     * @param   array       $option_list
     *  Array of options to be enlisted. Option's value would use user-defined
     *  array keys if it exist. If user-defined array keys do not exist, the
     *  array value would be used as the option's value.
     *
     * @param   string      $selected_option
     *  The option value to be selected automatically
     *
     * @param   string      $id = ''
     *  HTML element id value
     *
     * @param   string      $first_option = 'Choose one'
     *  Default to "Choose one". First item in the drop down box
     *
     * @param   string      $other_attributes = ''
     *  Other HTML attributes to be added
     *
     * @access  public
     * @return  string
     */
    public function dropDown($name, $option_list, $selected_option,
            $id = '', $first_option = 'Choose one...', $other_attributes = '')
    {
        $dropdown = '<select class="default" name="'.$name.'" id="'.$id.'" ';
        $dropdown .= $other_attributes.'>';
        $dropdown .= '<option value="">'.$first_option.'</option>';

        if (is_array($option_list)) {
            $keys = array_keys($option_list);
            $values = array_values($option_list);

            if ($keys[0] == '0' || $keys == 0) {
                $keys = $values;
            }
        }

        for ($i = 0; $i < count($option_list); $i++) {
            if ($keys[$i] == $selected_option && !empty($values[$i])) {
                $dropdown .= '<option value="'.$keys[$i].'" selected>'.$values[$i].'</option>';
            }
            else {
                $dropdown .= '<option value="'.$keys[$i].'">'.$values[$i].'</option>';
            }
        }

        $dropdown .= '</select>';
        return $dropdown;
    }

    /**
     * HTML drop down box where its options are populated from a data source
     *
     * @param   string      $name
     *  HTML element name
     *
     * @param   array       $resultset
     *  Resulset array with data retrieved from database to be used as list of
     *  options
     *
     * @param   array       $ds_fields
     *  Array of field names used for retrieving the resultset
     *
     * @param   string      $selected_option
     *  The option value to be selected automatically
     *
     * @param   string      $id = ''
     *  HTML element id value
     *
     * @param   string      $first_option = 'Choose one'
     *  Default to "Choose one". First item in the drop down box
     *
     * @param   string      $other_attributes = ''
     *  Other HTML attributes to be added
     *
     * @access  public
     * @return  string
     */
    public function dsDropDown($name, $resultset, $ds_fields, $selected_option,
            $id = '', $first_option = 'Choose one...', $other_attributes = '')
    {
        if (!is_array($resultset) || empty($resultset)) {
            return '';
        }

        foreach ($resultset as $data) {
            $option_list = array($data[$ds_fields[0]] => $data[$ds_fields[1]]);
        }

        return $this->dropDown($name, $option_list, $selected_option, $id, $first_option, $other_attributes);
    }

    /**
     * HTML hyperlink
     *
     * @param   string      $url
     *  The fully qualified URL. The "http://" prefix would be added if not found
     *
     * @param   string      $text
     *  The hyperlink text to be shown
     *
     * @param   string      $title = ''
     *  The title to be shown as tooltip
     *
     * @param   string      $other_attributes = ''
     *  Other HTML attributes to be added
     *
     * @access  public
     * @return  string
     */
    public function href($url, $text, $title = '', $other_attributes = '')
    {
        if (false === strpos($url, BASE_URI)) {
            $url = URI.$url;
        }

        $href = '<a class="links" href="'.$url.'" title="'.$title.'" ';
        $href .= $other_attributes.'>'.$text.'</a>';
        return $href;
    }

    /**
     * HTML image tag
     *
     * @param   string      $title
     *  The title to be shown as tooltip
     *
     * @param   string      $image_file = 'no_image.jpg'
     *  The image file to show
     *
     * @param   string      $other_attributes = ''
     *
     * @access  public
     * @return  string
     */
    public function img($title, $image_file = 'no_image.jpg',
            $other_attributes = '')
    {
        $img = '<img src="'.IMG_DIR.$image_file.'" title = "'.$title.'" ';
        $img .= $other_attributes.' />';
        return $img;
    }

    /**
     * Toggling between two action controller in an HTML form to automatically
     * decide whether the form's submission action should be for creating or
     * updating record. This would output a hidden textbox containing the action
     * identifier name
     *
     * @param   string      $create_action
     *  Action identifier to create record
     *
     * @param   string      $update_action
     *  Action identifier to update record
     *
     * @access  public
     * @return  string
     */
    public function toggleAction($create_action, $update_action)
    {
        if (isset(parent::$record) && !empty(parent::$record)) {
            return $this->hidden('_action', $update_action, '_action');
        }
        else {
            return $this->hidden('_action', $create_action, '_action');
        }
    }

    /**
     * Toggle show or hide link for collapsible screen area
     *
     * @param   string      $trigger_id
     *  HTML element id value which triggers the toggling
     *
     * @param   string      $target_id
     *  HTML element id value which would be collapsible
     *
     * @access  public
     * @return  string
     */
    public function showHide($trigger_id, $target_id)
    {
        if (is_null($trigger)) {
            $showhide = '<span class="show-hide" id="'.$trigger_id.'" ';
            $showhide .= 'onclick="showHide(\''.$trigger_id.'\', \''.$target_id.'\')';
            $showhide .= '">Show</span>';
        }
        
        return $showhide;
    }

    /**
     * Display Synapses corporate logo
     *
     * @access  public
     * @return  string
     */
    public function synapsesLogo()
    {
        return $this->img('Synapses Systems Sdn Bhd', 'synapses_logo.jpg');
    }
}
?>