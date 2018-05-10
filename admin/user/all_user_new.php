<?php
/* if(file_exists( HRMS_PLUGIN_DIR. '/admin/user/ajax_load_class.php')){
  echo 'File  Found';
 }else{
 echo 'File Not Found';
 }  */
$obj_user=new HrmgtEmployee;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'all_user';
/*   $AJAX = datatable_ajax_load();
  Print_r($AJAX);die; */ 
// echo HRMS_PLUGIN_DIR;
// echo WP_PLUGIN_URL . '/wphrm/ajax_load_class.php';
// echo plugins_url('ajax_load_class.php', __FILE__);
//echo  plugin_dir_path( __FILE__ ) ;
?>
<div class="popup-bg" style="min-height:1631px !important">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list"></div>     
		</div>
    </div>     
</div>
<div class="page-inner" style="margin: 0 -20px -20px; min-height:auto; !important">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-white">
			<div class="panel-body">

<?php if($active_tab == 'all_user'){ ?>	
<script type="text/javascript">
$(document).ready(function($) {

 $('#staff_list').DataTable({
  "bProcessing": true,
     "bServerSide": true,
     "sAjaxSource": ajaxurl+'?action=datatable_ajax_load',
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
				    <!--<th style="width: 50px;height:50px;"><?php  _e( 'Photo', 'hr_mgt' ) ;?></th>
				    <th><?php _e( 'User Name', 'hr_mgt' ) ;?></th>	-->		 
				    <th><?php _e( 'User Code', 'hr_mgt' ) ;?></th>			 
					<th> <?php _e( 'User  Email', 'hr_mgt' ) ;?></th>
					<th> <?php _e( 'User Role', 'hr_mgt' ) ;?></th>					
					  <!--<th> <?php _e( 'Action', 'hr_mgt' ) ;?></th>	-->				
				</tr>
			</thead>
		<tfoot>
            <tr>
			    <!-- <th><?php  _e( 'Photo', 'hr_mgt' ) ;?></th>
               <th><?php _e( 'User Name', 'hr_mgt' ) ;?></th>	-->		 
               <th><?php _e( 'User Code', 'hr_mgt' ) ;?></th>			 
			   <th> <?php _e( 'User  Email', 'hr_mgt' ) ;?></th>
			   <th> <?php _e( 'User Role', 'hr_mgt' ) ;?></th>
				  <!--<th> <?php _e( 'Action', 'hr_mgt' ) ;?></th>-->
            </tr>
        </tfoot> 
      <!--  <tbody>
         <?php 
		$result = hrmgt_get_all_user_in_plugin();
		foreach($result as $key=>$retrieved_data){			
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
				
					<td class="name"><a href="?page=hrmgt-user&tab=add_user&action=edit&user_type=<?php print $user_role  ?>&id=<?php echo $retrieved_data->ID;?>"><?php echo $retrieved_data->display_name;?></a></td>		 
					<td class="name"><?php echo $retrieved_data->employee_code;?></td>		 
			   
				
			  
			   <td class="email"><?php echo $retrieved_data->user_email;?></td>
			   <td style="text-transform: capitalize"><?php print $user_role; ?></td>	
				<td>					
					<a href="?page=hrmgt-user&tab=view_employee&action=view&employee_id=<?php print $retrieved_data->ID ?>" class="btn btn-primary"> <?php _e('View','hr_mgt');?></a>
					<a href="?page=hrmgt-user&tab=add_user&action=edit&user_type=<?php print $user_role  ?>&id=<?php echo $retrieved_data->ID;?>" class="btn btn-info"> <?php _e('Edit','hr_mgt');?><a>
					<a href="?page=hrmgt-user&tab=all_user&action=delete&emp_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
					onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
					<?php _e( 'Delete', 'hr_mgt' ) ;?> </a>				
				</td>
            </tr>
		<?php } ?>
        
     
        </tbody>-->
        
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
