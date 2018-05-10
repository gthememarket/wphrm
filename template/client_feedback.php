<?php 
$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'cf_list';
$role=hrmgt_get_user_role(get_current_user_id() );
$obj_feedback=new HrmgtCientFeedBack;
?>
 <script type="text/javascript">
$(document).ready(function() {
	jQuery('#cf_list').DataTable({
		"responsive": true,
	});	
} );
</script>

<script type="text/javascript">
$(document).ready(function() {
	$('#start_date').datepicker({dateFormat: "yy-mm-dd"}); 
	
});
</script>
<?php 
	if(isset($_POST['save_cf'])){		
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit'){				
			$result=$obj_feedback->hrmgt_add_client_feedback($_POST);
			if($result){
				wp_redirect ('?hr-dashboard=user&page=client_feedback&tab=cf_list&message=2');
			}
		}
		else{				
			$result = $obj_feedback->hrmgt_add_client_feedback($_POST);			
			if($result){				
				wp_redirect ( '?hr-dashboard=user&page=client_feedback&tab=cf_list&message=1');
			}
		}
	}
	
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete'){
	$result=$obj_feedback->hrmgt_delete_cf($_REQUEST['cf_id']);
	if($result)	{
		wp_redirect ('?hr-dashboard=user&page=client_feedback&tab=cf_list&message=3');
	}
}	

if(isset($_REQUEST['message']))	{	
	$message =$_REQUEST['message'];
	if($message =="1"){ ?>
		<div id="message" class="updated below-h2 msg "><p>	<?php _e('Client Feedback insert successfully','hr_mgt');?></p></div>
	<?php } if($message == "2"){ ?>
		<div id="message" class="updated below-h2 msg"><p><?php _e("Client Feedback update successfully.",'hr_mgt');?></p></div>
	<?php }	if($message=="3"){ ?>
		<div id="message" class="updated below-h2 msg"><p><?php _e("Client Feedback Delete successfully.",'hr_mgt');?></p></div>
	<?php } } ?>

<div class="popup-bg" style="display: none; height: 1251px;">
	<div class="overlay-content">
	<div class="category_list"></div>    
	</div> 
</div>

<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist">
 
	  	<li class="<?php if($active_tab=='cf_list'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=client_feedback&tab=cf_list" class="tab <?php echo $active_tab == 'cf_list' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Client Feedback List', 'hr_mgt'); ?></a>
          </a>
		</li>
		
		<?php
		if($role=="manager"){
		if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit" && $active_tab=="add_cf"){ ?>
		<li class="<?php if($active_tab=='add_cf'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=client_feedback&tab=add_cf&action=edit&cf_id=<?php print $_REQUEST['cf_id'] ?>" class="tab <?php echo $active_tab == 'add_cf' ? 'active' : ''; ?>">
              <?php _e('Edit Client Feedback', 'hr_mgt'); ?></a>
          </a>
		</li>	
		<?php } else { ?>
		<li class="<?php if($active_tab=='add_cf'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=client_feedback&tab=add_cf" class="tab <?php echo $active_tab == 'add_cf' ? 'active' : ''; ?>">
             <i class="fa fa-plus-circle" aria-hidden="true"></i> <?php _e('Add Client Feedback', 'hr_mgt'); ?></a>
          </a>
		</li>			
			<?php } } ?>
 
