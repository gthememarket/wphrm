<?php 
$active_tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'travel_list';
$obj_travel = new HrmgtTravel();
$role=hrmgt_get_user_role(get_current_user_id() );

if(isset($_POST['save_travel']))
{
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
	{
		$result=$obj_travel->hrmgt_add_travel($_POST);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=travel&tab=travel_list&message=2');
		}
	}
	else
	{			
		$result=$obj_travel->hrmgt_add_travel($_POST);
		if($result)
		{
			wp_redirect ('?hr-dashboard=user&page=travel&tab=travel_list&message=1');
		}
	}
}
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{
	$result=$obj_travel->hrmgt_delete_travel($_REQUEST['travel_id']);
	if($result)
	{
		wp_redirect ('?hr-dashboard=user&page=travel&tab=travel_list&message=3');
	}
}
if(isset($_REQUEST['message']))
{
	$message =$_REQUEST['message'];
	if($message == 1)
	{ ?>
		<div id="message" class="updated below-h2 msg ">
			<p><?php _e('Travel inserted successfully','hr_mgt');?></p>
		</div>
		<?php 			
	}
	elseif($message == 2)
	{ ?>
		<div id="message" class="updated below-h2 msg ">
			<p><?php _e("Travel updated successfully.",'hr_mgt');?></p>
		</div>
	<?php 
	}
	elseif($message == 3) 
	{ ?>
		<div id="message" class="updated below-h2 msg "><p>
			<?php _e('Travel deleted successfully','hr_mgt');?></div></p>
	<?php
	}
}
?>
 <script type="text/javascript">
$(document).ready(function() {
	jQuery('#travel_list').DataTable({
		"responsive": true,
	});
} );
</script>


<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list"></div>
		</div>
    </div> 
</div>
<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist">	  
	  	<li class="<?php if($active_tab=='travel_list'){?>active<?php }?>">
			<a href="?hr-dashboard=user&page=travel&tab=travel_list" class="tab <?php echo $active_tab == 'travel_list' ? 'active' : ''; ?>">
             <i class="fa fa-align-justify"></i> <?php _e('Travel List', 'hr_mgt'); ?></a>
          </a>
		</li>
		<?php if($role=="manager"){ ?>
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action']=="edit"){ ?>
		<li class="<?php if($active_tab=='add_travel'){?>active<?php }?>">
				<a href="?hr-dashboard=user&page=travel&tab=add_travel" class="tab <?php echo $active_tab == 'add_travel' ? 'active' : ''; ?>">
				 <?php _e('Edit Travel', 'hr_mgt'); ?></a>
          </a>
		</li>	
		<?php } else { ?>
		<li class="<?php if($active_tab=='add_travel'){?>active<?php }?>">
				<a href="?hr-dashboard=user&page=travel&tab=add_travel" class="tab <?php echo $active_tab == 'add_travel' ? 'active' : ''; ?>">
				<i class="fa fa-plus-circle"></i> <?php _e('Add Travel', 'hr_mgt'); ?></a>
          </a>
		</li>			
		<?php } } ?>
	 
