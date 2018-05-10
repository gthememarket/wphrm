<?php $role='accountant';?>
	<script type="text/javascript">
$(document).ready(function() {
	$('#staff_form').validationEngine();
		$('#birth_date').datepicker({
			dateFormat:'yy-mm-dd',
			changeMonth: true,
	        changeYear: true,
	        yearRange:'-65:+0',
			maxDate: 0,
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }
      });
	
	
	 $('#joining_date').datepicker({
		 dateFormat:'yy-mm-dd',
		 changeMonth: true,
	     changeYear: true,
	     yearRange:'-65:+0',
	     onChangeMonthYear: function(year, month, inst) {
			$(this).val(month + "/" + year);
	     }
      });
} );
</script>
     <?php 	

        	$id=0;
			$edit=0;
			if(isset($_REQUEST['id']))
				$id=$_REQUEST['id'];
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){					
				$edit=1;
				$user_info = get_userdata($id);						
				}?>
		
       <div class="panel-body" style="float:left;width:100%">
        <form name="staff_form" action="" method="post" class="form-horizontal" id="staff_form">	
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="role" value="<?php echo $role;?>"  />
		<input type="hidden" name="id" value="<?php echo $id;?>"  />
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_code"><?php _e('Employee Code','hr_mgt');?></label>
			<div class="col-sm-8">
			<?php
				if($edit == 0)
				{
					$employee_code = $user_object->generate_employee_code();
				}
			?>
			<input id="employee_code" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo $user_info->employee_code;}elseif(isset($_POST['employee_code'])){echo $_POST['employee_code'];}else{echo $employee_code;}?>" name="employee_code" readonly>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="first_name"><?php _e('First Name','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="first_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" type="text" value="<?php if($edit){ echo $user_info->first_name;}elseif(isset($_POST['first_name'])) echo $_POST['first_name'];?>" name="first_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="middle_name"><?php _e('Middle Name','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="middle_name" class="form-control " type="text"  value="<?php if($edit){ echo $user_info->middle_name;}elseif(isset($_POST['middle_name'])) echo $_POST['middle_name'];?>" name="middle_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="last_name"><?php _e('Last Name','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="last_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" type="text"  value="<?php if($edit){ echo $user_info->last_name;}elseif(isset($_POST['last_name'])) echo $_POST['last_name'];?>" name="last_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="gender"><?php _e('Gender','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<?php $genderval = "male"; if($edit){ $genderval=$user_info->gender; }elseif(isset($_POST['gender'])) {$genderval=$_POST['gender'];}?>
				<label class="radio-inline">
			     <input type="radio" value="male" class="tog validate[required]" name="gender"  <?php  checked( 'male', $genderval);  ?>/><?php _e('Male','hr_mgt');?>
			    </label>
			    <label class="radio-inline">
			      <input type="radio" value="female" class="tog validate[required]" name="gender"  <?php  checked( 'female', $genderval);  ?>/><?php _e('Female','hr_mgt');?> 
			    </label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="birth_date"><?php _e('Date of birth','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="birth_date" class="form-control validate[required]" type="text"  name="birth_date" 
				value="<?php if($edit){ echo date("Y-m-d",strtotime($user_info->birth_date));}elseif(isset($_POST['birth_date'])) echo $_POST['birth_date'];?>">
			</div>
		</div>	
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="joining_date"><?php _e('Joining Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="joining_date" class="form-control validate[required]" type="text"  name="joining_date" 
				value="<?php if($edit){ echo date("Y-m-d",strtotime($user_info->joining_date));}elseif(isset($_POST['joining_date'])) echo $_POST['joining_date'];?>">
			</div>
		</div>
		
				<div class="form-group">
			<label class="col-sm-2 control-label" for="department"><?php _e('Department','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="department" id="department">
				<option value=""><?php _e('Select Department','hr_mgt');?></option>
				<?php 
				if($edit)
					$category =$user_info->department;
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
			<label class="col-sm-2 control-label" for="parent_category_category"><?php _e('Designation','hr_mgt');?></label>
			<div class="col-sm-8">
				<select class="form-control" name="designation" id="designation_cat">
				<option value=""><?php _e('Select Designation','hr_mgt');?></option>
				<?php 
				if($edit)
					$category =$user_info->designation;
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
				value="<?php if($edit){ echo $user_info->employee_salary;}elseif(isset($_POST['employee_salary'])) echo $_POST['employee_salary'];?>">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="address"><?php _e('Home Town Address','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="address" class="form-control validate[required]" type="text"  name="address" 
				value="<?php if($edit){ echo $user_info->address;}elseif(isset($_POST['address'])) echo $_POST['address'];?>">
			</div>
		</div>
		
		
		
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="city_name"><?php _e('City','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="city_name" class="form-control validate[required]" type="text"  name="city_name" 
				value="<?php if($edit){ echo $user_info->city_name;}elseif(isset($_POST['city_name'])) echo $_POST['city_name'];?>">
			</div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label " for="mobile"><?php _e('Mobile Number','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-1">			
				<input type="text" readonly value="+<?php echo hrmgt_get_country_phonecode(get_option( 'hrmgt_contry' ));?>"  class="form-control" name="phonecode">
			</div>
			<div class="col-sm-7">
				<input id="mobile" class="form-control validate[required,custom[phone]] text-input" type="text"  name="mobile" maxlength="10"
				value="<?php if($edit){ echo $user_info->mobile;}elseif(isset($_POST['mobile'])) echo $_POST['mobile'];?>">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label " for="phone"><?php _e('Phone','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="phone" class="form-control validate[,custom[phone]] text-input" type="text"  name="phone" 
				value="<?php if($edit){ echo $user_info->phone;}elseif(isset($_POST['phone'])) echo $_POST['phone'];?>">
			</div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="qualification"><?php _e('Qualification','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="qualification" class="form-control validate[required]" type="text"  name="qualification" 
				value="<?php if($edit){ echo $user_info->qualification;}elseif(isset($_POST['qualification'])) echo $_POST['qualification'];?>">
			</div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label " for="email"><?php _e('Email','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="email" class="form-control validate[required,custom[email]] text-input" type="text"  name="email" 
				value="<?php if($edit){ echo $user_info->user_email;}elseif(isset($_POST['email'])) echo $_POST['email'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="username"><?php _e('User Name','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="username" class="form-control validate[required]" type="text"  name="username" 
				value="<?php if($edit){ echo $user_info->user_login;}?>" <?php if($edit) echo "readonly";?>>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="password"><?php _e('Password','hr_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
			<div class="col-sm-8">
				<input id="password" class="form-control <?php if(!$edit) echo 'validate[required]';?>" type="password"  name="password" value="">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="photo"><?php _e('Image','hr_mgt');?></label>
			<div class="col-sm-2">
				<input type="text" id="hrmgt_user_avatar_url" class="form-control" name="hrmgt_user_avatar"  
				value="<?php if($edit)echo esc_url( $user_info->hrmgt_user_avatar );elseif(isset($_POST['hrmgt_user_avatar'])) echo $_POST['hrmgt_user_avatar']; ?>" />
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
					if($user_info->hrmgt_user_avatar == "")
					{?>
					<img alt="" src="<?php echo get_option( 'hrmgt_system_logo' ); ?>">
					<?php }
					else {
						?>
					<img style="max-width:100%;" src="<?php if($edit)echo esc_url( $user_info->hrmgt_user_avatar ); ?>" />
					<?php 
					}
					}
					else {
						?>
						<img alt="" src="<?php echo get_option( 'hrmgt_system_logo' ); ?>">
						<?php 
					}?>
			</div>
   		 </div>
		</div>

		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Accountant','hr_mgt');}?>" name="save_accountant" class="btn btn-success"/>
        </div>
        </form>
        </div>   
    