</ul>

	<div class="tab-content">
    	<?php if($active_tab == 'cf_list')
		{ ?>
		<div class="panel-body">
		<form name="activity_form" action="" method="post">       
        	<div class="table-responsive">
        <table id="cf_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Client  Name', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Project  Name', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Comment', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Ratting', 'hr_mgt' ) ;?></th>              
			 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			  <th><?php _e( 'Client  Name', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Project  Name', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Comment', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Ratting', 'hr_mgt' ) ;?></th>   
			 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
           
        </tfoot>
 
        <tbody>
         <?php 
			$feedback=$obj_feedback->get_all_client_feedback();	
				
		 if(!empty($feedback)){

		 	foreach ($feedback as $retrieved_data){ ?>		
            <tr>
				<?php if($role=="manager"){ ?>
					<td><a href="?hr-dashboard=user&page=client_feedback&tab=add_cf&action=edit&cf_id=<?php echo $retrieved_data->id?>"><?php print $retrieved_data->client_name;?></a></td>
				<?php } else{ ?>
					<td><?php print $retrieved_data->client_name;?></td>
				<?php } ?>
				
				
			<td><?php print hrmgt_get_project_title($retrieved_data->project_id); ?></td>				
				<td><?php print $retrieved_data->comment; ?></td>				
				<td> <div id="rateYo_<?php echo $retrieved_data->id;?>"></div>
					<script type="text/javascript">					
						$(function () { 
						$("#rateYo_<?php echo $retrieved_data->id;?>").rateYo({ 
							rating    :<?php print $retrieved_data->rate; ?>,
							readOnly:true,
							 starWidth: "20px"
						}); 
					});
					</script>
					
				</td>
				<td class="action">	
					<a href="#" class="btn btn-primary view-client-feedback" id="<?php  print $retrieved_data->id; ?>"><?php _e('View','hr_mgt'); ?></a>
				<?php if($role=="manager"){ ?>
					<a href="?hr-dashboard=user&page=client_feedback&tab=add_cf&action=edit&cf_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
					<a href="?hr-dashboard=user&page=client_feedback&tab=cf_list&action=delete&cf_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
					onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
					<?php _e( 'Delete', 'hr_mgt' ) ;?> </a>
				<?php } ?>
                 </td>
             </tr>
            <?php } 
			
		} ?>
		</tbody>
        </table>     
        </div>
</form>
        </div>
        </div>
		<?php } ?>	
<?php 
if($active_tab=='add_cf'){

	$complaint_id=0;
			if(isset($_REQUEST['complaint_id']))
				$complaint_id=$_REQUEST['complaint_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;
					$postdata=get_post($complaint_id);
				}
?>

<?php 
$obj_project = new HrmgtProject();
$obj_feedback = new HrmgtCientFeedBack();
	                                 
	$cf_id=0;
	if(isset($_REQUEST['cf_id']))
		$cf_id=$_REQUEST['cf_id'];
		$edit=0;
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
				$edit=1;
				$result = $obj_feedback->hrmgt_get_single_c_feedback($cf_id);
				$employee_project = $obj_feedback->hrmgt_get_cf_employee($cf_id);					
				$employees_id = array();
				foreach($employee_project as $key=>$value){
					$employees_id[] = $value->employee_id;
				}	
			} ?>
			
<script type="text/javascript">

$(document).ready(function() {
	$('#leave_form').validationEngine();
	$('#employees').multiselect();
});


$(function () {
<?php if($edit){ ?>		
$("#rateYo").rateYo({
	rating: <?php print $result->rate ?>
});	

$("#rateYo").rateYo().on("rateyo.change", function (e, data) {
	var rating = data.rating;
	$("#star2_input").val(rating);
})

<?php }else { ?> 
$("#rateYo").rateYo().on("rateyo.change", function (e, data) {
	var rating = data.rating;
	$("#star2_input").val(rating);
});
<?php } ?>	
	
});
</script>



		<div class="panel-body">
        <form name="leave_form" action="" method="post" class="form-horizontal" id="leave_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="cf_id" value="<?php echo $cf_id;?>"  />	
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="note"><?php _e('Client Name','hr_mgt');?></label>
			<div class="col-sm-8">					
				<input type='text'  class='form-control' name='client_name' value="<?php if($edit) print $result->client_name; ?>" id='client_name' />
			</div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="parent_category_category"><?php _e('Project Name','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="project_id" id="project_id">
				<option value=""><?php _e('Select Project','hr_mgt');?></option>
				<?php 
				if($edit)
					$category =$result->project_id;
				elseif(isset($_REQUEST['project_id']))
					$category =$_REQUEST['project_id'];  
				else 
					$category = "";
					$projectdata=$obj_project->get_all_project();
				 if(!empty($projectdata)){
					foreach ($projectdata as $retrive_data){
						echo '<option value="'.$retrive_data->id.'" '.selected($category,$retrive_data->id).'>'.$retrive_data->project_title.'</option>';
					}
				} ?>
				</select>
			</div>		
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_id"><?php _e('Employee','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">	
				<select class="form-control validate[required] employee" id="employees" name="employee_id[]" Multiple>				
				<?php
					if($edit){
					 $employee = "";				
					$employeedata = get_employee_by_project_id($result->project_id);					
					if(!empty($employeedata)){						
						foreach ($employeedata as $key=>$retrive_data){?>
						<option  value="<?php print $retrive_data->employee_id; ?>"	<?php  if ($edit) { if(in_array($retrive_data->employee_id,$employees_id)){ print 'selected="selected"'; } } ?>> <?php print  hrmgt_get_display_name($retrive_data->employee_id); ?></option>
					<?php } } }  ?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="note"><?php _e('comment','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<textarea id="reason" class="form-control validate[required]" name="comment"><?php if($edit){echo $result->comment; }elseif(isset($_POST['comment'])) echo $_POST['comment']; ?> </textarea>
			</div>
		</div>
		
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="note"><?php _e('Ratting','hr_mgt');?></label>
			<div class="col-sm-8">				
				<div id="rateYo"></div>
				<input type='hidden' name='rate' value="<?php if($edit) print $result->rate; ?>" id='star2_input' />
			</div>
		</div>
		
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Client Feedback','hr_mgt');}?>" name="save_cf" class="btn btn-success"/>
        </div>
		</form>
</div>	
<?php 	}  ?>

	</div>
</div>
