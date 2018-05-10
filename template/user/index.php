<?php 

$user_object=new HrmgtEmployee;
$obj_user = new HrmgtEmployee();
$obj_department=new HrmgtDepartment;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'all_user';

?>
<!--<div class="popup-bg1">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list">   </div>
		</div>
    </div> 
</div>-->
<div class="page-inner" style="min-height:1088px !important">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?>
		</h3>
	</div>
<?php 

if(isset($_POST['print_exprience_latter'])){
	var_dump($_POST);
	exit;
}


if(isset($_POST['save_employee'])){	
$upload_docs_array=array();
$count_array=count($_FILES['cartificate']['name']);

for($a=0;$a<$count_array;$a++){			
	foreach($_FILES['cartificate'] as $image_key=>$image_val){		
		$document_array[$a]=array(
			'name'=>$_FILES['cartificate']['name'][$a],
			'type'=>$_FILES['cartificate']['type'][$a],
			'tmp_name'=>$_FILES['cartificate']['tmp_name'][$a],
			'error'=>$_FILES['cartificate']['error'][$a],
			'size'=>$_FILES['cartificate']['size'][$a]
		);
		
	}
}
 
foreach($document_array as $key=>$value){
	$get_file_name=$document_array[$key]['name'];
	$upload_docs_array[]=hrmgt_documets($value,$value,$get_file_name);
}
if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit"){
	$old_carti_arr =$_POST['old_hidden_cartificate'];
	$filedata = array_filter(array_merge($upload_docs_array,$old_carti_arr));
}else{
	$filedata = $upload_docs_array;
}
$filedatas = array_combine($_POST['cartificate_name'],$filedata);




$upload_docs_array = array_combine($_POST['cartificate_name'],$upload_docs_array);
$upload_docs_array['all_carti'] = $filedatas;


if(isset($_FILES['join_latter']) && !empty($_FILES['join_latter']) && $_FILES['join_latter']['size'] !=0){
	if($_FILES['join_latter']['size'] > 0)
		$upload_docs_array['join_latter']=hrmgt_load_documets($_FILES['join_latter'],'join_latter','join_latter');	
	}
	else{
		if(isset($_REQUEST['hidden_join_latter']))
		$upload_docs_array['hidden_join_latter']=$_REQUEST['hidden_join_latter'];
	}


if(isset($_FILES['cv']) && !empty($_FILES['cv']) && $_FILES['cv']['size'] !=0){
	if($_FILES['cv']['size'] > 0)
		$upload_docs_array['cv']=hrmgt_load_documets($_FILES['cv'],'cv','cv');	
	}
	else{
		if(isset($_REQUEST['hidden_cv']))
		$upload_docs_array['hidden_cv']=$_REQUEST['hidden_cv'];
	}

if(isset($_FILES['contract']) && !empty($_FILES['contract']) && $_FILES['contract']['size'] !=0){
	if($_FILES['contract']['size'] > 0)
		$upload_docs_array['contract']=hrmgt_load_documets($_FILES['contract'],'contract','contract');	
	}
	else{
		if(isset($_REQUEST['hidden_contract']))
		$upload_docs_array['hidden_contract']=$_REQUEST['hidden_contract'];
	}

if(isset($_FILES['id_proof']) && !empty($_FILES['id_proof']) && $_FILES['id_proof']['size'] !=0){
	if($_FILES['id_proof']['size'] > 0)
		$upload_docs_array['id_proof']=hrmgt_load_documets($_FILES['id_proof'],'id_proof','id_proof');	
	}
	else{
		if(isset($_REQUEST['hidden_id_proof']))
		$upload_docs_array['hidden_id_proof']=$_REQUEST['hidden_id_proof'];
	}
	
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit'){	
	$result=$user_object->hrmgt_add_user($_POST);
	$user_object->hrmgt_update_upload_documents($upload_docs_array,$result);

	if($result)	{				
		wp_redirect ( admin_url().'admin.php?page=hrmgt-user&tab=employee_list&message=emp_edit');
		} 
		}
	else{
		
		$result=$user_object->hrmgt_add_user($_POST);
		$user_object->hrmgt_upload_documents($upload_docs_array,$result);
		if($result){
			wp_redirect ( admin_url().'admin.php?page=hrmgt-user&tab=employee_list&message=emp_add');
		}
	}
	}


if(isset($_POST['save_staff'])){	

$obj_user = new HrmgtEmployee();
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit'){			
		$result=$obj_user->hrmgt_add_user($_POST);	
		if($result){
			wp_redirect ( admin_url() . 'admin.php?page=hrmgt-user&tab=hr_list&message=hr_edit');
		}
	}
	else{
	if( !email_exists( $_POST['email'] ) && !username_exists( $_POST['username'] )) {	
		$result=$obj_user->hrmgt_add_user($_POST);				
		if($result){
			wp_redirect (admin_url() . 'admin.php?page=hrmgt-user&tab=hr_list&message=hr_add');
		}
	}
	else{?>
	<div id="message" class="updated below-h2">
		<p><p><?php _e('Username Or Email id exists already.','hr_mgt');?></p></p>
	</div>
						
	  <?php }
		}		
	}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete'){	
				
	$result=$obj_user->delete_usedata($_REQUEST['hr_id']);
	if($result){
		wp_redirect ( admin_url() . 'admin.php?page=hrmgt-user&tab=hr_list&message=hr_del');
	}
}
	
