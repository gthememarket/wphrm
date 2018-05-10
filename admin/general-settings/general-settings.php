<script type="text/javascript">
$(document).ready(function() {
	$('#setting_form').validationEngine();
} );
</script>
	<div id="main-wrapper">
	<div class="panel panel-white">
		<div class="panel-body"><h2><?php  echo esc_html( __( 'General Settings', 'hr_mgt')); ?></h2>
		
		
		<div class="panel-body">
        <form name="setting_form" action="" method="post" class="form-horizontal" id="setting_form">
        <div class="form-group">
			<label class="col-sm-2 control-label" for="hrmgt_system_name"><?php _e('Company Name','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="hrmgt_system_name" class="form-control validate[required]" type="text" value="<?php echo get_option( 'hrmgt_system_name' );?>"  name="hrmgt_system_name">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="hrmgt_staring_year"><?php _e('Starting Year','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="hrmgt_staring_year" class="form-control" type="text" value="<?php echo get_option( 'hrmgt_staring_year' );?>"  name="hrmgt_staring_year">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="hrmgt_company_address"><?php _e('Company Address','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="hrmgt_company_address" class="form-control validate[required]" type="text" value="<?php echo get_option( 'hrmgt_office_address' );?>"  name="hrmgt_office_address">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="hrmgt_contact_number"><?php _e('Official Phone Number','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="hrmgt_contact_number" class="form-control validate[required]" type="text" value="<?php echo get_option( 'hrmgt_contact_number' );?>"  name="hrmgt_contact_number">
			</div>
		</div>
		<div class="form-group" class="form-control" id="">
			<label class="col-sm-2 control-label" for="hrmgt_contry"><?php _e('Country','hr_mgt');?></label>
			<div class="col-sm-8">
			
			<?php 
			$xml=simplexml_load_file(plugins_url( 'countrylist.xml', __FILE__ )) or die("Error: Cannot create object");
			$url = plugins_url( 'countrylist.xml', __FILE__ );			
			?>
			 <select name="hrmgt_contry" class="form-control" id="cmgt_contry">
				<option value=""><?php _e('Select Country','cmgt_contry');?></option>
                 <?php
				 foreach($xml as $country){ ?>
				 <option value="<?php echo $country->name;?>" <?php selected(get_option( 'hrmgt_contry' ), $country->name);  ?>><?php echo $country->name;?></option>
				<?php } ?>
             </select> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="hrmgt_email"><?php _e('Email','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="hrmgt_email" class="form-control validate[required,custom[email]] text-input" type="text" value="<?php echo get_option( 'hrmgt_email' );?>"  name="hrmgt_email">
			</div>
		</div>
				
		<div class="form-group">
			<label class="col-sm-2 control-label" for="hrmgt_email"><?php _e('Full Day Working Hour','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="full_working_hour" class="form-control text-input" type="text" value="<?php echo get_option( 'full_working_hour' );?>"  name="full_working_hour">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="hrmgt_email"><?php _e('Half Day Working Hour','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="half_working_hour" class="form-control  text-input" type="text" value="<?php echo get_option( 'half_working_hour' );?>"  name="half_working_hour">
			</div>
		</div>
		
		<!--
		<div class="form-group">
			<label class="col-sm-2 control-label" for="hrmgt_email"><?php _e('Profile Image Extension','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="profile_exe" class="form-control  text-input" type="text" value=""  name="profile_exe">
			</div>				
			<div class="col-md-2">
				<button type="button" id="profile_ext_btn" class="btn">Add</button>
			</div>
		</div>
		<div id="profile_exe_responce">11sddsadad</div>
		
		-->
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="amgt_logo"><?php _e('Company Logo','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input type="text" id="hrmgt_user_avatar_url" name="hrmgt_system_logo" class="validate[required]" value="<?php  echo get_option( 'hrmgt_system_logo' ); ?>" />
       			<input id="upload_user_avatar_button" type="button" class="button" value="<?php _e( 'Upload image', 'hr_mgt' ); ?>" />
       			<span class="description"><?php _e('Upload image.', 'hr_mgt' ); ?></span>
                     
                <div id="upload_user_avatar_preview" style="min-height: 100px;">
					<img style="max-width:100%;" src="<?php  echo get_option( 'hrmgt_system_logo' ); ?>" />				
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="hrmgt_cover_image"><?php _e('Profile Cover Image','hr_mgt');?></label>
			<div class="col-sm-8">			
				<input type="text" id="hrmgt_system_background_image" name="hrmgt_system_background_image" value="<?php  echo get_option( 'hrmgt_system_background_image' ); ?>" />	
       				  <input id="upload_image_button" type="button" class="button upload_user_cover_button" value="<?php _e( 'Upload Cover Image', 'hr_mgt' ); ?>" />
       				 <span class="description"><?php _e('Upload Cover Image', 'hr_mgt' ); ?></span>                     
                     <div id="upload_hrm_cover_preview" style="min-height: 100px;">
						<img style="max-width:100%;" src="<?php  echo get_option( 'hrmgt_system_background_image' ); ?>" />	
					</div>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php _e('Save', 'hr_mgt' ); ?>" name="save_setting" class="btn btn-success"/>
        </div>
        </form>
		</div>
        </div>
        </div>
    </div>
