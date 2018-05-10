<div class="popup-bg">
    <div class="overlay-content">
   <div class="category_list"></div>    
    </div> 
</div>	
<?php 		
$active_tab = isset($_GET['tab'])?$_GET['tab']:'travel_list';
$obj_travel=new HrmgtTravel; ?>
<div class="page-inner" style="min-height:1088px !important">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?>
		</h3>
</div>
<?php 
	if(isset($_POST['save_travel'])){		
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit'){
			$result=$obj_travel->hrmgt_add_travel($_POST);
			if($result){
				wp_redirect ( admin_url().'admin.php?page=hrmgt-travel&tab=travel_list&message=2');
			}
		}
		else{			
			$result=$obj_travel->hrmgt_add_travel($_POST);			
			if($result){
				wp_redirect ( admin_url().'admin.php?page=hrmgt-travel&tab=travel_list&message=1');
			}
		}
	}
	
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{
			$result=$obj_travel->hrmgt_delete_travel($_REQUEST['travel_id']);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-travel&tab=travel_list&message=3');
			}
		}
		if(isset($_REQUEST['message']))
		{
			$message =$_REQUEST['message'];
			if($message == 1)
			{ ?>
					<div id="message" class="updated below-h2 ">
					<p>
					<?php 
						_e('Travel insert successfully','hr_mgt');
					?></p></div>
					<?php 
			
			}
			elseif($message == 2)
			{?><div id="message" class="updated below-h2 "><p><?php
						_e("Travel update successfully.",'hr_mgt');?></p>
						</div>
					<?php 
				
			}
			elseif($message == 3) 
			{?>
			<div id="message" class="updated below-h2"><p>
			<?php 
				_e('Travel delete successfully','hr_mgt');
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
    	<a href="?page=hrmgt-travel&tab=travel_list" class="nav-tab <?php echo $active_tab == 'travel_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Travels List', 'hr_mgt'); ?></a>
    	
        <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{ ?>
        <a href="?page=hrmgt-travel&tab=add_travel&action=edit&travel_id=<?php echo $_REQUEST['travel_id'];?>" class="nav-tab <?php echo $active_tab == 'add_travel' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Travel', 'hr_mgt'); ?></a>  
		<?php 
		}
		else 
		{ ?>
			<a href="?page=hrmgt-travel&tab=add_travel" class="nav-tab <?php echo $active_tab == 'add_travel' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add New Travel', 'hr_mgt'); ?></a>
		<?php  } ?>
    </h2>
     <?php 
	
	if($active_tab == 'travel_list')
	{ ?>	
    <script type="text/javascript">
$(document).ready(function() {
	jQuery('#travel_list').DataTable({
		"bProcessing": true,
			 "bServerSide": true,
			 "sAjaxSource": ajaxurl+'?action=datatable_travelling_ajax_to_load',
			 "bDeferRender": true,
		});
} );
</script>
    <form name="activity_form" action="" method="post">
    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="travel_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Employee', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Travel Purpose', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Travel Start Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Travel End Date', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Description', 'hr_mgt' ) ;?></th>
			 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			  <th><?php _e( 'Employee', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Travel Purpose', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Travel Start Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Travel End Date', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Description ', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Action', 'hr_mgt' ) ;?></th>
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
			require_once HRMS_PLUGIN_DIR.'/admin/travel/'.$active_tab.'.php';
		 }
	}?>
</div>
			
	</div>
	</div>
</div>
