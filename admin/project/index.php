<div class="popup-bg">
    <div class="overlay-content">
		<div class="category_list"></div>    
    </div> 
</div>	
<?php 		
$active_tab = isset($_GET['tab'])?$_GET['tab']:'project_list';
$obj_project=new HrmgtProject; 
$obj_office=new HrmgtOfficeMgt;?>
<div class="page-inner" style="min-height:1088px !important">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?>
		</h3>
</div>
<?php 
	if(isset($_POST['save_project']))
	{		
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			$result=$obj_project->hrmgt_add_project($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-project&tab=project_list&message=2');
			}
		}
		else
		{
			$result=$obj_project->hrmgt_add_project($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-project&tab=project_list&message=1');
			}
		}
	}
	if(isset($_POST['save_task']))
	{			
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			$result=$obj_office->hrmgt_add_task($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-project&tab=time_tracker_list&message=5');
			}
		}
		else
		{
			$result=$obj_office->hrmgt_add_task($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-project&tab=time_tracker_list&message=4');
			}
		}
	}
	
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{
			if(isset($_REQUEST['project_id']))
			{
				$result=$obj_project->hrmgt_delete_project($_REQUEST['project_id']);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=hrmgt-project&tab=project_list&message=3');
				}
			}
			if(isset($_REQUEST['task_id']))
			{
				$result=$obj_office->hrmgt_delete_tasks($_REQUEST['task_id']);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=hrmgt-project&tab=time_tracker_list&message=6');
				}
			}
		}
		if(isset($_REQUEST['message']))
		{
			$message =$_REQUEST['message'];
			if($message == 1)
			{ ?>
				<div id="message" class="updated below-h2 "><p>	<?php 	_e('Project inserted successfully','hr_mgt');?></p></div>
			<?php 		
			}
			elseif($message == 2)
			{ ?>
				<div id="message" class="updated below-h2 "><p><?php _e("Project updated successfully.",'hr_mgt');?></p></div>
			<?php 				
			}
			elseif($message == 3){ ?>
				<div id="message" class="updated below-h2"><p><?php _e('Project deleted successfully','hr_mgt');?></p></div>
			<?php					
			}
			elseif($message == 4) 
			{ ?>
				<div id="message" class="updated below-h2"><p><?php _e('Task successfully inserted ','hr_mgt'); ?></div></p>
			<?php					
			}
			elseif($message == 5) 
			{ ?>
			<div id="message" class="updated below-h2"><p><?php _e('Task successfully updated ','hr_mgt'); ?></div></p>
			<?php					
			}
			elseif($message == 6) 
			{ ?>
			<div id="message" class="updated below-h2"><p><?php _e('Task successfully deleted ','hr_mgt'); ?></div></p>
			<?php
			}
		}
?>
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
	<h2 class="nav-tab-wrapper">
    	<a href="?page=hrmgt-project&tab=project_list" class="nav-tab <?php echo $active_tab == 'project_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Project List', 'hr_mgt'); ?></a>
  	
        <?php  if(isset($_REQUEST['action']) &&  $_REQUEST['action'] == 'edit' && $active_tab=="add_project")
		{ ?>
        <a  href="#" class=" disabled  nav-tab <?php echo $active_tab == 'add_project' ? '  nav-tab-active' : ''; ?>">
		<?php _e('Edit Project', 'hr_mgt'); ?></a>  
		<?php 
		}
		else 
		{ ?>
			<a href="?page=hrmgt-project&tab=add_project" class="nav-tab <?php echo $active_tab == 'add_project' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add New Project', 'hr_mgt'); ?></a>
		<?php  } ?>
		<a href="?page=hrmgt-project&tab=time_tracker_list" class="nav-tab <?php echo $active_tab == 'time_tracker_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Time Task List', 'hr_mgt'); ?></a>
		
        <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && $active_tab=="add_task_time" )
		{ ?>
		<a href="#" class="nav-tab <?php echo $active_tab == 'add_task_time' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Task Time', 'hr_mgt'); ?></a>  
		<?php }
		else 
		{ ?>
			<a href="?page=hrmgt-project&tab=add_task_time" class="nav-tab <?php echo $active_tab == 'add_task_time' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Task Time', 'hr_mgt'); ?></a>
		<?php  }?>
    </h2>
     <?php 
	if($active_tab == 'project_list')
	{ ?>	
    <script type="text/javascript">
$(document).ready(function() {
	jQuery('#project_list').DataTable({
		"bProcessing": true,
				 "bServerSide": true,
				 "sAjaxSource": ajaxurl+'?action=datatable_Project_ajax_to_load',
				 "bDeferRender": true,	
		});
} );
</script>
    <form name="activity_form" action="" method="post">    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="project_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Project Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Client Name', 'hr_mgt' ) ;?></th>			 
			  <th><?php _e( 'Project Start Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Project End Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Actual Completion Date', 'hr_mgt' ) ;?></th>
			 <th><?php  _e( 'Status', 'hr_mgt' ) ;?></th>
			 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			  <th><?php _e( 'Project Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Client Name', 'hr_mgt' ) ;?></th>			  
			  <th><?php _e( 'Project Start Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Project End Date', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'Actual Completion Date', 'hr_mgt' ) ;?></th>
			<th><?php  _e( 'Status', 'hr_mgt' ) ;?></th>
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
			require_once HRMS_PLUGIN_DIR.'/admin/project/'.$active_tab.'.php';
		 }
	}?>
</div>
			
	</div>
	</div>
</div>
