<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_statslist_permissions extends Migration {

    private $permission_array = array(
        'StatsList.Settings.View' => 'To view the News Settings menu.',
        'StatsList.Settings.Manage' => 'Manage News Settings.',
    );
    public function up()
	{
		$prefix = $this->db->dbprefix;
		
		foreach ($this->permission_array as $name => $description)
        {
            $this->db->query("INSERT INTO {$prefix}permissions(name, description) VALUES('".$name."', '".$description."')");
            // give current role (or administrators if fresh install) full right to manage permissions
            $this->db->query("INSERT INTO {$prefix}role_permissions VALUES(1,".$this->db->insert_id().")");
        }
		// Default Settings
        $default_settings = "
			INSERT INTO `{$prefix}settings` (`name`, `module`, `value`) VALUES
			 ('statslist.limit_to_primary', 'statslist', '1');
		";
        $this->db->query($default_settings);
	}
	
	//--------------------------------------------------------------------
	
	public function down() 
	{
		$prefix = $this->db->dbprefix;

        foreach ($this->permission_array as $name => $description)
        {
            $query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name = '".$name."'");
            foreach ($query->result_array() as $row)
            {
                $permission_id = $row['permission_id'];
                $this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
            }
            //delete the role
            $this->db->query("DELETE FROM {$prefix}permissions WHERE (name = '".$name."')");
        }
		$this->db->query("DELETE FROM {$prefix}settings WHERE (module = 'statslist')");
	}
	
	//--------------------------------------------------------------------
	
}