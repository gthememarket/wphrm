<?php
$user_object=new HrmgtEmployee;
$obj_user = new HrmgtEmployee();
$obj_department=new HrmgtDepartment;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'all_user';
if(isset($_POST['emp_filter']))
{
	$status = $_POST['emp_role'];
}
else
{
	$status = "Working";
}
?>
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list"></div>
		</div>
    </div> 
</div>
<div class="page-inner" style="min-height:500px !important">	
<?php 
if(isset($_POST['import_employee']))
{
	if(isset($_FILES['csv_file']))
	{			
		$errors= array();
		$file_name = $_FILES['csv_file']['name'];
		$file_size =$_FILES['csv_file']['size'];
		$file_tmp =$_FILES['csv_file']['tmp_name'];
		$file_type=$_FILES['csv_file']['type'];
		//$file_ext=strtolower(end(explode('.',$_FILES['csv_file']['name'])));
		$value = explode(".", $_FILES['csv_file']['name']);
		$file_ext = strtolower(array_pop($value));
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
			$rows = array_map('str_getcsv', file($file_tmp));			
			$header = array_map('strtolower',array_shift($rows));
			
			foreach ($rows as $row) 
			{		
				$csv = array_combine($header,$row);					
				$username = $csv['user_login'];				
				$user_id  = 0;
				$password = "99Inchrod";
				$problematic_row = false;				
				if( username_exists($username) )
				{ // if user exists, we take his ID by login
					$user_object = get_user_by( "login", $username );
					$user_id = $user_object->ID;
				
					if( !empty($password) )
						wp_set_password( $password, $user_id );
				}						
				else
				{
					if( empty($password) ) // if user not exist and password is empty but the column is set, it will be generated
						$password = wp_generate_password();				
					$user_id = wp_create_user($username, $password/*, $email*/);
				}
				
				if( is_wp_error($user_id))
				{ // in case the user is generating errors after this checks
					echo '<script>alert("Problems with user: ' . $username . ', we are going to skip");</script>';
					continue;
				}
				$role = hrmgt_get_user_role($user_id);
				
				
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
				
				if(isset($csv['contract_end_date'])) #### /* Singer’s Cell Phone (6th grade and up) */
					update_user_meta( $user_id, "contract_end_date", $csv['contract_end_date'] );
									
				if(isset($csv['deposit'])) #### /* Parent 1 Phone*/
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
			foreach($errors as &$error) echo $error;
		}
		
		if(isset($success))
		{	
			wp_redirect ('?hr-dashboard=user&page=user&tab=employee_list&message=import');
		} 
	}
}

if(isset($_POST['export_employee_csv']))
{
	export_csv_by_role('employee');
}

if(isset($_POST['save_employee']))
{	
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
		$filedatas = array_combine($_POST['cartificate_name'],$filedata);

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
	if(isset($_FILES['upload_user_avatar_image']) && !empty($_FILES['upload_user_avatar_image']) && $_FILES['upload_user_avatar_image']['size'] !=0){
		if($_FILES['upload_user_avatar_image']['size'] > 0)
		{
			$member_image=hrmgt_load_documets($_FILES['upload_user_avatar_image'],'upload_user_avatar_image','pimg');
			$member_image_url=content_url().'/uploads/hr_assets/'.$member_image;
		}
	}
	else{
		if(isset($_REQUEST['hidden_upload_user_avatar_image']))				
			$member_image=$_REQUEST['hidden_upload_user_avatar_image'];				
			$member_image_url=$member_image;						
	}	
	
	
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{
		$result=$user_object->hrmgt_add_user($_POST);
		$returnans=update_user_meta( $result,'hrmgt_user_avatar',$member_image_url);
		$user_object->hrmgt_update_upload_documents($upload_docs_array,$result);
		if($result)	
		{
			wp_redirect ('?hr-dashboard=user&page=user&tab=employee_list&message=emp_edit');
		} 
	}
	else
	{		
		$result=$user_object->hrmgt_add_user($_POST);
		$returnans=update_user_meta( $result,'hrmgt_user_avatar',$member_image_url);
		$upload_docs_arrays = removeEmptyElementsFromArray($upload_docs_array);
		$user_object->hrmgt_upload_documents($upload_docs_arrays,$result);
		if($result)
		{
			wp_redirect ( '?hr-dashboard=user&page=user&tab=employee_list&message=emp_add');
		}
	}
}

