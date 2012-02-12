<?php
/**
 * Menu management. Each menu definition must be registered to Nucleus before
 * it is available for use.
 *
 * @example Menu structure definition syntax:
 *  array('menu_id' => array('label', 'url')
 *
 * Description:
 *  menu_id - Must be the same name as the menu's respective module's name,
 *            respective case sensitivity.
 *  label   - The text to be shown as the menu
 *  url     - Full URL hyperlink to the intended page
 *
 * @package     Toolkits
 * @since       Jan 18, 2010
 * @version     1.1
 * @author      Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright   Synapses Systems Sdn Bhd. All rights reserved
 */

class NUCLEUS_Menus extends NUCLEUS_Core
{
    /**
     * Array of menus and its URL
     *
     * @access  protected
     * @var     array
     */
    protected $menus;

    /**
     * Class constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct()
    {
        parent::__construct();
        $this->menus = array();
    }

    /**
     * Register a new menu structure
     *
     * @param   string      $menu_name
     *  Unique identifitation of each menu set
     *
     * @param   array       $menu_structure
     *
     * @example Menu structure definition syntax:
     *  array('menu_id' => array('label', 'url')
     *
     * @access  public
     * @return  void
     */
    public function registerMenus($menu_name, $menu_structure)
    {
        if (!is_array($menu_structure)) {
            die('Error: Invalid menu structure definition. Menu structure must be an array');
        }

        $this->menus[$menu_name] = $menu_structure;
    }

    /**
     * Render tabbed menus display
     *
     * @param   string      $menu_name
     *
     * @access  public
     * @return  string
     */
    public function renderTabMenus($menu_name)
    {
        if ($this->_isMenuExists($menu_name)) {
            global $element;
            $tab_menu .= '<div class="tab-menu-wrapper">';
            $tab_menu .= '<ul class="tab-menu">';
            
            foreach ($this->menus[$menu_name] as $menu_key => $menu_value) {
                if (parent::$module == $menu_key) {
                    $tab_menu .= '<li class="active">';
                    $tab_menu .= $element->href($menu_value[key($menu_value)], key($menu_value));
                }
                else {
                    $tab_menu .= '<li>';
                    $tab_menu .= $element->href($menu_value[key($menu_value)], key($menu_value));
                }

                $tab_menu .= '</li>';
            }

            $tab_menu .= '</li></ul>';
            $tab_menu .= '</div>';
        }

        return $tab_menu;
    }

    /**
     * Render module specific menus. Menu orientation is user defined. Selected
     * menu is based on currently focused module. Supports us of menu icons
     *
     * @param   string      $menu_name
     *  Name of menu to render
     *
     * @param   string      $layout = LAYOUT_HORIZONTAL
     *  Accepts either LAYOUT_HORIZONTAL or LAYOUT_VERTICAL
     *
     * @access  public
     * @return  string
     */
    public function renderModuleMenus($menu_name, $layout = LAYOUT_HORIZONTAL)
    {
        if ($this->_isMenuExists($menu_name)) {
            global $element;
            $module_menu_list = $this->menus[$menu_name][parent::$module];

            if (is_array($module_menu_list)) {
                $menu_count = count($module_menu_list);
                $counter = 1;
                $menus = '<table cellpadding="0" cellspacing="0"><tr>';

                foreach ($module_menu_list as $menu_key => $menu_value) {
                    $menus .= '<td class="submenu-column">';

                    if (is_array($menu_value)) {
                        /*
                         * $menu_value is an array when menu icon is used. Icon
                         * may not be defined, so, no need to use <img> tag
                         */
                        if (isset($menu_value['icon']) && !empty($menu_value['icon'])) {
                            $menus .= $element->href($menu_value['href'], '<img class="icon" src="'.$menu_value['icon'].'" align="left" alt="'.$menu_key.'" /><span class="submenu-text">'.$menu_key.'</span>');
                        }
                        else {
                            $menus .= $element->href($menu_value['href'], '<span class="submenu-text">'.$menu_key.'</span>');
                        }
                    }
                    else {
                        /*
                         * not using menu icons
                         */
                        $menus .= $element->href($menu_value, '<span class="submenu-text">'.$menu_key.'</span>');
                    }
                    
                    $menus .= '</td>';

                    if ($counter != $menu_count) {
                        $menus .= '<td width="1"><span class="normal" style="color:#999999">|</span></td>';
                    }

                    $counter++;
                }

                $menus .= '</tr></table>';
            }

            return $menus;
        }
    }

    /**
     * Check if the required menu has been created or registered
     *
     * @param   array       $menu_name
     * @access  private
     * @return  boolean
     */
    private function _isMenuExists($menu_name)
    {
        if (!array_key_exists($menu_name, $this->menus)) {
            NUCLEUS_Exceptions::catcher($menu_name.': '.MENU_NOT_EXIST);
            return false;
        }
        else if (!is_array($this->menus[$menu_name])) {
            NUCLEUS_Exceptions::catcher($menu_name.': '.MENU_STRUCT_ERROR);
            return false;
        }

        return true;
    }
}
?>