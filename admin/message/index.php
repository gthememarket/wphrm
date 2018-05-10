<?php 
	$obj_message = new HrmgtMessage();
	$active_tab = isset($_GET['tab'])?$_GET['tab']:'inbox';
?>
<div class="page-inner" style="min-height:1631px !important">
<div class="page-title">
		<h3><img src="<?php echo get_option( 'hrmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'hrmgt_system_name' );?></h3>
	</div>
	<?php 
	if(isset($_POST['save_message']))
	{
		$result = $obj_message->hrmgt_add_message($_POST);
	}
	
	if(isset($result))
	{
		wp_redirect ( admin_url() . 'admin.php?page=hrmgt-message&tab=inbox&message=1');
	}
	if(isset($_REQUEST['message']))
	{
		$message =$_REQUEST['message'];
		if($message == 1)
		{ ?>
			<div id="message" class="updated below-h2 "><p>	<?php _e('Message sent successfully','hr_mgt');?></p></div>
	<?php 			
		}
		elseif($message == 2)
		{ ?>
			<div id="message" class="updated below-h2 "><p><?php _e("Message deleted successfully",'hr_mgt'); ?></p></div>
		<?php 		
		}	}	
	?>
<div id="main-wrapper">
<div class="row mailbox-header">
	<div class="col-md-2">
		<a class="btn btn-success btn-block" href="?page=hrmgt-message&tab=compose"><?php _e('Compose','hr_mgt');?></a>
	</div>
		<div class="col-md-6">
			<h2>
			<?php
			if(!isset($_REQUEST['tab']) || ($_REQUEST['tab'] == 'inbox'))
			echo esc_html( __( 'Inbox', 'hr_mgt' ) );
			else if(isset($_REQUEST['page']) && $_REQUEST['tab'] == 'sentbox')
			echo esc_html( __( 'Sent Item', 'hr_mgt' ) );
			else if(isset($_REQUEST['page']) && $_REQUEST['tab'] == 'compose')
				echo esc_html( __( 'Compose', 'hr_mgt' ) );
			?>
		</h2>
		</div>
 </div>
 <div class="col-md-2">
	<ul class="list-unstyled mailbox-nav">
		<li <?php if(!isset($_REQUEST['tab']) || ($_REQUEST['tab'] == 'inbox')){?>class="active"<?php }?>>
		<a href="?page=hrmgt-message&tab=inbox"><i class="fa fa-inbox"></i> <?php _e('Inbox','hr_mgt');?><span class="badge badge-success pull-right"><?php echo count($obj_message->hrmgt_count_inbox_item(get_current_user_id()));?></span></a></li>
		<li <?php if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'sentbox'){?>class="active"<?php }?>><a href="?page=hrmgt-message&tab=sentbox"><i class="fa fa-sign-out"></i><?php _e('Sent','hr_mgt');?></a></li>                                
	</ul>
</div>
 <div class="col-md-10">
 <?php  
 	if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'sentbox')
 		require_once HRMS_PLUGIN_DIR. '/admin/message/sendbox.php';
 	if(!isset($_REQUEST['tab']) || ($_REQUEST['tab'] == 'inbox'))
 		require_once HRMS_PLUGIN_DIR. '/admin/message/inbox.php';
 	if(isset($_REQUEST['tab']) && ($_REQUEST['tab'] == 'compose'))
 		require_once HRMS_PLUGIN_DIR. '/admin/message/composemail.php';
 	if(isset($_REQUEST['tab']) && ($_REQUEST['tab'] == 'view_message'))
 		require_once HRMS_PLUGIN_DIR. '/admin/message/view_message.php';
 	
 	?>
 </div>
</div>
</div>