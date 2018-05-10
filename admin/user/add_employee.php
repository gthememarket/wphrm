<?php 
$obj_user=new HrmgtEmployee;
$obj_department=new HrmgtDepartment;
$role="employee";
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#employee_form').validationEngine();
	$('#birth_date').datepicker({
		dateFormat:'yy-mm-dd',
		maxDate: 0,
		dateFormat:'yy-mm-dd',
		changeMonth: true,
	    changeYear: true,
	    yearRange:'-65:+0',
		onChangeMonthYear: function(year, month, inst) {
	        $(this).val(month + "/" + year);
	    }
	}); 
	
	$('.date').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
	    changeYear: true,
		defaultDate: new Date(),
	    yearRange:'-65:+30',
	    onChangeMonthYear: function(year, month, inst) {
	        $(this).val(month + "/" + year);
	    }
	});  	  
}); 
</script>
<?php 	
$id=0;
if(isset($_REQUEST['id']))
	$id=$_REQUEST['id'];
	$edit=0;
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
{
	$edit=1;
	$result = get_userdata($id);	
	$EarningData = json_decode(get_user_meta($result->ID,'other_earning_entry',true));	
	$DeductionData = json_decode(get_user_meta($result->ID,'other_deduction_entry',true));	
} 
?> 
<form name="employee_form" action="" method="post" class="form-horizontal" id="employee_form" enctype="multipart/form-data">
    <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
	<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
	<input type="hidden" name="id" value="<?php echo $id;?>"  />
	<input type="hidden" name="role" value="<?php echo $role;?>"  />		
		<div class="header"><hr>
			<h3><?php _e('Employee Information','hr_mgt');?></h3>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_code"><?php _e('Employee Code','hr_mgt');?></label>
			<div class="col-sm-8">
			<?php
				if($edit == 0)
				{
					$employee_code = $user_object->generate_employee_code();
				}
			?>
				<input id="employee_code" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo $result->employee_code;}elseif(isset($_POST['employee_code'])){echo $_POST['employee_code'];}else{echo $employee_code;}?>" name="employee_code" readonly>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="first_name"><?php _e('First Name','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="first_name" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo $result->first_name;}elseif(isset($_POST['first_name'])) echo $_POST['first_name'];?>" name="first_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="middle_name"><?php _e('Middle Name','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="middle_name" class="form-control " type="text"  value="<?php if($edit){ echo $result->middle_name;}elseif(isset($_POST['middle_name'])) echo $_POST['middle_name'];?>" name="middle_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="last_name"><?php _e('Last Name','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="last_name" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo $result->last_name;}elseif(isset($_POST['last_name'])) echo $_POST['last_name'];?>" name="last_name">
			</div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="username"><?php _e('User Name','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="username" class="form-control validate[required]" type="text"  name="username" 
				value="<?php if($edit){ echo $result->user_login;}elseif(isset($_POST['username'])) echo $_POST['username'];?>" <?php if($edit) echo "readonly";?>>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="password"><?php _e('Password','hr_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
			<div class="col-sm-8">
				<input id="password" class="form-control <?php if(!$edit) echo 'validate[required]';?>" type="password"  name="password" value="">
			</div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label " for="email"><?php _e('Email','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="email" class="form-control validate[required,custom[email]] text-input" type="text"  name="email" 
				value="<?php if($edit){ echo $result->user_email;}elseif(isset($_POST['email'])) echo $_POST['email'];?>">
			</div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="gender"><?php _e('Gender','hr_mgt');?></label>
			<div class="col-sm-8">
			<?php $genderval = "male"; if($edit){ $genderval=$result->gender; }elseif(isset($_POST['gender'])) {$genderval=$_POST['gender'];}?>
				<label class="radio-inline">
			     <input type="radio" value="male" class="tog" name="gender"  <?php  checked( 'male', $genderval);  ?>/><?php _e('Male','hr_mgt');?>
			    </label>
			    <label class="radio-inline">
			      <input type="radio" value="female" class="tog" name="gender"  <?php  checked( 'female', $genderval);  ?>/><?php _e('Female','hr_mgt');?> 
			    </label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="birth_date"><?php _e('Date of birth','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="birth_date" class="form-control validate[required]" type="text"  name="birth_date" 
				value="<?php if($edit){ echo isset($result->birth_date)?date("Y-m-d",strtotime($result->birth_date)):'';}elseif(isset($_POST['birth_date'])) echo $_POST['birth_date'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="marital_status"><?php _e('Marital Status ','hr_mgt');?></label>
			<div class="col-sm-8">
				<select class="form-control" name="marital_status">
				<option value=""><?php _e('Select Marital Status ','hr_mgt');?></option>
				<?php 
				if($edit)
					$status =$result->marital_status;
				elseif(isset($_POST['marital_status']))
					$status =$_POST['marital_status'];
				else
					$status ="";?>
				<option value="single" <?php selected($status,'single');?>><?php _e('Single','hr_mgt');?></option>
				<option value="married" <?php selected($status,'married');?>><?php _e('Married','hr_mgt');?></option>
				<option value="divorced" <?php selected($status,'divorced');?>><?php _e('Divorced','hr_mgt');?></option>
				<option value="separated" <?php selected($status,'separated');?>><?php _e('Separated','hr_mgt');?></option>
				<option value="widowed" <?php selected($status,'widowed');?>><?php _e('Widowed','hr_mgt');?></option>
				<option value="in_relationship" <?php selected($status,'in_relationship');?>><?php _e('In A Relationship','hr_mgt');?></option>
				<option value="engaged" <?php selected($status,'engaged');?>><?php _e('Engaged','hr_mgt');?></option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="bloodgruop"><?php _e('Blood Group','hr_mgt');?></label>
			<div class="col-sm-8">
				<?php if($edit){ $userblood=$result->blood_group; }elseif(isset($_POST['blood_group'])){$userblood=$_POST['blood_group'];}else{$userblood='';}?>
				<select id="blood_group" class="form-control" name="blood_group">
				<option value=""><?php _e('Select Blood Group','hr_mgt');?></option>
				<?php foreach(hrmgt_blood_group() as $blood){ ?>
						<option value="<?php echo $blood;?>" <?php selected($userblood,$blood);  ?>><?php echo $blood; ?> </option>
				<?php } ?>
			</select>
			</div>
		</div>
		
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="working_status"><?php _e('Working Status ','hr_mgt');?></label>
			<div class="col-sm-8">
				<select class="form-control" name="working_status">					
					<?php 
					if($edit)
						$workingstatus =$result->working_status;
					elseif(isset($_POST['working_status']))
						$workingstatus =$_POST['working_status'];
					else
						$workingstatus ="";?>
					<option value="Working" <?php selected($workingstatus,'Working');?>><?php _e('Working','hr_mgt');?></option>
					<option value="Left" <?php selected($workingstatus,'Left');?>><?php _e('Left','hr_mgt');?></option>
					<option value="Resign" <?php selected($workingstatus,'Resign');?>><?php _e('Resign','hr_mgt');?></option>			
				</select>
			</div>
		</div>
		
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="joining_date"><?php _e('Joining Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="joining_date" class="form-control validate[required] date" type="text"  name="joining_date" 
				value="<?php if($edit){ echo isset($result->birth_date)?date("Y-m-d",strtotime($result->joining_date)):'';}elseif(isset($_POST['joining_date'])) echo $_POST['joining_date'];?>">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="contract_end_date"><?php _e('Contract End Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="contract_end_date" class="form-control validate[required] date" type="text"  name="contract_end_date" 
				value="<?php if($edit){ echo isset($result->birth_date)?date("Y-m-d",strtotime($result->contract_end_date)):'';}elseif(isset($_POST['contract_end_date'])) echo $_POST['contract_end_date'];?>">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Deposit"><?php _e('Deposit','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="deposit" class="form-control" type="text"  name="deposit" 
				value="<?php if($edit){ echo $result->deposit; } elseif(isset($_POST['deposit'])) echo $_POST['deposit'];?>">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_level"><?php _e('Employee Level','hr_mgt');?></label>
			<div class="col-sm-8">
				<select class="form-control" name="employee_level">
					<option value="Trainee" <?php if($edit) selected($result->employee_level,'Trainee') ?>> <?php _e('Trainee','hr_mgt');?></option>
					<option value="Full Time" <?php if($edit) selected($result->employee_level,'Full Time') ?> > <?php _e('Full Time','hr_mgt');?></option>
					<option value="Probation" <?php if($edit) selected($result->employee_level,'Probation') ?> > <?php _e('Probation','hr_mgt');?></option>					
				</select>				
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="term_detail"><?php _e('Term Detail','hr_mgt'); ?></label>
			<div class="col-sm-8">
				<textarea name="term_detail" class="form-control" id="term_detail"><?php if($edit) print $result->term_detail ?></textarea>				
			</div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="monthly_leave"><?php _e('Monthly leave','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="monthly_leave" class="form-control" type="text"  name="monthly_leave" 
				value="<?php if($edit){ echo $result->monthly_leave;}elseif(isset($_POST['monthly_leave'])) echo $_POST['monthly_leave'];?>">
			</div>
		</div>
		
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="department"><?php _e('Department','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="department" id="department">
				<option value=""><?php _e('Select Department','hr_mgt');?></option>
				<?php 
				if($edit)
					$category =$result->department;
				elseif(isset($_REQUEST['department']))
					$category =$_REQUEST['department'];  
				else 
					$category = "";
				
					$departmentdata=$obj_department->get_all_departments();
			 if(!empty($departmentdata))
			 {
				foreach ($departmentdata as $retrive_data){
						{
						echo '<option value="'.$retrive_data->id.'" '.selected($category,$retrive_data->id).'>'.$retrive_data->department_name.'</option>';
					}
				}
			 }?>
				</select>
			</div>
			
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="parent_category_category"><?php _e('Designation','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="designation" id="designation_cat">
				<option value=""><?php _e('Select Designation','hr_mgt');?></option>
				<?php 
				if($edit)
					$category =$result->designation;
				elseif(isset($_REQUEST['designation']))
					$category =$_REQUEST['designation'];  
				else 
					$category = "";
				
				$activity_category=hrmgt_get_all_category('designation_cat');
				if(!empty($activity_category))
				{
					foreach ($activity_category as $retrive_data)
					{
						echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
					}
				} ?>
				</select>
			</div>
			<div class="col-sm-2"><button id="addremove" model="designation_cat"><?php _e('Add Or Remove','hr_mgt');?></button></div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_salary"><?php _e('Employee Salary','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="employee_salary" class="form-control validate[required]" type="text"  name="employee_salary" 
				value="<?php if($edit){ echo $result->employee_salary;}elseif(isset($_POST['employee_salary'])) echo $_POST['employee_salary'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="qualification"><?php _e('Qualification','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="qualification" class="form-control" type="text"  name="qualification" 
				value="<?php if($edit){ echo $result->qualification;}elseif(isset($_POST['qualification'])) echo $_POST['qualification'];?>">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label " for="mobile"><?php _e('Mobile Number','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-1">
				<input type="text" readonly value="+<?php echo hrmgt_get_country_phonecode(get_option( 'hrmgt_contry' ));?>"  class="form-control" name="phonecode">
			</div>
			<div class="col-sm-7">
				<input id="mobile" class="form-control text-input validate[required]" type="text"  name="mobile" maxlength="10"
				value="<?php if($edit){ echo $result->mobile;}elseif(isset($_POST['mobile'])) echo $_POST['mobile'];?>">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="gov_id"><?php _e('Government Id / Social Security','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="gov_id" class="form-control text-input" type="text"  value="<?php if($edit){ echo $result->gov_id;}elseif(isset($_POST['gov_id'])) echo $_POST['gov_id'];?>" name="gov_id">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="passport_number "><?php _e('Passport Number ','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="passport_number" class="form-control text-input" type="text"  value="<?php if($edit){ echo $result->passport_number;}elseif(isset($_POST['passport_number'])) echo $_POST['passport_number'];?>" name="passport_number">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="passport_expiry_date "><?php _e('Passport Expiration','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="passport_expiry_date" class="form-control date text-input" type="text"  value="<?php if($edit){ echo isset($result->birth_date)?date("Y-m-d",strtotime($result->passport_expiry_date)):'';}elseif(isset($_POST['passport_expiry_date'])) echo $_POST['passport_expiry_date'];?>" name="passport_expiry_date">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="driving_license_number  "><?php _e('Driving License Number ','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="driving_license_number" class="form-control text-input" type="text"  value="<?php if($edit){ echo $result->driving_license_number;}elseif(isset($_POST['driving_license_number'])) echo $_POST['driving_license_number'];?>" name="driving_license_number">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="driving_license_expiry_date"><?php _e('Driving License Expiration','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="driving_license_expiry_date" class="form-control date text-input" type="text"  value="<?php if($edit){ echo isset($result->birth_date)?date("Y-m-d",strtotime($result->driving_license_expiry_date)):'';}elseif(isset($_POST['driving_license_expiry_date'])) echo $_POST['driving_license_number'];?>" name="driving_license_expiry_date">
			</div>
		</div>
		
		
		
		<div class="header"><hr>
			<h3><?php _e('Permanent Contact Information','hr_mgt');?></h3>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="address"><?php _e('Address','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="p_address" class="form-control validate[required]" type="text"  name="p_address" 
				value="<?php if($edit){ echo $result->p_address;}elseif(isset($_POST['p_address'])) echo $_POST['p_address'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="city_name"><?php _e('City','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="city_name" class="form-control validate[required] " type="text"  name="p_city_name" 
				value="<?php if($edit){ echo $result->p_city_name;}elseif(isset($_POST['p_city_name'])) echo $_POST['p_city_name'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="state_name"><?php _e('State','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="p_state_name" class="form-control validate[required]" type="text"  name="p_state_name" 
				value="<?php if($edit){ echo $result->p_state_name;}elseif(isset($_POST['p_state_name'])) echo $_POST['p_state_name'];?>">
			</div>
		</div>
		<div class="form-group" class="form-control" id="">
			<label class="col-sm-2 control-label " for="cmgt_contry"><?php _e('Country','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<?php 
			
			$xml=simplexml_load_file(HRMS_PLUGIN_URL. '/admin/countrylist.xml') or die("Error: Cannot create object");
			
			if($edit)
				$country=$result->p_country_name;
			elseif(isset($_POST['country_name']))
					$country=$_POST['p_country_name'];
			else
				$country=get_option( 'hrmgt_contry' );
			?>
			 <select name="cmgt_contry" class="form-control validate[required]" id="p_country_name">                       	
               <?php
					foreach($xml as $country){ ?>
					 <option value="<?php echo $country->name;?>" <?php selected($country, $country->name);  ?>><?php echo $country->name;?></option>
				<?php } ?>
             </select> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="zip_code"><?php _e('Zip Code','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="p_zip_code" class="form-control validate[required]" type="text"  name="p_zip_code" 
				value="<?php if($edit){ echo $result->p_zip_code;}elseif(isset($_POST['p_zip_code'])) echo $_POST['p_zip_code'];?>">
			</div>
		</div>
		<div class="header">	<hr>
			<h3><?php _e('Present Contact Information','hr_mgt');?></h3>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="address"><?php _e('Address','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="address" class="form-control validate[required]" type="text"  name="address" 
				value="<?php if($edit){ echo $result->address;}elseif(isset($_POST['address'])) echo $_POST['address'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="city_name"><?php _e('City','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="city_name" class="form-control validate[required] " type="text"  name="city_name" 
				value="<?php if($edit){ echo $result->city_name;}elseif(isset($_POST['city_name'])) echo $_POST['city_name'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="state_name"><?php _e('State','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="state_name" class="form-control validate[required]" type="text"  name="state_name" 
				value="<?php if($edit){ echo $result->state_name;}elseif(isset($_POST['state_name'])) echo $_POST['state_name'];?>">
			</div>
		</div>
		<div class="form-group" class="form-control" id="">
			<label class="col-sm-2 control-label" for="cmgt_contry"><?php _e('Country','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<?php 
			
			$xml=simplexml_load_file(HRMS_PLUGIN_URL. '/admin/countrylist.xml') or die("Error: Cannot create object");
			
			if($edit)
				$country=$result->country_name;
			elseif(isset($_POST['country_name']))
					$country=$_POST['country_name'];
			else
				$country=get_option( 'hrmgt_contry' );
			?>
			 <select name="cmgt_contry" class="form-control validate[required]" id="country_name">
                <?php
					foreach($xml as $country){ ?>
					 <option value="<?php echo $country->name;?>" <?php selected($country, $country->name);  ?>><?php echo $country->name;?></option>
				<?php } ?>
             </select> 
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="zip_code"><?php _e('Zip Code','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="zip_code" class="form-control validate[required]" type="text"  name="zip_code" 
				value="<?php if($edit){ echo $result->zip_code;}elseif(isset($_POST['zip_code'])) echo $_POST['zip_code'];?>">
			</div>
		</div>
		
		
		
		
		<div class="header"><hr>
			<h3><?php _e('Employee Earning Details','hr_mgt');?></h3>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="branch_name"><?php _e('Dearness Allowance (D.A.) ','hr_mgt');?></label>
			<div class="col-sm-6">
				<input id="Dearness_Allowance" class="form-control text-input" type="text" value="<?php if(isset($EarningData) && isset($edit)){ echo $EarningData[0]->amount;}elseif(isset($_POST['Dearness_Allowance'])) echo $_POST['Dearness_Allowance'];?>" name="Dearness_Allowance">
			</div>
			<div class="col-sm-2">
				<select name="Dearness_Allowance_Status" class="form-control">
					<option value="visible" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[0]->status,'visible') ?>><?php _e("Visible","hr_mgt"); ?></option>
					<option value="hidden" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[0]->status,'hidden') ?> ><?php _e("Hidden","hr_mgt"); ?></option>					
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="branch_name"><?php _e('House Rent Allowance (H.R.A.) ','hr_mgt');?></label>
			<div class="col-sm-6">
				<input id="House_Rent_Allowance" class="form-control text-input" type="text" value="<?php if(isset($EarningData) && isset($edit)){ echo $EarningData[1]->amount;}elseif(isset($_POST['House_Rent_Allowance'])) echo $_POST['House_Rent_Allowance'];?>" name="House_Rent_Allowance">
			</div>
			<div class="col-sm-2">
				<select name="House_Rent_Allowance_Status" class="form-control">
					<option value="visible" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[1]->status,'visible')?> ><?php _e("Visible","hr_mgt"); ?></option>
					<option value="hidden" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[1]->status,'hidden') ?> ><?php _e("Hidden","hr_mgt"); ?></option>					
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Conveyanc_Allowance"><?php _e('Conveyanc_Allowance','hr_mgt');?></label>
			<div class="col-sm-6">
				<input id="Conveyanc_Allowance" class="form-control text-input" type="text" value="<?php if(isset($EarningData) && isset($edit)){ echo  $EarningData[2]->amount;}elseif(isset($_POST['Conveyanc_Allowance'])) echo $_POST['Conveyanc_Allowance'];?>" name="Conveyanc_Allowance">
			</div>
			<div class="col-sm-2">
				<select name="Conveyanc_Allowance_Status" class="form-control">
					<option value="visible" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[2]->status,'visible') ?> ><?php _e("Visible","hr_mgt"); ?></option>
					<option value="hidden" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[2]->status,'hidden') ?> ><?php _e("Hidden","hr_mgt"); ?></option>					
				</select>
			</div>			
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Travel_Allowance"><?php _e('Travel Allowance (T.A.)','hr_mgt');?></label>
			<div class="col-sm-6">
				<input id="Travel_Allowance" class="form-control text-input" type="text" value="<?php if(isset($EarningData) && isset($edit)){ echo $EarningData[3]->amount;}elseif(isset($_POST['Travel_Allowance'])) echo $_POST['Travel_Allowance'];?>" name="Travel_Allowance">
			</div>
			<div class="col-sm-2">
				<select name="Travel_Allowance_Status" class="form-control">
					<option value="visible" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[3]->status,'visible') ?> ><?php _e("Visible","hr_mgt"); ?></option>
					<option value="hidden" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[3]->status,'hidden') ?> ><?php _e("Hidden","hr_mgt"); ?></option>					
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Medical_Allowance"><?php _e('Medical Allowance','hr_mgt');?></label>
			<div class="col-sm-6">
				<input id="Medical_Allowance" class="form-control text-input" type="text" value="<?php if(isset($EarningData) && isset($edit)){ echo $EarningData[4]->amount; }elseif(isset($_POST['Medical_Allowance'])) echo $_POST['Medical_Allowance'];?>" name="Medical_Allowance">
			</div>
			<div class="col-sm-2">
				<select name="Medical_Allowance_Status" class="form-control">
					<option value="visible" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[4]->status,'visible') ?>><?php _e("Visible","hr_mgt"); ?></option>
					<option value="hidden" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[4]->status,'hidden') ?> ><?php _e("Hidden","hr_mgt"); ?></option>					
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Food_Allowance"><?php _e('Food Allowance','hr_mgt');?></label>
			<div class="col-sm-6">
				<input id="Food_Allowance" class="form-control text-input" type="text" value="<?php if(isset($EarningData) && isset($edit)){ echo $EarningData[5]->amount;}elseif(isset($_POST['Food_Allowance'])) echo $_POST['Food_Allowance'];?>" name="Food_Allowance">
			</div>
			<div class="col-sm-2">
				<select name="Food_Allowance_Status" class="form-control">
					<option value="visible" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[5]->status,'visible') ?>><?php _e("Visible","hr_mgt"); ?></option>
					<option value="hidden" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[5]->status,'hidden') ?> ><?php _e("Hidden","hr_mgt"); ?></option>					
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Mobile_Allowance"><?php _e('Mobile Allowance','hr_mgt');?></label>
			<div class="col-sm-6">
				<input id="Mobile_Allowance" class="form-control text-input" type="text" value="<?php if(isset($EarningData) && isset($edit)){ echo $EarningData[6]->amount;}elseif(isset($_POST['Mobile_Allowance'])) echo $_POST['Mobile_Allowance'];?>" name="Mobile_Allowance">
			</div>
			<div class="col-sm-2">
				<select name="Mobile_Allowance_Status" class="form-control">
					<option value="visible" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[6]->status,'visible') ?> ><?php _e("Visible","hr_mgt"); ?></option>
					<option value="hidden" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[6]->status,'hidden') ?> ><?php _e("Hidden","hr_mgt"); ?></option>					
				</select>
			</div>
		</div>		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Perfomance_Incentives"><?php _e('Perfomance Incentives','hr_mgt');?></label>
			<div class="col-sm-6">
				<input id="Perfomance_Incentives" class="form-control text-input" type="text" value="<?php if(isset($EarningData) && isset($edit)){ echo $EarningData[7]->amount;}elseif(isset($_POST['Perfomance_Incentives'])) echo $_POST['Perfomance_Incentives'];?>" name="Perfomance_Incentives">
			</div>
			<div class="col-sm-2">
				<select name="Perfomance_Incentives_Status" class="form-control">
					<option value="visible" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[7]->status,'visible') ?> ><?php _e("Visible","hr_mgt"); ?></option>
					<option value="hidden" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[7]->status,'hidden') ?> ><?php _e("Hidden","hr_mgt"); ?></option>					
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Salary_Difference"><?php _e('Salary Difference','hr_mgt');?></label>
			<div class="col-sm-6">
				<input id="Salary_Difference" class="form-control text-input" type="text" value="<?php if(isset($EarningData) && isset($edit)){ echo $EarningData[8]->amount ;}elseif(isset($_POST['Salary_Difference'])) echo $_POST['Salary_Difference'];?>" name="Salary_Difference">
			</div>
			<div class="col-sm-2">
				<select name="Salary_Difference_Status" class="form-control">
					<option value="visible" <?php if(isset($EarningData) && isset($edit)) selected($EarningData[8]->status,'visible') ?> ><?php _e("Visible","hr_mgt"); ?></option>
					<option value="hidden" <?php  if(isset($EarningData) && isset($edit)) selected($EarningData[8]->status,'hidden') ?> ><?php _e("Hidden","hr_mgt"); ?></option>					
				</select>
			</div>
		</div>
		<?php 
		$earning = get_option('earning');		
		if(!empty($earning))
		{ 	$e=9;
			foreach($earning as $key=>$value){  ?>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="<?php print $value ?>"><?php echo str_replace("_"," ",$value);?></label>
				<div class="col-sm-6">
					<input id="<?php print $value ?>" class="form-control text-input" type="text" value="<?php  if(isset($EarningData) && isset($edit)) print isset($EarningData["$e"]->amount)?$EarningData["$e"]->amount:''?>" name="<?php print $value ?>">
				</div>				
			</div>		
			<?php $e++; } 
		}
		?>	
		
		<div class="header">	<hr>
			<h3><?php _e('Employee Deduction Detail','hr_mgt');?></h3>
		</div>		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Professional_Tax"><?php _e('Professional Tax','hr_mgt');?></label>
			<div class="col-sm-6">
				<input id="Professional_Tax" class="form-control text-input" type="text" value="<?php if(isset($EarningData) && isset($edit)){ echo $DeductionData[0]->amount;}elseif(isset($_POST['Professional_Tax'])) echo $_POST['Professional_Tax'];?>" name="Professional_Tax">
			</div>
			<div class="col-sm-2">
				<select name="Professional_Tax_Status" class="form-control">
					<option value="visible" <?php if(isset($EarningData) && isset($edit)) selected($DeductionData[0]->status,'visible') ?> ><?php _e("Visible","hr_mgt"); ?></option>
					<option value="hidden" <?php if(isset($EarningData) && isset($edit)) selected($DeductionData[0]->status,'hidden') ?> ><?php _e("Hidden","hr_mgt"); ?></option>					
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Loan_Repayment"><?php _e('Loan Repayment / Advance','hr_mgt');?></label>
			<div class="col-sm-6">
				<input id="Loan_Repayment" class="form-control text-input" type="text" value="<?php if(isset($EarningData) && isset($edit)){ echo $DeductionData[1]->amount;}elseif(isset($_POST['Loan_Repayment'])) echo $_POST['Loan_Repayment'];?>" name="Loan_Repayment">
			</div>
			<div class="col-sm-2">
				<select name="Loan_Repayment_Status" class="form-control">
					<option value="visible" <?php if(isset($EarningData) && isset($edit)) selected($DeductionData[1]->status,'visible') ?> ><?php _e("Visible","hr_mgt"); ?></option>
					<option value="hidden" <?php if(isset($EarningData) && isset($edit)) selected($DeductionData[1]->status,'hidden') ?> ><?php _e("Hidden","hr_mgt"); ?></option>					
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Mobile_Bill_Recovery"><?php _e('Mobile Bill Recovery','hr_mgt');?></label>
			<div class="col-sm-6">
				<input id="Mobile_Bill_Recovery" class="form-control text-input" type="text" value="<?php if(isset($EarningData) && isset($edit)){ echo $DeductionData[2]->amount;}elseif(isset($_POST['Mobile_Bill_Recovery'])) echo $_POST['Mobile_Bill_Recovery'];?>" name="Mobile_Bill_Recovery">
			</div>
			<div class="col-sm-2">
				<select name="Mobile_Bill_Recovery_Status" class="form-control">
					<option value="visible" <?php if(isset($EarningData) && isset($edit)) selected($DeductionData[2]->status,'visible') ?> ><?php _e("Visible","hr_mgt"); ?></option>
					<option value="hidden" <?php if(isset($EarningData) && isset($edit)) selected($DeductionData[2]->status,'hidden') ?> ><?php _e("Hidden","hr_mgt"); ?></option>					
				</select>
			</div>
		</div>
		<div class="form-group">
		<div class="form-group">
		<div class="form-group">
			<label class="col-sm-2 control-label" for="Tax_Deducted_at_Source"><?php _e('Tax Deducted at Source (T.D.S.)','hr_mgt');?></label>
			<div class="col-sm-6">
				<input id="Tax_Deducted_at_Source" class="form-control text-input" type="text" value="<?php if(isset($EarningData) && isset($edit)){ echo $DeductionData[3]->amount;}elseif(isset($_POST['Tax_Deducted_at_Source'])) echo $_POST['Tax_Deducted_at_Source'];?>" name="Tax_Deducted_at_Source">
			</div>
			<div class="col-sm-2">
				<select name="Tax_Deducted_at_Source_Status" class="form-control">
					<option value="visible" <?php if(isset($EarningData) && isset($edit)) selected($DeductionData[3]->status,'visible') ?> ><?php _e("Visible","hr_mgt"); ?></option>
					<option value="hidden" <?php if(isset($EarningData) && isset($edit)) selected($DeductionData[3]->status,'hidden') ?> ><?php _e("Hidden","hr_mgt"); ?></option>					
				</select>
			</div>
		</div>
		<?php 
		$extradeduction = get_option('deduction');		
		if(!empty($extradeduction))
		{ 	$d=4;
			
			foreach($extradeduction as $deduction_key=>$deduction_value){  ?>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="<?php print $deduction_value ?>"><?php echo str_replace("_"," ",$deduction_value);?></label>
				<div class="col-sm-6">
					<input id="<?php print $deduction_value ?>" class="form-control text-input" type="text" value="<?php if(isset($EarningData) && isset($edit)) print isset($DeductionData["$d"]->amount)?$DeductionData["$d"]->amount:'' ?>" name="<?php print $deduction_value ?>">
				</div>				
			</div>		
			<?php $d++; } 
		}
		?>
			
		
		
		<div class="header"><hr>
			<h3><?php _e('Bank Account Details','hr_mgt');?></h3>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="ac_holder_name"><?php _e('Account Holder Name','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="ac_holder_name" class="form-control  text-input" type="text" value="<?php if($edit){ echo $result->ac_holder_name;}elseif(isset($_POST['ac_holder_name'])) echo $_POST['ac_holder_name'];?>" name="ac_holder_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="account_number"><?php _e('Account Number','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="account_number" class="form-control  text-input" type="text" value="<?php if($edit){ echo $result->account_number;}elseif(isset($_POST['account_number'])) echo $_POST['account_number'];?>" name="account_number">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="bank_name"><?php _e('Bank Name','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="bank_name" class="form-control text-input" type="text" value="<?php if($edit){ echo $result->bank_name;}elseif(isset($_POST['bank_name'])) echo $_POST['bank_name'];?>" name="bank_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="IFSC_code"><?php _e('IFSC Code','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="IFSC_code" class="form-control text-input" type="text" value="<?php if($edit){ echo $result->IFSC_code;}elseif(isset($_POST['IFSC_code'])) echo $_POST['IFSC_code'];?>" name="IFSC_code">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="PAN_number"><?php _e('PAN Number','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="PAN_number" class="form-control text-input" type="text" value="<?php if($edit){ echo $result->PAN_number;}elseif(isset($_POST['PAN_number'])) echo $_POST['PAN_number'];?>" name="PAN_number">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="branch_name"><?php _e('Branch','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="branch_name" class="form-control text-input" type="text" value="<?php if($edit){ echo $result->branch_name;}elseif(isset($_POST['branch_name'])) echo $_POST['branch_name'];?>" name="branch_name">
			</div>
		</div>	
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="photo"><?php _e('Image','hr_mgt');?></label>
			<div class="col-sm-2">
				<input type="text" id="hrmgt_user_avatar_url" class="form-control" name="hrmgt_user_avatar"  
				value="<?php if($edit)echo esc_url( $result->hrmgt_user_avatar );elseif(isset($_POST['hrmgt_user_avatar'])) echo $_POST['hrmgt_user_avatar']; ?>" />
			</div>	
			<div class="col-sm-3">
				<input id="upload_user_avatar_button" type="button" class="button" value="<?php _e( 'Upload image', 'hr_mgt' ); ?>" />
       			<span class="description"><?php _e('Upload image', 'hr_mgt' ); ?></span>       		
			</div>
			<div class="clearfix"></div>			
			<div class="col-sm-offset-2 col-sm-8">
                 <div id="upload_user_avatar_preview" >
	            <?php if($edit)
				{
	                if($result->hrmgt_user_avatar == "")
					{ ?>
						<img alt="" src="<?php echo get_option( 'hrmgt_system_logo' ) ?>">
					<?php }
					else 
					{ ?>
						<img style="max-width:100%;" src="<?php if($edit)echo esc_url( $result->hrmgt_user_avatar ); ?>" />
					<?php 
					}
	           	}
				else {	?>
					<img alt="" src="<?php echo get_option( 'hrmgt_system_logo' ) ?>">
				<?php  } ?>
				</div>
			</div>
		</div>
	
		<div class="header">	<hr>
			<h3><?php _e('Employee Documents','hr_mgt');?></h3>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label " for="join"><?php _e('Joining Letter','hr_mgt'); ?></label>
			<div class="col-sm-6">
				<input id="join"  name="join_latter" tmp_attr ="join_latter" class="input-file" type="file">
				<input id="join"  name="hidden_join_latter" value="<?php if($edit){ print $result->join_latter;}?>" type="hidden">
			</div>

			<div class="col-sm-2">
				<?php if(isset($result->join_latter) && $result->join_latter!=""){?>
				<a href="<?php echo content_url().'/uploads/hr_assets/'.$result->join_latter;?>" class="btn btn-default"><i class="fa fa-download"></i> <?php _e('Joining Latter','hr_mgt');?></a>
				<?php } ?>			
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="join"><?php _e('CV','hr_mgt'); ?></label>
			<div class="col-sm-6">
				<input id="join"  name="cv" tmp_attr ="cv" class="input-file" type="file">
				<input id="join"  name="hidden_cv"  type="hidden" value="<?php if($edit){ print $result->cv;}?>">
			</div>
			<div class="col-sm-2">
				<?php if(isset($result->cv) && $result->cv != ""){?>
				<a href="<?php echo content_url().'/uploads/hr_assets/'.$result->cv;?>" class="btn btn-default"><i class="fa fa-download"></i> <?php _e('CV','hr_mgt');?></a>
				<?php } ?>			
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="join"><?php _e('Contract','hr_mgt'); ?></label>
			<div class="col-sm-6">
				<input id="join"  name="contract" tmp_attr ="contract" class="input-file"  type="file">
				<input id="join"  name="hidden_contract"  type="hidden" value="<?php if($edit){ print $result->contract;}?>">
			</div>
			<div class="col-sm-2">
				<?php if(isset($result->contract) && $result->contract!=""){?>
				<a href="<?php echo content_url().'/uploads/hr_assets/'.$result->contract;?>" class="btn btn-default"><i class="fa fa-download"></i> <?php _e('Contract','hr_mgt');?></a>
				<?php } ?>			
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="join"><?php _e('ID proof','hr_mgt'); ?></label>
			<div class="col-sm-6">
				<input id="join"  name="id_proof" tmp_attr ="id_proof" class="input-file" type="file">
				<input id="join"  name="hidden_id_proof"  type="hidden" value="<?php if($edit){ print $result->id_proof;}?>">
			</div>
			<div class="col-sm-2">
				<?php if(isset($result->id_proof) && $result->id_proof!=""){?>
				<a href="<?php echo content_url().'/uploads/hr_assets/'.$result->id_proof;?>" class="btn btn-default"><i class="fa fa-download"></i> <?php _e('ID Proof','hr_mgt');?></a>
				<?php } ?>			
			</div>
		</div>
		
		<?php 			
		if($edit)
		{
			if(!empty($result->all_carti))
			{
				foreach($result->all_carti as $carti_name=>$carti_val)
				{	?>					
					<div id="cartificate_entrys">
						<div class="form-group">
							<div class="col-md-2 col-sm-offset-1">
								<input type="text"  name="cartificate_name[]" class="form-control" value="<?php print $carti_name;?>" />
								<input type="hidden"  name="old_cartificate_name[]" class="form-control" value="<?php print $carti_name;?>" />
							</div>
							<div class="col-md-3">					
								<input type="file" tmp_attr ="cartificate_name[]" class="input-file" name="cartificate[]"/>						
								<input type="hidden" name="old_hidden_cartificate[]" value="<?php print $carti_val;?>" >					
							</div>
							<div class="col-md-1">
								<a  class="btn btn-default" href="<?php print content_url().'/uploads/hr_assets/'.$carti_val; ?>"><?php _e('View','hr_mgt');?></a>
							</div>
							<div class="col-md-2">
								<input type="button" value="<?php _e('Delete','hr_mgt') ?>" onclick="deleteParentElement(this)" class="remove_cirtificate btn btn-defualt">
							</div>		
						</div>
					</div>
				 <?php  } }	?> 
				
					<div id="cartificate_entry">
						<div class="form-group">
							<div class="col-md-2 col-sm-offset-1">
								<input type="text"  name="cartificate_name[] " class="form-control" />
								
							</div>
							<div class="col-md-3">					
								<input type="file" tmp_attr ="cartificate_name[]" class="input-file" name="cartificate[]"  >														
							</div>							
							<div class="col-md-2">
								<input type="button" value="<?php _e('Delete','hr_mgt') ?>" onclick="deleteParentElement(this)" class="remove_cirtificate btn btn-defualt">
							</div>		
						</div>
					</div>
				<?php
			}
		else
		{ ?> 
		<div id="cartificate_entry">
			<div class="form-group">
				<div class="col-md-2 col-sm-offset-1">
					<input type="text"  name="cartificate_name[]" class="form-control "  />
				</div>
				<div class="col-md-3">					
					<input type="file" tmp_attr ="cartificate_name[]" class="input-file" name="cartificate[]">						
					<input type="hidden" name="cartificate[]">					
				</div>
				<div class="col-md-2">
					<input type="button" value="<?php _e('Delete','hr_mgt') ?>" onclick="deleteParentElement(this)" class="remove_cirtificate btn btn-defualt">
				</div>		
			</div>
		</div>
			<?php  } ?>		
		<div class=" col-md-offset-1 col-md-5">
			<input type="button" value="<?php _e('Add More Certificate','hr_mgt') ?>"  onclick="add_cirtificate()" class="add_cirtificate btn btn-defualt">
		</div>		
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Employee','hr_mgt');}?>" name="save_employee" class="btn btn-success"/>
        </div>
	</form>
<script>
   	var blank_cirtificate_entry ='';
   	$(document).ready(function() { 
   		blank_cirtificate_entry = $('#cartificate_entry').html();   	
   	});

   	function add_cirtificate()
   	{
   		$("#cartificate_entry").append(blank_cirtificate_entry);   		
   	}  	
   	
   	function deleteParentElement(n){
   		n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
   	}
</script>
<script>
jQuery("body").on("change", ".input-file[type=file]", function () {
	var file = this.files[0];
	var ext = $(this).val().split('.').pop().toLowerCase();
	//Extension Check
	if($.inArray(ext, ['doc','docx','csv','pdf']) == -1) {
		alert('invalid extension!, '+ext+' file not allowed');
		$(this).replaceWith('<input type="file" class="input-file" tmp_attr="'+$(this).attr('tmp_attr')+'" name="'+$(this).attr('tmp_attr')+'"/>');		
		return false;
	}
	
});
</script>