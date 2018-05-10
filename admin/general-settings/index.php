<?php 		
$obj_policy=new HrmgtCompanyPolicy;
$obj_holiday=new HrmgtHoliday;
$obj_file=new HrmgtFile;
$obj_department = new HrmgtDepartment();
$active_tab = isset($_GET['tab'])?$_GET['tab']:'general_settings';
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
if(isset($_POST['save_setting']))
{	
	$optionval=hrmgt_option();	
	foreach($optionval as $key=>$val)
	{	
		if(isset($_POST[$key]))	
		{	
			if($key=="hrmgt_system_logo" || $key=="hrmgt_system_background_image")
			{				
				$FileURL = hrmgt_upload_profile($_POST[$key]);				
				if(isset($FileURL))
				{					
					$result = update_option( $key, $FileURL );
				} 
			}
			else
			{			
				$result	=	update_option( $key, $_POST[$key] );
			}
		}
	}
	

	if(isset($result)){ ?>
		<div id="message" class="updated below-h2">
			<p><?php _e('Settings updated successfully','hr_mgt');?></p>
		</div>
	<?php } }

if(isset($_POST['save_policy'])){
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit'){
		$result=$obj_policy->hrmgt_add_policy($_POST);
		if($result){
				wp_redirect ( admin_url().'admin.php?page=hrmgt-general_settings&tab=policy_list&message=policy_edit');
			}
		}
		else
		{
			
			$result=$obj_policy->hrmgt_add_policy($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-general_settings&tab=policy_list&message=policy_add');
			}
		}
	}

	if(isset($_POST['save_FAQ']))		
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			$result=$obj_policy->hrmgt_add_FAQ($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-general_settings&tab=FAQ_list&message=faq_edit');
			}
		}
		else
		{
			
			$result=$obj_policy->hrmgt_add_FAQ($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-general_settings&tab=FAQ_list&message=faq_add');
			}
		}
	}

	if(isset($_POST['save_holiday']))
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			$result=$obj_holiday->hrmgt_add_holiday($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-general_settings&tab=holiday_list&message=holiday_edit');
			}
		}
		else
		{
			
			$result=$obj_holiday->hrmgt_add_holiday($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-general_settings&tab=holiday_list&message=holiday_add');
			}
		}
	}
	
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete'){
	if(isset($_REQUEST['holiday_id'])){
		$result=$obj_holiday->hrmgt_delete_holidays($_REQUEST['holiday_id']);
			if($result){
				wp_redirect ( admin_url().'admin.php?page=hrmgt-general_settings&tab=holiday_list&message=holiday_del');
			}
		}
}

if(isset($_POST['save_file'])){		
	if(isset($_FILES['file']) && !empty($_FILES['file']) && $_FILES['file']['size'] !=0){		
	if($_FILES['file']['size'] > 0)
		$upload_file=hrmgt_load_documets($_FILES['file'],'file','doc1');	
	}
	else{
		if(isset($_REQUEST['hidden_file']))
			$upload_file=$_REQUEST['hidden_file'];
	}
	
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit'){
		$result=$obj_file->hrmgt_add_file($_POST,$upload_file);
			if($result)	{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-general_settings&tab=form_list&message=file_edit');
			}
		}
		else{
			
			$result=$obj_file->hrmgt_add_file($_POST,$upload_file);
			if($result){
				wp_redirect ( admin_url().'admin.php?page=hrmgt-general_settings&tab=form_list&message=file_add');
			}
		}
	}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete'){
	$result=$obj_file->hrmgt_delete_file($_REQUEST['file_id']);
	if($result)	{
		wp_redirect ( admin_url().'admin.php?page=hrmgt-general_settings&tab=form_list&message=file_del');
	}
}

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{
			if(isset($_REQUEST['policy_id'])){
				$result=$obj_policy->hrmgt_delete_police($_REQUEST['policy_id']);
				if($result)	{
					wp_redirect ( admin_url().'admin.php?page=hrmgt-general_settings&tab=policy_list&message=policy_del');
				}
			}
			if(isset($_REQUEST['FAQ_id'])){
				$result=$obj_policy->hrmgt_delete_faq($_REQUEST['FAQ_id']);
				if($result)	{
					wp_redirect ( admin_url().'admin.php?page=hrmgt-general_settings&tab=FAQ_list&message=faq_del');
				}
			}
		}

