<?php
/**
 * User roles and permissions
 *
 * @package     Security
 * @since       Jan 13, 2010
 * @version     1.0
 * @author      Marshal Yung <marshal.yung@synapses.com.my>
 * @copyright   Synapses Systems Sdn Bhd. All rights reserved
 */

class NUCLEUS_Roles extends NUCLEUS_Core
{
    /**
     * Unique record identifier
     *
     * @access  protected
     * @var     string
     */
    protected $role_id;

    /**
     * Creator of record
     *
     * @access  protected
     * @var     string
     */
    protected $owner;

    /**
     * Date and time of record creation
     *
     * @access  protected
     * @var     datetime
     */
    protected $created;

    /**
     * Record modification user
     *
     * @access  protected
     * @var     string
     */
    protected $modified_by;

    /**
     * Record modification date and time
     *
     * @access  protected
     * @var     datetime
     */
    protected $modified;

    /**
     * Literal name of role
     *
     * @access  public
     * @var     string
     */
    protected $role_name;

    /**
     * List of serialized array containing module specific permissions
     *
     * @access  string
     * @var     text
     */
    protected $permissions;

    /**
     * Class constructor
     *
     * @access  public
     * @return  void
     */
    public function __construct()
    {
        parent::__construct();
        $this->owner        = $_SESSION['user_id'];
        $this->created      = date('Y-m-d H:i:s');
        $this->modified_by  = $_SESSION['user_id'];
        $this->modified     = date('Y-m-d H:i:s');
        $this->role_name    = addslashes($_POST['role_name']);
        $this->permissions  = $this->_parsePermission($_POST['permissions']);
    }

    /**
     * Create new role
     *
     * @access  public
     * @return  void
     */
    public function createRole()
    {
        $sql = 'INSERT INTO nucleus_roles SET role_id = "'.$this->role_id.'", ';
        $sql .= 'owner = "'.$this->owner.'", created = "'.$this->created.'", ';
        $sql .= 'role_name = "'.$this->role_name.'", ';
        $sql .= 'permissions = "'.$this->permissions.'";';
        $this->db->query($sql);
    }

    /**
     * Update role
     *
     * @access  public
     * @return  void
     */
    public function updateRole()
    {
        $sql = 'UPDATE roles SET modified_by = "'.$this->modified_by.'", ';
        $sql .= 'modified = "'.$this->modified.'", role = "'.$this->role.'", ';
        $sql .= 'permissions = "'.$this->permissions.'" ';
        $sql .= 'WHERE role_id = "'.$this->role_id.'";';
        $this->db->query($sql);
    }

    /**
     * Delete role
     *
     * @access  public
     * @return  void
     */
    public function deleteRole()
    {
        $sql = 'DELETE FROM roles WHERE role_id = "'.$this->role_id.'";';
        $this->db->query($sql);
    }

    /**
     * Retrieve list of roles
     *
     * @access  public
     * @return  array
     */
    public function getRoleList()
    {
        $sql = 'SELECT role_id, role_name FROM roles ';
        $sql .= 'ORDER BY role_name;';
        $this->db->query($sql);
        return $this->db->fetchList();
    }

    /**
     * Retrieve list of permissions for the given role_id
     *
     * @param   string      $role_id
     * @access  public
     * @return  array
     */
    public function getPermissionsByRole($role_id)
    {
        $sql = 'SELECT permissions FROM roles WHERE role_id = "'.$role_id.'";';
        $this->db->query($sql);
        $result = $this->db->fetchData();

        if (!empty($result['permissions'])) {
            $permission_list = $this->_parsePermission($result['permissions'], MODE_UNSERIALIZE);
        }

        return $permission_list;
    }

    /**
     * Serialize/unserialize permission list
     *
     * @param   mixed       $value
     *  If saving into database, $value would be array to be serialized. If
     *  retrieving from database, $value would be serialized string to be
     *  unserialized into an array
     *
     * @param   int         $mode
     *  Accepts either:
     *      - MODE_SERIALIZE: Serialize $value (default)
     *      - MODE_UNSERIALIZE: Unserialize $value
     *
     * @access  private
     * @return  mixed
     */
    private function _parsePermission($value, $mode = MODE_SERIALIZE)
    {
        if ($mode == MODE_SERIALIZE) {
            return serialize($value);
        }
        else if ($mode == MODE_UNSERIALIZE) {
            return unserialize($value);
        }

        return '';
    }
}
?>