if(isset($_POST['save_staff']))
{
	$obj_user = new HrmgtEmployee();
	if(isset($_FILES['upload_user_avatar_image']) && !empty($_FILES['upload_user_avatar_image']) && $_FILES['upload_user_avatar_image']['size'] !=0)
	{
		if($_FILES['upload_user_avatar_image']['size'] > 0)
		{
			$member_image=hrmgt_load_documets($_FILES['upload_user_avatar_image'],'upload_user_avatar_image','pimg');
			$member_image_url=content_url().'/uploads/hr_assets/'.$member_image;
		}
	}
	else
	{
		if(isset($_REQUEST['hidden_upload_user_avatar_image']))				
			$member_image=$_REQUEST['hidden_upload_user_avatar_image'];				
			$member_image_url=$member_image;						
	}


	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{			
		$result=$obj_user->hrmgt_add_user($_POST);
		$returnans=update_user_meta( $result,'hrmgt_user_avatar',$member_image_url);
		if($result)
		{
			wp_redirect ( '?hr-dashboard=user&page=user&tab=hr_list&message=hr_edit');
		}
	}
	else
	{
		if( !email_exists( $_POST['email'] ) && !username_exists( $_POST['username'] ))
		{	
			$result=$obj_user->hrmgt_add_user($_POST);
			$returnans=update_user_meta( $result,'hrmgt_user_avatar',$member_image_url);
			if($result)
			{
				wp_redirect ('?hr-dashboard=user&page=user&tab=hr_list&message=hr_add');
			}
		}
	else{ ?>
	<div id="message" class="updated below-h2">
		<p><?php _e('Username Or Email id exists already.','hr_mgt');?></p>
	</div>						
	<?php }
	}		
}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	$result=$obj_user->delete_usedata($_REQUEST['hr_id']);
	if($result){
		wp_redirect ('?hr-dashboard=user&page=user&tab=hr_list&message=hr_del');
	}
}
	
