<?php
/**
 * Calendar rendering class. Currently support only Gregorian calendar in
 * the English language
 *
 * @package     Toolkits
 * @since       Sep 12, 2010
 * @version     1.0
 * @author      Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright   Synapses Systems Sdn Bhd. All rights reserved
 */

class NUCLEUS_Calendar
{
    /**
     * Get all day names in a week based on the given format
     *
     * @param   string      $format = l
     *  Accepts PHP formatting characters for days
     *
     * @access  public
     * @return  array
     */
    public static function getDayNameList($format = 'l')
    {
        $days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday',
                      'Saturday', 'Sunday'
                     );

        switch ($format) {
            case 'D':
                foreach ($days as $day) {
                    $day_names[] = date('D', strtotime($day));
                }

                break;
                
            case 'l':
            default:
                foreach ($days as $day) {
                    $day_names[] = date('l', strtotime($day));
                }

                break;
        }

        return $day_names;
    }

    /**
     * Get total number of days for the given month
     *
     * @param   string      $year
     *  4 digits representation of the year without leading zero.
     *  Default to current year if invalid
     *
     * @param   string      $month
     *  Numerical representation of the month without leading zero.
     *  Default to current month if invalid
     *
     * @access  public
     * @return  string
     */
    public static function getMonthTotalDays($year, $month)
    {
        if (!isset($year) || empty($year)) {
            $year = date('Y');
        }

        if (!isset($month) || empty($month)) {
            $month = date('n');
        }
        
        return date('t', mktime(0, 0, 0, $month, 1, $year));
    }

    /**
     * Find out on which day of the week does the first day of the month falls on
     *
     * @param   string      $year
     *  4 digits representation of the year without leading zero.
     *  Default to current year if invalid
     *
     * @param   string      $month
     *  Numerical representation of the month without leading zero.
     *  Default to current month if invalid
     *
     * @access  public
     * @return  string
     */
    public static function getFirstDayOfMonth($year, $month)
    {
        if (!isset($year) || empty($year)) {
            $year = date('Y');
        }

        if (!isset($month) || empty($month)) {
            $month = date('n');
        }

        return strftime('%u', mktime(0, 0, 0, $month, 1, $year)); exit;
    }

    /**
     * Find out on which day of the week does the last day of the month falls on.
     *
     * @param   string      $year
     *  4 digits representation of the year without leading zero.
     *  Default to current year
     *
     * @param   string      $month
     *  Numerical representation of the month without leading zero.
     *  Default to current month if invalid
     *
     * @access  public
     * @return  string
     */
    public static function getLastDayOfMonth($year, $month)
    {
        if (!isset($year) || empty($year)) {
            $year = date('Y');
        }

        if (!isset($month) || empty($month)) {
            $month = date('n');
        }
        
        return strftime('%u', mktime(0, 0, 0, ($month + 1), 0, $year));
    }

    /**
     * Check if the given date is today's date
     *
     * @param   string      $year
     *  4 digit numerical representation of the year. Default to current year if
     *  invalid
     *
     * @param   string      $month
     *  Numerical representation of the month without leading zero. Default to
     *  current month if invalid
     *
     * @param   string      $day
     *  Numerical representation of the day in the month without leading zero.
     *  Default to current day if invalid
     *
     * @access  public
     * @return  boolean
     */
    public static function isToday($year, $month, $day)
    {
        if (!isset($year) || empty($year)) {
            $year = date('Y');
        }

        if (!isset($month) || empty($month)) {
            $month = date('n');
        }

        if (!isset($day) || empty($day)) {
            $day = date('j');
        }
        
        if ($year.'-'.$month.'-'.$day != date('Y-n-j')) {
            return false;
        }
        
        return true;
    }

    /**
     * Scrolling months
     *
     * @param   string      $month
     *  Numerical representation of month without leading zero. Default to
     *  current month if invalid
     *
     * @param   string      $format
     *  PHP define formatting characters for Month. Default to 'F'
     *
     * @param   int         $mode
     *  Accepts either MONTH_PREV to get previous month or MONTH_NEXT to get
     *  next month or MONTH_NOW to get current month. Default to MONTH_NOW
     *
     * @access  public
     * @return  string
     */
    public static function scrollMonth($month, $format = 'F', $mode = MONTH_NOW)
    {
        if (!isset($month) || empty($month)) {
            $month = date('n');
        }
        
        if ($mode == MONTH_PREV) {
            $the_month = date($format, mktime(0, 0, 0, ($month - 1), 1));
        }
        else if ($mode == MONTH_NEXT) {
            $the_month = date($format, mktime(0, 0, 0, ($month + 1), 1));
        }
        else {
            $the_month = date($format, mktime(0, 0, 0, $month, 1));
        }
        
        return $the_month;
    }

    /**
     * Scrolling years. Automatically calculates if the year should increment or
     * decrement by 1
     *
     * @param   string      $year
     *  4 digits numerical representation of the year. Default to current year
     *  if invalid
     *
     * @param   string      $month
     *  Numerical representation of month without leading zero.
     *  Default to current month if invalid
     *
     * @param   string      $format
     *  PHP defined formatting characters for Year. Default to 'Y'
     *
     * @param   int         $mode
     *  Accepts either YEAR_PREV to get previous year, YEAR_NEXT to get next
     *  year, or YEAR_NOW to get the current year. Default to YEAR_NOW
     *
     * @access  public
     * @return  string
     */
    public static function scrollYear($year, $month, $format = 'Y', $mode = YEAR_NOW)
    {
        if (!isset($year) || empty($year)) {
            $year = date('Y');
        }

        if (!isset($month) || empty($month)) {
            $month = date('n');
        }
        
        if ($mode == YEAR_PREV && $month == 1) {
            $the_year = date($format, mktime(0, 0, 0, $month, 1, ($year - 1)));
        }
        else if ($mode == YEAR_NEXT && $month == 12) {
            $the_year = date($format, mktime(0, 0, 0, $month, 1, ($year + 1))) ;
        }
        else {
            $the_year = date($format, mktime(0, 0, 0, $month, 1, $year));
        }

        return $the_year;
    }

    /**
     * Scrolling days. Automatically calculates the day when scrolling to next
     * and previous days
     *
     * @param   string      $year
     *  4 digits representation of the year. Default to current month if invalid
     *
     * @param   string      $month
     *  Numerical representation of the month without leading zero. Default to
     *  current month if invalid
     *
     * @param   string      $day
     *  Numerical representation of the day of the month without leading zero
     *  Default to current day of the week if invalid
     *
     * @param   string      $format
     *  PHP defined formatting characters for day, month, and year. Default to
     *  'l, F d, Y'
     *
     * @param   int         $mode
     *  Accepts either DAY_PREV to get previous day, DAY_NEXT to get next day,
     *  or DAY_NOW to get current day
     *
     * @access  public
     * @return  string
     */
    public static function scrollDay($year, $month, $day, $format = 'l, F d, Y', $mode = DAY_NOW)
    {
        if (!isset($year) || empty($year)) {
            $year = date('Y');
        }

        if (!isset($month) || empty($month)) {
            $month = date('n');
        }

        if (!isset($day) || empty($day)) {
            $day = date('j');
        }

        if ($mode == DAY_PREV) {
            if ($month == 1) {
                $month = self::scrollMonth($month, 'n', MONTH_PREV);
                $year = self::scrollYear($year, $month, 'Y', YEAR_PREV);
            }
            $the_day = date($format, mktime(0, 0, 0, $month, ($day - 1), $year));
        }
        else if ($mode == DAY_NEXT) {
            if ($month == 12) {
                $month = self::scrollMonth($month, 'n', MONTH_NEXT);
                $year = self::scrollYear($year, $month, 'Y', YEAR_NEXT);
            }

            $the_day = date($format, mktime(0, 0, 0, $month, ($day + 1), $year));
        }
        else {
            $the_day = date($format, mktime(0, 0, 0, $month, $day, $year));
        }

        return $the_day;
    }
}
?>