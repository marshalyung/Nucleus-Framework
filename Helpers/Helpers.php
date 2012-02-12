<?php
/**
 * Helper/utility class
 *
 * @package     Helpers
 * @since       Jan 13, 2010
 * @version     1.1
 * @author      Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright   Synapses Systems Sdn Bhd. All rights reserved
 */

class NUCLEUS_Helpers
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
         * Do nothing at the moment
         */
    }

    /**
     * Convert to MySQL compliant date format, Y-m-d. If invalid date is given,
     * the current date would be assumed.
     *
     * @param   string      $date_string
     *  The date value to be converted
     *
     * @access  public
     * @return  string
     */
    public function convertToMySQLDate($date_string)
    {
        if ($date_string != '--' || !empty($date_string)) {
            $date = explode('-', $date_string);
            $mysql_date = $date[2].'-'.$date[1].'-'.$date[0];
        }
        else {
            $mysql_date = date('Y-m-d');
        }

        return $mysql_date;
    }

    /**
     * Convert to MySQL compliant time format, G:ia. If invalid time is given,
     * the current time would be assumed
     *
     * @param   string      $time_string
     *  The time value to be converted
     *
     * @access  public
     * @return  string
     */
    public function convertToMySQLTime($time_string)
    {
        if ($time_string != '::' || !empty($time_string)) {
            $mysql_time = date('G:ia', strtotime($time_string));
        }
        else {
            $mysql_time = date('G:ia');
        }

        return $mysql_time;
    }

    /**
     * Convert to MySQL compliant date and time format, Y-m-d G:ia. If invalid
     * date and time is given, the current date and time would be assumed.
     *
     * @param   string      $datetime_string
     *  The date and time value to be converted
     *
     * @access  public
     * @return  string
     */
    public function convertToMySQLDateTime($datetime_string)
    {
        $datetime = explode(' ', $datetime_string);
        $datetime[0] = $this->convertToMySQLDate($datetime[0]);
        $datetime[1] = $this->convertToMySQLTime($datetime[1].$datetime[2]);
        $mysql_datetime = $datetime[0].' '.$datetime[1];
        return $mysql_datetime;
    }

    /**
     * Concert MySQL datetime format to literal date and time based on the
     * given formatting characters. Formatting characters must comply to PHP
     * official formatting characters
     *
     * @param   string      $mysql_datetime
     *  Date value in Y-m-d H:i:s format from MySQL
     *
     * @param   string      $format = 'M d, Y G:ia'
     *  Formatting characters complyin to PHP official formatting characters
     *
     * @access  public
     * @return  stirng
     */
    public function convertToLiteralDateTime($mysql_datetime,
            $format = 'M d, Y, g:ia')
    {
        if ($mysql_datetime != '0000-00-00 00:00:00' && !empty($mysql_datetime)) {
            $literal_datetime = date($format, strtotime($mysql_datetime));
        }
        else {
            $literal_datetime = '';
        }

        return $literal_datetime;
    }

    /**
     * Convert MySQL date format to literal date based on the given formatting
     * characters. Formatting characters must comply to PHP official formatting
     * characters
     *
     * @param   string      $mysql_date
     *  Date value in Y-m-d format from MySQL
     *
     * @param   string      $format = 'M d, Y'
     *  Formatting characters complying to PHP official formatting characters
     *
     * @access  public
     * @return  string
     */
    public function convertToLiteralDate($mysql_date, $format = 'M d, Y')
    {
        if ($mysql_date != '0000-00-00' && !empty($mysql_date)) {
            $literal_date = date($format, strtotime($mysql_date));
        }
        else {
            $literal_date = '';
        }

        return $literal_date;
    }

    /**
     * Convert MySQL time format to literal time based on the given formatting
     * characters. Formatting characters must comply to PHP official formatting
     * characters
     *
     * @param   string      $mysql_time
     *  Time value in HH:MM::SS format from MySQL
     *
     * @param   string      $format = 'g:ia'
     *  Formatting characters complying to PHP official formatting characters
     *
     * @access  public
     * @return  string
     */
    public function convertToLiteralTime($mysql_time, $format = 'g:ia')
    {
        if ($mysql_time != '00:00:00' && !empty($mysql_time)) {
            $literal_time = date($format, strtotime($mysql_time));
        }
        else {
            $literal_time = '';
        }

        return $literal_time;
    }

    /**
     * Parse monetary value to the given format.
     *
     * @param   int         $number
     *  Monetary value to parse
     *
     * @param   int         $decimal_position = 2
     *  Number of decimal position
     *
     * @param   string      $decimal_symbol = '.'
     *  Symbol to use as the decimal point
     *
     * @param   string      $thousand_separator = ','
     *  Symbol to use as the thousand separator
     *
     * @access  public
     * @return  string
     */
    public function parseMoney($number, $decimal_position = 2,
            $decimal_symbol = '.', $thousand_separator = ',')
    {
        if (!empty($number)) {
            $money = number_format($number, 2, $decimal_symbol,
                    $thousand_separator);
        }
        else {
            $money = '';
        }

        return $money;
    }

    /**
     * Parse Y to Yes and N to No
     *
     * @param   string      $value
     *  Value to parse
     *
     * @access  public
     * @return  string
     */
    public function parseYesNo($value)
    {
        if ($value == 'Y' || $value == 'y') {
            return 'Yes';
        }
        elseif ($value == 'N' || $value == 'n') {
            return 'No';
        }

        return '';
    }

    /**
     * Chop string length to the specified length suffixed with ellipsis
     *
     * @param   string      $str
     *  String to be chopped
     *
     * @param   int         $len
     *  Length of string to be returned
     *
     * @access  public
     * @return  string
     */
    public function chopString($str, $len)
    {
        if (strlen($str) > $len) {
            $chopped = substr($str, 0, $len).'...';
        }
        else {
            $chopped = $str;
        }

        return $chopped;
    }
}
?>