if(isset($_POST['save_accountant']))
{	

	if(isset($_FILES['upload_user_avatar_image']) && !empty($_FILES['upload_user_avatar_image']) && $_FILES['upload_user_avatar_image']['size'] !=0)
	{
		if($_FILES['upload_user_avatar_image']['size'] > 0)
		{
			$member_image=hrmgt_load_documets($_FILES['upload_user_avatar_image'],'upload_user_avatar_image','pimg');
			$member_image_url=content_url().'/uploads/hr_assets/'.$member_image;
		}
	}
	else
	{
		if(isset($_REQUEST['hidden_upload_user_avatar_image']))				
		$member_image=$_REQUEST['hidden_upload_user_avatar_image'];				
			$member_image_url=$member_image;						
	}



if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
{
	$result=$obj_user->hrmgt_add_user($_POST);
	$returnans=update_user_meta( $result,'hrmgt_user_avatar',$member_image_url);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=user&tab=accountantlist&message=acc_edit');
		}
	}
	else
	{
		if( !email_exists( $_POST['email'] ) && !username_exists( $_POST['username'] ))
		{	
			$result=$obj_user->hrmgt_add_user($_POST);
			$returnans=update_user_meta( $result,'hrmgt_user_avatar',$member_image_url);
				if($result)
				{
					wp_redirect ('?hr-dashboard=user&page=user&tab=accountantlist&message=acc_add');
				}
			}
			else{?>
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
		wp_redirect ('?hr-dashboard=user&page=user&tab=accountantlist&message=acc_del');
	}
}
		
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	$result=$user_object->delete_usedata($_REQUEST['emp_id']);
	if($result)
	{
		wp_redirect ('?hr-dashboard=user&page=user&tab=employee_list&message=emp_del');
	}
}
if(isset($_REQUEST['message'])){
	$message =$_REQUEST['message'];
	print '<div class="message_space">';
	if($message == "emp_add"){ ?>
	<div id="message" class="updated below-h2 msg ">
		<p><?php _e('Employee insert successfully','hr_mgt');?></p>
	</div>
	<?php 	}
	elseif($message =="emp_edit"){?>
	<div id="message" class="updated below-h2 msg ">
		<p><?php _e("Employee update successfully.",'hr_mgt');?></p>
	</div>
	<?php }
	elseif($message == "emp_del"){ ?>
	<div id="message" class="updated below-h2 msg ">
		<p><?php _e('Employee delete successfully','hr_mgt');?></p>
	</div>
	<?php }
	
	if($message == "hr_add"){ ?>
	<div id="message" class="updated below-h2 msg msg">
		<p><?php _e('HR Manager insert successfully','hr_mgt');?></p>
	</div>
	<?php 	}
	elseif($message == "import"){ ?>
	<div id="message" class="updated below-h2 msg msg">
		<p><?php _e('CSV file imported successfully','hr_mgt');?></p>
	</div>
	<?php 	}
	elseif($message =="hr_edit"){?>
	<div id="message" class="updated below-h2 msg">
		<p><?php _e("HR Manager updat successfully.",'hr_mgt');?></p>
	</div>
	<?php }
	elseif($message == "hr_del"){ ?>
	<div id="message" class="updated below-h2 msg">
		<p><?php _e('HR Manager delete successfully','hr_mgt');?></p>
	</div>
	<?php }
	
	
	if($message == "acc_add"){ ?>
	<div id="message" class="updated below-h2 msg">
		<p><?php _e('Accountant insert successfully','hr_mgt');?></p>
	</div>
	<?php 	}
	elseif($message =="acc_edit"){?>
	<div id="message" class="updated below-h2 msg">
		<p><?php _e("Accountant update successfully.",'hr_mgt');?></p>
	</div>
	<?php }
	elseif($message == "acc_del"){ ?>
	<div id="message" class="updated below-h2 msg">
		<p><?php _e('Accountant delete successfully','hr_mgt');?></p>
	</div>
	<?php }  print "</div>"; } ?>
	
	<div id="main-wrapper">	
		<div class="row">		
			<div class="col-md-12">
				<div class="panel panel-white">
				
<div class="panel-body">		
	 <ul class="nav nav-tabs panel_tabs" role="tablist">	 
	  	<li class="<?php if($active_tab=='all_user'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=user&tab=all_user" class="tab <?php echo $active_tab == 'all_user' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('All User', 'hr_mgt'); ?></a>         
		</li>		
		
		<li class="<?php if($active_tab=='employee_list'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=user&tab=employee_list" class="tab <?php echo $active_tab == 'employee_list' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Employee', 'hr_mgt'); ?></a>         
		</li>
		
		<li class="<?php if($active_tab=='hr_list'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=user&tab=hr_list" class="tab <?php echo $active_tab == 'hr_list' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('HR Manager', 'hr_mgt'); ?></a>         
		</li>
		
		
		<li class="<?php if($active_tab=='accountantlist'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=user&tab=accountantlist" class="tab <?php echo $active_tab == 'accountantlist' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Accountant', 'hr_mgt'); ?></a>         
		</li>
		<?php if($role=="manager"){ ?> 
			<li class="<?php if($active_tab=='upload_emp'){?>active<?php }?>">
				<a href="?hr-dashboard=user&page=user&tab=upload_emp" class="tab <?php echo $active_tab == 'upload_emp' ? 'active' : ''; ?>">
				 <i class="fa fa-align-justify"></i> <?php _e('Upload Employee', 'hr_mgt'); ?></a>			  
			</li>
		<?php } ?>
		
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit"){ ?> 
		<li class="active">
			<a href="#" class="tab "><?php _e(' Edit User','hr_mgt'); ?></a>          
		</li>
		<?php } ?> 
		
		<?php if($role=="manager"){ ?>
		<?php if($active_tab=="employee_list"){?>
			<li style="float:right; padding:0;" class="<?php if($active_tab=='add_user'){?>active<?php } ?>">		
				<a href="?hr-dashboard=user&page=user&tab=add_user&user_type=employee" class="<?php echo $active_tab == 'add_user' ? 'active' : ''; ?>">
					<i class="fa fa-plus-circle" aria-hidden="true"></i> <?php _e('Add Employee', 'hr_mgt'); ?></a>
			</li>
		<?php } elseif($active_tab=="hr_list"){ ?> 
			<li style="float:right; padding:0;" class="<?php if($active_tab=='add_user'){?>active<?php } ?>">		
			<a href="?hr-dashboard=user&page=user&tab=add_user&user_type=manager" class="  <?php echo $active_tab == 'add_user' ? 'active' : ''; ?>">
				<i class="fa fa-plus-circle" aria-hidden="true"></i> <?php _e('Add HR Manager', 'hr_mgt'); ?></a>
			 </li>
		<?php } elseif($active_tab=="accountantlist"){ ?>
			<li style="float:right; padding:0;" class="<?php if($active_tab=='add_user'){?>active<?php } ?>">		
				<a href="?hr-dashboard=user&page=user&tab=add_user&user_type=accountant" class="  <?php echo $active_tab == 'add_user' ? 'active' : ''; ?>">
					<i class="fa fa-plus-circle" aria-hidden="true"></i> <?php _e('Add Accountant', 'hr_mgt'); ?></a>
			</li>
		<?php } else{?> 
			<li style="float:right; padding:0;" class="<?php if($active_tab=='add_user'){?>active<?php } ?>">		
			<a href="?hr-dashboard=user&page=user&tab=add_user" class="  <?php echo $active_tab == 'add_user' ? 'active' : ''; ?>">
				 <i class="fa fa-plus-circle" aria-hidden="true" style="padding-right:4px;"></i><?php _e('Add User', 'hr_mgt'); ?></a>
			  </a>			
		</li>
		<?php } }?>
