<?php 
	$curr_user_id=get_current_user_id();

	$obj_employee=new HrmgtEmployee;
	$user = wp_get_current_user ();
	$user_data =get_userdata( $user->ID);	
	
	$first_name = get_user_meta($user_data->ID,'first_name',true);
	$last_name = get_user_meta($user_data->ID,'last_name',true);
	
	
	
	require_once ABSPATH . 'wp-includes/class-phpass.php';
	$wp_hasher = new PasswordHash( 8, true );
	if(isset($_POST['save_change'])){
		$referrer = $_SERVER['HTTP_REFERER'];		
		$success=0;
		if($wp_hasher->CheckPassword($_REQUEST['current_pass'],$user_data->user_pass)){			
			if(isset($_REQUEST['new_pass']) && $_REQUEST['new_pass'] ==$_REQUEST['conform_pass'] && isset($_REQUEST['conform_pass'])){
				 wp_set_password( $_REQUEST['new_pass'], $user->ID);
				$success=1;
			}
			else{
				wp_redirect($referrer.'&sucess=2');
			}			
		}
		else{
			wp_redirect($referrer.'&sucess=3');
		}
		if($success==1){
			wp_cache_delete($user->ID,'users');
			wp_cache_delete($user_data->user_login,'userlogins');
			wp_logout();
			if(wp_signon(array('user_login'=>$user_data->user_login,'user_password'=>$_REQUEST['new_pass']),false)):
				$referrer = $_SERVER['HTTP_REFERER'];
				
				wp_redirect($referrer.'&sucess=1');
			endif;
			ob_start();
		}else{
    wp_set_auth_cookie($user->ID, true);
		}
		
	
	}
?>
<?php 
	$edit=1;
	$coverimage=get_option( 'hrmgt_system_background_image' );
	if($coverimage!="")
	{?>

<style>
.profile-cover{
	background: url("<?php echo get_option( 'hrmgt_system_background_image' );?>") repeat scroll 0 0 / cover rgba(0, 0, 0, 0);
}
<?php }?>



