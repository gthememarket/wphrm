<div class="mailbox-content">
 	<table class="table">
 		<thead>
 			<tr>
 				<th class="text-right" colspan="5">
                 <?php 
                $message = $obj_message->hrmgt_count_inbox_item(get_current_user_id());
              
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
 	echo $obj_message->hrmgt_pagination($totlal_message,$p,$prev,$next,'page=hrmgt-message&tab=inbox');?>
                </th>
 			</tr>
 		</thead>
 		<tbody>
 		<tr>
 			<th class="hidden-xs">
            	<span><?php _e('Message For','apartment_mgt');?></span>
            </th>
            <th><?php _e('Subject','apartment_mgt');?></th>
             <th>
                  <?php _e('Description','apartment_mgt');?>
            </th>
			 <th>
                  <?php _e('Date','apartment_mgt');?>
            </th>
            </tr>
 		<?php 
 		$message = $obj_message->hrmgt_get_inbox_message(get_current_user_id(),$limit,$max);
 		foreach($message as $msg)
 		{
 			?>
 			<tr>
 			
            <td><?php echo hrmgt_get_display_name($msg->sender);?></td>
             <td>
                 <a href="?page=hrmgt-message&tab=inbox&tab=view_message&from=inbox&id=<?php echo $msg->message_id;?>"> <?php echo $msg->msg_subject;?><?php if($obj_message->hrmgt_count_reply_item($msg->post_id)>=1){?><span class="badge badge-success pull-right"><?php echo $obj_message->hrmgt_count_reply_item($msg->post_id);?></span><?php } ?></a>
            </td>
            <td>
			<?php echo wp_trim_words( $msg->message_body,5);?>
            </td>
            <td>
                <?php  echo  mysql2date('d M', $msg->msg_date );?>
            </td>
            </tr>
 			<?php 
 		}
 		?>
 		
 		</tbody>
 	</table>
 </div>
 <?php ?>