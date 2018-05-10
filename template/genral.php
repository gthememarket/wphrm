<?php 		
$obj_policy=new HrmgtCompanyPolicy;
$obj_holiday=new HrmgtHoliday;
$obj_file=new HrmgtFile;
$obj_department = new HrmgtDepartment();
$active_tab = isset($_GET['tab'])?$_GET['tab']:'policy_list';?>

<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list"></div>
		</div>
    </div> 
</div>
<div class="page-inner" style="min-height:1088px !important">	
<?php 
if(isset($_POST['save_policy'])){
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit'){
		$result=$obj_policy->hrmgt_add_policy($_POST);
		if($result){
				wp_redirect ('?hr-dashboard=user&page=genral&tab=policy_list&message=policy_edit');
			}
		}
		else{			
			$result=$obj_policy->hrmgt_add_policy($_POST);
			if($result){
				wp_redirect ('?hr-dashboard=user&page=genral&tab=policy_list&message=policy_add');
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
				wp_redirect ( '?hr-dashboard=user&page=genral&tab=FAQ_list&message=faq_edit');
			}
		}
		else{
			
			$result=$obj_policy->hrmgt_add_FAQ($_POST);
			if($result){
				wp_redirect ( '?hr-dashboard=user&page=genral&tab=FAQ_list&message=faq_add');
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
			wp_redirect ('?hr-dashboard=user&page=genral&tab=holiday_list&message=holiday_edit');
		}
	}
	else{
		
		$result=$obj_holiday->hrmgt_add_holiday($_POST);
		if($result){
			wp_redirect ( '?hr-dashboard=user&page=genral&tab=holiday_list&message=holiday_add');
		}
	}
}
	
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete' && !empty($_REQUEST['holiday_id']))
{	
	$result=$obj_holiday->hrmgt_delete_holidays($_REQUEST['holiday_id']);
	if($result)
	{
		wp_redirect ( '?hr-dashboard=user&page=genral&tab=holiday_list&message=holiday_del');
	}
}

if(isset($_POST['save_file']))
{		
	if(isset($_FILES['file']) && !empty($_FILES['file']) && $_FILES['file']['size'] !=0)
	{		
		if($_FILES['file']['size'] > 0)
			$upload_file=hrmgt_load_documets($_FILES['file'],'file','doc1');	
	}
	else
	{
		if(isset($_REQUEST['hidden_file']))
			$upload_file=$_REQUEST['hidden_file'];
	}
	
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{
		$result=$obj_file->hrmgt_add_file($_POST,$upload_file);
			if($result)	
			{
				wp_redirect ('?hr-dashboard=user&page=genral&tab=form_list&message=file_edit');
			}
	}
		else
		{			
			$result=$obj_file->hrmgt_add_file($_POST,$upload_file);
			if($result)
			{
				wp_redirect ('?hr-dashboard=user&page=genral&tab=form_list&message=file_add');
			}
		}
}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete' && !empty($_REQUEST['file_id']))
{		
	$result=$obj_file->hrmgt_delete_file($_REQUEST['file_id']);
	if($result)
	{
		wp_redirect ('?hr-dashboard=user&page=genral&tab=form_list&message=file_del');
	}
}

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	if(isset($_REQUEST['policy_id']))
	{
		$result=$obj_policy->hrmgt_delete_police($_REQUEST['policy_id']);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=genral&tab=policy_list&message=policy_del');
		}
	}
	if(isset($_REQUEST['FAQ_id']))
	{
		$result=$obj_policy->hrmgt_delete_faq($_REQUEST['FAQ_id']);
		if($result)	
		{
			wp_redirect ( '?hr-dashboard=user&page=genral&tab=FAQ_list&message=faq_del');
		}
	}
}


if(isset($_POST['save_schedule']))
{
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
	wp_redirect ( '?hr-dashboard=user&page=genral&tab=office_mgt&message=sed');
		
}