</style>
<script type="text/javascript">
$(document).ready(function() {
	$('#member_form').validationEngine();
	$('#pass_form').validationEngine();
	$('#birth_date').datepicker({
		  changeMonth: true,
	        changeYear: true,
	        yearRange:'-65:+0',
	        onChangeMonthYear: function(year, month, inst) {
	            $(this).val(month + "/" + year);
	        }
    }); 
} );
</script>
<div>
	<div class="profile-cover">
		<div class="row">				
		<div class="col-md-3 profile-image">
			<div class="profile-image-container">
				<?php $umetadata=get_user_meta($user->ID, 'hrmgt_user_avatar', true);										
				if(empty($umetadata)){
					echo '<img src='.get_option( 'hrmgt_system_logo' ).' height="150px" width="150px" class="img-circle" />';
				}
				else
					echo '<img src='.$umetadata.' height="150px" width="150px" class="img-circle" />'; 
				?>
			</div>
		</div>						
		</div>
	</div>				
	
	<div Id="main-wrapper"> 
		<div class="row user-details">
			<div class="col-md-3 col-sm-12 col-xs-12 user-profile">
				<h3 class="text-center"><?php echo $user_data->display_name; ?>	</h3>				
				<hr>
				<ul class="list-unstyled text-center">
					<?php if($user_data->address!='' || $user_data->city!=''){?>
					<li>
						<p><i class="fa fa-map-marker m-r-xs"></i>
						<a href="#"><?php echo $user_data->address.",".$user_data->city;?></a></p>
					</li>	
					<?php } ?>
					<li>
						<i class="fa fa-envelope m-r-xs"></i>
						<a href="#"><?php echo 	$user_data->user_email;?></a></p>
					</li>
				</ul>				
			</div>			
			<?php if(isset($_REQUEST['message']))
			{
			$message =$_REQUEST['message'];
				if($message == 2){?>
					<div class="col-md-8 col-sm-12 col-xs-12 m-t-lg "><div id="message" class="updated below-h2 msg"><p><?php _e("Profile update successfully.",'hr_mgt');	?></p></div></div>
				<?php }	if($message == 3){ ?>
				<div class="col-md-8 col-sm-12 col-xs-12 m-t-lg "><div id="message" class="updated below-h2 msg"><p><?php _e("Confirm password does not match.",'hr_mgt'); 	?></p>	</div></div>
				<?php }	if($message == 4){?>
				<div class="col-md-8 col-sm-12 col-xs-12 m-t-lg"><div id="message" class="updated below-h2 msg "><p><?php 	_e("Enter correct current password.",'hr_mgt');	?></p></div></div>
			<?php } } ?>
				<div class="col-md-8 col-sm-12 col-xs-12 m-t-lg">
				<div class="panel panel-white">
				<div class="panel-heading">
					<div class="panel-title"><?php _e('Account Settings ','hr_mgt');?>	</div>
				</div>
				<div class="panel-body">
					<form class="form-horizontal" action="#" method="post" id="pass_form">
						<div class="form-group">
							<label  class="control-label col-xs-2"></label>
								<div class="col-xs-10">	
									<p>
										<h4 class="bg-danger"><?php 
										if(isset($_REQUEST['sucess']))
										{ 
											if($_REQUEST['sucess']==1)
											{
												wp_safe_redirect(home_url()."?hr-dashboard=user&page=profile&action=edit&message=2" );
											}
											if($_REQUEST['sucess']==2)
											{
												wp_safe_redirect(home_url()."?hr-dashboard=user&page=profile&action=edit&message=3" );
											}
											if($_REQUEST['sucess']==3)
											{
												wp_safe_redirect(home_url()."?hr-dashboard=user&page=profile&action=edit&message=4" );
											}
											
											
										} ?></h4>
									</p>
								</div>
						</div>
						<div class="form-group">
							<label for="inputEmail" class="control-label col-sm-2"><?php _e('Name','hr_mgt');?></label>
							<div class="col-sm-10">
								<input type="Name" class="form-control " id="name" placeholder="Full Name" value="<?php echo $user->display_name; ?>" readonly>									
							</div>
						</div>
							
						<div class="form-group">
							<label for="inputEmail" class="control-label col-sm-2"><?php _e('Username','hr_mgt');?></label>
							<div class="col-sm-10">
								<input type="username" class="form-control " id="name" placeholder="Full Name" value="<?php echo $user->user_login; ?>" readonly>									
							</div>
						</div>
							
						<div class="form-group">
							<label for="inputPassword" class="control-label col-sm-2 "><?php _e('Current Password','hr_mgt');?></label>
							<div class="col-sm-10">
								<input type="password" class="form-control validate[required]" id="inputPassword" placeholder="Password" name="current_pass">
							</div>
						</div>
							
						<div class="form-group">
							<label for="inputPassword" class="control-label col-sm-2"><?php _e('New Password','hr_mgt');?></label>
							<div class="col-sm-10">
								<input type="password" class="validate[required] form-control" id="inputPassword" placeholder="New Password" name="new_pass">
							</div>
						</div>
							
						<div class="form-group">
							<label for="inputPassword" class="control-label col-sm-2"><?php _e('Confirm Password','hr_mgt');?></label>
							<div class="col-sm-10">
								<input type="password" class="validate[required] form-control" id="inputPassword" placeholder="Confirm Password" name="conform_pass">
							</div>
						</div>
							

						<div class="form-group">
							<div class="col-xs-offset-2 col-sm-10">
								<button type="submit" class="btn btn-success" name="save_change"><?php _e('Save','hr_mgt');?></button>
							</div>
						</div>
					</form>						
				</div>		   
				</div>					
					<?php 	$user_info=get_userdata(get_current_user_id()); ?> 
					<div class="panel panel-white">
					<div class="panel-heading">
						<div class="panel-title"><?php _e('Other Information','hr_mgt');?>	</div>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" action="#" method="post" id="member_form">
							<input type="hidden" value="edit" name="action">
							<input type="hidden" value="<?php echo $role;?>" name="role">
							<input type="hidden" value="<?php echo get_current_user_id();?>" name="id">
							<input type="hidden" value="<?php print $first_name ?>" name="first_name" >
							<input type="hidden" value="<?php print $last_name ?>" name="last_name" >
							
							<div class="form-group">
									<label class="col-sm-2 control-label " for="mobile"><?php _e('Mobile Number','hr_mgt');?><span class="require-field">*</span></label>
									<div class="col-sm-2">									
									<input type="text" readonly value="+<?php echo hrmgt_get_country_phonecode(get_option( 'hrmgt_contry' ));?>"  class="form-control" name="phonecode">
									</div>
									<div class="col-sm-8">
										<input id="mobile" class="form-control validate[required,custom[phone]] text-input" type="text"  name="mobile" maxlength="10"
										value="<?php if($edit){ echo $user_info->mobile;}elseif(isset($_POST['mobile'])) echo $_POST['mobile'];?>">
									</div>
							</div>
							<div class="form-group">
								<label for="inputEmail" class="control-label col-sm-2"><?php _e('Email','hr_mgt');?></label>
							<div class="col-sm-10">
									<input id="email" class="form-control validate[required,custom[email]] text-input" type="text"  name="email" value="<?php if($edit){ echo $user_info->user_email;}?>">
								</div>
								</div>		
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-success" name="profile_save_change"><?php _e('Save','hr_mgt');?></button>
								</div>
							</div>
						</form>
						</div>
						</div>
					</div>					
			
				</div>

 		</div>
		</div>
	</div>
</div>
<?php 
	if(isset($_POST['profile_save_change'])){		
		$result=$obj_employee->hrmgt_add_user($_POST);		
		if($result){ 
			wp_safe_redirect(home_url()."?hr-dashboard=user&page=profile&action=edit&message=2" );
		}
	}
?>