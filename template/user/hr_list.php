<?php 
$obj_user=new HrmgtEmployee;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'hr_list';
?>

<div class="page-inner" style="margin: 0px -20px -20px; min-height:500px !important">
<div class="row">
<div class="col-md-12">
	<div class="panel panel-white">
	<div class="panel-body">
<?php if($active_tab == 'hr_list'){ ?>	
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#staff_listd').DataTable({		
		 "order": [[ 1, "asc" ]],
		  "responsive": true,
		 "aoColumns":[
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": false}
         ]		 
	});	
} );
</script>
<form name="wcwm_report" action="" method="post">  
    <div class="table-responsive">
        <table id="staff_listd" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
				<th style="width: 50px;height:50px;"><?php  _e( 'Photo', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'HR Manager Name', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Code', 'hr_mgt' ) ;?></th>			
				<th> <?php _e( 'HR Manager Email', 'hr_mgt' ) ;?></th>
				<th> <?php _e( 'Mobile No', 'hr_mgt' ) ;?></th>
               <?php if($role=="manager"){ ?> 
					 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
				<?php }?>
            </tr>
        </thead>
		<tfoot>
            <tr>
				<th><?php  _e( 'Photo', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'HR Manager Name', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Code', 'hr_mgt' ) ;?></th>			 
				<th> <?php _e( 'HR Manager Email', 'hr_mgt' ) ;?></th>
				<th> <?php _e( 'Mobile No', 'hr_mgt' ) ;?></th>
				<?php if($role=="manager"){ ?> 
					 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
				<?php } ?>          
            </tr>
        </tfoot> 
        <tbody>
         <?php 		
			$get_staff = array('role' => 'manager');
			$staffdata=get_users($get_staff);	
			if(!empty($staffdata))
			{
				foreach ($staffdata as $retrieved_data){
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
						<td class="name"><a href="?hr-dashboard=user&page=user&tab=add_user&action=edit&user_type=manager&id=<?php echo $retrieved_data->ID;?>"><?php echo $retrieved_data->display_name;?></a></td>
				<?php }else{ ?> 
						<td class="name"><?php echo $retrieved_data->display_name;?></td>							
				<?php } ?>             
             
				<td class=""><?php echo $retrieved_data->employee_code;?></td>
                <td class="email"><?php echo $retrieved_data->user_email;?></td>
                <td class="mobile"><?php echo $retrieved_data->mobile;?></td>
				<?php if($role=="manager"){ ?> 				
               	<td class="action">				
					<a href="?hr-dashboard=user&page=user&tab=view_employee&action=view&employee_id=<?php print $retrieved_data->ID ?>" class="btn btn-primary"> <?php _e('View','hr_mgt')?></a>
					<a href="?hr-dashboard=user&page=user&tab=add_user&action=edit&user_type=manager&id=<?php echo $retrieved_data->ID;?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
					<a href="?hr-dashboard=user&page=user&tab=hr_list&action=delete&hr_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
					onclick="return confirm('<?php _e('Do you really want to delete this record?','hr_mgt');?>');">
					<?php _e( 'Delete', 'hr_mgt' ) ;?> </a>				
                </td>    
				<?php } ?>
            </tr>
            <?php }			
		} ?>     
        </tbody>        
        </table>
        </div>       
</form>
    <?php 
	}	
	if($active_tab == 'add_hr')
	{
		require_once HRMS_PLUGIN_DIR. '/admin/hr_manager/add_hr.php';
	}
	?>		
	</div>
	</div>
</div>
</div>