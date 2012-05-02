<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_statslist_permissions extends Migration {
	
	public function up() 
	{
		$prefix = $this->db->dbprefix;
		
		// permissions
		$data = array(
			'name'        => 'OOLM.StatsList.Manage' ,
			'description' => 'Manage OOTP Team Stats Settings' 
		);
		$this->db->insert("{$prefix}permissions", $data);
		
		$permission_id = $this->db->insert_id();
		
		$this->db->query("INSERT INTO {$prefix}role_permissions VALUES(1, ".$permission_id.")");
		
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

        // permissions
		$query = $this->db->query("SELECT permission_id FROM {$prefix}permissions WHERE name = 'OOLM.StatsList.Manage'");
		foreach ($query->result_array() as $row)
		{
			$permission_id = $row['permission_id'];
			$this->db->query("DELETE FROM {$prefix}role_permissions WHERE permission_id='$permission_id';");
		}
		//delete the permission
		$this->db->query("DELETE FROM {$prefix}permissions WHERE (name = 'OOLM.StatsList.Manage')");
		
		$this->db->query("DELETE FROM {$prefix}settings WHERE (module = 'statslist')");
	}
	
	//--------------------------------------------------------------------
	
}