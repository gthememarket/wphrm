<?php $active_tab = isset($_GET['tab'])?$_GET['tab']:'noticelist'; ?>
<?php 
if(isset($_POST['save_notice']))
{
	if($_POST['action']=='edit')
	{
		$args = array(
			'ID'           => $_REQUEST['notice_id'],
			'post_title'   => $_REQUEST['notice_title'],
			'post_content' =>  $_REQUEST['notice_content'],
		);
		$result1=wp_update_post( $args );
		$result2=update_post_meta($_REQUEST['notice_id'], 'notice_for', $_REQUEST['notice_for']);
		$result3=update_post_meta($_REQUEST['notice_id'], 'start_date',$_REQUEST['notice_start_date']);
		$result3=update_post_meta($_REQUEST['notice_id'], 'end_date',$_REQUEST['notice_end_date']);
		if($result1)
		{
			wp_redirect ( admin_url().'admin.php?page=hrmgt-notice&tab=noticelist&message=2');
		}
	}
	else
	{		
		$args = array(
			'ID'           => $_POST['notice_id'],
			'post_title'   => $_POST['notice_title'],
			'post_type' => 'hrmgt_notice',
			'post_status' => 'publish',
			'post_content' => $_POST['notice_content'],
		);		
		
		$result1=wp_insert_post( $args );	
		$result2=add_post_meta($result1, 'notice_for', $_POST['notice_for']);			
		$result3=add_post_meta($result1, 'start_date',$_POST['notice_start_date']);			
		$result4=add_post_meta($result1, 'end_date',$_POST['notice_end_date']);		
		if($result1)
		{
			wp_redirect ( admin_url().'admin.php?page=hrmgt-notice&tab=noticelist&message=1');
		}
	}
}
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
{
	$result=wp_delete_post($_REQUEST['notice_id']);
	if($result)
	{ 
		wp_redirect ( admin_url().'admin.php?page=hrmgt-notice&tab=noticelist&message=3');
	}
}	
?>	

<div class="popup-bg">
    <div class="overlay-content">   
    	<div class="notice_content"></div>    
    </div>     
</div>	
<div class="page-inner" style="min-height:1631px !important">
<div class="page-title">
	<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?></h3>
</div>
<?php 
if(isset($_REQUEST['message']))
{
	$message =$_REQUEST['message'];
	if($message == 1)
	{ ?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e('Notice inserted successfully','hr_mgt');?></p>
	</div>
	<?php 			
	}
	if($message == 2)
	{ ?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e('Notice update successfully','hr_mgt');?></p>
	</div>
	<?php 			
	}
	if($message == 3)
	{ ?>
	<div id="message" class="updated below-h2 ">
		<p><?php _e('Notice delete successfully','hr_mgt');?></p>
	</div>
	<?php 			
	}
}
?>

<div  id="main-wrapper" class="notice_page">
	<div class="panel panel-white">
		<div class="panel-body">   
		<h2 class="nav-tab-wrapper">
			<a href="?page=hrmgt-notice&tab=noticelist" class="nav-tab <?php echo $active_tab == 'noticelist' ? 'nav-tab-active' : ''; ?>">
			<?php echo '<span class="dashicons dashicons-menu"></span>'.__('Notice List', 'hr_mgt'); ?></a>
			 <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
			{?>
		   <a href="?page=hrmgt-notice&tab=addnotice&action=edit&notice_id=<?php echo $_REQUEST['notice_id'];?>" class="nav-tab <?php echo $active_tab == 'addnotice' ? 'nav-tab-active' : ''; ?>">
			<?php _e('Edit Notice', 'hr_mgt'); ?></a>  
			<?php 
			}
			else
			{?>
			<a href="?page=hrmgt-notice&tab=addnotice" class="nav-tab <?php echo $active_tab == 'addnotice' ? 'nav-tab-active' : ''; ?>">
			<?php echo '<span class="dashicons dashicons-plus-alt"></span>'.__('Add Notice', 'hr_mgt'); ?></a>  
			<?php } ?>
		</h2>
<?php	
if($active_tab == 'noticelist')
{	
?>	  
<div class="panel-body">
<script>
jQuery(document).ready(function() {
	var table =  jQuery('#notice_list').DataTable({
							"bProcessing": true,
							 "bServerSide": true,
							 "sAjaxSource": ajaxurl+'?action=datatable_notic_ajax_to_load',
							 "bDeferRender": true,	
	});
});
</script>
<div class="table-responsive">
	<form id="frm-example" name="frm-example" method="post">	
        <table id="notice_list" class="display" cellspacing="0" width="100%">
        <thead>
            <tr> 			   
                <th width="190px"><?php _e('Notice Title','hr_mgt');?></th>
                <th><?php _e('Notice Comment','hr_mgt');?></th>
                <th><?php _e('Notice Start Date','hr_mgt');?></th>
				<th><?php _e('Notice End Date','hr_mgt');?></th>               
                <th><?php _e('Notice For','hr_mgt');?></th>
                <th width="185px"><?php _e('Action','hr_mgt');?></th>               
            </tr>
        </thead> 
        <tfoot>
            <tr>				
            	<th><?php _e('Notice Title','hr_mgt');?></th>
                <th><?php _e('Notice Comment','hr_mgt');?></th>
                <th><?php _e('Notice Start Date','hr_mgt');?></th>
				<th><?php _e('Notice End Date','hr_mgt');?></th>
                <th><?php _e('Notice For','hr_mgt');?></th>                
                <th><?php _e('Action','hr_mgt');?></th>           
            </tr>
        </tfoot>
			<?php
				$args['post_type'] = 'hrmgt_notice';
				$args['posts_per_page'] = -1;
				$args['post_status'] = 'public';
				$q = new WP_Query();
				$NoticeData = $q->query( $args );				
			?>
	 </table>
	</form>
</div>
</div>
<?php  }
if($active_tab == 'addnotice')
{
	require_once HRMS_PLUGIN_DIR. '/admin/notice/add-notice.php';
}
?>
</div>
</div>
</div>
</div>