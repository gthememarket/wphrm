<?php 
$obj_hrmanagement=new hrmgt_management(get_current_user_id());
$obj_message = new HrmgtMessage();

$active_tab = isset($_GET['tab'])?$_GET['tab']:'inbox';
if(isset($result))
{
	wp_redirect ( home_url() . '?hr-dashboard=user&page=message&tab=inbox&message=1');
}
	if(isset($_REQUEST['message']))
	{
		$message =$_REQUEST['message'];
		if($message == 1)
		{?>
				<div id="message" class="updated below-h2 msg ">
				<p>
				<?php 
					_e('Message sent successfully','hr_mgt');
				?>
				</p></div>
				<?php 
			
		}
		elseif($message == 2)
		{?><div id="message" class="updated below-h2  msg"><p><?php
					_e("Message deleted successfully",'hr_mgt');
					?></p>
					</div>
				<?php 
			
		}
	}		
	?>
	<div id="main-wrapper">
		<div class="row mailbox-header">
			<div class="col-md-2 col-sm-3 col-xs-4">			
				<a class="btn btn-success btn-block" href="?hr-dashboard=user&page=message&tab=compose">
				<?php _e("Compose","hr_mgt");?></a>			  
			</div>
				<div class="col-md-10 col-sm-9 col-xs-8">
					<h2>
					<?php
					if(!isset($_REQUEST['tab']) || ($_REQUEST['tab'] == 'inbox'))
						echo esc_html( __( 'Inbox', 'hr_mgt' ) );									
					else if(isset($_REQUEST['page']) && $_REQUEST['tab'] == 'sentbox')
						echo esc_html( __( 'Sent Item', 'hr_mgt' ) );
					else if(isset($_REQUEST['page']) && $_REQUEST['tab'] == 'compose')
						echo esc_html( __( 'Compose', 'hr_mgt' ) );
					else if(isset($_REQUEST['page']) && $_REQUEST['tab'] == 'view_message')
						echo esc_html( __( 'View Message', 'hr_mgt' ) );
					?>                                   
					</h2>
				</div>
        </div>
		<div class="col-md-2 col-sm-3 col-xs-12">
			<ul class="list-unstyled mailbox-nav">
				<li <?php if(!isset($_REQUEST['tab']) || ($_REQUEST['tab'] == 'inbox')){?>class="active"<?php }?>>
					<a href="?hr-dashboard=user&page=message&tab=inbox">
						<i class="fa fa-inbox"></i><?php _e("Inbox","hr_mgt");?> <span class="badge badge-success pull-right">
						<?php echo count($obj_message->hrmgt_count_inbox_item(get_current_user_id()));?></span>
					</a>
				</li>
				
				<li <?php if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'sentbox'){?>class="active"<?php }?>><a href="?hr-dashboard=user&page=message&tab=sentbox"><i class="fa fa-sign-out"></i><?php _e("Sent","hr_mgt");?></a></li>
										  
			</ul>
		</div>
 <div class="col-md-10 col-sm-9 col-xs-12">
 <?php  
 	if($active_tab == 'sentbox')
 		require_once HRMS_PLUGIN_DIR. '/template/message/sendbox.php';
 	if($active_tab == 'inbox')
 		require_once HRMS_PLUGIN_DIR. '/template/message/inbox.php';
 	if($active_tab == 'compose')
 		require_once HRMS_PLUGIN_DIR. '/template/message/composemail.php';
 	if($active_tab == 'view_message')
 		require_once HRMS_PLUGIN_DIR. '/template/message/view_message.php'; 	
 	?>
 </div>
</div>