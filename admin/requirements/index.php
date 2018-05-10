<div class="popup-bg">
    <div class="overlay-content">
   <div class="category_list"></div>    
    </div> 
</div>	
<?php 		
$active_tab = isset($_GET['tab'])?$_GET['tab']:'job_list';
$obj_requirements=new HrmgtRequirements;
$obj_department=new HrmgtDepartment; ?>
<div class="page-inner" style="min-height:1088px !important">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?>
		</h3>
</div>
<?php 
	if(isset($_POST['save_job']))		
	{
		
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			$result=$obj_requirements->hrmgt_add_job($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-requirements&tab=job_list&message=2');
			}
		}
		else
		{
			$result=$obj_requirements->hrmgt_add_job($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-requirements&tab=job_list&message=1');
			}
		}
	}
	if(isset($_POST['save_candidate']))		
	{
		if(isset($_FILES['bio_data']) && !empty($_FILES['bio_data']) && $_FILES['bio_data']['size'] !=0)
		{
			if($_FILES['bio_data']['size'] > 0)
				$upload_docs=hrmgt_load_documets($_FILES['bio_data'],'bio_data','doc1');
		}
		else
		{
			if(isset($_REQUEST['hidden_bio_data']))
				$upload_docs=$_REQUEST['hidden_bio_data'];
		}
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			$result=$obj_requirements->hrmgt_apply_candidates($_POST,$upload_docs);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-requirements&tab=candidate_list&message=5');
			}
		}
		else
		{
			$result=$obj_requirements->hrmgt_apply_candidates($_POST,$upload_docs);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-requirements&tab=candidate_list&message=4');
			}
		}
	}
	
	
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
	{
		if(isset($_REQUEST['candidate_id']))
		{
			$result=$obj_requirements->hrmgt_delete_candidates($_REQUEST['candidate_id']);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-requirements&tab=candidate_list&message=6');
			}
		}
		else
		{
			$result=$obj_requirements->hrmgt_delete_posted_job($_REQUEST['job_id']);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-requirements&tab=job_list&message=3');
			}
		}
	}
	if(isset($_REQUEST['message']))
	{
		$message =$_REQUEST['message'];
		if($message == 1)
		{ ?>
			<div id="message" class="updated below-h2 ">
				<p>
					<?php _e('Job successfully Added','hr_mgt'); ?>
				</p></div>
		<?php 			
			}
			elseif($message == 2)
			{ ?>
				<div id="message" class="updated below-h2 "><p><?php _e("Job  successfully updated .",'hr_mgt');?></p></div>
		<?php 				
			}
			elseif($message == 3) 
			{ ?>
			<div id="message" class="updated below-h2"><p><?php _e('Job  successfully archived ','hr_mgt'); ?></div></p>
		<?php
			}
			elseif($message == 4) 
			{ ?>
				<div id="message" class="updated below-h2"><p><?php _e('Candidate  successfully Added ','hr_mgt');?></div></p>
			<?php
			}
			
			elseif($message == 5) 
			{ ?>
				<div id="message" class="updated below-h2"><p><?php _e('Candidate  successfully updated ','hr_mgt'); ?></div></p>
			<?php
			}
			elseif($message == 6) 
			{ ?>
			<div id="message" class="updated below-h2"><p>
			<?php 
				_e('Candidate  successfully deleted ','hr_mgt');
			?></div></p><?php
					
			}
			
	} ?>
	
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
	<h2 class="nav-tab-wrapper">
    	<a href="?page=hrmgt-requirements&tab=job_list" class="nav-tab <?php echo $active_tab == 'job_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Job List', 'hr_mgt'); ?></a>
    	
        <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && $active_tab=="add_job")
		{ ?>
        <a href="?page=hrmgt-requirements&tab=add_job&action=edit&job_id=<?php echo isset($_REQUEST['job_id']);?>" class="nav-tab <?php echo $active_tab == 'add_job' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Job', 'hr_mgt'); ?></a>  
		<?php 
		}
		else 
		{ ?>
			<a href="?page=hrmgt-requirements&tab=add_job" class="nav-tab <?php echo $active_tab == 'add_job' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add New Job', 'hr_mgt'); ?></a>
		<?php  } ?>
		
		<a href="?page=hrmgt-requirements&tab=candidate_list" class="nav-tab <?php echo $active_tab == 'candidate_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Job Candidates', 'hr_mgt'); ?></a>
    	
        <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && $active_tab=="add_candidate")
		{ ?>
        <a href="?page=hrmgt-requirements&tab=add_candidate&action=edit&candidate_id=<?php echo isset($_REQUEST['candidate_id']);?>" class="nav-tab <?php echo $active_tab == 'add_candidate' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Candidate', 'hr_mgt'); ?></a>  
		<?php 
		}
		else 
		{ ?>
			<a href="?page=hrmgt-requirements&tab=add_candidate" class="nav-tab <?php echo $active_tab == 'add_candidate' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add New Candidate', 'hr_mgt'); ?></a>
		<?php  } ?>	
		
    </h2>
     <?php 
	if($active_tab == 'job_list')
	{ ?>	
    <script type="text/javascript">
$(document).ready(function() {
	jQuery('#job_list').DataTable({
				 "bProcessing": true,
				 "bServerSide": true,
				 "sAjaxSource": ajaxurl+'?action=datatable_recruitment_ajax_to_load',
				 "bDeferRender": true,
		});
});
</script>
    <form name="activity_form" action="" method="post">
    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="job_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Job Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Department', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Designation', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'No of Positions', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Job Post Closing Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Status', 'hr_mgt' ) ;?></th>
			 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			  <th><?php _e( 'Job Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Department', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Designation', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'No of Positions', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Job Post Closing Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Status', 'hr_mgt' ) ;?></th>
			 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </tfoot>
    </table>
        </div>
        </div>
</form>
     <?php 
	 }
	else
	{
		if(isset($active_tab))
		 {
			require_once HRMS_PLUGIN_DIR.'/admin/requirements/'.$active_tab.'.php';
		 }
	} ?>
</div>
			
	</div>
	</div>
</div>