</ul>

<?php if($active_tab == 'employee_list'){ ?>	
<script type="text/javascript">
$(document).ready(function() {
   var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
   var working_status = $('#emp_status').val();
	jQuery('#employee_list').DataTable({
		"bProcessing": true,
		 "bServerSide": true,
		 "sAjaxSource": ajaxurl+'?action=datatable_All_employee_ajax_to_load&working_status='+working_status,
		 "bDeferRender": true,
	});
});
</script>
<?php 
if($role=="manager")
{
?> 
<form name="" action="" class="form-inline" method="post" style="margin-top:35px">
	<div class="form-group">
		<label for="email"><?php _e('Select Status','hr_mgt')?></label>
	</div>
	<select class="form-control" name="emp_role" style="width:200px">		
		<option value="Working" <?php selected('Working',$status); ?>><?php _e('Working','hr_mgt'); ?></option>
		<option value="Left" <?php selected('Left',$status); ?>><?php _e('Left','hr_mgt'); ?></option>
		<option value="Resign" <?php selected('Resign',$status); ?> ><?php _e('Resign','hr_mgt'); ?></option>
	</select>
	<input type="submit" name="emp_filter" value="Go" class="btn btn-info" />
</form>
<?php
}
?>
    <form name="activity_form" action="" method="post">    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="employee_list" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
				<th><?php 	_e( 'Photo', 'hr_mgt' ) ;?></th>
				<th><?php 	_e( 'Employee Name', 'hr_mgt' ) ;?></th>
				<th><?php 	_e( 'Employee Code', 'hr_mgt' ) ;?></th>
				<th><?php 	_e( 'Department Name', 'hr_mgt' ) ;?></th>
				<th><?php 	_e( 'Designation', 'hr_mgt' ) ;?></th>
				<th><?php  	_e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
				<th><?php 	_e( 'Photo', 'hr_mgt' ) ;?></th>
				<th><?php 	_e( 'Employee Name', 'hr_mgt' ) ;?></th>
				<th><?php 	_e( 'Employee Code', 'hr_mgt' ) ;?></th>
				<th><?php 	_e( 'Department Name', 'hr_mgt' ) ;?></th>
				<th><?php 	_e( 'Designation', 'hr_mgt' ) ;?></th>
				<th><?php 	_e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>           
        </tfoot> 
    <!--    <tbody>
         <?php 
		  $args = array (
				'role'       	=> 'employee',				
				'meta_query' 	=> array(
					'relation' 	=> 'OR',
					array(
						'key'     => 'working_status',
						'value'   => $status,
						'compare' => 'LIKE'
					),       
				)
			);
			$employees = get_users( $args );
			
			/* $get_employee = array('role' => 'employee');
			$employees=get_users($get_employee); */			
			$logindata[] 	= $obj_user->hrmgt_get_single_employee_data_new(get_current_user_id());		
			$employeedata 	= array_merge($logindata,$employees);			
			$employeedata  	= array_unique($employeedata,SORT_REGULAR);
			
			if(!empty($employeedata))
			{
				foreach ($employeedata as $retrieved_data)
				{ ?>
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
							<td class="name"><a href="?hr-dashboard=user&page=user&tab=add_user&user_type=employee&action=edit&id=<?php echo $retrieved_data->ID;?>"><?php echo $retrieved_data->first_name .' '. $retrieved_data->last_name; ?></a></td>
						<?php } else { ?> 
							<td class="name"><?php echo $retrieved_data->first_name .' '. $$retrieved_data->last_name;?></td>
						<?php } ?>	
						<td><?php echo $retrieved_data->employee_code;?></td>
						<td class="Department"><?php echo !empty($retrieved_data->department) ? hrmgt_get_department_name($retrieved_data->department):'';?></td>
						<td class="code"><?php echo !empty($retrieved_data->designation)?get_the_title($retrieved_data->designation):'';?></td>						
					   <td class="action">				   
						<?php if($retrieved_data->ID==get_current_user_id() ||  $role=='manager'){ ?>
								<a href="?hr-dashboard=user&page=user&tab=view_employee&ction=view&employee_id=<?php echo $retrieved_data->ID?>" class="btn btn-primary"><?php _e('View','hr_mgt') ?></a>
							<?php } ?>
							<?php if($retrieved_data->ID == get_current_user_id() && $role == "employee" ||  $role=='manager' ){ ?> 
								<a href="?hr-dashboard=user&page=user&tab=add_user&action=edit&user_type=employee&id=<?php echo $retrieved_data->ID?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
							<?php } ?>
								
							<?php if($role=="manager" ){ ?>
								<a href="?hr-dashboard=user&page=user&tab=employee_list&action=delete&emp_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
								onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
								<?php _e( 'Delete', 'hr_mgt' ) ;?> </a>
							<?php }   ?>
						</td>					   
					</tr>
            <?php } 			
			}?>
		</tbody>-->
        </table>
        </div>
        </div>
		<?php 
		if($role=='manager')
		{ 
			print '<input name="export_employee_csv" value="Export IN CSV" class="btn btn-info" type="submit">';
		} 
		?>      
	</form>
     <?php 
	}
	if($active_tab == 'hr_list')
	{
		require_once HRMS_PLUGIN_DIR.'/template/user/'.$active_tab.'.php';
	} 
	 	 
	if($active_tab == 'accountantlist')
	{		 
		require_once HRMS_PLUGIN_DIR.'/template/user/accountantlist.php';
	}
	
	if($active_tab == 'add_employee')
	{		
		require_once HRMS_PLUGIN_DIR.'/template/user/add_employee.php';
	}
	 
	if($active_tab == 'add_user')
	{
		require_once HRMS_PLUGIN_DIR.'/template/user/add_user.php';
	}
	 
	if($active_tab == 'add_hr')
	{
		require_once HRMS_PLUGIN_DIR.'/template/user/add_hr.php';
	} 
	
	if($active_tab == 'add_accountant')
	{
		require_once HRMS_PLUGIN_DIR.'/template/user/add_accountant.php';
	}	
	
	if($active_tab == 'all_user')
	{			
		require_once HRMS_PLUGIN_DIR.'/template/user/all_user.php';
	}
	
	if($active_tab == 'view_employee')
	{		  	  
		require_once HRMS_PLUGIN_DIR.'/template/user/view_employee.php';		 
	}
	
	if($active_tab == 'upload_emp')
	{		  	  
		 require_once HRMS_PLUGIN_DIR.'/template/user/upload_emp.php';
	}
	?>	 
</div>
</div>
</div>
</div>