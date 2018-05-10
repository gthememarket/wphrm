<?php $obj_requirement = new HrmgtRequirements(); ?>	
<script type="text/javascript">
$(document).ready(function() {
	$('#sortlist_candidate').validationEngine();
	var job_title = $('#job_title').val();
	var criteria = $('#crierearea11').val();
	//alert(criteria);
	jQuery('#candidate_list').DataTable({
		"bProcessing": true,
				 "bServerSide": true,
				 "sAjaxSource": ajaxurl+'?action=datatable_job_candidate_ajax_to_load&job_title='+job_title+'&crierearea='+criteria,
				 "bDeferRender": true,
		});
});
</script> 

<div class="panel-body">
	<div class="table-responsive">
		<form id="sortlist_candidate" name="sortlist_candidate" action="" method="post">
	<div class="form-group col-md-3">
		<label for="class_id"><?php _e('Select Job','hr_mgt');?><span class="require-field">*</span></label>
		<select name="sub_id"  id="job_title"  class="form-control show_criere validate[required]">
			<option value="-1"><?php _e('Select Job','hr_mgt');?></option>
			<?php 
				$result = $obj_requirement->get_all_posted_job();
				$sub_id=0;
				if(isset($_POST['sub_id']))
				{
					$sub_id = $_POST['sub_id'];
				}

				foreach($result as $key=>$value){ ?>
					<option id="<?php echo $value->id;?>" <?php selected($sub_id,$value->id); ?> class="" value="<?php echo $value->id;?>"><?php echo $value->job_title;?></option> 
			<?php } ?>							
		</select>		
	</div>
	<div class="form-group col-md-3">
		<label for="class_id"><?php _e('Select Shortlist','hr_mgt');?><span class="require-field">*</span></label>			
		<select name="crierearea" id="crierearea11"  class="form-control shortlist validate[required] ">
			<option value=" "><?php _e('Select Criteria','hr_mgt');?></option>				
			<?php
				$crierearea=0;
				if(isset($_POST['crierearea']))
				{
					$crierearea = $_POST['crierearea'];
				}
				$allsubjects = array();
				foreach($allsubjects as $subjectdata)
				{ ?>
					<option value="<?php echo $subjectdata->subid;?>" <?php selected($crierearea,$subjectdata->subid); ?>><?php echo $subjectdata->sub_name;?></option>
				 <?php } ?>
		</select>		
	</div>
			
	<div class="form-group col-md-3 button-possition">
		<label for="shortlist">&nbsp;</label>
			<input type="submit" name="view_shortlist" Value="<?php _e('Go','hr_mgt');?>"  class="btn btn-info"/>
	</div>
	
        <table id="candidate_list" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th><?php _e( 'Candidate Name', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Email', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Apply for Job', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Mobile', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Criteria', 'hr_mgt' ) ;?></th>
					<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th><?php _e( 'Candidate Name', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Email', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Apply for Job', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Mobile', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Criteria', 'hr_mgt' ) ;?></th>
					<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
				</tr>
			</tfoot>
    </table>
		</form>
    </div>
</div>