<div class="popup-bg">
    <div class="overlay-content">
   <div class="category_list"></div>    
    </div> 
</div>	
<?php 		
$active_tab = isset($_GET['tab'])?$_GET['tab']:'complaint_list';
$obj_suggestion=new HrmgtSuggestion;

 ?>
<div class="page-inner" style="min-height:1088px !important">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?>
		</h3>
</div>
<?php 
if(isset($_POST['save_complaint']))	{
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit'){
			
			$args = array(
			  'ID'=> $_REQUEST['complaint_id'],
			  'post_type' => 'hrmgt_complaint',
			  'post_title' => $_REQUEST['complaint_title'],
			  'post_content' => $_REQUEST['compalint'],
						
			);
			$result1=wp_update_post( $args );
			$result2=update_post_meta($_REQUEST['complaint_id'], 'complaint_date',$_REQUEST['complaint_date']);
			$result2=update_post_meta($_REQUEST['complaint_id'], 'complaint_from',$_REQUEST['employee_id']);
			$result2=update_post_meta($_REQUEST['complaint_id'], 'complaint_status',$_REQUEST['complaint_status']);
		
		
			if($result1 || $result2)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-feedback&tab=complaint_list&message=com_edit');
			}
		}
		else
		{
			
			$post_id = wp_insert_post( array(
					'post_status' => 'publish',
					'post_type' => 'hrmgt_complaint',
					'post_title' => $_REQUEST['complaint_title'],
					'post_content' => $_REQUEST['compalint']
			) );
				$result=add_post_meta($post_id, 'complaint_date',$_POST['complaint_date']);
				$result=add_post_meta($post_id, 'complaint_from',$_POST['employee_id']);
				$result=add_post_meta($post_id, 'complaint_status',$_POST['complaint_status']);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=hrmgt-feedback&tab=complaint_list&message=com_add');
				}
		}
	}

	
if(isset($_POST['save_suggestion'])){
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit'){
		$result=$obj_suggestion->hrmgt_add_suggestion($_POST);
			if($result){
				wp_redirect ( admin_url().'admin.php?page=hrmgt-feedback&tab=suggestion_list&message=sug_edit');
			}
		}else{			
			$result=$obj_suggestion->hrmgt_add_suggestion($_POST);
			if($result)	{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-feedback&tab=suggestion_list&message=sug_add');
			}
		}
	}

if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete'){
	$result=$obj_suggestion->hrmgt_delete_suggestion($_REQUEST['suggestion_id']);
	if($result){
		wp_redirect ( admin_url().'admin.php?page=hrmgt-feedback&tab=suggestion_list&message=sug_del');
	}
}
	
	
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{
			$result=wp_delete_post($_REQUEST['complaint_id']);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-feedback&tab=complaint_list&message=com_del');
			}
		}
		if(isset($_REQUEST['message']))
		{
			$message =$_REQUEST['message'];
			if($message == "com_add")
			{ ?>
					<div id="message" class="updated below-h2 ">
					<p>
					<?php 
						_e('Complaint inserted successfully','hr_mgt');
					?></p></div>
					<?php 
			
			}
			elseif($message =="com_edit")
			{?><div id="message" class="updated below-h2 "><p><?php
						_e("Complaint updated successfully.",'hr_mgt');?></p>
						</div>
					<?php 
				
			}
			elseif($message == "com_del") { ?>
				<div id="message" class="updated below-h2"><p><?php _e('Complaint deleted successfully','hr_mgt');	?></div></p><?php
					
			}	
			
			if($message == "sug_add")
			{ ?>
				<div id="message" class="updated below-h2 "><p><?php _e('Suggestion inserted successfully','hr_mgt');?></p></div>
			<?php 			
			}
			elseif($message =="sug_edit")
			{ ?>
				<div id="message" class="updated below-h2 "><p><?php _e("Suggestion updated successfully.",'hr_mgt');?></p></div>
			<?php 			
			}
			elseif($message == "sug_del") 
			{ ?>
				<div id="message" class="updated below-h2"><p><?php _e('Suggestion deleted successfully','hr_mgt');	?></div></p><?php
					
			}
	} ?>
	
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
	<h2 class="nav-tab-wrapper">
    	<a href="?page=hrmgt-feedback&tab=complaint_list" class="nav-tab <?php echo $active_tab == 'complaint_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Complaint List', 'hr_mgt'); ?></a>
    	
        <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && $active_tab=="add_complaint")
		{ ?>
			<a href="" class="nav-tab <?php echo $active_tab == 'add_complaint' ? 'nav-tab-active' : ''; ?>">
			<?php _e('Edit Complaint', 'hr_mgt'); ?></a>  
		<?php 
		}
		else 
		{ ?>
			<a href="?page=hrmgt-feedback&tab=add_complaint" class="nav-tab <?php echo $active_tab == 'add_complaint' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add New Complaint', 'hr_mgt'); ?></a>
		<?php  } ?>
		
		<a href="?page=hrmgt-feedback&tab=suggestion_list" class="nav-tab <?php echo $active_tab == 'suggestion_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Suggestion List', 'hr_mgt'); ?></a>
		
		<?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && $active_tab=="add_suggestion")
		{ ?>
			<a href="" class="nav-tab <?php echo $active_tab == 'add_suggestion' ? 'nav-tab-active' : ''; ?>">
			<?php _e('Edit Suggestion', 'hr_mgt'); ?></a>  
		<?php 
		}
		else 
		{ ?>
			<a href="?page=hrmgt-feedback&tab=add_suggestion" class="nav-tab <?php echo $active_tab == 'add_suggestion' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Suggestion', 'hr_mgt'); ?></a>
		<?php  } ?>
		
    </h2>
     <?php 	
	if($active_tab == 'complaint_list')
	{ ?>	
    <script type="text/javascript">
	$(document).ready(function() {
		jQuery('#complaint_list').DataTable({
			"bProcessing": true,
		 "bServerSide": true,
		 "sAjaxSource": ajaxurl+'?action=datatable_employee_feedback_complain_ajax_to_load',
		 "bDeferRender": true,
			});
	} );
</script>
    <form name="activity_form" action="" method="post">
    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="complaint_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Complaint Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Complaint From', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Complaint Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Complaint Status', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Complaint', 'hr_mgt' ) ;?></th>
             <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			  <th><?php _e( 'Complaint Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Complaint From', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Complaint Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Complaint Status', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Complaint', 'hr_mgt' ) ;?></th>
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
		if($active_tab=="add_complaint"){
			require_once HRMS_PLUGIN_DIR.'/admin/employee_feedback/add_complaint.php';
		 }
		 
		 if($active_tab=="add_suggestion"){
			require_once HRMS_PLUGIN_DIR.'/admin/employee_feedback/add_suggestion.php';
		 }
		 if($active_tab=="suggestion_list"){
			require_once HRMS_PLUGIN_DIR.'/admin/employee_feedback/suggestion_list.php';
		 }
	} ?>
</div>
			
	</div>
	</div>
</div>
