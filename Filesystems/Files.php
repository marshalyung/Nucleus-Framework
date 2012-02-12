<?php
/**
 * Filesystem directory manipulation and tools
 *
 * @package     Filesystems
 * @since       Mar 8, 2010
 * @version     1.0
 * @author      Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright   Synapses Systems Sdn Bhd. All rights reserved
 */

class NUCLEUS_Files
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
     * Read the contents of the given directory
     *
     * @param   string      $path_to_directory
     *  Absolute path to the directory. Trailing slash is required
     *
     * @param   int         $sort_order = SORT_ASC
     *  Directory contents sorting order. Accepts either SORT_ASC or SORT_DESC.
     *  Default to SORT_ASC.
     *
     * @access  public
     * @return  array
     */
    public function ls($path_to_directory, $sort_order = SORT_ASC)
    {
        if (!is_dir($path_to_directory)) {
            NUCLEUS_Exceptions::catcher(INVALID_DIRECTORY);
            return '';
        }

        if ($sort_order == SORT_DESC) {
            $sort = 1;
        }
        else {
            $sort = 0;
        }

        $contents = scandir($path_to_directory, $sort);
        return $this->cleanDirList($contents);
    }

    /**
     * Get information about a file or directory. If subject is a directory,
     * the INFO_CONTENT_COUNT returns the number of files in the directory, else
     * returns 0
     *
     * @param   string      $path_to
     *  Absolute path to the file or directory
     *
     * @access  public
     * @return  array
     *  Returns associative array with elements dirname, basename, ext, filename,
     *  size (in bytes), modified (UNIX timestamp of last modified date and time),
     *  content_count (directory only).
     */
    public function info($path_to)
    {
        $info = pathinfo($path_to);
        
        if (is_dir($path_to)) {
            $contents = scandir($path_to);
            $contents = $this->cleanDirList($contents);
            $info['content_count'] = count($contents);
        }
        else {
            $info['size'] = filesize($path_to);
            $info['modified'] = filemtime($path_to);
            $info['content_count'] = '0';
        }
        
        return $info;
    }

    /**
     * Convert file size in bytes to the intended metric as specified. Currently
     * support conversion up to gigabytes
     *
     * @param   int         $bytes
     *  File size in bytes
     *
     * @param   int         $convert_to = CONVERT_AUTO
     *  Accepts either CONVERT_AUTO, CONVERT_MB, CONVERT_KB, CONVERT_GB. Default
     *  to CONVERT_AUTO.
     *
     * @access  public
     * @return  int
     *  If CONVERT_AUTO is used, we would automatically decide
     *  which metric would be best used for end-user readability; such as,
     *  if file size is more than 1024 bytes, returned file size would be in KB;
     *  if file size is more than 1024 kilobytes, returned file size would be in
     *  MB, and if file size is more than 1024 megabytes, returned file size
     *  would be GB. If file size is too small for conversion, returned value is
     *  in bytes.
     */
    public function convertFileSize($bytes, $convert_to = CONVERT_AUTO)
    {
        switch ($convert_to) {
            case CONVERT_KB:
                $converted = round(($bytes / 1024), 2).' KB';
                break;
            
            case CONVERT_MB:
                $converted = round(($bytes / 1024 / 1024), 2).' MB';
                break;

            case CONVERT_GB:
                $converted = round(($bytes / 1024 / 1024 / 1024), 2).' GB';
                break;

            default:
            case CONVERT_AUTO:
                $formatted = number_format($bytes);
                $split = explode(',', $formatted);
                
                if (count($split) == 2) {
                    $converted = round(($bytes / 1024), 2).' KB';
                }
                else if (count($split) == 3) {
                    $converted = round(($bytes / 1024 / 1024), 2).' MB';
                }
                else if (count($split) == 4) {
                    $converted = round(($bytes / 1024 / 1024 / 1024), 2).' GB';
                }
                else {
                    $converted = $bytes.' bytes';
                }
                break;
        }

        return $converted;
    }

    /**
     * Remove '.' and '..' as directories from retrieved directory list
     *
     * @param   array       $dir_list
     *  Array of directory retrieved
     *
     * @access  public
     * @return  array
     */
    public function cleanDirList($dir_list)
    {
        foreach ($dir_list as $dir_item) {
            if ($dir_item != '.' && $dir_item != '..') {
                $items[] = $dir_item;
            }
        }

        return $items;
    }
}
?>