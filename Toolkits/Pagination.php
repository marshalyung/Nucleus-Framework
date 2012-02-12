<?php
/**
 * Abstract class for pagination management
 *
 * @package             Toolkits
 * @since               28-Dec-2009
 * @version		1.0
 * @author		Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright           Synapses Systems Sdn Bhd. All rights reserved
 */
class NUCLEUS_Pagination extends NUCLEUS_Core
{
    /**
     * Current page number in focus
     *
     * @access  private
     * @var     int
     */
    private static $_current_page;

    /**
     * Total number of pages
     *
     * @access  private
     * @var     int
     */
    private static $_total_pages;

    /**
     * Class constructor
     *
     * @param   string      $sql
     *  Original SQL statement before appending LIMIT statement
     *
     * @param   int         [$current_page = null]
     *  Current page number in focus
     *
     * @param   int         [$page_size = null]
     *  Number of rows to show on each page
     * 
     * @access  public
     * @return  void
     */
    public function __construct($sql, $current_page = null, $page_size = 25)
    {
        parent::__construct();
        global $mysql;
        $offset = $this->_calculateOffset($page_size, $current_page);
        self::$_total_pages = $this->_calculateTotalPages($sql, $page_size);
        $sql .= ' LIMIT '.$offset.', '.$page_size;
        $mysql->query($sql);
    }

    /**
     * Calculate offset for LIMIT parameter
     *
     * @param   int         $page_size
     * @param   int         [$current_page = null]
     *  Current page number in focus
     *
     * @access  private
     * @return  int
     */
    private function _calculateOffset($page_size, $current_page = null)
    {
        self::$_current_page = $this->_verifyCurrentPageNumber($current_page);
        return (self::$_current_page - 1) * $page_size;
    }

    /**
     * Calculate total number of pages
     *
     * @param   string      $sql
     * @param   int         $page_size
     * @access  private
     * @return  int
     */
    private function _calculateTotalPages($sql, $page_size)
    {
        global $mysql;
        $mysql->query($sql);
        $total_record = $mysql->countNumRows();
        return ceil($total_record / (float)$page_size);
    }

    /**
     * Verify current page number whether an existing value exist
     *
     * @param   int         $current_page
     * @access  private
     * @return  int
     */
    private function _verifyCurrentPageNumber($current_page = null)
    {
        if (!isset($current_page) || empty($current_page)) {
            return 1;
        }

        return $current_page;
    }

    /**
     * User interface for paging navigation
     *
     * @param   int         [$max_page_num = 5]
     *  Maximum page numbers to show for navigation. Default to 5. This is only
     *  applicable if total pages is more than 1 page
     *
     * @access  public
     * @return  string
     */
    public static function navigator($max_navigation_num = 4)
    {
        $nav = '<div class="normal" align="right">';

        if (!empty(self::$_current_page) && self::$_current_page > 1) {
            if (self::$_total_pages <= $max_navigation_num) {
                $max_navigation_num = self::$_total_pages;
            }

            if (self::$_current_page >= $max_navigation_num) {
                $page_num = $max_navigation_num;
            }
            else {
                $page_num = 1;
            }

            for ($i = 1; $i <= $max_navigation_num; $i++) {
                if ($page_num > 1) {
                    $nav .= '<a class="links">previous</a>';
                }

                if ($page_num == self::$_current_page) {
                    $nav .= $page_num;
                }
                else {
                    $nav .= '<a class="links">'.$page_num.'</a>';
                }
                
                $page_num++;

                if ($page_num < self::$_total_pages) {
                    $nav .= '<a class="pager">next</a>';
                }
            }
        }

        $nav .= '</div>';
        return $nav;
    }
}
?>