if(isset($_POST['save_accountant'])){	
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit'){
	$result=$obj_user->hrmgt_add_user($_POST);
		if($result)	{
			wp_redirect ( admin_url() . 'admin.php?page=hrmgt-user&tab=accountantlist&message=acc_edit');
		}
	}
	else{
		if( !email_exists( $_POST['email'] ) && !username_exists( $_POST['username'] )){	
			$result=$obj_user->hrmgt_add_user($_POST);				
				if($result){
					wp_redirect ( admin_url() . 'admin.php?page=hrmgt-user&tab=accountantlist&message=acc_add');
				}
			}
			else{?>
			<div id="message" class="updated  msg below-h2">
				<p><?php _e('Username Or Email id exists already.','hr_mgt');?></p>
			</div>
						
	  <?php } 
	} 
}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete'){				
	$result=$obj_user->delete_usedata($_REQUEST['accountant_id']);
	if($result){
		wp_redirect ( admin_url() . 'admin.php?page=hrmgt-user&tab=accountantlist&message=acc_del');
	}
}
		
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete'){
	$result=$user_object->delete_usedata($_REQUEST['emp_id']);
	if($result){
		wp_redirect ( admin_url().'admin.php?page=hrmgt-user&tab=employee_list&message=emp_del');
	}
}

