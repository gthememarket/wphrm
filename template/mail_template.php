<?php
if(isset($_REQUEST['add_leave_template'])){
	update_option('addleave_email_template',$_REQUEST['addleave_email_template']);
	update_option('add_leave_subject',$_REQUEST['add_leave_subject']);
	update_option('add_leave_emails',$_REQUEST['add_leave_emails']);	
}

if(isset($_REQUEST['leave_approve_template'])){
	update_option('leave_approve_email_template',$_REQUEST['leave_approve_email_template']);	
	update_option('leave_approve_subject',$_REQUEST['leave_approve_subject']);
	update_option('leave_approveemails',$_REQUEST['leave_approveemails']);	
}

if(isset($_REQUEST['event_template'])){
	update_option('event_email_template',$_REQUEST['event_email_template']);	
	update_option('event_subject',$_REQUEST['event_subject']);
	update_option('event_emails',$_REQUEST['event_emails']);	
}

if(isset($_REQUEST['registration_template'])){
	update_option('registration_email_template',$_REQUEST['registration_email_template']);	
	update_option('registration_subject',$_REQUEST['registration_subject']);
	update_option('registration_emails',$_REQUEST['registration_emails']);	
}

if(isset($_REQUEST['traning_template'])){
	update_option('traning_email_template',$_REQUEST['traning_email_template']);	
	update_option('traning_subject',$_REQUEST['traning_subject']);
	update_option('traning_emails',$_REQUEST['traning_emails']);
}

if(isset($_REQUEST['exprience_template'])){
	update_option('hrmgt_exprience_latter_heading',$_REQUEST['hrmgt_exprience_latter_heading']);	
	update_option('hrmgt_exprience_latter_subject',$_REQUEST['hrmgt_exprience_latter_subject']);	
	update_option('hrmgt_exprience_latter_to',$_REQUEST['hrmgt_exprience_latter_to']);	
	update_option('hrmgt_exprience_latter_content',$_REQUEST['hrmgt_exprience_latter_content']);	
}

 ?>
