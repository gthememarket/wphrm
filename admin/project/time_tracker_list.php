<script type="text/javascript">
$(document).ready(function() {
	jQuery('#task_list').DataTable({
		"bProcessing": true,
				 "bServerSide": true,
				 "sAjaxSource": ajaxurl+'?action=datatable_Project_tast_timelist_ajax_to_load',
				 "bDeferRender": true,
		});
} );
</script>
    <form name="activity_form" action="" method="post">
		<div class="panel-body">
        	<div class="table-responsive">
        <table id="task_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Work Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Employee', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Project Name', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Working Date', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Task Start Time', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Task End Time', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Status', 'hr_mgt' ) ;?></th>
			  <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			<th><?php _e( 'Work Title', 'hr_mgt' ) ;?></th>
			 <th><?php _e( 'Employee', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Project Name ', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Working Date', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Task Start Time', 'hr_mgt' ) ;?></th>
              <th><?php _e( 'Task End Time', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Status', 'hr_mgt' ) ;?></th>
			<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
         </tfoot>
   </table>
        </div>
        </div>
</form>