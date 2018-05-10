<script type="text/javascript">
$(document).ready(function() {
	$('#message_form').validationEngine();
} );
</script>
<div class="mailbox-content">
    <?php
		if(isset($message))
		echo '<div id="message" class="updated below-h2"><p>'.$message.'</p></div>';
	?>
    <form name="message_form" action="" method="post" class="form-horizontal" id="message_form">
        <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="to"><?php _e('Message To','hr_mgt');?><span class="require-field">*</span></label>
                <div class="col-sm-8">
                   <select name="receiver" class="form-control validate[required] text-input" id="to">
						<option value="employee"><?php _e('All Employee','hr_mgt');?></option>	
						<?php hrmgt_get_all_user_in_message();?>
					</select>
                </div>
		</div>
         <div class="form-group">
            <label class="col-sm-2 control-label" for="subject"><?php _e('Subject','hr_mgt');?><span class="require-field">*</span></label>
            <div class="col-sm-8">
                <input id="subject" class="form-control validate[required] text-input" type="text" name="subject" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="subject"><?php _e('Message Comment','hr_mgt');?><span class="require-field">*</span></label>
            <div class="col-sm-8">
				<textarea name="message_body" id="message_body" class="form-control validate[required] text-input"></textarea>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="subject"><?php _e(' Send Mail','hr_mgt');?></label>
			 <div class="col-sm-8">
				<input type="checkbox" name="send_mail" value="1" checked>
            </div>			
        </div>
		
        <div class="form-group">
            <div class="col-sm-10">
                <div class="pull-right">
                    <input type="submit" value="<?php  _e('Send Message','hr_mgt');?>" name="save_message" class="btn btn-success"/>
                </div>
            </div>
        </div>
    </form>
</div>