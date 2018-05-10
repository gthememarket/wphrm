<?php 
$user_object=new HrmgtEmployee;
$obj_user = new HrmgtEmployee();
$obj_department=new HrmgtDepartment;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'all_user';
?>
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list"></div>
		</div>
    </div> 
</div>
<div class="page-inner" style="min-height:1088px !important">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?></h3>
	</div>
<?php 

if(isset($_POST['export_employee_csv']))
{	
	export_csv_by_role('employee');
}

if(isset($_POST['import_employee']))
{
	if(isset($_FILES['csv_file']))
	{			
		$errors= array();
		$file_name 	= 	$_FILES['csv_file']['name'];
		$file_size 	=	$_FILES['csv_file']['size'];
		$file_tmp 	=	$_FILES['csv_file']['tmp_name'];
		$file_type	=	$_FILES['csv_file']['type'];
		//$file_ext=strtolower(end(explode('.',$_FILES['csv_file']['name'])));
		$value 		= 	explode(".", $_FILES['csv_file']['name']);
		$file_ext 	= 	strtolower(array_pop($value));
		$extensions = array("csv");
		$upload_dir = wp_upload_dir();
		if(in_array($file_ext,$extensions )=== false)
		{
			$errors[]="this file not allowed, please choose a CSV file.";
		}
		if($file_size > 2097152)
		{
			$errors[]='File size limit 2 MB';
		}
		
		
		if(empty($errors)==true)
		{			
			$rows 	= array_map('str_getcsv', file($file_tmp));	
			//var_dump($rows);
			$header = array_map('strtolower',array_shift($rows));
			//var_dump($header); die;
			
			foreach ($rows as $row) 
			{	
				$csv 		= array_combine($header,$row);				
				$username 	= $csv['user_login'];				
				$user_id  	= 0;
				$password 	= "99Inchrod";
				$problematic_row = false;				
				if( username_exists($username) )
				{ 
					// if user exists, we take his ID by login
					$user_object 	= 	get_user_by( "login", $username );
					$user_id 	 	= 	$user_object->ID;
				
					if( !empty($password) )
						wp_set_password( $password, $user_id );
				}						
				else
				{
					if( empty($password) ) // if user not exist and password is empty but the column is set, it will be generated
						$password 	= 	wp_generate_password();				
					$user_id 	= 	wp_create_user($username, $password);
				}
				
				if( is_wp_error($user_id))
				{
					// in case the user is generating errors after this checks
					echo '<script>alert("Problems with user: ' . $username . ', we are going to skip");</script>';
					continue;
				}
				$role[] = hrmgt_get_user_role($user_id);
				
				
				if(!( in_array("administrator",$role, FALSE) || is_multisite() && is_super_admin( $user_id ) ))
					wp_update_user(array ('ID' => $user_id, 'role' => 'employee')) ;
					//update_user_meta( $user_id, "active", true );
						
				
				if(isset($csv['employee_code']))
					update_user_meta( $user_id, "employee_code", $csv['employee_code'] );
				if(isset($csv['first_name']))
					update_user_meta( $user_id, "first_name", $csv['first_name'] );
				if(isset($csv['last_name']))
					update_user_meta( $user_id, "last_name", $csv['last_name'] );
				if(isset($csv['middle_name']))
					update_user_meta( $user_id, "middle_name", $csv['middle_name'] );						
				if(isset($csv['gender']))
					update_user_meta( $user_id, "gender", strtolower($csv['gender'] ));
				
				if(isset($csv['birth_date']))
					update_user_meta( $user_id, "birth_date", $csv['birth_date'] );
				
				if(isset($csv['marital_status'])) 
					update_user_meta( $user_id, "marital_status", $csv['marital_status'] );
				if(isset($csv['blood_group']))
					update_user_meta( $user_id, "blood_group", $csv['blood_group'] );
				if(isset($csv['working_status']))
					update_user_meta( $user_id, "working_status", $csv['working_status'] );	
				
				if(isset($csv['joining_date']))
					update_user_meta( $user_id, "joining_date", $csv['joining_date'] );
				
				if(isset($_REQUEST['department']))
					update_user_meta( $user_id, "department", $_REQUEST['department'] );
				
				if(isset($csv['contract_end_date'])) 
					update_user_meta( $user_id, "contract_end_date", $csv['contract_end_date'] );
									
				if(isset($csv['deposit'])) 
					update_user_meta($user_id, "deposit", $csv['deposit']);	
				if(isset($csv['employee_level']))
					update_user_meta($user_id, "employee_level", $csv['employee_level']);		
				
				if(isset($csv['term_detail']))
					update_user_meta( $user_id, "term_detail", $csv['term_detail'] );
				if(isset($csv['monthly_leave']))
					update_user_meta( $user_id, "monthly_leave", $csv['monthly_leave'] );
				
				if(isset($csv['designation']))
					update_user_meta( $user_id, "designation", $csv['designation'] );
				
				if(isset($csv['employee_salary']))
					update_user_meta( $user_id, "employee_salary", $csv['employee_salary'] );
				
				if(isset($csv['qualification']))
					update_user_meta( $user_id, "qualification", $csv['qualification'] );
				if(isset($csv['mobile']))
					update_user_meta( $user_id, "mobile", $csv['mobile'] );
				
				if(isset($csv['gov_id']))
					update_user_meta( $user_id, "gov_id", $csv['gov_id'] );
				
				if(isset($csv['passport_number']))
					update_user_meta( $user_id, "passport_number", $csv['passport_number'] );
				
				if(isset($csv['passport_expiry_date']))
					update_user_meta( $user_id, "passport_expiry_date", $csv['passport_expiry_date'] );
				
				if(isset($csv['driving_license_number']))
					update_user_meta( $user_id, "driving_license_number", $csv['driving_license_number'] );

				if(isset($csv['driving_license_expiry_date']))
					update_user_meta( $user_id, "driving_license_expiry_date", $csv['driving_license_expiry_date'] );
				
				if(isset($csv['p_address']))
					update_user_meta( $user_id, "p_address", $csv['p_address'] );				
				if(isset($csv['p_city_name']))
					update_user_meta( $user_id, "p_city_name", $csv['p_city_name'] );				
				if(isset($csv['p_state_name']))
					update_user_meta( $user_id, "p_state_name", $csv['p_state_name'] );				
				if(isset($csv['p_zip_code']))
					update_user_meta( $user_id, "p_zip_code", $csv['p_zip_code'] );
				
				if(isset($csv['address']))
					update_user_meta( $user_id, "address", $csv['address'] );				
				if(isset($csv['city_name']))
					update_user_meta( $user_id, "city_name", $csv['city_name'] );				
				if(isset($csv['state_name']))
					update_user_meta( $user_id, "state_name", $csv['state_name'] );				
				if(isset($csv['zip_code']))
					update_user_meta( $user_id, "zip_code", $csv['zip_code'] );
				
				
				if(isset($csv['ac_holder_name']))
					update_user_meta( $user_id, "ac_holder_name", $csv['ac_holder_name'] );
				
				if(isset($csv['bank_name']))
					update_user_meta( $user_id, "bank_name", $csv['bank_name'] );
				
				if(isset($csv['account_number']))
					update_user_meta( $user_id, "account_number", $csv['account_number'] );
				
				if(isset($csv['ifsc_code']))
					update_user_meta( $user_id, "IFSC_code", $csv['ifsc_code'] );
				
				if(isset($csv['pan_number']))
					update_user_meta( $user_id, "PAN_number", $csv['pan_number'] );
				
				if(isset($csv['branch_name']))
					update_user_meta( $user_id, "branch_name", $csv['branch_name'] );	
				
				$success = 1; 
			}  
		}
		else
		{
			foreach($errors as &$error) echo "<div id='message' class='updated below-h2'>
				<p>$error</p>
				</div>";
		}
		
		if(isset($success))
		{	
			wp_redirect ( admin_url().'admin.php?page=hrmgt-user&tab=employee_list&message=import');
		} 
	}
}