if(isset($_POST['save_schedule'])){
		$time_schedule['sunday'] =array('start' => isset($_REQUEST['sunday_start'])?$_REQUEST['sunday_start']:'',
		'end' => isset($_REQUEST['sunday_end'])?$_REQUEST['sunday_end']:'',
		'close' =>isset($_REQUEST['sunday_close'])?$_REQUEST['sunday_close']:0);
		
		$time_schedule['monday'] =array('start' => isset($_REQUEST['monday_start'])?$_REQUEST['monday_start']:'',
		'end' => isset($_REQUEST['monday_end'])?$_REQUEST['monday_end']:'',
		'close' =>isset($_REQUEST['monday_close'])?$_REQUEST['monday_close']:0);
		
		$time_schedule['tuesday'] =array('start' => isset($_REQUEST['tuesday_start'])?$_REQUEST['tuesday_start']:'',
		'end' => isset($_REQUEST['tuesday_end'])?$_REQUEST['tuesday_end']:'',
		'close' =>isset($_REQUEST['tuesday_close'])?$_REQUEST['tuesday_close']:0);
		
		$time_schedule['wednesday'] =array('start' => isset($_REQUEST['wednesday_start'])?$_REQUEST['wednesday_start']:'',
		'end' => isset($_REQUEST['wednesday_end'])?$_REQUEST['wednesday_end']:'',
		'close' =>isset($_REQUEST['wednesday_close'])?$_REQUEST['wednesday_close']:0);
		
		$time_schedule['thursday'] =array('start' => isset($_REQUEST['thursday_start'])?$_REQUEST['thursday_start']:'',
		'end' => isset($_REQUEST['thursday_end'])?$_REQUEST['thursday_end']:'',
		'close' =>isset($_REQUEST['thursday_close'])?$_REQUEST['thursday_close']:0);
		
		$time_schedule['friday'] =array('start' => isset($_REQUEST['friday_start'])?$_REQUEST['friday_start']:'',
		'end' => isset($_REQUEST['friday_end'])?$_REQUEST['friday_end']:'',
		'close' =>isset($_REQUEST['friday_close'])?$_REQUEST['friday_close']:0);
		
		$time_schedule['saturday'] =array('start' => isset($_REQUEST['saturday_start'])?$_REQUEST['saturday_start']:'',
		'end' => isset($_REQUEST['saturday_end'])?$_REQUEST['saturday_end']:'',
		'close' =>isset($_REQUEST['saturday_close'])?$_REQUEST['saturday_close']:0);
		
		$result=update_option( 'hrmgt_time_Schedule',$time_schedule );
		wp_redirect ( admin_url() . 'admin.php?page=hrmgt-general_settings&tab=office_mgt&message=2');
		
	}

		if(isset($_REQUEST['message']))
		{
			$message =$_REQUEST['message'];
			if($message == "policy_add")
			{ ?>
					<div id="message" class="updated below-h2 ">
					<p>
					<?php 
						_e('Policy inserted successfully','hr_mgt');
					?></p></div>
					<?php 
			
		}
		elseif($message == "policy_edit")
		{?><div id="message" class="updated below-h2 "><p><?php
					_e("Policy updated successfully.",'hr_mgt');?></p>
					</div>
				<?php 
			
		}
		elseif($message == "policy_del") 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php 
			_e('Policy deleted successfully','hr_mgt');
		?></div></p><?php
				
		}
		elseif($message == 4) 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php 
			_e('Leave Approved successfully','hr_mgt');
		?></div></p><?php
				
		}
		
		elseif($message == "faq_add") 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php  _e('FAQ insert successfully','hr_mgt');	?></div></p><?php	}
		
		elseif($message == "faq_edit") 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php  _e('FAQ updated successfully','hr_mgt');	?></div></p><?php	}
		
		elseif($message == "faq_del") 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php  _e('FAQ delete successfully','hr_mgt');	?></div></p><?php	}
		
		
		elseif($message == "holiday_add") 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php  _e('Holiday insert successfully','hr_mgt');	?></div></p><?php	}
		
		elseif($message == "holiday_edit") 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php  _e('Holiday updated successfully','hr_mgt');	?></div></p><?php	}
		
		elseif($message == "holiday_del") 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php  _e('Holiday delete successfully','hr_mgt');	?></div></p><?php	}
		
		
		elseif($message == "file_add") 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php  _e('File insert successfully','hr_mgt');	?></div></p><?php	}
		
		elseif($message == "file_edit") 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php  _e('File updated successfully','hr_mgt');	?></div></p><?php	}
		
		elseif($message == "file_del") 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php  _e('File delete successfully','hr_mgt');	?></div></p><?php	}		
		}?>
		
		
	
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
	<h2 class="nav-tab-wrapper">	
		<a href="?page=hrmgt-general_settings&tab=general_settings" class="nav-tab <?php echo $active_tab == 'general_settings' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('General Settings', 'hr_mgt'); ?></a>
		
		
    	<a href="?page=hrmgt-general_settings&tab=policy_list" class="nav-tab <?php echo $active_tab == 'policy_list' || $active_tab == 'add_policy'  ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Policy List', 'hr_mgt'); ?></a>
		
		
		
		<a href="?page=hrmgt-general_settings&tab=FAQ_list" class="nav-tab <?php echo $active_tab == 'FAQ_list' || $active_tab == 'add_FAQ' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('FAQ List', 'hr_mgt'); ?></a>
    	
        <a href="?page=hrmgt-general_settings&tab=holiday_list" class="nav-tab <?php echo $active_tab == 'holiday_list' || $active_tab == 'add_holiday' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Holiday List', 'hr_mgt'); ?></a>
		
		<a href="?page=hrmgt-general_settings&tab=form_list" class="nav-tab <?php echo $active_tab == 'form_list' ||$active_tab == 'add_file' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Company Form List', 'hr_mgt'); ?></a>
		
		<a href="?page=hrmgt-general_settings&tab=office_mgt" class="nav-tab <?php echo $active_tab == 'office_mgt' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Office Time Schedule', 'hr_mgt'); ?></a>
		
		<a href="?page=hrmgt-general_settings&tab=organization" class="nav-tab <?php echo $active_tab == 'organization' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Organization', 'hr_mgt'); ?></a>
		
		
		
    </h2>
