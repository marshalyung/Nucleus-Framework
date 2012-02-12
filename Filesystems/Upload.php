<?php
/**
 * File upload handling through HTTP POST method
 *
 * On instantiation, the HTML file element name would be passed into the
 * method accept(), where the information of the uploading file would be
 * constructed in $_file_info array.
 *
 * This class is designed to handle single file upload. For multiple files
 * upload, the method upload() should be called through an
 * interator (i.e. for-loop).
 *
 * The decision whether to validate filesize, file type, and MIME-type is up to
 * the user by calling the respective validation methods. If one decides to
 * validate the uploading file, the $max_upload_size, $allowed_upload_mime_type,
 * and $allowed_upload_file_ext variables must first be assigned with the
 * intended valid value, then call the respective validation method before
 * calling the upload() method.
 *
 * If the $max_upload_size value is omitted, the upload_max_filesize value
 * defined in php.ini would be assumed during the filesize validation process.
 *
 * @package     Filesystems
 * @since       Feb 22, 2010
 * @version     1.1
 * @author      Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright   Synapses Systems Sdn Bhd. All rights reserved
 */

class NUCLEUS_Upload
{
    /**
     * Maximum file size allowed in bytes. If not defined, the default PHP
     * setting would be assumed
     *
     * @access  protected
     * @var     int
     */
    protected $max_upload_size;

    /**
     * Array list of allowed MIME types
     *
     * @access  protected
     * @var     array
     */
    protected $allowed_upload_mime_type = array();

    /**
     * Array list of allowed file extensions
     *
     * @access  protected
     * @var     array
     */
    protected $allowed_upload_file_ext = array();

    /**
     * File information of the uploading file
     *
     * @access  private
     * @var     array
     */
    private $_file_info;

