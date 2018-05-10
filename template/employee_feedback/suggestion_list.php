<div class="popup-bg">
    <div class="overlay-content">
   <div class="category_list"></div>    
    </div> 
</div>
<div class="panel panel-white">	
<?php if($active_tab == 'suggection_list'){ ?>	
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#suggestion_list').DataTable({
		"order": [[ 0, "asc" ]],
		"responsive": true,
		"aoColumns":[
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": false}]
	});
} );
</script>
    <form name="activity_form" action="" method="post">    
        <div class="panel-body">
        	<div class="table-responsive">
        <table id="suggestion_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e( 'Suggestion Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Suggestion From', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Suggestion Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Suggestion', 'hr_mgt' ) ;?></th>
             <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			  <th><?php _e( 'Suggestion Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Suggestion From', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Suggestion Date', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Suggestion', 'hr_mgt' ) ;?></th>
             <th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
         </tfoot>
		<tbody>
         <?php 
		$suggestiondata=$obj_suggestion->get_all_suggestion();			
		 if(!empty($suggestiondata)){
		 	foreach ($suggestiondata as $retrieved_data){ ?>
            <tr>				
				<td class="title"><a href="?hr-dashboard=user&page=employee_feedback&tab=add_suggection&action=edit&suggestion_id=<?php echo $retrieved_data->id;?>"><?php echo $retrieved_data->suggetion_title;?></a></td>
				<td class="emp"><?php echo  hrmgt_get_display_name($retrieved_data->employee_id);?></td>
				<td class="date"><?php echo hrmgt_change_dateformat($retrieved_data->suggestion_date);?></td>
				<td class="description"><?php echo wp_trim_words($retrieved_data->suggestion,3,'...');?></td>
				<td class="action">
				<a href="#" class="btn btn-primary view-suggestion" id="<?php echo $retrieved_data->id;?>"> <?php _e('View','apartment_mgt');?></a>
				<a href="?hr-dashboard=user&page=employee_feedback&tab=add_suggection&action=edit&suggestion_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
                <a href="?hr-dashboard=user&page=employee_feedback&tab=suggestion_list&action=delete&suggestion_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
                onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
                <?php _e( 'Delete', 'hr_mgt' ) ;?> </a>
                 </td>
             </tr>
            <?php } } ?>
		</tbody>
        </table>
        </div>
        </div>
</form>
<?php  }?>
</div>