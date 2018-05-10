<div class="popup-bg">
    <div class="overlay-content">
		<div class="category_list"></div>    
    </div> 
</div>	
<?php
	$obj_compansation = new HrmgtCompansation();
	$active_tab = isset($_GET['tab'])?$_GET['tab']:'assets_list'; 
	
	if(isset($_POST['assign_asset']))
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			$result=$obj_compansation->hrmgt_assign_asset($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-assets_benefit&tab=assets_list&message=asset_edit');
			}
		}
		else
		{
			$result=$obj_compansation->hrmgt_assign_asset($_POST);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-assets_benefit&tab=assets_list&message=asset_add');
			}
		}
	}
	
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
	{
		if(isset($_REQUEST['assign_id']))
		{
			$result=$obj_compansation->hrmgt_delete_assets($_REQUEST['assign_id']);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=hrmgt-assets_benefit&tab=assets_list&message=asset_del');
			}
		}					
	}
?>

<div class="page-inner" style="min-height:1088px !important">
<div class="page-title">
	<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?></h3>
</div>
<?php 
if(isset($_REQUEST['message']))
{
	$message =$_REQUEST['message'];
	if($message == "asset_add")
	{
	?>
		<div id="message" class="updated  below-h2 "><p><?php 	_e('Assets inserted successfully','hr_mgt'); ?></p></div>
	<?php 
	}
	elseif($message == "asset_edit")
	{ ?><div id="message" class="updated  below-h2 "><p><?php _e("Assets updated successfully.",'hr_mgt');?></p></div>
	<?php 
	}
	elseif($message == "asset_del") 
	{ ?>
		<div id="message" class="updated  below-h2"><p><?php 	_e('Assets deleted successfully','hr_mgt');	?></div></p>
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
		
			<a href="?page=hrmgt-assets_benefit&tab=assets_list" class="nav-tab <?php echo $active_tab == 'assets_list' ? 'nav-tab-active' : ''; ?>">
			<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Assets List', 'hr_mgt'); ?></a>
	
			<?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'  && $active_tab=="assign_assets")
			{ ?>
			<a href="#" class="nav-tab <?php echo $active_tab == 'assign_assets' ? 'nav-tab-active' : ''; ?>">
			<?php _e('Edit Assets', 'hr_mgt'); ?></a>  
			<?php 
			}
			else 
			{ ?>
				<a href="?page=hrmgt-assets_benefit&tab=assign_assets" class="nav-tab <?php echo $active_tab == 'assign_assets' ? 'nav-tab-active' : ''; ?>">
			<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Assets', 'hr_mgt'); ?></a>
			<?php  } ?>		
		</h2>
		
<?php if($active_tab == 'assets_list'){ ?>	
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#assets_list').DataTable({
		"bProcessing": true,
				 "bServerSide": true,
				 "sAjaxSource": ajaxurl+'?action=datatable_campasion_ajax_to_load',
				 "bDeferRender": true,	
		});
} );
</script>

<form name="activity_form" action="" method="post">    
    <div class="panel-body">
		<div class="table-responsive">
        <table id="assets_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Assets', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Assigned Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Return Date', 'hr_mgt' ) ;?></th>
             <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			   <th><?php _e( 'Assets', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Employee Name', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Assigned Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Return Date', 'hr_mgt' ) ;?></th>
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
				require_once HRMS_PLUGIN_DIR.'/admin/assets-benefit/'.$active_tab.'.php';
		}
	} ?>