print '<div class="message_space">';
		if(isset($_REQUEST['message']))
		{
			$message =$_REQUEST['message'];
			if($message == "policy_add"){ ?>
			<div id="message" class="updated below-h2 msg "><p>	<?php _e('Policy inserted successfully','hr_mgt');	?></p></div>
			<?php 	}	elseif($message == "policy_edit")
		{?><div id="message" class="updated below-h2 msg "><p><?php
					_e("Policy updated successfully.",'hr_mgt');?></p>
					</div>
				<?php 
			
		}
		elseif($message == "policy_del") 
		{?>
		<div id="message" class="updated below-h2 msg "><p>
		<?php 
			_e('Policy deleted successfully','hr_mgt');
		?></div></p><?php
				
		}
		elseif($message == 4) 
		{?>
		<div id="message" class="updated below-h2 msg "><p>
		<?php 
			_e('Leave Approved successfully','hr_mgt');
		?></div></p><?php
				
		}
		
		elseif($message == "faq_add") 
		{?>
		<div id="message" class="updated below-h2 msg "><p>
		<?php  _e('FAQ insert successfully','hr_mgt');	?></div></p><?php	}
		
		elseif($message == "faq_edit") 
		{?>
		<div id="message" class="updated below-h2 msg "><p>
		<?php  _e('FAQ updated successfully','hr_mgt');	?></div></p><?php	}
		
		elseif($message == "faq_del") 
		{?>
		<div id="message" class="updated below-h2 msg "><p>
		<?php  _e('FAQ delete successfully','hr_mgt');	?></div></p><?php	}
		
		
		elseif($message == "holiday_add") 
		{?>
		<div id="message" class="updated below-h2 msg "><p>
		<?php  _e('Holiday insert successfully','hr_mgt');	?></div></p><?php	}
		
		elseif($message == "holiday_edit") 
		{?>
		<div id="message" class="updated below-h2 msg "><p>
		<?php  _e('Holiday updated successfully','hr_mgt');	?></div></p><?php	}
		
		elseif($message == "holiday_del") 
		{?>
		<div id="message" class="updated below-h2 msg "><p>
		<?php  _e('Holiday delete successfully','hr_mgt');	?></div></p><?php	}
		
		
		
		
		elseif($message == "file_add") 
		{?>
		<div id="message" class="updated below-h2 msg "><p>
		<?php  _e('File insert successfully','hr_mgt');	?></div></p><?php	}
		
		elseif($message == "file_edit") 
		{?>
		<div id="message" class="updated below-h2 msg "><p>
		<?php  _e('File updated successfully','hr_mgt');	?></div></p><?php	}
		
		elseif($message == "file_del") 
		{?>
		<div id="message" class="updated below-h2 msg "><p>
		<?php  _e('File delete successfully','hr_mgt');	?></div></p><?php	}
		
		
		elseif($message == "sed") 
		{?>
		<div id="message" class="updated below-h2 msg "><p>
		<?php  _e('Time Schedule updated','hr_mgt');	?></div></p><?php	}
		
		} ?>
		</div>
		
	
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
					 <ul class="nav nav-tabs panel_tabs" role="tablist">	  
						<li class="<?php if($active_tab=='policy_list'){?>active<?php }?>">
							<a href="?hr-dashboard=user&page=genral&tab=policy_list" class="tab <?php echo $active_tab == 'policy_list' ? 'active' : ''; ?>">
							 <i class="fa fa-align-justify"></i> <?php _e('Policy List', 'hr_mgt'); ?></a>
						  </a>
						</li>
						
						
						<li class="<?php if($active_tab=='FAQ_list'){?>active<?php }?>">
							<a href="?hr-dashboard=user&page=genral&tab=FAQ_list" class="tab <?php echo $active_tab == 'FAQ_list' ? 'active' : ''; ?>">
							 <i class="fa fa-align-justify"></i> <?php _e('FAQ List', 'hr_mgt'); ?></a>
						  </a>
						</li>
						
						
						<li class="<?php if($active_tab=='holiday_list'){?>active<?php }?>">
							<a href="?hr-dashboard=user&page=genral&tab=holiday_list" class="tab <?php echo $active_tab == 'holiday_list' ? 'active' : ''; ?>">
							 <i class="fa fa-align-justify"></i> <?php _e('Holiday List', 'hr_mgt'); ?></a>
						  </a>
						</li>
						
						
						<li class="<?php if($active_tab=='form_list'){?>active<?php }?>">
							<a href="?hr-dashboard=user&page=genral&tab=form_list" class="tab <?php echo $active_tab == 'form_list' ? 'active' : ''; ?>">
							 <i class="fa fa-align-justify"></i> <?php _e('Compay form list', 'hr_mgt'); ?></a>
						  </a>
						</li>
						
						
						<li class="<?php if($active_tab=='office_mgt'){?>active<?php }?>">
							<a href="?hr-dashboard=user&page=genral&tab=office_mgt" class="tab <?php echo $active_tab == 'office_mgt' ? 'active' : ''; ?>">
							 <i class="fa fa-align-justify"></i> <?php _e('Office Time Schedule', 'hr_mgt'); ?></a>
						  </a>
						</li>
						
						
						<li class="<?php if($active_tab=='organization'){?>active<?php }?>">
							<a href="?hr-dashboard=user&page=genral&tab=organization" class="tab <?php echo $active_tab == 'organization' ? 'active' : ''; ?>">
							 <i class="fa fa-align-justify"></i> <?php _e('Organization', 'hr_mgt'); ?></a>
						  </a>
						</li>					
						
					</ul>			
					

