<div id="main-wrapper">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-white">
    
 <script type="text/javascript">
$(document).ready(function() {
jQuery('#holiday_list').DataTable({
	"responsive": true,
	"order": [[ 0, "asc" ]],
	"aoColumns":[				 
	  {"bSortable": true},
	  {"bSortable": true},
	  {"bSortable": true},
	  {"bSortable": true},	                 
	  {"bSortable": false}]
	});
	jQuery('#year').datepicker({
		changeMonth: false,
		dateFormat: 'yy',
		changeYear: true,
		yearRange:'-10:+10',
	});
} );
</script>
    <form name="leave_filter" action="" class="form-inline" method="post">
		<div class="form-group">
			<label class="col-sm-5 control-label" for="start_date"><?php _e('Holiday Start Date','hr_mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-7">
				<input id="year" class="form-control validate[required]" type="text"  name="year" 
				value="<?php print isset($_POST['year'])?$_POST['year']:date('Y'); ?>">
			</div>
		</div>
		<input type="submit" name="holiday_filter" value="<?php _e('Get Holiday','hr_mgt') ?>" class="btn btn-info">
	</form><br><br>
	<?php
		$year = date("Y");
		if(isset($_POST['holiday_filter']))
		{
			$year = $_POST['year'];
		}
	?>	
   	<div class="table-responsive">
        <table id="holiday_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Holiday Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Holiday Start Date', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Holiday End Date', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Description', 'hr_mgt' ) ;?></th>
			 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			 <th><?php _e( 'Holiday Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Holiday Start Date', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Holiday End Date', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Description', 'hr_mgt' ) ;?></th>
			 <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
           
        </tfoot>
 
        <tbody>
         <?php 
			$attendancedata=$obj_holiday->get_all_holidays($year);
			
		 if(!empty($attendancedata))
		 {
		 	foreach ($attendancedata as $retrieved_data){ ?>
            <tr>
				<td class="Employee"><a href="?page=hrmgt-general_settings&tab=add_holiday&action=edit&holiday_id=<?php echo $retrieved_data->id;?>"><?php echo $retrieved_data->holiday_title;?></a></td>
				<td class="start date"><?php echo hrmgt_change_dateformat($retrieved_data->start_date);?></td>
				<td class="end date"><?php echo hrmgt_change_dateformat($retrieved_data->end_date);?></td>
				<td class="reason"><?php echo wp_trim_words($retrieved_data->description,3,'...');?></td>
				<td class="action">		
					<a href="#" class="view-holiday btn btn-primary" id="<?php print $retrieved_data->id; ?>"><?php _e('View','hr_mgt'); ?></a>
              	<a href="?page=hrmgt-general_settings&tab=add_holiday&action=edit&holiday_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
                <a href="?page=hrmgt-general_settings&tab=holiday_list&action=delete&holiday_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
                onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
                <?php _e( 'Delete', 'hr_mgt' ) ;?> </a>
                 </td>
             </tr>
            <?php } 
			
		} ?>
		</tbody>
        </table>
    </div>       
</div>			
	</div>
	</div>
</div>