<div class="page-inner" style="min-height:1088px !important">
<div id="main-wrapper">
<div class="row">
<div class="col-md-12">
<div class="panel panel-white">
	<div class="panel-body">
		<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          <?php _e('Add Leave Email Template ','hr_mgt'); ?>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
      <div class="panel-body">
        <form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
			<div class="form-group">
				<label for="emails" class="col-sm-3 control-label"><?php _e('Emails','hr_mgt');?> </label>
				<div class="col-md-8">
					<input class="form-control validate[required]" name="add_leave_emails" id="add_leave_emails" placeholder="abc@abc.com, xyz@xyz.com" value="<?php print get_option('add_leave_emails'); ?>">
				</div>
			</div>
			
			<div class="form-group">
				<label for="first_name" class="col-sm-3 control-label"><?php _e('Email Subject','hr_mgt');?> </label>
				<div class="col-md-8">
					<input class="form-control validate[required]" name="add_leave_subject" id="add_leave_subject" placeholder="Enter email subject" value="<?php print get_option('add_leave_subject'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="first_name" class="col-sm-3 control-label"><?php _e('Emails Sent to HR when employee add leave','hr_mgt'); ?> </label>
				<div class="col-md-8">
					<textarea style="min-height:200px;" name="addleave_email_template" class="form-control validate[required]"><?php print get_option('addleave_email_template'); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-md-8">
					<label><?php _e('You can use following variables in the email template:','hr_mgt');?></label><br>					
					<label><strong><?php _e('{{employee_name}} -','hr_mgt');?> </strong><?php _e('Name of employee','hr_mgt'); ?></label><br>
					<label><strong><?php _e('{{leave_type}} -','hr_mgt');?> </strong><?php _e('Leave Type','hr_mgt'); ?></label><br>
					<label><strong><?php _e('{{leave_duration}} -','hr_mgt');?> </strong><?php _e('Duration of the leave','hr_mgt'); ?></label><br>
					<label><strong><?php _e('{{reason}} -','hr_mgt');?> </strong><?php _e('Reson of the leave','hr_mgt'); ?></label><br>
					
					<label><strong><?php _e('{{start_date}} - ','hr_mgt');?></strong><?php _e('Date of leave start','hr_mgt'); ?></label><br>
					<label><strong><?php _e('{{end_date}} - ','hr_mgt');?></strong><?php _e('Date of leave end','hr_mgt'); ?></label><br>
					<label><strong><?php _e('{{system_name}} -','hr_mgt')?> </strong><?php _e('System name','hr_mgt'); ?></label>						
				</div>
			</div>
			<div class="col-sm-offset-3 col-sm-8">        	
				<input value="Save" name="add_leave_template" class="btn btn-success" type="submit">
			</div>
		</form>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
          <?php _e('Leave Approve Email Template ','hr_mgt'); ?>
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
		<form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
		
			<div class="form-group">
				<label for="emails" class="col-sm-3 control-label"><?php _e('Emails','hr_mgt');?> </label>
				<div class="col-md-8">
					<input class="form-control validate[required]" name="leave_approveemails" id="leave_approveemails" placeholder="abc@abc.com, xyz@xyz.com" value="<?php print get_option('leave_approveemails'); ?>">
				</div>
			</div>
			
			<div class="form-group">
				<label for="" class="col-sm-3 control-label"><?php _e('Email Subject','hr_mgt');?> </label>
				<div class="col-md-8">
					<input class="form-control validate[required]" name="leave_approve_subject" id="leave_approve_subject" placeholder="Enter email subject" value="<?php print get_option('leave_approve_subject'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-3 control-label"><?php _e('Emails Sent to Employee When A HR Add Approve Leave','hr_mgt'); ?>  </label>
				<div class="col-md-8">
					<textarea style="min-height:200px" name="leave_approve_email_template" class="form-control validate[required]"><?php print get_option('leave_approve_email_template'); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-md-8">
					<label><?php _e('You can use following variables in the email template:','hr_mgt');?></label><br>
					<label><strong><?php _e('{{user_name}} -','hr_mgt')?> </strong><?php _e('The employee full name or login name (whatever is available)','hr_mgt');?></label><br>
				
					
					<label><strong><?php _e('{{date}} - ','hr_mgt');?></strong><?php _e('Date of leave','hr_mgt'); ?></label><br>
					
					<label><strong><?php _e('{{system_name}} -','hr_mgt')?> </strong><?php _e('System name','hr_mgt'); ?></label>						
				</div>
			</div>
			<div class="col-sm-offset-3 col-sm-8">        	
				<input value="Save" name="leave_approve_template" class="btn btn-success" type="submit">
			</div>
		</form>
	  
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
         <?php _e('Event Email Template ','hr_mgt'); ?>
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse">
      <div class="panel-body">
	  
        <form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
		
			<div class="form-group">
				<label for="emails" class="col-sm-3 control-label"><?php _e('Emails','hr_mgt');?> </label>
				<div class="col-md-8">
					<input class="form-control validate[required]" name="event_emails" id="event_emails" placeholder="abc@abc.com, xyz@xyz.com" value="<?php print get_option('event_emails'); ?>">
				</div>
			</div>
			
			<div class="form-group">
				<label for="" class="col-sm-3 control-label"><?php _e('Email Subject','hr_mgt');?></label>
				<div class="col-md-8">
					<input class="form-control validate[required]" name="event_subject" id="event_subject" placeholder="Enter email subject" value="<?php print get_option('event_subject'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-3 control-label"><?php _e('Emails Sent to all employee when HR add event','hr_mgt'); ?> </label>
				<div class="col-md-8">
					<textarea style="min-height:200px" name="event_email_template" class="form-control validate[required]"><?php print get_option('event_email_template'); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-md-8">
					<label><?php _e('You can use following variables in the email template:','hr_mgt');?></label><br>				
					<label><strong><?php _e('{{event_start_date}} - ','hr_mgt');?></strong><?php _e('Date of event start','hr_mgt'); ?></label><br>
					<label><strong><?php _e('{{event_end_date}} - ','hr_mgt');?></strong><?php _e('Date of event end','hr_mgt'); ?></label><br>
					<label><strong><?php _e('{{event_place}} - ','hr_mgt');?></strong><?php _e('Place of event','hr_mgt'); ?></label><br>
					<label><strong><?php _e('{{system_name}} -','hr_mgt')?> </strong><?php _e('System name','hr_mgt'); ?></label>						
				</div>
			</div>
			<div class="col-sm-offset-3 col-sm-8">        	
				<input value="Save" name="event_template" class="btn btn-success" type="submit">
			</div>
		</form>		
      </div>
    </div>
  </div>


