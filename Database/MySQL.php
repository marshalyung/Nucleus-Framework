<?php
/**
 * MySQL database server operations
 *
 * @package             Database
 * @since               15-Nov-2009
 * @version		1.0
 * @author		Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright           Synapses Systems Sdn Bhd. All rights reserved
 */
class NUCLEUS_MySQL
{
    /**
     * MySQL database connection resource handler
     *
     * @access  private
     * @var     string
     */
    private $_connection;

    /**
     * SQL statement execution result
     *
     * @access  private
     * @var     mixed
     */
    private $_result;

    /**
     * Class constructor
     *
     * @access  public
     * @return  void
     * @todo    Error message needs to be handled by Exception class and logged
     *          by Logs class
     */
    public function __construct()
    {
        if (!isset($this->_connection) || empty($this->_connection)) {
            if (!$this->_connection = @mysql_connect(DB_HOST, DB_USER, DB_PWD)) {
                NUCLEUS_Logger::entry(mysql_errno().': '.mysql_error(), LOG_ERROR);
                die($this->_getMySQLError('<strong>MySQL connection error.</strong>'));
            }
            else {
                if (!@mysql_select_db(DB_NAME)) {
                    NUCLEUS_Logger::entry(mysql_errno($this->_connection).': '.mysql_error($this->_connection), LOG_ERROR);
                    die($this->_getMySQLError('<strong>MySQL database not found.</strong>'));
                }
            }
        }
    }

    /**
     * Run SQL statements
     *
     * @param   mixed       [$page_size = null]
     *  Number of rows to show per page. Default to null
     *
     * @access  public
     * @return  mixed
     */
    public function query($sql)
    {
        if (!$this->_result = @mysql_query($sql, $this->_connection)) {
            NUCLEUS_Logger::entry(mysql_errno($this->_connection).': '.mysql_error($this->_connection), LOG_ERROR);
            die($this->_getMySQLError('<strong>SQL syntax error.</strong><br />'.$sql));
        }
        
        return $this->_result;
    }

    /**
     * Retrieve list of recordsets using associative array
     *
     * @access  public
     * @return  array
     */
    public function fetchList()
    {
        if (mysql_affected_rows() == 1) {
            $dataset[] = mysql_fetch_array($this->_result, MYSQL_ASSOC);
        }
        else {
            while ($list = mysql_fetch_array($this->_result, MYSQL_ASSOC)) {
                foreach ($list as $key => $value) {
                    $keys[] = $key;
                    $values[] = $value;
                }

                $dataset[] = array_combine($keys, $values);
            }
        }

        return $dataset;
    }

    /**
     * Retrieve single recordset using associate array
     *
     * @access  public
     * @return  array
     */
    public function fetchData()
    {
        return mysql_fetch_array($this->_result, MYSQL_ASSOC);
    }

    /**
     * Get number of rows returned from the last SELECT statement
     *
     * @access  public
     * @return  int
     */
    public function countNumRows()
    {
        return mysql_num_rows($this->_result);
    }

    /**
     * Construct error messages generated from MySQL server
     *
     * @param   string      $message
     *  Message pre-appended to MySQL server error
     *
     * @access  private
     * @return  string
     */
    private function _getMySQLError($message)
    {
        $error = $message.'<br />';
        $error .= '<p><em>MySQL says: ['.mysql_errno().'] ';
        $error .= mysql_error().'</em></p>';
        return $error;
    }

    /**
     * Class destructor
     *
     * @access  public
     * @return  void
     */
    public function __destruct()
    {
        if (isset($this->_result) && !empty($this->_result) &&
                ($this->_result != 'true' || $this->_result != 'false')) {
            mysql_free_result($this->_result);
        }
    }
}
?>