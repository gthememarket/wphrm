<?php 
class hrmgt_management
{

	public $role;
	
	function __construct($user_id = NULL)
	{
		
		
		if($user_id)
		{
			
			$this->role=$this->get_current_user_role();
			
		}
	}
	private function get_current_user_role () {
		global $current_user;
		$user_roles = $current_user->roles;
		$user_role = array_shift($user_roles);
		return $user_role;
	}
	
	
	
}
?>