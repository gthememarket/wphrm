<?php $obj_requirement = new HrmgtRequirements(); ?>	
<script type="text/javascript">
$(document).ready(function() {
	$('#sortlist_candidate').validationEngine();
	jQuery('#candidate_list').DataTable({
		"responsive": true,
		"order": [[ 0, "asc" ]],
		"aoColumns":[
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": false}]
		});
});
</script> 

<div class="panel-body">
	<div class="table-responsive">
		<form id="sortlist_candidate" name="sortlist_candidate" action="" method="post">
	<div class="form-group col-md-3">
		<label for="class_id"><?php _e('Select Job','hr_mgt');?><span class="require-field">*</span></label>
		<select name="sub_id"   class="form-control show_criere validate[required]">
			<option value=" "><?php _e('Select Job','hr_mgt');?></option>
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
		<select name="crierearea"  class="form-control shortlist validate[required] ">
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
 
			<tbody>
			 <?php 
			if(isset($_POST['view_shortlist']))
			{
				$candidatesdata = $obj_requirement->hrmgt_crierearea_condidate($_POST);
			}
			else
			{
				$candidatesdata=$obj_requirements->get_all_candidates();
			}
			if(!empty($candidatesdata))
			{
				foreach ($candidatesdata as $retrieved_data){ ?>
				<tr>
					<td class="candidate"><a href="?hr-dashboard=user&page=requirements&tab=add_candidate&action=edit&candidate_id=<?php echo $retrieved_data->id;?>"><?php echo $retrieved_data->first_name." ".$retrieved_data->last_name;?></a></td>
					<td class="email"><?php echo $retrieved_data->email;?></td>
					<td class="jobtitle"><?php echo hrmgt_get_job_title($retrieved_data->job_id);?></td>
					<td class="mobile"><?php echo $retrieved_data->mobile;?></td>
					<td class="status"><?php echo $retrieved_data->crierearea;?></td>
					<td class="action">
					<?php if(isset($retrieved_data->bio_data) && $retrieved_data->bio_data!=""){?>
					<a href="<?php echo content_url().'/uploads/hr_assets/'.$retrieved_data->bio_data;?>" class="btn btn-default"><i class="fa fa-download"></i> <?php _e('Curriculum','hr_mgt');?></a>
					<?php } ?>
					<a href="?hr-dashboard=user&page=requirements&tab=add_candidate&action=edit&candidate_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
					<a href="?hr-dashboard=user&page=requirements&tab=candidate_list&action=delete&candidate_id	=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
					onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
					<?php _e( 'Delete', 'hr_mgt' ) ;?> </a>
					 </td>
				 </tr>
				<?php } 			
			} ?>
			</tbody>
        </table>
		</form>
    </div>
</div>