<?php 
$obj_user=new HrmgtEmployee;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'all_user';
?>

<div class="page-inner" style="background:white; min-height:500px">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-white">
			<div class="panel-body">

	<?php if($active_tab == 'all_user'){ ?>	
	<script type="text/javascript">
		$(document).ready(function() 
		{
		    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
			jQuery('#staff_list').DataTable({
				"bProcessing": true,
				 "bServerSide": true,
				 "sAjaxSource": ajaxurl+'?action=datatable_All_user_ajax_to_load',
				 "bDeferRender": true,
			});
			
		});
	</script>
    <form name="wcwm_report" action="" method="post">
    <div class="panel-body">
        <div class="table-responsive">
			<table id="staff_list" class="display" cellspacing="0" width="100%">
        	 <thead>
				<tr>
				    <th style="width: 50px;height:50px;"><?php  _e( 'Photo', 'hr_mgt' ) ;?></th>
				    <th><?php _e( 'User Name', 'hr_mgt' ) ;?></th>	
					<th><?php _e( 'User Code', 'hr_mgt' ) ;?></th>						
					<th> <?php _e( 'User  Email', 'hr_mgt' ) ;?></th>
					<th> <?php _e( 'User Role', 'hr_mgt' ) ;?></th>					
					<th> <?php _e( 'Action', 'hr_mgt' ) ;?></th>					
				</tr>
			</thead>
		<tfoot>
            <tr>
			   <th><?php  _e( 'Photo', 'hr_mgt' ) ;?></th>
               <th><?php _e( 'User Name', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'User Code', 'hr_mgt' ) ;?></th>	
				<th> <?php _e( 'User  Email', 'hr_mgt' ) ;?></th>
			   <th> <?php _e( 'User Role', 'hr_mgt' ) ;?></th>
				<th> <?php _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </tfoot> 
     <!--   <tbody>
        <?php 
		$AllUserData = hrmgt_get_all_user_in_plugin();
		$logindata[] = $obj_user->hrmgt_get_single_employee_data_new(get_current_user_id());		
		$userdata = array_merge($logindata,$AllUserData);			
		$result  = array_unique($userdata,SORT_REGULAR);
		foreach($result as $key=>$retrieved_data){			//
			$user_roles = get_userdata($retrieved_data->ID);
			$user_role =  implode(', ', $user_roles->roles);				
		 ?>
            <tr>
				<td class="user_image"><?php $uid=$retrieved_data->ID;
					$userimage=get_user_meta($uid, 'hrmgt_user_avatar', true);
					if(empty($userimage)){
						echo '<img src='.get_option( 'hrmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
					}
					else { ?>
						<img src="<?php print $userimage ?>" height="50px" width="50px" class="img-circle"/>
					<?php }	?>
				</td>
				<?php if($role=="manager"){ ?> 
					<td class="name"><a href="?hr-dashboard=user&page=user&tab=add_user&action=edit&user_type=<?php print $user_role  ?>&id=<?php echo $retrieved_data->ID;?>"><?php echo $retrieved_data->display_name;?></a></td>		 
				<?php } else{ ?> 
					<td class="name"><?php echo $retrieved_data->display_name;?></td>		 
				<?php } ?>	
				<td class="name"><?php echo $retrieved_data->employee_code;?></td>		 				
			   <td class="email"><?php echo $retrieved_data->user_email;?></td>
			   <td style="text-transform: capitalize"><?php print $user_role; ?></td>	
				<td>
				<?php if($retrieved_data->ID == get_current_user_id() ||  $role=='manager' ){ ?>
					<a href="?hr-dashboard=user&page=user&tab=view_employee&action=view&employee_id=<?php print $retrieved_data->ID ?>" class="btn btn-primary"> <?php _e('View','hr_mgt');?></a>
				<?php } ?>
				<?php if($retrieved_data->ID == get_current_user_id() && $role == "employee" ||  $role=='manager'){ ?> 						
					<a href="?hr-dashboard=user&page=user&tab=add_user&action=edit&user_type=employee&id=<?php echo $retrieved_data->ID?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
				<?php } ?>
				<?php if($role=="manager"){ ?> 									
					<a href="?hr-dashboard=user&page=user&tab=all_user&action=delete&emp_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');"><?php _e( 'Delete', 'hr_mgt' ) ;?> </a>
				<?php } ?>					
				</td>
            </tr>
		<?php } ?>    
        </tbody>    -->    
        </table>
        </div>
    </div>       
</form>
<?php 
	}	
if($active_tab == 'add_accountant')
{
	require_once HRMS_PLUGIN_DIR. '/admin/accountant/add_accountant.php';
}
?>
</div>
</div>
</div>
</div>