<div class="popup-bg">
    <div class="overlay-content">
   <div class="category_list"></div>    
    </div> 
</div>	
<?php 		
$obj_par_mark=new HrmgtParfomanceMark;
$obj_project=new HrmgtProject;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'performance_mark_list';?>

<div class="page-inner" style="min-height:1088px !important">
	<div class="page-title">
		<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?>
		</h3>
	</div>
<?php 
if(isset($_POST['save_perfomance_marks']))
{
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{
		$result=$obj_par_mark->hrmgt_add_parfomance_marks($_POST);
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=hrmgt-parfomance_marks&tab=performance_mark_list&message=2');
		}
	}
	else
	{			
		$result=$obj_par_mark->hrmgt_add_parfomance_marks($_POST);		
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=hrmgt-parfomance_marks&tab=performance_mark_list&message=1');
		}
	}
}
	
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	$result=$obj_par_mark->hrmgt_delete_parfomance_marks($_REQUEST['parfomance_id']);
	if($result)	
	{
		wp_redirect ( admin_url().'admin.php?page=hrmgt-parfomance_marks&tab=performance_mark_list&message=3');
	}
}
if(isset($_REQUEST['message']))	{
	$message =$_REQUEST['message'];
	if($message == 1)
	{ ?>
		<div id="message" class="updated below-h2 "><p><?php _e('Perfomance Mark insert successfully','hr_mgt');?></p></div>
	<?php 
	}
	elseif($message == 2)
	{ ?>
		<div id="message" class="updated below-h2 "><p><?php _e("Perfomance Mark update successfully.",'hr_mgt');?></p></div>
	<?php 
	}
	elseif($message == 3) 
	{ ?>
		<div id="message" class="updated below-h2"><p><?php _e('Perfomance Mark delete successfully','hr_mgt'); ?></div></p>
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
    	<a href="?page=hrmgt-parfomance_marks&tab=performance_mark_list" class="nav-tab <?php echo $active_tab == 'performance_mark_list' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Performance  Marks List', 'hr_mgt'); ?></a>
    	
        <?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{ ?>
        <a href="?page=hrmgt-parfomance_marks&tab=add_parfomance_marks&action=edit&parfomance_id=<?php echo $_REQUEST['parfomance_id'];?>" class="nav-tab <?php echo $active_tab == 'add_parfomance_marks' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Performance  Marks', 'hr_mgt'); ?></a>  
		<?php 
		}
		else 
		{ ?>
			<a href="?page=hrmgt-parfomance_marks&tab=add_parfomance_marks" class="nav-tab <?php echo $active_tab == 'add_parfomance_marks' ? 'nav-tab-active' : ''; ?>">
		<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Performance  Marks', 'hr_mgt'); ?></a>
		<?php  }?>
    </h2>
    <?php 
	if($active_tab == 'performance_mark_list')
	{ ?>	
	<script type="text/javascript">
		$(document).ready(function() {
			jQuery('#performance_mark_list').DataTable({
				"bProcessing": true,
				 "bServerSide": true,
				 "sAjaxSource": ajaxurl+'?action=datatable_Perfomance_marks_ajax_to_load',
				 "bDeferRender": true,			
			});
		} );
	</script>
    <form name="activity_form" action="" method="post">    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="performance_mark_list" class="display" cellspacing="0" width="100%">
        	<thead>
				<tr>
					<th><?php _e( 'Project', 'hr_mgt' ) ;?></th>			  
					<th><?php _e( 'Title', 'hr_mgt' ) ;?></th>			  
					<th><?php _e( 'Mark', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Description', 'hr_mgt' ) ;?></th>
					<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th><?php _e( 'Project', 'hr_mgt' ) ;?></th>			  
					<th><?php _e( 'Title', 'hr_mgt' ) ;?></th>			  
					<th><?php _e( 'Mark', 'hr_mgt' ) ;?></th>
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
	else
	{
		if(isset($active_tab))
		 {
			require_once HRMS_PLUGIN_DIR.'/admin/parfomance-marks/'.$active_tab.'.php';
		 }
	}	 ?>
</div>			
</div>
</div>
</div>