<script type="text/javascript">
$(document).ready(function() {
	$('#candidate_form').validationEngine();		 
	 $('#birth_date').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		maxDate:0,
		yearRange:'-65:+65',
		onChangeMonthYear: function(year, month, inst) {
			$(this).val(month + "/" + year);
		}
    }); 	  
});
</script>
     <?php 	                                 
			$candidate_id=0;
			if(isset($_REQUEST['candidate_id']))
				$candidate_id=$_REQUEST['candidate_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;
					$candidates_result = $obj_requirements->hrmgt_get_single_candidates($candidate_id);	
					
				}		
				?>
		<div class="panel-body">
        <form name="candidate_form" action="" method="post" class="form-horizontal" id="candidate_form" enctype="multipart/form-data">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="candidate_id" value="<?php echo $candidate_id;?>"  />
		<div class="form-group">
			<label class="col-sm-2 control-label" for="job"><?php _e('Job Field','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required] show_criere" name="job_id" id="job_id">
				<option value=""><?php _e('Select Job','hr_mgt');?></option>
				<?php 
				if($edit)
					$category =$candidates_result->job_id;
				elseif(isset($_REQUEST['job_id']))
					$category =$_REQUEST['job_id'];  
				else 
					$category = 0;
				
				$psotedjobdata=$obj_requirements->get_all_posted_job();
			 if(!empty($psotedjobdata))
			 {
				foreach ($psotedjobdata as $retrive_data){
						{
						echo '<option id="'.$retrive_data->id.'" value="'.$retrive_data->id.'" '.selected($category,$retrive_data->id).'>'.$retrive_data->job_title.'</option>';
					}
				}
			 }?>
				</select>
			</div>
		</div>
		<div class="form-group">
				<label for="class_id" class="col-sm-2 control-label "><?php _e('Select Criteria','hr_mgt');?></label>			
				<div class="col-sm-8">			
					<select name="crierearea" class="form-control shortlist">
						<option value=" "><?php _e('Select Criteria','hr_mgt');?></option>
						<?php if($edit){
						$candidates_result->crierearea;
						$result =$obj_requirements->hrmgt_get_single_job($category );
						$allcriere = json_decode($result->criere_entry);
						foreach($allcriere as $key=>$value){ ?>
							<option value="<?php print $value;?>" <?php  selected($candidates_result->crierearea,$value); ?>> <?php print $value; ?></option>
						<?php }	
						}?>
					</select>
				</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="first_name"><?php _e('First Name','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="first_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" type="text" value="<?php if($edit){ echo $candidates_result->first_name;}elseif(isset($_POST['first_name'])) echo $_POST['first_name'];?>" name="first_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="middle_name"><?php _e('Middle Name','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="middle_name" class="form-control " type="text"  value="<?php if($edit){ echo $candidates_result->middle_name;}elseif(isset($_POST['middle_name'])) echo $_POST['middle_name'];?>" name="middle_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="last_name"><?php _e('Last Name','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="last_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" type="text"  value="<?php if($edit){ echo $candidates_result->last_name;}elseif(isset($_POST['last_name'])) echo $_POST['last_name'];?>" name="last_name">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="gender"><?php _e('Gender','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<?php $genderval = "male"; if($edit){ $genderval=$candidates_result->gender; }elseif(isset($_POST['gender'])) {$genderval=$_POST['gender'];}?>
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
				value="<?php if($edit){ echo date("Y-m-d",strtotime($candidates_result->birth_date)) ;}elseif(isset($_POST['birth_date'])) echo $_POST['birth_date'];?>">
			</div>
		</div>
		<div class="header">	
			<h3><?php _e('Contact Information','hr_mgt');?></h3>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="address"><?php _e('Address','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="address" class="form-control validate[required]" type="text"  name="address" 
				value="<?php if($edit){ echo $candidates_result->address;}elseif(isset($_POST['address'])) echo $_POST['address'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="city_name"><?php _e('City','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="city_name" class="form-control validate[required]" type="text"  name="city_name" 
				value="<?php if($edit){ echo $candidates_result->city_name;}elseif(isset($_POST['city_name'])) echo $_POST['city_name'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="state_name"><?php _e('State','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="state_name" class="form-control" type="text"  name="state_name" 
				value="<?php if($edit){ echo $candidates_result->state_name;}elseif(isset($_POST['state_name'])) echo $_POST['state_name'];?>">
			</div>
		</div>
		<div class="form-group" class="form-control" id="">
			<label class="col-sm-2 control-label" for="cmgt_contry"><?php _e('Country','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
			<?php 			
			$xml=simplexml_load_file(HRMS_PLUGIN_URL. '/admin/countrylist.xml') or die("Error: Cannot create object");
			
			if($edit)
				$country=$candidates_result->country_name;
			elseif(isset($_POST['country_name']))
					$country=$_POST['country_name'];
			else
				$country=get_option( 'hrmgt_contry' );
			?>
			<select name="country_name" class="form-control validate[required]" id="country_name">                        	
				<?php
					foreach($xml as $country)
					{ ?>
					 <option value="<?php echo $country->name;?>" <?php selected($country, $country->name);  ?>><?php echo $country->name;?></option>
				<?php } ?>
			</select> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="zip_code"><?php _e('Zip Code','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="zip_code" class="form-control  validate[custom[onlyLetterNumber]]" type="text"  name="zip_code" 
				value="<?php if($edit){ echo $candidates_result->zip_code;}elseif(isset($_POST['zip_code'])) echo $_POST['zip_code'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="email"><?php _e('Email','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="email" class="form-control validate[required,custom[email]] text-input" type="text"  name="email" 
				value="<?php if($edit){ echo $candidates_result->email;}elseif(isset($_POST['email'])) echo $_POST['email'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label " for="mobile"><?php _e('Mobile Number','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-1">
				<input type="text" readonly value="+<?php echo hrmgt_get_country_phonecode(get_option( 'hrmgt_contry' ));?>"  class="form-control" name="phonecode">
			</div>
			<div class="col-sm-7">
				<input id="mobile" class="form-control validate[required,custom[phone]] text-input" type="text"  name="mobile" maxlength="10"
				value="<?php if($edit){ echo $candidates_result->mobile;}elseif(isset($_POST['mobile'])) echo $_POST['mobile'];?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="hrmgt_contact_number"><?php _e('Phone Number','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="phone" class="form-control" type="text" value="<?php if($edit){ echo $candidates_result->phone;}elseif(isset($_POST['phone'])) echo $_POST['phone'];?>"  name="phone">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Interests','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="interests" class="form-control" name="interests"><?php if($edit){echo $candidates_result->interests; }elseif(isset($_POST['interests'])) echo $_POST['interests']; ?> </textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="achievements"><?php _e('Achievements','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="achievements" class="form-control" name="achievements"><?php if($edit){echo $candidates_result->achievements; }elseif(isset($_POST['achievements'])) echo $_POST['achievements']; ?> </textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="notes"><?php _e('Notes','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="notes" class="form-control" name="notes"><?php if($edit){echo $candidates_result->notes; }elseif(isset($_POST['notes'])) echo $_POST['notes']; ?> </textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="bio_data"><?php _e('Curriculum','hr_mgt');?></label>
			<div class="col-sm-6">
				<input type="file" class="form-control file" name="bio_data" >
				<input type="hidden" name="hidden_bio_data" value="<?php if($edit){ echo $candidates_result->bio_data;}elseif(isset($_POST['bio_data'])) echo $_POST['bio_data'];?>">
				<p class="help-block"><?php _e('Upload document in PDF','hr_mgt');?></p> 
			</div>
			<div class="col-sm-2">
				<?php if(isset($candidates_result->bio_data) && $candidates_result->bio_data !=""){?>
				<a href="<?php echo content_url().'/uploads/hr_assets/'.$candidates_result->bio_data;?>" class="btn btn-default"><i class="fa fa-download"></i> <?php _e('Bio-Data','hr_mgt');?></a>
				<?php } ?>
				 
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Candidate','hr_mgt');}?>" name="save_candidate" class="btn btn-success"/>
        </div>
		</form>
</div>