<?php if($role=="manager"){ ?>					
<div class="row">
	<div class="col-md-11 ">
		
	</div>
	
	<div class="col-md-1">
		<?php if($active_tab=="policy_list"){ ?>
			 <a href="?hr-dashboard=user&page=genral&tab=add_policy"style="float:right"  class="btn btn-primary">
			 <?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Policy', 'hr_mgt'); ?></a>
		<?php } elseif($active_tab=="add_policy"){ ?>
			 <a href="?hr-dashboard=user&page=genral&tab=policy_list"style="float:right"  class="btn btn-primary">
			 <?php echo '<span class="fa fa-arrow-left"></span> '.__('Back To List', 'hr_mgt'); ?></a>
		<?php } ?>
		
		
		<?php if($active_tab=="FAQ_list" ) { ?> 
			 <a href="?hr-dashboard=user&page=genral&tab=add_FAQ"style="float:right"  class="btn btn-primary">
			<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add FAQ', 'hr_mgt'); ?></a>
		<?php } elseif($active_tab=="add_FAQ"){ ?>
			<a href="?hr-dashboard=user&page=genral&tab=FAQ_list"style="float:right"  class="btn btn-primary">
			 <?php echo '<span class="fa fa-arrow-left"></span> '.__('Back To List', 'hr_mgt'); ?></a>
		<?php } ?>
		
		
		
		
		<?php if( $active_tab=="holiday_list" ) { ?> 
			 <a href="?hr-dashboard=user&page=genral&tab=add_holiday"style="float:right"  class="btn btn-primary">
			<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Holidy', 'hr_mgt'); ?></a>
		<?php } elseif($active_tab=="add_holiday"){ ?> 
			<a href="?hr-dashboard=user&page=genral&tab=holiday_list"style="float:right"  class="btn btn-primary">
			<?php echo '<span class="fa fa-arrow-left"></span> '.__('Back To List', 'hr_mgt'); ?></a>
		<?php } ?>
		
		<?php if($active_tab=="form_list" ) { ?> 
			 <a href="?hr-dashboard=user&page=genral&tab=add_file"style="float:right"  class="btn btn-primary">
			<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Form', 'hr_mgt'); ?></a>
		<?php }elseif($active_tab=="add_file"){ ?> 
			<a href="?hr-dashboard=user&page=genral&tab=form_list"style="float:right"  class="btn btn-primary">
			<?php echo '<span class="fa fa-arrow-left"></span> '.__('Back To List', 'hr_mgt'); ?></a>
		<?php }?>
	</div>
</div>
<?php } 	
	if($active_tab == 'policy_list'){ 
      require_once HRMS_PLUGIN_DIR.'/template/general/polices_list.php';
	 }
	
	if($active_tab=="holiday_list"){
		
		require_once HRMS_PLUGIN_DIR.'/template/general/holiday_list.php';
	}
	if($active_tab == 'add_holiday'){ 
      require_once HRMS_PLUGIN_DIR.'/template/general/add_holiday.php';
	 }
	 
	 if($active_tab=="general_settings"){
		 require_once HRMS_PLUGIN_DIR.'/template/general/general.php';
	 }
	
	 if($active_tab == 'add_policy')
	 {
		require_once HRMS_PLUGIN_DIR.'/template/general/add_policy.php';
	 } 
	 if($active_tab == 'FAQ_list')
	 {
		require_once HRMS_PLUGIN_DIR.'/template/general/FAQ-list.php';
	 }
	 if($active_tab == 'add_FAQ')
	 {
		require_once HRMS_PLUGIN_DIR.'/template/general/add_FAQ.php';
	 }
	if($active_tab=="form_list"){
		require_once HRMS_PLUGIN_DIR.'/template/general/file_list.php';
	}
	if($active_tab=="add_file"){
		require_once HRMS_PLUGIN_DIR.'/template/general/add_file.php';
	}
	
	if($active_tab=="office_mgt"){
		require_once HRMS_PLUGIN_DIR.'/template/general/office_management.php';
	}
	if($active_tab=="organization"){
		require_once HRMS_PLUGIN_DIR.'/template/general/organization.php';
		
	}
	 ?>
</div>
	</div>
	</div>
</div>