if(isset($_POST['emp_filter']))
{
	$status = $_POST['emp_role'];
}
else
{
	$status = "Working";
}

if(isset($_POST['save_employee']))
{	
	$upload_docs_array=array();
   	
	if(isset($_FILES['cartificate']['name']))
	{
		$count_array=count($_FILES['cartificate']['name']);	
		for($a=0;$a<$count_array;$a++)
		{			
			foreach($_FILES['cartificate'] as $image_key=>$image_val)
			{		
				$document_array[$a]=array(
					'name'=>$_FILES['cartificate']['name'][$a],
					'type'=>$_FILES['cartificate']['type'][$a],
					'tmp_name'=>$_FILES['cartificate']['tmp_name'][$a],
					'error'=>$_FILES['cartificate']['error'][$a],
					'size'=>$_FILES['cartificate']['size'][$a]
				);			
			}
		}
	
		foreach($document_array as $key=>$value)
		{
			$get_file_name=$document_array[$key]['name'];
			$upload_docs_array[]=hrmgt_documets($value,$value,$get_file_name);
		}
		
		if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && $_POST['old_hidden_cartificate'])
		{
			$old_carti_arr =$_POST['old_hidden_cartificate'];	
			$filedata = array_filter(array_merge($upload_docs_array,$old_carti_arr));
		}
		else
		{
			$filedata = $upload_docs_array;
		}
	
		$filedatas = array_combine(array_filter($_POST['cartificate_name']),$filedata);
	
		$upload_docs_array = array_combine($_POST['cartificate_name'],$upload_docs_array);
		$upload_docs_array['all_carti'] = $filedatas;
	
		if(isset($_FILES['join_latter']) && !empty($_FILES['join_latter']) && $_FILES['join_latter']['size'] !=0)
		{
			if($_FILES['join_latter']['size'] > 0)
				$upload_docs_array['join_latter']=hrmgt_load_documets($_FILES['join_latter'],'join_latter','join_latter');	
		}
		else
		{
			if(isset($_REQUEST['hidden_join_latter']))
			$upload_docs_array['hidden_join_latter']=$_REQUEST['hidden_join_latter'];
		}
	
		if(isset($_FILES['cv']) && !empty($_FILES['cv']) && $_FILES['cv']['size'] !=0)
		{
			if($_FILES['cv']['size'] > 0)
				$upload_docs_array['cv']=hrmgt_load_documets($_FILES['cv'],'cv','cv');	
		}
		else
		{
			if(isset($_REQUEST['hidden_cv']))
				$upload_docs_array['hidden_cv']=$_REQUEST['hidden_cv'];
		}
	
	
		if(isset($_FILES['contract']) && !empty($_FILES['contract']) && $_FILES['contract']['size'] !=0)
		{
			if($_FILES['contract']['size'] > 0)
				$upload_docs_array['contract']=hrmgt_load_documets($_FILES['contract'],'contract','contract');	
		}
		else
		{
			if(isset($_REQUEST['hidden_contract']))
				$upload_docs_array['hidden_contract']=$_REQUEST['hidden_contract'];
		}	
	
	
		if(isset($_FILES['id_proof']) && !empty($_FILES['id_proof']) && $_FILES['id_proof']['size'] !=0)
		{
			if($_FILES['id_proof']['size'] > 0)
				$upload_docs_array['id_proof']=hrmgt_load_documets($_FILES['id_proof'],'id_proof','id_proof');	
		}
		else
		{
			if(isset($_REQUEST['hidden_id_proof']))
			$upload_docs_array['hidden_id_proof']=$_REQUEST['hidden_id_proof'];
		}
	} 

	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{	
		$result=$user_object->hrmgt_add_user($_POST);	
		$user_object->hrmgt_update_upload_documents($upload_docs_array,$result);

		if($result)
		{				
			wp_redirect ( admin_url().'admin.php?page=hrmgt-user&tab=employee_list&message=emp_edit');
		} 
	}
	else
	{	if( !email_exists( $_POST['email'] ) && !username_exists( $_POST['username'] )) 
		{
			$result=$user_object->hrmgt_add_user($_POST);
		}
		$upload_docs_arrays = removeEmptyElementsFromArray($upload_docs_array);
		$user_object->hrmgt_upload_documents($upload_docs_arrays,$result);
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=hrmgt-user&tab=employee_list&message=emp_add');
		}
	}
	//}
	
}


