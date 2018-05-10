<script type="text/javascript">
$(document).ready(function() {
	jQuery('#policy_list').DataTable({
		"responsive": true,
		"order": [[ 0, "asc" ]],
		"aoColumns":[
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": true},
			<?php if($role=="manager"){ ?>
				{"bSortable": true},
			<?php } ?>
			
			{"bSortable": false}]
		});
} );
</script>
    <form name="activity_form" action="" method="post">
		<div class="panel-body">
        	<div class="table-responsive">
        <table id="policy_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			   <th><?php _e( 'Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Policy Type', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'Status', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Description', 'hr_mgt' ) ;?></th>
			  <?php if($role=="manager"){ ?>
				<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
			  <?php }   ?>
             
            </tr>
        </thead>
		<tfoot>
            <tr>
			  <th><?php _e( 'Title', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Policy Type', 'hr_mgt' ) ;?></th>
			   <th><?php _e( 'Status', 'hr_mgt' ) ;?></th>
			  <th><?php _e( 'Description', 'hr_mgt' ) ;?></th>
             <?php if($role=="manager"){ ?>
				<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
			  <?php }   ?>
            </tr>
           
        </tfoot>
 
        <tbody>
         <?php 
			$policydata=$obj_policy->get_all_polices();
		 if(!empty($policydata))
		 {
		 	foreach ($policydata as $retrieved_data){ ?>
            <tr>
				<?php if($role=="manager"){ ?>
					<td class="title"><a href="?hr-dashboard=user&page=genral&tab=add_policy&action=edit&policy_id=<?php echo $retrieved_data->id;?>"><?php echo $retrieved_data->policy_title;?></a></td>
				<?php }else { ?> 
					<td class="title"><?php echo $retrieved_data->policy_title;?></td>
				<?php } ?>
				
				<td class="policy type"><?php echo get_the_title($retrieved_data->policy_type_id);?></td>
				<td class="status"><?php if($retrieved_data->status==1) _e('Active','hr_mgt'); else _e('Deactive','hr_mgt');?></td>
				<td class="description"><?php echo wp_trim_words($retrieved_data->description,3,'...');?></td>
				<td class="action">
				<?php if($role=="manager"){ ?> 
					<a href="?hr-dashboard=user&page=genral&tab=add_policy&action=edit&policy_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
					 <a href="?hr-dashboard=user&page=genral&tab=policy_list&action=delete&policy_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
					onclick="return confirm('<?php _e('Are you sure you want to delete this record?','hr_mgt');?>');">
					<?php _e( 'Delete', 'hr_mgt' ) ;?> </a>
				<?php }?>
				
                 </td>
             </tr>
            <?php } 
			
		} ?>
		</tbody>
        </table>
        </div>
        </div>
</form>