if(isset($_REQUEST['message'])){
	$message =$_REQUEST['message'];
	
	if($message == "emp_add"){ ?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e('Employee inserted successfully','hr_mgt');?></p>
	</div>
	<?php 	}
	elseif($message =="emp_edit"){?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e("Employee updated successfully.",'hr_mgt');?></p>
	</div>
	<?php }
	elseif($message == "emp_del"){ ?>
	<div id="message" class="updated below-h2">
		<p><?php _e('Employee deleted successfully','hr_mgt');?></p>
	</div>
	<?php }
	
	
	if($message == "hr_add"){ ?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e('HR Manager inserted successfully','hr_mgt');?></p>
	</div>
	<?php 	}
	elseif($message =="hr_edit"){?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e("HR Manager updated successfully.",'hr_mgt');?></p>
	</div>
	<?php }
	elseif($message == "hr_del"){ ?>
	<div id="message" class="updated below-h2">
		<p><?php _e('HR Manager deleted successfully','hr_mgt');?></p>
	</div>
	<?php }
	
	
	if($message == "acc_add"){ ?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e('Accountant inserted successfully','hr_mgt');?></p>
	</div>
	<?php 	}
	elseif($message =="acc_edit"){?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e("Accountant updated successfully.",'hr_mgt');?></p>
	</div>
	<?php }
	elseif($message == "acc_del"){ ?>
	<div id="message" class="updated below-h2">
		<p><?php _e('Accountant deleted successfully','hr_mgt');?></p>
	</div>
	<?php }



 } ?>
	
	<div id="main-wrapper">	
		<div class="row">		
			<div class="col-md-12">
				<div class="panel panel-white">
				<div class="col-md-12">
					<div class="col-md-2"><h2 style="margin:15px 0" ><?php _e('Manage  User','hr_mgt'); ?></h2></div>					
				</div>
		<div class="panel-body">
	<h2 class="nav-tab-wrapper">
		<a href="?page=hrmgt-user&tab=all_user" class="nav-tab <?php echo $active_tab == 'all_user' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('All User', 'hr_mgt'); ?></a>

    	<a href="?page=hrmgt-user&tab=employee_list" class="nav-tab <?php if($active_tab=="employee_list" || isset( $_REQUEST['user_type']) && $_REQUEST['user_type']=="employee"){ print 'nav-tab-active';} ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Employee2 List', 'hr_mgt'); ?></a>
		
		<a href="?page=hrmgt-user&tab=hr_list" class="nav-tab <?php if($active_tab=="hr_list" || isset( $_REQUEST['user_type']) && $_REQUEST['user_type']=="manager"){ print 'nav-tab-active';} ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('HR Manager List', 'hr_mgt'); ?></a>
    	
		<a href="?page=hrmgt-user&tab=accountantlist"  class="nav-tab  <?php if($active_tab=="accountantlist" || isset( $_REQUEST['user_type']) && $_REQUEST['user_type']=="accountant"){ print 'nav-tab-active';} ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Accountant List', 'hr_mgt'); ?></a>
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit"){?> 
		<a href="?page=hrmgt-user&tab=hr_list" class="nav-tab nav-tab-active">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Edit User', 'hr_mgt'); ?></a>
		<?php }?>
		<?php
		if(isset($_REQUEST['tab'])){
			if($_REQUEST['tab']=="hr_list"){ ?>
				<a href="?page=hrmgt-user&tab=add_user&user_type=manager" style="float:right" class="btn btn-info <?php echo $active_tab == 'add_user' ? 'nav-tab-active' : ''; ?>"> <i class="dashicons dashicons-plus-alt"></i> <?php _e('Add HR Manager','hr_mgt'); ?></a>
			<?php }elseif($_REQUEST['tab']=="employee_list"){ ?>
				<a href="?page=hrmgt-user&tab=add_user&user_type=employee" style="float:right" class="btn btn-info <?php echo $active_tab == 'add_user' ? 'nav-tab-active' : ''; ?>"><i class="dashicons dashicons-plus-alt"></i> <?php _e('Add Employee','hr_mgt'); ?></a>
			<?php }elseif($_REQUEST['tab']=="accountantlist"){ ?>
				<a href="?page=hrmgt-user&tab=add_user&user_type=accountant" style="float:right" class="btn btn-info <?php echo $active_tab == 'add_user' ? 'nav-tab-active' : ''; ?>"> <i class="dashicons dashicons-plus-alt"></i><?php _e('Add Accountant','hr_mgt'); ?></a>
			<?php }else{ ?>
				<a href="?page=hrmgt-user&tab=add_user" style="float:right" class="btn btn-info <?php echo $active_tab == 'add_user' ? 'nav-tab-active' : ''; ?>"><i class="dashicons dashicons-plus-alt"></i> <?php _e('Add User','hr_mgt'); ?></a>
			<?php }
		}
		?>		
		<?php if($active_tab=='view_employee'){?>
		<a href="#" class="nav-tab <?php echo $active_tab == 'view_employee' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('View', 'hr_mgt'); ?></a>
		<?php } ?>
    </h2>
     <?php 
	
	if($active_tab == 'employee_list')
	{ ?>	
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#employee_list').DataTable({
		"order": [[ 0, "asc" ]],
		"aoColumns":[
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": false}]
		});
} );
</script>

    <form name="activity_form" action="" method="post">
    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="employee_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Photo', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Employee Code', 'hr_mgt' ) ;?></th>
             <th><?php _e( 'Department Name', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'Designation', 'hr_mgt' ) ;?></th>
				<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			<th><?php _e( 'Photo', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Employee Code', 'hr_mgt' ) ;?></th>
             <th><?php _e( 'Department Name', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'Designation', 'hr_mgt' ) ;?></th>
				<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>           
        </tfoot> 
        <tbody>
         <?php 		
		$get_employee = array('role' => 'employee');
		$employeedata=get_users($get_employee);			
		 if(!empty($employeedata))
		 {
		 	foreach ($employeedata as $retrieved_data){ ?>
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
                <td class="name"><a href="?page=hrmgt-user&tab=add_user&user_type=employee&action=edit&id=<?php echo $retrieved_data->ID;?>"><?php echo $retrieved_data->display_name;?></a></td>
				<td class=""><?php echo $retrieved_data->employee_code;?></td>
				<td class="Department"><?php echo hrmgt_get_department_name($retrieved_data->department);?></td>
				<td class="code"><?php echo get_the_title($retrieved_data->designation);?></td>
				
                
               <td class="action">
				   <a href="?page=hrmgt-report&tab=month_report&action=view&employee_id=<?php echo $retrieved_data->ID?>" class="btn btn-success"> <?php _e('Report', 'hr_mgt' ) ;?></a>
				   <a href="?page=hrmgt-user&tab=view_employee&ction=view&employee_id=<?php echo $retrieved_data->ID?>" class="btn btn-primary"><?php _e('View','hr_mgt') ?></a>
					<a href="?page=hrmgt-user&tab=add_user&action=edit&user_type=employee&id=<?php echo $retrieved_data->ID?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
					<a href="?page=hrmgt-user&tab=employee_list&action=delete&emp_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
					onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
					<?php _e( 'Delete', 'hr_mgt' ) ;?> </a>                
                </td>
               
            </tr>
            <?php } 
			
		}?>
		</tbody>
        </table>
        </div>
        </div>
       
</form>
     <?php 
	 }
	 if($active_tab == 'hr_list'){
		require_once HRMS_PLUGIN_DIR.'/admin/user/'.$active_tab.'.php';
	 } 
	 
	 
	 if($active_tab == 'accountantlist'){
		require_once HRMS_PLUGIN_DIR.'/admin/user/accountantlist.php';
	 }
	 if($active_tab == 'add_employee'){
		require_once HRMS_PLUGIN_DIR.'/admin/user/add_employee.php';
	 }
	 
	 if($active_tab == 'add_user'){
		require_once HRMS_PLUGIN_DIR.'/admin/user/add_user.php';
	 }
	 
	 if($active_tab == 'add_hr'){
		require_once HRMS_PLUGIN_DIR.'/admin/user/add_hr.php';
	 } 
	  if($active_tab == 'add_accountant'){
		require_once HRMS_PLUGIN_DIR.'/admin/user/add_accountant.php';
	 }	
	if($active_tab == 'all_user'){			
		require_once HRMS_PLUGIN_DIR.'/admin/user/all_user.php';
	}

	  if($active_tab == 'view_employee'){		  	  
		 require_once HRMS_PLUGIN_DIR.'/admin/user/view_employee.php';
	  }
	 ?>
	 
</div>
</div>
</div>
</div>