if(isset($_POST['save_staff']))
{	

	$obj_user = new HrmgtEmployee();
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{			
		$result=$obj_user->hrmgt_add_user($_POST);	
		if($result)
		{
			wp_redirect ( admin_url() . 'admin.php?page=hrmgt-user&tab=hr_list&message=hr_edit');
		}
	}
	else
	{
		if( !email_exists( $_POST['email'] ) && !username_exists( $_POST['username'] )) 
		{	
			$result=$obj_user->hrmgt_add_user($_POST);				
			if($result)
			{
				wp_redirect (admin_url() . 'admin.php?page=hrmgt-user&tab=hr_list&message=hr_add');
			}
	}
	else
	{ ?>
		<div id="message" class="updated below-h2">
			<p><?php _e('Username Or Email id exists already.','hr_mgt');?></p>
		</div>
<?php }
	}		
}

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{			
	$result=$obj_user->delete_usedata($_REQUEST['hr_id']);
	if($result)
	{
		wp_redirect ( admin_url() . 'admin.php?page=hrmgt-user&tab=hr_list&message=hr_del');
	}
}


if(isset($_POST['save_accountant']))
{	
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{
		$result=$obj_user->hrmgt_add_user($_POST);
		if($result)
		{
			wp_redirect ( admin_url() . 'admin.php?page=hrmgt-user&tab=accountantlist&message=acc_edit');
		}
	}
	else
	{
		if( !email_exists( $_POST['email'] ) && !username_exists( $_POST['username'] ))
		{	
			$result=$obj_user->hrmgt_add_user($_POST);
			if($result)
			{
				wp_redirect ( admin_url() . 'admin.php?page=hrmgt-user&tab=accountantlist&message=acc_add');
			}
		}
		else
		{ ?>
			<div id="message" class="updated  msg below-h2">
				<p><?php _e('Username Or Email id exists already.','hr_mgt');?></p>
			</div>						
	  <?php }
	}
}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{				
	$result=$obj_user->delete_usedata($_REQUEST['accountant_id']);
	if($result)
	{
		wp_redirect ( admin_url() . 'admin.php?page=hrmgt-user&tab=accountantlist&message=acc_del');
	}
}

		
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	$result=$user_object->delete_usedata($_REQUEST['emp_id']);
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=hrmgt-user&tab=employee_list&message=emp_del');
	}
}