</ul>

	<div class="tab-content">
    	<?php if($active_tab == 'travel_list')
		{ ?>
		<div class="panel-body">
		<form name="activity_form" action="" method="post">
    
        <div class="">
        	<div class="table-responsive">
        <table id="travel_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Employee', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Travel Purpose', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Travel Start Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Travel End Date', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Description', 'hr_mgt' ) ;?></th>
			 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			  <th><?php _e( 'Employee', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Travel Purpose', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Travel Start Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Travel End Date', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Description', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
           
        </tfoot>
 
        <tbody>
         <?php 
		 if($role=="manager"){
			 $traveldata=$obj_travel->get_all_travels();
		 }
		 else{
			$id=get_current_user_id();
			$traveldata=$obj_travel->get_user_travels($id);
		 }
		 if(!empty($traveldata))
		 {
		 	foreach ($traveldata as $retrieved_data){ ?>
            <tr>
			<?php if($role=="manager"){ ?>
				<td class="title"><a href="?hr-dashboard=user&page=travel&tab=add_travel&action=edit&travel_id=<?php echo $retrieved_data->id?>" ><?php echo hrmgt_get_display_name($retrieved_data->employee_id);?></a></td>
			<?php } else{ ?>
				<td class="title"><?php echo hrmgt_get_display_name($retrieved_data->employee_id);?></td>
			<?php } ?>
				
				<td class="purpose"><?php echo wp_trim_words($retrieved_data->visit_purpose,4,'...');?></td>
				<td class="start"><?php echo hrmgt_change_dateformat($retrieved_data->start_date);?></td>
				<td class="end"><?php echo hrmgt_change_dateformat($retrieved_data->end_date);?></td>
				<td class="description"><?php echo wp_trim_words($retrieved_data->description,3,'...');?></td>
				<td class="action">
					<a href="#" class="btn btn-primary view-travel" id="<?php print $retrieved_data->id ?>"> <?php _e('View','hr_mgt'); ?></a>
					<?php if($role=="manager"){ ?> 
						<a href="?hr-dashboard=user&page=travel&tab=add_travel&action=edit&travel_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
						<a href="?hr-dashboard=user&page=travel&tab=travel_list&action=delete&travel_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
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
        </div>
</form>
        </div>
        </div>
		<?php } ?>	
<?php
if($active_tab=="add_travel"){ ?>
<?php ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#perfomance_form').validationEngine();
	$('#start_date').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
	    changeYear: true,
	    yearRange:'-65:+0',
		onChangeMonthYear: function(year, month, inst) {
	        $(this).val(month + "/" + year);
	    },
		onSelect: function(selected) {
			$("#end_date").datepicker("option","minDate", selected)
		}
    }); 
	$('#end_date').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
	    changeYear: true,
	    yearRange:'-65:+0',
	    onChangeMonthYear: function(year, month, inst) {
	        $(this).val(month + "/" + year);
	    },
		onSelect: function(selected) {
			$("#start_date").datepicker("option","maxDate", selected)
		}
    }); 
});
</script>
     <?php 	                                 
			$travel_id=0;
			if(isset($_REQUEST['travel_id']))
				$travel_id=$_REQUEST['travel_id'];
			$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit'){
					$edit=1;
					$result = $obj_travel->hrmgt_get_single_travel($travel_id);
				} ?>
		<div class="panel-body">
        <form name="perfomance_form" action="" method="post" class="form-horizontal" id="perfomance_form">
         <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input id="action" type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="travel_id" value="<?php echo $travel_id;?>"  />
		<div class="header">	
			<h3><?php _e('Travel Information','hr_mgt');?></h3>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="employee_id"><?php _e('Employee','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<select class="form-control validate[required]" name="employee_id">
				<option value=""><?php _e('Select Employee','hr_mgt');?></option>
				<?php 
				if($edit)
					$employee =$result->employee_id;
				elseif(isset($_REQUEST['employee_id']))
					$employee =$_REQUEST['employee_id'];  
				else 
					$employee = "";
					$employeedata = hrmgt_get_working_user('employee');
					if(!empty($employeedata))
					{
						foreach ($employeedata as $retrive_data){ 
							echo '<option value="'.$retrive_data->ID.'" '.selected($employee,$retrive_data->ID).'>'.$retrive_data->display_name.'</option>';
					}
				} ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="holiday_title"><?php _e('Purpose To Visit','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="title" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo $result->visit_purpose;}elseif(isset($_POST['visit_purpose'])) echo $_POST['visit_purpose'];?>" name="visit_purpose">
			</div>
		</div>
		<div class="header">	
			<h3><?php _e('Travel Dates','hr_mgt');?></h3>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="start_date"><?php _e('Start Date','hr_mgt');?><span class="require-field">*</span>	</label>
			<div class="col-sm-8">
				<input id="start_date" class="form-control validate[required] text-input" type="text"  value="<?php if($edit){ echo date("Y-m-d",strtotime($result->start_date));}elseif(isset($_POST['start_date'])) echo $_POST['start_date'];?>" name="start_date">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="end_date"><?php _e('End Date','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="end_date" class="form-control text-input" type="text"  value="<?php if($edit){ echo date("Y-m-d",strtotime($result->end_date)); } elseif(isset($_POST['end_date'])) echo $_POST['end_date'];?>" name="end_date">
			</div>
		</div>
		<div class="header">	
			<h3><?php _e('Travel Budget','hr_mgt');?></h3>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="expected_budget"><?php _e('Expected Travel Budget','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="expected_budget" class="form-control text-input" type="text"  value="<?php if($edit){ echo $result->expected_budget;}elseif(isset($_POST['expected_budget'])) echo $_POST['expected_budget'];?>" name="expected_budget">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="actual_budget"><?php _e('Actual Travel Budget','hr_mgt');?></label>
			<div class="col-sm-8">
				<input id="actual_budget" class="form-control text-input" type="text"  value="<?php if($edit){ echo $result->actual_budget;}elseif(isset($_POST['actual_budget'])) echo $_POST['actual_budget'];?>" name="actual_budget">
			</div>
		</div>
		<div class="header">	
			<h3><?php _e('Travel Destinations','hr_mgt');?></h3>
		</div>
		<?php 
			
			if($edit){
				$after_travel_destination_entry=json_decode($result->destination_data);
			}
			else
			{
				if(isset($_POST['travel_destination_entry'])){
					
					$all_data=$obj_travel->get_travel_destination_entry_records($_POST);
					$after_travel_destination_entry=json_decode($all_data);
				}
				
					
			}
			if(!empty($after_travel_destination_entry))
			{
					foreach($after_travel_destination_entry as $entry){
					?>
					<div id="travel_destination_entry">
						<div class="form-group">
						<label class="col-sm-2 control-label" for="travel_destination_entry"><?php _e('Travel Destination','hr_mgt');?></label>
						
						<div class="col-sm-4">
							<input id="travel_destination_entry" class="form-control text-input" type="text" value="<?php echo $entry->entry;?>" name="travel_destination_entry[]">
						</div>
						<div class="col-sm-2">
							<select name="travel_mode[]" class="form-control">
							<option value=""><?php echo __('Select Travel Mode','hr_mgt');?></option>
							<?php foreach(hrmgt_travel_destinations() as $destination){ ?>
							<option value="<?php echo $destination;?>"  <?php selected($destination,$entry->mode);?>><?php echo $destination;?></option>
							<?php } ?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="arrange_type[]" class="form-control">
							<?php foreach(hrmgt_arrangement_type() as $arrangement){ ?>
							<option value="<?php echo $arrangement;?>" <?php selected($arrangement,$entry->arrange_type);?>><?php echo $arrangement;?></option>
							<?php } ?>
							</select>
						</div>		
						<div class="col-sm-2">
							<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
							<i class="entypo-trash"><?php _e('Delete','hr_mgt');?></i>
						</button>
						</div>
						</div>	
					</div>
					<?php }
				
			}
			else
			{ ?>
					<div id="travel_destination_entry">
						<div class="form-group">
						<label class="col-sm-2 control-label" for="Destination"><?php _e('Travel Destination','hr_mgt');?></label>
						
						<div class="col-sm-4">
							<input id="travel_destination_entry" class="form-control text-input" type="text" value="" name="travel_destination_entry[]" placeholder="Place Of Visit">
						</div>
					
						<div class="col-sm-2">
							<select name="travel_mode[]" class="form-control">
							<?php foreach(hrmgt_travel_destinations() as $destination){ ?>
							<option value="<?php echo $destination;?>"><?php echo $destination;?></option>
							<?php } ?>
							</select>
							
						</div>						
						<div class="col-sm-2">
							<select name="arrange_type[]" class="form-control">
							<?php foreach(hrmgt_arrangement_type() as $arrangement){ ?>
							<option value="<?php echo $arrangement;?>"><?php echo $arrangement;?></option>
							<?php } ?>
							</select>
						</div>						
						<div class="col-sm-2">
						<button type="button" class="btn btn-default" onclick="deleteParentElement(this)">
						<i class="entypo-trash"><?php _e('Delete','hr_mgt');?></i>
						</button>
						</div>
						</div>	
					</div>
					
		<?php } ?>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="income_entry"></label>
			<div class="col-sm-3">
				<button id="add_new_routin_checkup_entry" class="btn btn-default btn-sm btn-icon icon-left" type="button"   name="add_new_entry" onclick="add_routin_entry()"><?php _e('Add New','hr_mgt'); ?>
				</button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="description"><?php _e('Description','hr_mgt');?></label>
			<div class="col-sm-8">
				<textarea id="description" class="form-control" name="description"><?php if($edit){echo $result->description; }elseif(isset($_POST['description'])) echo $_POST['description']; ?> </textarea>
			</div>
		</div>
		<div class="col-sm-offset-2 col-sm-8">
        	<input type="submit" value="<?php if($edit){ _e('Save','hr_mgt'); }else{ _e('Add Travel','hr_mgt');}?>" name="save_travel" class="btn btn-success"/>
        </div>
		</form>
</div>
<script>
var blank_travel_destination_entry ='';
   	$(document).ready(function() { 
   		blank_travel_destination_entry = $('#travel_destination_entry').html();   		
   	}); 
   	function add_routin_entry()
   	{
   		$("#travel_destination_entry").append(blank_travel_destination_entry);   		
   	}
   	
   	function deleteParentElement(n){
   		n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
   	}
</script>  
<?php } ?>
</div>