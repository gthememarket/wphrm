<div class="faq-popup-bg">
    <div class="overlay-content">
   <div class="faq-content"></div>    
    </div> 
</div>	
<script type="text/javascript">
$(document).ready(function() {
	jQuery('#FAQ_list').DataTable({
		"responsive": true,
		"order": [[ 0, "asc" ]],
		"aoColumns":[
		  {"bSortable": true},
		  {"bSortable": true},
		  {"bSortable": false}]
		});
} );
</script>

    <form name="activity_form" action="" method="post">
		<div class="panel-body">
        	<div class="table-responsive">
        <table id="FAQ_list" class="display" cellspacing="0" width="100%">
        	 <thead>
            <tr>
			  <th><?php _e('Title', 'hr_mgt') ;?></th>
			  <th><?php _e('Description', 'hr_mgt') ;?></th>
             <th><?php  _e('Action', 'hr_mgt') ;?></th>
            </tr>
        </thead>
		<tfoot>
            <tr>
			  <th><?php _e('Title', 'hr_mgt' );?></th>
			  <th><?php _e('Description', 'hr_mgt') ;?></th>
             <th><?php  _e( 'Action', 'hr_mgt');?></th>
            </tr>
        </tfoot>
		<tbody>
         <?php 
			$faqdata=$obj_policy->get_all_faq();
		 if(!empty($faqdata))
		 {
		 	foreach ($faqdata as $retrieved_data){ ?>
            <tr>
			
			<?php if($role=="manager"){ ?>
				<td class="title"><a href="?hr-dashboard=user&page=genral&tab=add_FAQ&action=edit&FAQ_id=<?php echo $retrieved_data->id;?>"><?php echo $retrieved_data->title;?></a></td>
			<?php }else { ?> 
				<td class="title"><?php echo $retrieved_data->title;?></td>
			<?php } ?>
			
				
				<td class="description"><?php echo wp_trim_words($retrieved_data->description,3,'...');?></td>
				<td class="action">
				<a href="#" class="btn btn-primary view-faq" id="<?php echo $retrieved_data->id;?>"> <?php _e('View','apartment_mgt');?></a>
					<?php if($role=="manager"){ ?> .
						<a href="?hr-dashboard=user&page=genral&tab=add_FAQ&action=edit&FAQ_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
						<a href="?hr-dashboard=user&page=genral&tab=FAQ_list&action=delete&FAQ_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
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