<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
         <?php _e('Registration  Email Template ','hr_mgt'); ?>
        </a>
      </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse">
      <div class="panel-body">
	  
        <form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
		
		<div class="form-group">
				<label for="emails" class="col-sm-3 control-label"><?php _e('Emails','hr_mgt');?> </label>
				<div class="col-md-8">
					<input class="form-control validate[required]" name="registration_emails" id="registration_emails" placeholder="abc@abc.com, xyz@xyz.com" value="<?php print get_option('registration_emails'); ?>">
				</div>
			</div>
			
			<div class="form-group">
				<label for="" class="col-sm-3 control-label"><?php _e('Email Subject','hr_mgt');?></label>
				<div class="col-md-8">
					<input class="form-control validate[required]" name="registration_subject" id="event_subject" placeholder="Enter email subject" value="<?php print get_option('registration_subject'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-3 control-label"><?php _e('Emails Sent to employee after employee registration','hr_mgt'); ?>  </label>
				<div class="col-md-8">
					<textarea style="min-height:200px" name="registration_email_template" class="form-control validate[required]"><?php print get_option('registration_email_template'); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-md-8">
					<label><?php _e('You can use following variables in the email template:','hr_mgt');?></label><br>
					
					<label><strong><?php _e('{{username}} -','hr_mgt');?> </strong><?php _e('User name of employee','hr_mgt'); ?></label><br>
					
					<label><strong><?php _e('{{Password}} - ','hr_mgt');?></strong><?php _e('Password of employee','hr_mgt'); ?></label><br>
					<label><strong><?php _e('{{Email}} - ','hr_mgt');?></strong><?php _e('Employee Email','hr_mgt'); ?></label><br>				
				</div>
			</div>
			<div class="col-sm-offset-3 col-sm-8">        	
				<input value="Save" name="registration_template" class="btn btn-success" type="submit">
			</div>
		</form>		
      </div>
    </div>
  </div>
  
  
