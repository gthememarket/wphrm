<?php 		
$obj_training=new HrmgtTraining;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'training_list';?>
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
	if(isset($_POST['save_training'])){
		
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit'){
			$result=$obj_training->hrmgt_add_training($_POST);			
			if($result){				
				wp_redirect ( admin_url().'admin.php?page=hrmgt-employee_training&tab=training_list&message=2');
			}
		}
		else{	
			
			$result=$obj_training->hrmgt_add_training($_POST);
			if($result){
				wp_redirect ( admin_url().'admin.php?page=hrmgt-employee_training&tab=training_list&message=1');
			}
		}
	}
	
	
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete'){
			$result=$obj_training->hrmgt_delete_training($_REQUEST['training_id']);
			if($result){
				wp_redirect ( admin_url().'admin.php?page=hrmgt-employee_training&tab=training_list&message=3');
			}
		}
		if(isset($_REQUEST['message'])){
			$message =$_REQUEST['message'];
			if($message == 1)
			{ ?>
					<div id="message" class="updated below-h2 ">
					<p>
					<?php 
						_e('Employee Training inserted successfully','hr_mgt');
					?></p></div>
					<?php 
			
		}
		elseif($message == 2)
		{?><div id="message" class="updated below-h2 "><p><?php
					_e("Employee Training updated successfully.",'hr_mgt');?></p>
					</div>
				<?php 
			
		}
		elseif($message == 3) 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php 
			_e('Employee Training deleted successfully','hr_mgt');
		?></div></p><?php
				
		}
		
	}
	?>
	
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
	<h2 class="nav-tab-wrapper">
    	<a href="?page=hrmgt-employee_training&tab=training_list" class="nav-tab <?php echo $active_tab == 'training_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Employee Training', 'hr_mgt'); ?></a>
    	
        <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{ ?>
        <a href="?page=hrmgt-employee_training&tab=add_training&action=edit&training_id=<?php echo $_REQUEST['training_id'];?>" class="nav-tab <?php echo $active_tab == 'add_training' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Training', 'hr_mgt'); ?></a>  
		<?php 
		}
		else 
		{ ?>
			<a href="?page=hrmgt-employee_training&tab=add_training" class="nav-tab <?php echo $active_tab == 'add_training' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add New Training', 'hr_mgt'); ?></a>
		<?php  }?>
    </h2>
     <?php 	
	if($active_tab == 'training_list')
	{ ?>	
    <script type="text/javascript">
	$(document).ready(function() {
		jQuery('#training_list').DataTable({
			"bProcessing": true,
		 "bServerSide": true,
		 "sAjaxSource": ajaxurl+'?action=datatable_employee_training_ajax_to_load',
		 "bDeferRender": true,
			});
	} );
	</script>
    <form name="activity_form" action="" method="post">
    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="training_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Training Type', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Training Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Training Subject', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Training Start Date', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Training End Date', 'hr_mgt' ) ;?></th>
			<th><?php _e( 'Description', 'hr_mgt' ) ;?></th>
			 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			  <th><?php _e( 'Training Type', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Training Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Training Subject', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Training Start Date', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Training End Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Description', 'hr_mgt' ) ;?></th>
			 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
           
        </tfoot>
 </table>
        </div>
        </div>
</form>
     <?php 
	 }
	
	 if($active_tab == 'add_training')
	 {
		require_once HRMS_PLUGIN_DIR.'/admin/employee-training/add_training.php';
	 } ?>
</div>
			
	</div>
	</div>
</div>
