<?php $obj_message = new HrmgtMessage(); ?>
<div class="mailbox-content">
<div class="table-responsive">
 	<table class="table">
 		<thead>
 			<tr> 				
               <th class="text-right" colspan="5">
               <?php $message = $obj_message->hrmgt_count_inbox_item(get_current_user_id());
             
 		$max = 10;
 		if(isset($_GET['pg'])){
 			$p = $_GET['pg'];
 		}else{
 			$p = 1;
 		}
 		 
 		$limit = ($p - 1) * $max;
 		$prev = $p - 1;
 		$next = $p + 1;
 		$limits = (int)($p - 1) * $max;
 		$totlal_message =count($message);
 		$totlal_message = ceil($totlal_message / $max);
 		$lpm1 = $totlal_message - 1;
 		$offest_value = ($p-1) * $max;
 		echo $obj_message->hrmgt_pagination($totlal_message,$p,$prev,$next,'church-dashboard=user&&page=message&tab=inbox');?>
                </th>
 			</tr>
 		</thead>
 		<tbody>
 		<tr> 			
 			<th class="hidden-xs">
            	<span><?php _e('Message For','hr_mgt');?></span>
            </th>
            <th><?php _e('Subject','hr_mgt');?></th>
             <th><?php _e('Description','hr_mgt');?></th>
            </tr>
 		<?php  		
 		$message = $obj_message->hrmgt_get_inbox_message(get_current_user_id(),$limit,$max);			
 		foreach($message as $msg)
 		{
 			?>
 			 <tr>
 			
            <td><?php echo hrmgt_get_display_name($msg->sender);?></td>
             <td>
                 <a href="?hr-dashboard=user&page=message&tab=view_message&from=inbox&id=<?php echo $msg->message_id;?>"> <?php echo $msg->msg_subject;?><?php if($obj_message->hrmgt_count_reply_item($msg->post_id)>=1){?><span class="badge badge-success pull-right"><?php echo $obj_message->hrmgt_count_reply_item($msg->post_id);?></span><?php } ?></a>
            </td>
            <td><?php echo $msg->message_body;?>
            </td>
            <td>             
            </td>
            </tr>
 			<?php 
 		}
 		?>
 		
 		</tbody>
 	</table>
 	</div>
 </div>