<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapsefifth">
         <?php _e('Training  Email Template ','hr_mgt'); ?>
        </a>
      </h4>
    </div>
    <div id="collapsefifth" class="panel-collapse collapse">
      <div class="panel-body">
	  
        <form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
			
			<div class="form-group">
				<label for="emails" class="col-sm-3 control-label"><?php _e('Emails','hr_mgt');?> </label>
				<div class="col-md-8">
					<input class="form-control validate[required]" name="traning_emails" id="traning_emails" placeholder="abc@abc.com, xyz@xyz.com" value="<?php print get_option('traning_emails'); ?>">
				</div>
			</div>
			
			<div class="form-group">
				<label for="" class="col-sm-3 control-label"><?php _e('Email Subject','hr_mgt');?> </label>
				<div class="col-md-8">
					<input class="form-control validate[required]" name="traning_subject" id="event_subject" placeholder="Enter email subject" value="<?php print get_option('traning_subject'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-3 control-label"><?php _e('Emails Sent to employee when HR add new training','hr_mgt'); ?>  </label>
				<div class="col-md-8">
					<textarea style="min-height:200px" name="traning_email_template" class="form-control validate[required]"><?php print get_option('traning_email_template'); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-md-8">
					<label><?php _e('You can use following variables in the email template:','hr_mgt');?></label><br>
					<label><strong><?php _e('{{training_type}} -','hr_mgt')?> </strong><?php _e('Type of training','hr_mgt');?></label><br>
					<label><strong><?php _e('{{training_subject}} -','hr_mgt');?> </strong><?php _e('Subject of training ','hr_mgt'); ?></label><br>
					<label><strong><?php _e('{{trainer_name}} - ','hr_mgt');?></strong><?php _e('Name of the trainer','hr_mgt'); ?></label><br>
					<label><strong><?php _e('{{training_location}} - ','hr_mgt');?></strong><?php _e('Training location name','hr_mgt'); ?></label><br>
					<label><strong><?php _e('{{traininer_start_date}} - ','hr_mgt');?></strong><?php _e('Date of training start','hr_mgt'); ?></label><br>
					<label><strong><?php _e('{{traininer_end_date}} - ','hr_mgt');?></strong><?php _e('Date of training end','hr_mgt'); ?></label><br>					
					<label><strong><?php _e('{{description}} -','hr_mgt')?> </strong><?php _e('Training Description','hr_mgt'); ?></label>						
				</div>
			</div>
			<div class="col-sm-offset-3 col-sm-8">        	
				<input value="Save" name="traning_template" class="btn btn-success" type="submit">
			</div>
		</form>		
      </div>
    </div>
  </div>
  
  
  
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapsesix">
         <?php _e('Employee Experience Certificate Template ','hr_mgt'); ?>
        </a>
      </h4>
    </div>
    <div id="collapsesix" class="panel-collapse collapse">
      <div class="panel-body">
	  
        <form id="email_template_form" class="form-horizontal" method="post" action="" name="parent_form">
			<div class="form-group">
				<label for="" class="col-sm-3 control-label"><?php _e('Experience Latter heding','hr_mgt');?> </label>
				<div class="col-md-8">
					<input class="form-control validate[required]" name="hrmgt_exprience_latter_heading" id="event_subject" placeholder="Enter email subject" value="<?php print get_option('hrmgt_exprience_latter_heading'); ?>">
				</div>
			</div>
			
			<div class="form-group">
				<label for="" class="col-sm-3 control-label"><?php _e('Experience Subject','hr_mgt');?></label>
				<div class="col-md-8">
					<input class="form-control validate[required]" name="hrmgt_exprience_latter_subject" id="event_subject" placeholder="" value="<?php print get_option('hrmgt_exprience_latter_subject'); ?>">
				</div>
			</div>
			
			<div class="form-group">
				<label for="" class="col-sm-3 control-label"><?php _e('Experience Latter To','hr_mgt');?> </label>
				<div class="col-md-8">
					<input class="form-control validate[required]" name="hrmgt_exprience_latter_to" id="event_subject" placeholder="" value="<?php print get_option('hrmgt_exprience_latter_to'); ?>">
				</div>
			</div>
			
			
			
			<div class="form-group">
				<label for="" class="col-sm-3 control-label"><?php _e('Cartificate content','hr_mgt'); ?>  </label>
				<div class="col-md-8">
					<textarea style="min-height:200px" name="hrmgt_exprience_latter_content" class="form-control validate[required]"><?php print get_option('hrmgt_exprience_latter_content'); ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-md-8">
					<label><?php _e('You can use following variables in the email template:','hr_mgt');?></label><br>
					<label><strong><?php _e('{{employee_name}} -','hr_mgt')?> </strong><?php _e('employee name','hr_mgt');?></label><br>
					<label><strong><?php _e('{{system_name}} -','hr_mgt');?> </strong><?php _e('System Name','hr_mgt'); ?></label><br>
					<label><strong><?php _e('{{join_date}} - ','hr_mgt');?></strong><?php _e('Join date','hr_mgt'); ?></label><br>
					<label><strong><?php _e('{{leave_date}} - ','hr_mgt');?></strong><?php _e('contract end date','hr_mgt'); ?></label><br>
					
				</div>
			</div>
			<div class="col-sm-offset-3 col-sm-8">        	
				<input value="Save" name="exprience_template" class="btn btn-success" type="submit">
			</div>
		</form>		
      </div>
    </div>
  </div>
</div>
	</div>
</div>
</div>
</div>
</div>