if(isset($_REQUEST['message']))
{
	$message =$_REQUEST['message'];	
	if($message == "emp_add"){ ?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e('Employee insert successfully','hr_mgt');?></p>
	</div>
	<?php 	}
	if($message == "import"){ ?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e('CSV file Imported successfully','hr_mgt');?></p>
	</div>
	<?php 	}
	elseif($message =="emp_edit"){?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e("Employee update successfully.",'hr_mgt');?></p>
	</div>
	<?php }
	elseif($message =="docupmsg"){?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e("Docunent Upload error.",'hr_mgt');?></p>
	</div>
	<?php }
	elseif($message == "emp_del"){ ?>
	<div id="message" class="updated below-h2">
		<p><?php _e('Employee delete successfully','hr_mgt');?></p>
	</div>
	<?php }
	
	if($message == "hr_add"){ ?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e('HR Manager insert successfully','hr_mgt');?></p>
	</div>
	<?php 	}
	elseif($message =="hr_edit"){?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e("HR Manager update successfully.",'hr_mgt');?></p>
	</div>
	<?php }
	elseif($message == "hr_del"){ ?>
	<div id="message" class="updated below-h2">
		<p><?php _e('HR Manager delete successfully','hr_mgt');?></p>
	</div>
	<?php }	
	
	if($message == "acc_add"){ ?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e('Accountant insert successfully','hr_mgt');?></p>
	</div>
	<?php 	}
	elseif($message =="acc_edit"){?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e("Accountant update successfully.",'hr_mgt');?></p>
	</div>
	<?php }
	elseif($message == "acc_del"){ ?>
	<div id="message" class="updated below-h2">
		<p><?php _e('Accountant delete successfully','hr_mgt');?></p>
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
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Employee List', 'hr_mgt'); ?></a>
		
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
		<a href="?page=hrmgt-user&tab=upload_emp" class="nav-tab <?php if($active_tab == 'upload_emp'){ print  'nav-tab-active'; } ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '. __('Upload Employee', 'hr_mgt'); ?></a>
		
		<?php if($active_tab=='view_employee'){?>
		<a href="#" class="nav-tab <?php echo $active_tab == 'view_employee' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="fa fa-eye"></span> '.__('View', 'hr_mgt'); ?></a>
		<?php } ?>
    </h2>
     <?php 
	
	if($active_tab == 'employee_list')
	{ ?>	
<script type="text/javascript">
$(document).ready(function() {
var working_status = $('#emp_status').val();
	jQuery('#employee_list').DataTable({
		 "bProcessing": true,
		 "bServerSide": true,
		 "sAjaxSource": ajaxurl+'?action=datatable_All_employee_ajax_to_load&working_status='+working_status,
		 "bDeferRender": true,
		});
	});
</script>

<form name="" action="" class="form-inline" method="post" style="margin-top:35px">
	<div class="form-group">
		<label for="email"><?php _e('Select Status','hr_mgt')?></label>
	</div>
	<select class="form-control" name="emp_role" id="emp_status" style="width:200px">		
		<option value="Working" <?php selected('Working',$status); ?>><?php _e('Working','hr_mgt'); ?></option>
		<option value="Left" <?php selected('Left',$status); ?>><?php _e('Left','hr_mgt'); ?></option>
		<option value="Resign" <?php selected('Resign',$status); ?> ><?php _e('Resign','hr_mgt'); ?></option>
	</select>
	<input type="submit" name="emp_filter" value="Go" class="btn btn-info" />
</form>
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
				<th><?php _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
				<th><?php _e( 'Photo', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Employee Code', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Department Name', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Designation', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </tfoot>
     </table>		
        </div>
        </div>	
		<form method="post">
			<input type="submit" name="export_employee_csv" value="Export IN CSV" class="btn btn-info" >
		</form>		
    <?php 
	}
	if($active_tab == 'hr_list')
	{
		require_once HRMS_PLUGIN_DIR.'/admin/user/'.$active_tab.'.php';
	} 
	if($active_tab == 'accountantlist')
	{
		require_once HRMS_PLUGIN_DIR.'/admin/user/accountantlist.php';
	}
	
	if($active_tab == 'add_employee')
	{
		require_once HRMS_PLUGIN_DIR.'/admin/user/add_employee.php';
	}
	 
	if($active_tab == 'add_user')
	{
		require_once HRMS_PLUGIN_DIR.'/admin/user/add_user.php';
	}
	 
	if($active_tab == 'add_hr')
	{
		require_once HRMS_PLUGIN_DIR.'/admin/user/add_hr.php';
	}
	
	if($active_tab == 'add_accountant')
	{
		require_once HRMS_PLUGIN_DIR.'/admin/user/add_accountant.php';
	}
	
	if($active_tab == 'all_user')
	{			
		require_once HRMS_PLUGIN_DIR.'/admin/user/all_user.php';
	}

	if($active_tab == 'view_employee')
	{		  	  
		require_once HRMS_PLUGIN_DIR.'/admin/user/view_employee.php';
	}
	
	if($active_tab == 'upload_emp')
	{
		require_once HRMS_PLUGIN_DIR.'/admin/user/'.$active_tab.'.php';
	}
	?>	 
</div>
</div>
</div>
</div>