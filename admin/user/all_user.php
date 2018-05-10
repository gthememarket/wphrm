<?php

$obj_user=new HrmgtEmployee;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'all_user';

?>
<div class="popup-bg" style="min-height:1631px !important">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list"></div>     
		</div>
    </div>     
</div>
<div class="page-inner" style="margin: 0 -20px -20px; min-height:auto; !important">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-white">
			<div class="panel-body">

<?php if($active_tab == 'all_user'){ ?>	
<script type="text/javascript">
	jQuery(document).ready(function($) {

		 jQuery('#staff_list').DataTable({
			"bProcessing": true,
		 "bServerSide": true,
		 "sAjaxSource": ajaxurl+'?action=datatable_All_user_ajax_to_load',
		 "bDeferRender": true,
			});
	});   
</script>
    <form name="wcwm_report" action="" method="post">
    <div class="panel-body">
        <div class="table-responsive">
			<table id="staff_list" class="display" cellspacing="0" width="100%">
        	 <thead>
				<tr>
				  <th style="width: 50px;height:50px;"><?php  _e( 'Photo', 'hr_mgt' ) ;?></th>
				    <th><?php _e( 'User Name', 'hr_mgt' ) ;?></th>		 
				    <th><?php _e( 'User Code', 'hr_mgt' ) ;?></th>			 
					<th> <?php _e( 'User  Email', 'hr_mgt' ) ;?></th>
					<th> <?php _e( 'User Role', 'hr_mgt' ) ;?></th>					
					<th> <?php _e( 'Action', 'hr_mgt' ) ;?></th>		
				</tr>
			</thead>
		<tfoot>
            <tr>
		   <th><?php  _e( 'Photo', 'hr_mgt' ) ;?></th>
               <th><?php _e( 'User Name', 'hr_mgt' ) ;?></th>		 
               <th><?php _e( 'User Code', 'hr_mgt' ) ;?></th>			 
			   <th> <?php _e( 'User  Email', 'hr_mgt' ) ;?></th>
			   <th> <?php _e( 'User Role', 'hr_mgt' ) ;?></th>
		   <th> <?php _e( 'Action', 'hr_mgt' ) ;?></th>
            </tr>
        </tfoot> 
		<tbody>
		</tbody>
      
        </table>
        </div>
        </div>
       
</form>
     <?php 
	 }
	
	if($active_tab == 'add_accountant')
	 {
		require_once HRMS_PLUGIN_DIR. '/admin/accountant/add_accountant.php';
	 }
	 ?>
</div>			
	</div>
	</div>
</div>