<div class="row">
	<div class="col-md-11 ">
		
	</div>
	<div class="col-md-1">
		<?php if($active_tab=="policy_list"){ ?>
			 <a href="?page=hrmgt-general_settings&tab=add_policy"style="float:right"  class="btn btn-primary">
			 <?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Policy', 'hr_mgt'); ?></a>
		<?php } elseif($active_tab=="add_policy"){ ?>
			 <a href="?page=hrmgt-general_settings&tab=policy_list"style="float:right"  class="btn btn-primary">
			 <?php echo '<span class="fa fa-arrow-left"></span> '.__('Back To List', 'hr_mgt'); ?></a>
		<?php } ?>
		
		
		<?php if($active_tab=="FAQ_list" ) { ?> 
			 <a href="?page=hrmgt-general_settings&tab=add_FAQ"style="float:right"  class="btn btn-primary">
			<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add FAQ', 'hr_mgt'); ?></a>
		<?php } elseif($active_tab=="add_FAQ"){ ?>
			<a href="?page=hrmgt-general_settings&tab=FAQ_list"style="float:right"  class="btn btn-primary">
			 <?php echo '<span class="fa fa-arrow-left"></span> '.__('Back To List', 'hr_mgt'); ?></a>
		<?php } ?>
		
		
		
		
		<?php if( $active_tab=="holiday_list" ) { ?> 
			 <a href="?page=hrmgt-general_settings&tab=add_holiday"style="float:right"  class="btn btn-primary">
			<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Holidy', 'hr_mgt'); ?></a>
		<?php } elseif($active_tab=="add_holiday"){ ?> 
			<a href="?page=hrmgt-general_settings&tab=holiday_list"style="float:right"  class="btn btn-primary">
			<?php echo '<span class="fa fa-arrow-left"></span> '.__('Back To List', 'hr_mgt'); ?></a>
		<?php } ?>
		
		<?php if($active_tab=="form_list" ) { ?> 
			 <a href="?page=hrmgt-general_settings&tab=add_file"style="float:right"  class="btn btn-primary">
			<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Form', 'hr_mgt'); ?></a>
		<?php }elseif($active_tab=="add_file"){ ?> 
			<a href="?page=hrmgt-general_settings&tab=form_list"style="float:right"  class="btn btn-primary">
			<?php echo '<span class="fa fa-arrow-left"></span> '.__('Back To List', 'hr_mgt'); ?></a>
		<?php }?>
	</div>
</div>
	
     <?php 
	if($active_tab == 'policy_list'){ 
      require_once HRMS_PLUGIN_DIR.'/admin/general-settings/polices_list.php';
	 }
	
	if($active_tab=="holiday_list"){
		
		require_once HRMS_PLUGIN_DIR.'/admin/general-settings/holiday_list.php';
	}
	if($active_tab == 'add_holiday'){ 
      require_once HRMS_PLUGIN_DIR.'/admin/general-settings/add_holiday.php';
	 }
	 
	 if($active_tab=="general_settings"){
		 require_once HRMS_PLUGIN_DIR.'/admin/general-settings/general-settings.php';
	 }
	
	 if($active_tab == 'add_policy')
	 {
		require_once HRMS_PLUGIN_DIR.'/admin/general-settings/add_policy.php';
	 } 
	 if($active_tab == 'FAQ_list')
	 {
		require_once HRMS_PLUGIN_DIR.'/admin/general-settings/FAQ-list.php';
	 }
	 if($active_tab == 'add_FAQ')
	 {
		require_once HRMS_PLUGIN_DIR.'/admin/general-settings/add_FAQ.php';
	 }
	if($active_tab=="form_list"){
		require_once HRMS_PLUGIN_DIR.'/admin/general-settings/file_list.php';
	}
	if($active_tab=="add_file"){
		require_once HRMS_PLUGIN_DIR.'/admin/general-settings/add_file.php';
	}
	
	if($active_tab=="office_mgt"){
		require_once HRMS_PLUGIN_DIR.'/admin/general-settings/office_management.php';
	}
	if($active_tab=="organization"){
		require_once HRMS_PLUGIN_DIR.'/admin/general-settings/organization.php';		
	}
	 ?>
</div>
	</div>
	</div>
</div>
