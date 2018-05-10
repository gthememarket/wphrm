<script type="text/javascript">
$(document).ready(function() {
	jQuery('#file_list').DataTable({
		"order": [[ 0, "asc" ]],
		"responsive": true,
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
        <table id="file_list" class="display" cellspacing="0" width="100%">
        	<thead>
				<tr>
					<th><?php _e( 'Title', 'hr_mgt' ) ;?></th>
					<th><?php _e( 'Description', 'hr_mgt' ) ;?></th>
					<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
				</tr>
			</thead>
		<tfoot>
            <tr>
				<th><?php _e( 'Title', 'hr_mgt' ) ;?></th>
				<th><?php _e( 'Description', 'hr_mgt' ) ;?></th>
				<th><?php  _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>           
        </tfoot> 
        <tbody>
         <?php 	
		if($role=="manager"){ 
			$filesdata=$obj_file->get_all_files($role);	
		}else{			
			$filesdatas=$obj_file->get_role_wise_all_files($role);			
			if(!empty($filesdatas)){
				foreach($filesdatas as $key=>$val){
					$filesdata[]= $obj_file->hrmgt_get_single_file($val->file_id);					
				}
			}		
		}			
		 if(!empty($filesdata)){
		 	foreach ($filesdata as $retrieved_data){ ?>
            <tr>
				<?php if($role=="manager"){ ?>
					<td class="title"><a href="?hr-dashboard=user&page=genral&tab=add_file&action=edit&file_id=<?php echo $retrieved_data->id;?>"><?php echo $retrieved_data->title;?></a></td>
				<?php } else{?> 
				<td class="title"><?php echo $retrieved_data->title;?></td>
				<?php }  ?>
					
				<td class="description"><?php echo wp_trim_words($retrieved_data->description,3,'...');?></td>
				<td class="action">
				<?php if(isset($retrieved_data->file) && $retrieved_data->file!=""){?>
				<a href="<?php echo content_url().'/uploads/hr_assets/'.$retrieved_data->file;?>" class="btn btn-default"><i class="fa fa-eye"></i> <?php _e('View','hr_mgt');?></a>
				<?php } ?>
				<?php if($role=="manager"){ ?> 
					<a href="?hr-dashboard=user&page=genral&tab=add_file&action=edit&file_id=<?php echo $retrieved_data->id?>" class="btn btn-info"> <?php _e('Edit', 'hr_mgt' ) ;?></a>
                <a href="?hr-dashboard=user&page=genral&tab=form_list&action=delete&file_id=<?php echo $retrieved_data->id;?>" class="btn btn-danger" 
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