    /**
     * Class constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct()
    {
        /*
         * Do nothing
         */
    }
    
    /**
     * Receive the uploaded file, if any
     *
     * @param   string      $var_name
     *  HTML element name for the uploading file
     *
     * @access	public
     * @return	void
     */
    public function accept($var_name)
    {
        if ($this->_isHttpPostUpload($_FILES[$var_name]['tmp_name'])) {
            $this->_file_info = array('name'        => $_FILES[$var_name]['name'],
                                  	  'mime_type'   => $_FILES[$var_name]['type'],
                                  	  'ext'         => $this->_getFileExtension($_FILES[$var_name]['name']),
                                  	  'size'        => $_FILES[$var_name]['size'],
                                      'tmp_name'    => $_FILES[$var_name]['tmp_name'],
                                      'error'       => $_FILES[$var_name]['error']
                                     );
        }
    }

    /**
     * Upload file physically
     *
     * @param	string		$upload_dir
     *  Absolute path to the file upload directory. Do not specify trailing slash
     *
     * @param	string		$new_filename = null
     * 	If specified, the new filename to be saved, replacing the actual
     *  filename. If not specified, Nucleus would auto-generate a random filename
     *
     * @access  public
     * @return  mixed
     */
    public function upload($upload_dir, $new_filename = null)
    {
        if (!$this->_isHttpPostUpload($this->_file_info['tmp_name'])) {
            NUCLEUS_Logger::entry('File "'.$this->_file_info['name'].'" is not an HTTP POST method upload', LOG_ERROR);
            die('File "'.$this->_file_info['name'].'" is not an HTTP POST method upload');
        }
        else {
            if (is_dir($upload_dir)) {
                if (!isset($new_filename)) {
                    $this->_file_info['new_name'] = uniqid(rand(), true).'.'.$this->_file_info['ext'];
                }
                else {
                    $this->_file_info['new_name'] = $new_filename;
                }
                
                if (!move_uploaded_file($this->_file_info['tmp_name'], $upload_dir.'/'.$this->_file_info['new_name'])) {
                    NUCLEUS_Logger::entry('Unable to save file "'.$this->_file_info['name'].'" in directory "'.$upload_dir.'"', LOG_ERROR);
                    die('Unable to save file "'.$this->_file_info['name'].'" in directory "'.$upload_dir.'"');
                }
            }
            else {
                NUCLEUS_Logger::entry('Directory "'.$upload_dir.'" is not a valid path', LOG_ERROR);
                die('Directory "'.$upload_dir.'" is not a valid path');
            }
        }
        
        return $this->_file_info['new_name'];
    }

    /**
     * Check if filesize of uploading file is not more than the allowed size in
     * bytes. Filesize would be compared against $max_upload_size value. If
     * $max_upload_size was not predefined by user, then the upload_max_filesize
     * value in php.ini would be used
     *
     * @access  public
     * @return  boolean
     */
    public function isAllowedFileSize()
    {
        if (empty($this->max_upload_size)) {
            $this->max_upload_size = ini_get('upload_max_filesize');
        }

        if ($this->_file_info['size'] > $this->max_upload_size) {
            NUCLEUS_Exceptions::catcher(UPLOAD_FILESIZE_DENIED);
            return false;
        }

        return true;
    }

    /**
     * Check if the uploading file's MIME type is allowed
     *
     * @access  public
     * @return  boolean
     */
    public function isAllowedMIMEType()
    {
        if (!empty($this->allowed_upload_mime_type)) {
            if (!is_array($this->allowed_upload_mime_type)) {
                NUCLEUS_Exceptions::catcher(MIME_TYPE_LIST_ERROR);
                return false;
            }
            else {
                if (!in_array($this->_file_info['type'], $this->allowed_upload_mime_type)) {
                    NUCLEUS_Exceptions::catcher(UPLOAD_MIME_TYPE_DENIED);
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Check if the uploading file's extension type is allowed
     *
     * @access  public
     * @return  boolean
     */
    public function isAllowedExtension()
    {
        if (!empty($this->allowed_upload_file_ext)) {
            if (!is_array($this->allowed_upload_file_ext)) {
                NUCLEUS_Exceptions::catcher(FILE_TYPE_LIST_ERROR);
                return false;
            }
            else {
                if (!in_array($this->_file_info['ext'], $this->allowed_upload_file_ext)) {
                    NUCLEUS_Exceptions::catcher(UPLOAD_FILE_TYPE_DENIED);
                    return false;
                }
            }
        }

        return true;
    }
    
    /**
     * Return file properties information
     *
     * @param	string		$info_type
     * 	Accepts either "name", "mime_type", "ext", "size", "tmp_name", "error",
     *  "all"
     *
     * @access	public
     * @return	mixed
     */
    public function getFileProperties($info_type)
    {
        switch ($info_type) {
            case 'name':
                $info = $this->_file_info['tmp_name'];
                break;
                
            case 'mime_type':
                $info = $this->_file_info['mime_type'];
                break;
                
            case 'ext':
                $info = $this->_file_info['ext'];
                break;
                
            case 'size':
                $info = $this->_file_info['size'];
                break;
                
            case 'tmp_name':
                $info = $this->_file_info['tmp_name'];
                break;
                
            case 'error':
                $info = $this->_file_info['error'];
                break;
                
            case 'all':
                $info = $this->_file_info;
                break;
        }
        
        return $info;
    }
    
	/**
     * Check if uploaded file is through a valid HTTP POST method
     *
     * @param   string      $tmp_name
     *  Temporary filename of the uploading file
     *
     * @access  private
     * @return  boolean
     */
    private function _isHttpPostUpload($tmp_name)
    {
        if (!isset($tmp_name) || empty($tmp_name)) {
            return false;
        }

        return true;
    }

    /**
     * Get the uploading file's extension
     *
     * @param   string      $filename
     * @access  private
     * @return  string
     */
    private function _getFileExtension($filename)
    {
        if (empty($filename)) {
            return '';
        }

        $split = explode('.', $filename);
        return $split[1];
    }
}
?>
