<?php 
//add_action( 'wp_ajax_hrmgt_add_profile_exe', 'hrmgt_add_profile_exe');
// Start Datatable Ajax Action Call
add_action('wp_ajax_datatable_All_user_ajax_to_load','datatable_All_user_ajax_to_load');
add_action('wp_ajax_nopriv_datatable_All_user_ajax_to_load','datatable_All_user_ajax_to_load');
add_action('wp_ajax_datatable_All_employee_ajax_to_load','datatable_All_employee_ajax_to_load');
add_action('wp_ajax_nopriv_datatable_All_employee_ajax_to_load','datatable_All_employee_ajax_to_load');
add_action('wp_ajax_datatable_employee_leave_ajax_to_load','datatable_employee_leave_ajax_to_load');
add_action('wp_ajax_datatable_employee_training_ajax_to_load','datatable_employee_training_ajax_to_load');
add_action('wp_ajax_datatable_travelling_ajax_to_load','datatable_travelling_ajax_to_load');
add_action('wp_ajax_datatable_all_hr_list_ajax_to_load','datatable_all_hr_list_ajax_to_load');
add_action('wp_ajax_datatable_all_Accountant_list_ajax_to_load','datatable_all_Accountant_list_ajax_to_load');
add_action('wp_ajax_datatable_Present_attendance_ajax_load','datatable_Present_attendance_ajax_load');
add_action('wp_ajax_datatable_Present_attendance_ajax_load1','datatable_Present_attendance_ajax_load1');
add_action('wp_ajax_datatable_events_ajax_to_load','datatable_events_ajax_to_load');
add_action('wp_ajax_datatable_Perfomance_marks_ajax_to_load','datatable_Perfomance_marks_ajax_to_load');
add_action('wp_ajax_datatable_Project_ajax_to_load','datatable_Project_ajax_to_load');
add_action('wp_ajax_datatable_Project_tast_timelist_ajax_to_load','datatable_Project_tast_timelist_ajax_to_load');
add_action('wp_ajax_datatable_payslip_ajax_to_load','datatable_payslip_ajax_to_load');
add_action('wp_ajax_datatable_payslip_record_ajax_to_load','datatable_payslip_record_ajax_to_load');
add_action('wp_ajax_datatable_campasion_ajax_to_load','datatable_campasion_ajax_to_load');
add_action('wp_ajax_datatable_recruitment_ajax_to_load','datatable_recruitment_ajax_to_load');
add_action('wp_ajax_datatable_job_candidate_ajax_to_load','datatable_job_candidate_ajax_to_load');
add_action('wp_ajax_datatable_employee_feedback_complain_ajax_to_load','datatable_employee_feedback_complain_ajax_to_load');
add_action('wp_ajax_datatable_employee_feedback_suggestion_ajax_to_load','datatable_employee_feedback_suggestion_ajax_to_load');
add_action('wp_ajax_datatable_client_feedback_ajax_to_load','datatable_client_feedback_ajax_to_load');
add_action('wp_ajax_datatable_paid_leave_ajax_to_load','datatable_paid_leave_ajax_to_load');
add_action('wp_ajax_datatable_notic_ajax_to_load','datatable_notic_ajax_to_load');
add_action('wp_ajax_datatable_department_ajax_to_load','datatable_department_ajax_to_load');

// End Datatable Ajax Action Call

//add_action( 'wp_ajax_datatable_ajax_load', 'datatable_ajax_load');
add_action( 'wp_ajax_hrmgt_add_or_remove_category', 'hrmgt_add_or_remove_category');
add_action( 'wp_ajax_hrmgt_add_category', 'hrmgt_add_category');
add_action( 'wp_ajax_nopriv_hrmgt_add_category', 'hrmgt_add_category');
add_action( 'wp_ajax_hrmgt_experience_letter', 'hrmgt_experience_letter');
add_action( 'wp_ajax_hrmgt_remove_category', 'hrmgt_remove_category');
add_action( 'wp_ajax_hrmgt_load_multiple_day', 'hrmgt_load_multiple_day');
add_action( 'wp_ajax_hrmgt_view_faq', 'hrmgt_view_faq');
add_action( 'wp_ajax_hrmgt_view_policy', 'hrmgt_view_policy');
add_action( 'wp_ajax_hrmgt_view_trainee', 'hrmgt_view_trainee');
add_action( 'wp_ajax_hrmgt_view_perfomance_mark', 'hrmgt_view_perfomance_mark');
add_action( 'wp_ajax_hrmgt_view_suggestion', 'hrmgt_view_suggestion');
add_action( 'wp_ajax_hrmgt_view_event', 'hrmgt_view_event');
add_action( 'wp_ajax_hrmgt_view_notice', 'hrmgt_view_notice');
add_action( 'wp_ajax_hrmgt_view_complaint', 'hrmgt_view_complaint');
add_action( 'wp_ajax_hrmgt_view_payslip', 'hrmgt_view_payslip');
add_action( 'wp_ajax_hrmgt_view_project', 'hrmgt_view_project');
add_action( 'wp_ajax_hrmgt_view_client_feedback', 'hrmgt_view_client_feedback');
add_action( 'wp_ajax_hrmgt_view_holiday', 'hrmgt_view_holiday');
add_action( 'wp_ajax_hrmgt_view_tasklist', 'hrmgt_view_tasklist');
add_action( 'wp_ajax_hrmgt_view_requirements', 'hrmgt_view_requirements');
add_action( 'wp_ajax_hrmgt_view_travel', 'hrmgt_view_travel');
add_action( 'wp_ajax_hrmgt_view_employee', 'hrmgt_view_employee');
add_action( 'wp_ajax_hrmgt_view_criere', 'hrmgt_view_criere');
add_action( 'wp_ajax_hrmgt_view_project_employee', 'hrmgt_view_project_employee');
add_action( 'wp_ajax_hrmgt_update_attendance_detail_status', 'hrmgt_update_attendance_detail_status');


add_action( 'wp_ajax_hrmgt_leave_approve', 'hrmgt_leave_approve');
add_action( 'wp_ajax_hrmgt_leave_reject', 'hrmgt_leave_reject');
add_action( 'wp_ajax_hrmgt_delete_earning_deduction', 'hrmgt_delete_earning_deduction');

add_action( 'wp_ajax_hrmgt_custom_payslip_emp', 'hrmgt_custom_payslip_emp');

// Start DataTable Functions
function datatable_department_ajax_to_load()
{
	
	 global $wpdb;
	 $sTable = $wpdb->prefix . 'hrmgt_department';
	 $sUsers = $wpdb->prefix . 'users';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch)
	   {
		   $sQuery = "
		   SELECT *
		   FROM  $sTable INNER JOIN $sUsers ON $sTable.employee_id = $sUsers.ID WHERE display_name LIKE '%$ssearch%' OR year LIKE '%$ssearch%' OR month_1 LIKE '%$ssearch%' OR month_2 LIKE '%$ssearch%' OR month_3 LIKE '%$ssearch%' OR month_4 LIKE '%$ssearch%' OR month_5 LIKE '%$ssearch%' OR month_6 LIKE '%$ssearch%' OR month_7 LIKE '%$ssearch%' OR month_8 LIKE '%$ssearch%' OR month_9 LIKE '%$ssearch%' OR month_10 LIKE '%$ssearch%' OR month_11 LIKE '%$ssearch%' OR month_12 LIKE '%$ssearch%' Group BY employee_id ,employee_id DESC $sLimit"; 
	   }
	   else
	   {
			$sQuery = "SELECT * FROM  $sTable";
	   }
	      $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		  $wpdb->get_results(" SELECT * FROM $sTable"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results(" SELECT * FROM $sTable ");
		  $iTotal = $wpdb->num_rows;
		
  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
 
		 foreach($rResult as $aRow)
		 {
			
			$row[0] = $aRow['department_name'];
			$row[1] = $aRow['dept_head_id'];
			$row[2] = $aRow['parent_department_id'];			
			$row[3] = '<a href="admin.php?page=hrmgt-pl&tab=pl_list&action=delete&pl_id='.$aRow['id'].'" class="btn btn-danger deletealert"> Delete </a>';
			
				$output['aaData'][] = $row;
			
		 }
 echo json_encode( $output );
 die();
	
	
}
function datatable_notic_ajax_to_load()
{
    global $wpdb;
	$sTable = $wpdb->prefix . 'posts';
	$sLimit = "";
	if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	{
	  $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	}
	  $ssearch = $_REQUEST['sSearch'];
	  if($ssearch){
	  $sQuery = "
	   SELECT * FROM $sTable INNER JOIN wp_postmeta ON($sTable.ID = wp_postmeta.post_id) WHERE wp_postmeta.meta_key = 'start_date' 
	   AND wp_postmeta.meta_value LIKE '%$ssearch%' OR wp_postmeta.meta_key = 'end_date' 
	   AND wp_postmeta.meta_value LIKE '%$ssearch%' OR wp_postmeta.meta_key = 'notice_for' 
	   AND wp_postmeta.meta_value LIKE '%$ssearch%' OR post_title LIKE '%$ssearch%' OR post_content LIKE '%$ssearch%' Group BY id , id DESC $sLimit"; 
	   }
	   else
	   {
		$sQuery = "SELECT * FROM `wp_posts` where post_type ='hrmgt_notice' OR post_status ='public'";
	   }
	  $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		 
		   $wpdb->get_results("SELECT * FROM `wp_posts` where post_type ='hrmgt_notice' OR post_status ='public'");		   
		   $iFilteredTotal = $wpdb->num_rows;
		   $wpdb->get_results("SELECT * FROM `wp_posts`");
		   $iTotal = $wpdb->num_rows;

  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
         
		 foreach($rResult as $aRow)
		 {
			$row[0] = $aRow['post_title'];
			$row[1] = $aRow['post_content'];
			$row[2] = hrmgt_change_dateformat(get_post_meta($aRow['ID'],'start_date',true));
			$row[3] = hrmgt_change_dateformat(get_post_meta($aRow['ID'],'end_date',true));
			$row[4] = ucwords(str_replace("_",' ',get_post_meta($aRow['ID'],'notice_for',true)));
			
			$row[5] = '<a href="?page=hrmgt-notice&tab=addnotice&action=edit&notice_id='.$aRow['ID'].'" class="btn btn-info">Edit</a>
					<a href="?page=hrmgt-notice&tab=noticelist&action=delete&notice_id='.$aRow['ID'].'" class="btn btn-danger deletealert" 
					>
					Delete</a>';
			
				$output['aaData'][] = $row;
			
		 }

 echo json_encode( $output );
 die();
}

function datatable_paid_leave_ajax_to_load()
{
     global $wpdb;
	 $sTable = $wpdb->prefix . 'hrmgt_pl_menaegment';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch)
	   {
		   $sQuery = "
		   SELECT *
		   FROM  $sTable INNER JOIN wp_users ON $sTable.employee_id = wp_users.ID WHERE display_name LIKE '%$ssearch%' OR year LIKE '%$ssearch%' OR month_1 LIKE '%$ssearch%' OR month_2 LIKE '%$ssearch%' OR month_3 LIKE '%$ssearch%' OR month_4 LIKE '%$ssearch%' OR month_5 LIKE '%$ssearch%' OR month_6 LIKE '%$ssearch%' OR month_7 LIKE '%$ssearch%' OR month_8 LIKE '%$ssearch%' OR month_9 LIKE '%$ssearch%' OR month_10 LIKE '%$ssearch%' OR month_11 LIKE '%$ssearch%' OR month_12 LIKE '%$ssearch%' Group BY employee_id ,employee_id DESC $sLimit"; 
	   }
	   else
	   {
			$sQuery = "SELECT * FROM $sTable";
	   }
	      $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		  $wpdb->get_results(" SELECT * FROM $sTable"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results(" SELECT * FROM $sTable ");
		  $iTotal = $wpdb->num_rows;

  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
 
		 foreach($rResult as $aRow)
		 {
			
			$row[0] = hrmgt_get_display_name($aRow['employee_id']);
			$row[1] = $aRow['year'];
			$row[2] = $aRow['month_1'];
			$row[3] = $aRow['month_2'];
			$row[4] = $aRow['month_3'];
			$row[5] = $aRow['month_4'];
			$row[6] = $aRow['month_5'];
			$row[7] = $aRow['month_6'];
			$row[8] = $aRow['month_7'];
			$row[9] = $aRow['month_8'];
			$row[10] = $aRow['month_9'];
			$row[11] = $aRow['month_10'];
			$row[12] = $aRow['month_11'];
			$row[13] = $aRow['month_12'];
			$row[14] = '<a href="admin.php?page=hrmgt-pl&tab=pl_list&action=delete&pl_id='.$aRow['id'].'" class="btn btn-danger deletealert"> Delete </a>';
			
				$output['aaData'][] = $row;
			
		 }
 echo json_encode( $output );
 die();
}
function datatable_client_feedback_ajax_to_load()
{
     global $wpdb;
	 $sTable = $wpdb->prefix . 'hrmgt_client_feedback';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch)
	   {
	        $table_hrmgt_project = $wpdb->prefix. 'hrmgt_project';
			$sQuery = "SELECT $sTable.id,$sTable.client_name,$sTable.comment,$sTable.project_id,$sTable.rate,$table_hrmgt_project.project_title FROM  $sTable INNER JOIN $table_hrmgt_project ON ($sTable.`project_id` = $table_hrmgt_project.`id`) WHERE $sTable.client_name LIKE '%$ssearch%' OR comment LIKE '%$ssearch%' OR project_title LIKE '%$ssearch%' Group BY $sTable.id , $sTable.id DESC $sLimit"; 
	   }
	   else
	   {
		 $sQuery = "SELECT * FROM $sTable Group BY id , id DESC $sLimit";
	   }
	   $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		   
		  $wpdb->get_results("SELECT * FROM $sTable Group BY id , id DESC $sLimit"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results(" SELECT * FROM $sTable Group BY id , id DESC $sLimit");
		  $iTotal = $wpdb->num_rows;
          
  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
		  
 
		 foreach($rResult as $aRow)
		 {
			$row[0] = '<a href="?page=hrmgt-client-feedback&tab=add_cf&action=edit&cf_id='.$aRow['id'].'">'.$aRow['client_name'].'</a>';
			$row[1] = hrmgt_get_project_title($aRow['project_id']);
			$row[2] = $aRow['comment'];
			$row[3] = '<div id="rateYo_'.$aRow['id'].'"></div>
			 <script type="text/javascript">					
						$(function () { 
						$("#rateYo_'.$aRow['id'].'").rateYo({ 
							rating    :'.$aRow['rate'].',
							readOnly:true,
							starWidth: "20px"
						}); 
					});
					</script>';
			$row[4] = '<a href="#" class="btn btn-primary view-client-feedback" id="'.$aRow['id'].'">View</a>
					<a href="?page=hrmgt-client-feedback&tab=add_cf&action=edit&cf_id='.$aRow['id'].'" class="btn btn-info">Edit</a>
					<a href="?page=hrmgt-client-feedback&tab=cf_list&action=delete&cf_id='.$aRow['id'].'" class="btn btn-danger deletealert " 
					>
					Delete</a>';
			$output['aaData'][] = $row;
		}
	
 echo json_encode( $output );
 die();
}
function datatable_employee_feedback_suggestion_ajax_to_load()
{
     global $wpdb;
	 $sTable = $wpdb->prefix . 'hrmgt_suggestion';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch)
	   {
			$sQuery = "SELECT * FROM  $sTable  INNER JOIN wp_users ON ($sTable.employee_id = wp_users.ID) WHERE suggetion_title LIKE '%$ssearch%' OR display_name LIKE '%$ssearch%' OR suggestion_date LIKE '%$ssearch%' OR suggestion LIKE '%$ssearch%' Group BY $sTable.id , $sTable.id DESC $sLimit"; 
	   }
	   else
	   {
		 $sQuery = "SELECT * FROM $sTable Group BY id , id DESC $sLimit";
	   }
	   $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		   
		  $wpdb->get_results("SELECT * FROM $sTable Group BY id , id DESC $sLimit"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results(" SELECT * FROM $sTable Group BY id , id DESC $sLimit");
		  $iTotal = $wpdb->num_rows;
          
  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
		  
 
		 foreach($rResult as $aRow)
		 {
			$row[0] = '<a href="?page=hrmgt-feedback&tab=add_suggestion&action=edit&suggestion_id='.$aRow['id'].'">'.$aRow['suggetion_title'].'</a>';
			$row[1] = hrmgt_get_display_name($aRow['employee_id']);
			$row[2] = hrmgt_change_dateformat($aRow['suggestion_date']);
			$row[3] = wp_trim_words($aRow['suggestion'],3,'...');
			$row[4] = '<a href="#" class="btn btn-primary view-suggestion" id="'.$aRow['id'].'">View</a>
				<a href="?page=hrmgt-feedback&tab=add_suggestion&action=edit&suggestion_id='.$aRow['id'].'" class="btn btn-info">Edit</a>
                <a href="?page=hrmgt-feedback&tab=suggestion_list&action=delete&suggestion_id='.$aRow['id'].'" class="btn btn-danger deletealert">
               Delete</a>';
			$output['aaData'][] = $row;
		}
	
 echo json_encode( $output );
 die();
}
function datatable_employee_feedback_complain_ajax_to_load()
{
    global $wpdb;
	 $sTable = $wpdb->prefix . 'posts';
	 $sTableuser = $wpdb->prefix . 'users';
	 $sLimit = "";
	 
	
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch)
	   {    
			$sQuery = "SELECT p.post_title,p.post_content,p.post_type,u1.display_name,p1.meta_value AS complaint_date,p2.meta_value AS complaint_from ,p3.meta_value AS complaint_status FROM wp_posts p JOIN wp_postmeta p1 ON (p1.post_id = p.ID AND p1.meta_key ='complaint_date' ) JOIN wp_postmeta p2 ON (p2.post_id = p.ID AND p2.meta_key ='complaint_from' )JOIN wp_postmeta p3 ON (p3.post_id = p.ID AND p3.meta_key ='complaint_status' ) JOIN wp_users u1 ON (u1.ID = p2.meta_value) where p.post_type='hrmgt_complaint' AND p.post_title LIKE '%$ssearch%' OR p.post_content LIKE '%$ssearch%' OR u1.display_name LIKE '%$ssearch%' OR p3.meta_key LIKE 'complaint_status' AND p3.meta_value LIKE '%$ssearch%' Group BY p.id , p.id DESC $sLimit"; 
	   }
	   else
	   {
			$sQuery = "SELECT p.post_title,p.post_content,p.post_type,p1.meta_value AS complaint_date,p2.meta_value AS complaint_from ,p3.meta_value AS complaint_status FROM wp_posts p JOIN wp_postmeta p1 ON (p1.post_id = p.ID AND p1.meta_key ='complaint_date' ) JOIN wp_postmeta p2 ON (p2.post_id = p.ID AND p2.meta_key ='complaint_from' )JOIN wp_postmeta p3 ON (p3.post_id = p.ID AND p3.meta_key ='complaint_status' ) where p.post_type='hrmgt_complaint'  Group BY p.id , p.id DESC $sLimit";
	   }
	     $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		
		  $wpdb->get_results("SELECT * FROM $sTable where post_type ='hrmgt_complaint'");
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results("SELECT * FROM $sTable");
		  $iTotal = $wpdb->num_rows;
          
  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
		  
     
		 foreach($rResult as $aRow)
		 {
		
		   $row[0] = '<a href="?page=hrmgt-feedback&tab=add_complaint&action=edit&complaint_id='.$aRow['ID'].'">'.$aRow['post_title'].'</a>';
			$row[1] = hrmgt_get_display_name($aRow['complaint_from']);
			$row[2] = hrmgt_change_dateformat($aRow['complaint_date']);
			$row[3] = $aRow['complaint_status'];
			$row[4] = wp_trim_words($aRow['post_content'],3,'...');
			$row[5] = '<a href="#" class="btn btn-primary view-complaint" id="'.$aRow['ID'].'">View</a>
				<a href="?page=hrmgt-feedback&tab=add_complaint&action=edit&complaint_id='.$aRow['ID'].'" class="btn btn-info">Edit</a>
                <a href="?page=hrmgt-feedback&tab=complaint_list&action=delete&complaint_id='.$aRow['ID'].'" class="btn btn-danger deletealert" 
              >
               Delete </a>';
			$output['aaData'][] = $row;
		}

 echo json_encode( $output );
 die();
}
function datatable_job_candidate_ajax_to_load()
{
     $job_title = $_REQUEST['job_title'];
	 $criteria = $_REQUEST['crierearea'];
     global $wpdb;
	 $sTable = $wpdb->prefix . 'hrmgt_apply_candidates';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch)
	   {
	        $table_hrmgt_posted_job = $wpdb->prefix. 'hrmgt_posted_job';
			$sQuery = "SELECT * FROM  $sTable  INNER JOIN  $table_hrmgt_posted_job
		ON ($sTable.job_id =  $table_hrmgt_posted_job.id)  WHERE job_title LIKE '%$ssearch%' OR first_name LIKE '%$ssearch%' OR last_name LIKE '%$ssearch%' OR email LIKE '%$ssearch%' OR mobile LIKE '%$ssearch%' OR crierearea LIKE '%$ssearch%'  Group BY $sTable.id , $sTable.id DESC $sLimit"; 
	   }
	   elseif($job_title != "-1")
	   {
		$sQuery = "SELECT * FROM  $sTable  WHERE job_id ='$job_title' "; 
	   }
	   else
	   {
		 $sQuery = "SELECT * FROM $sTable Group BY id , id DESC $sLimit";
	   }
	   $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		   
		  $wpdb->get_results("SELECT * FROM $sTable Group BY id , id DESC $sLimit"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results(" SELECT * FROM $sTable Group BY id , id DESC $sLimit");
		  $iTotal = $wpdb->num_rows;
          
  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
		  
 
		 foreach($rResult as $aRow)
		 {
			$row[0] = '<a href="?page=hrmgt-requirements&tab=add_candidate&action=edit&candidate_id='.$aRow['id'].'">'.$aRow['first_name'].' '.$aRow['last_name'].'</a>';
			$row[1] = $aRow['email'];
			$row[2] = hrmgt_get_job_title($aRow['job_id']);
			$row[3] = $aRow['mobile'];
			$row[4] = $aRow['crierearea'];
			$row[5] = '<a href="#" id="'.$aRow['id'].'" class="btn btn-primary view-requirements">View</a>
				<a href="?page=hrmgt-requirements&tab=add_job&action=edit&job_id='.$aRow['id'].'" class="btn btn-info">Edit</a>
                <a href="?page=hrmgt-requirements&tab=job_list&action=delete&job_id='.$aRow['id'].'" class="btn btn-danger deletealert" >Delete</a>';
			$output['aaData'][] = $row;
		}
	
 echo json_encode( $output );
 die();
}
function datatable_recruitment_ajax_to_load()
{
     global $wpdb;
	 $sTable = $wpdb->prefix . 'hrmgt_posted_job';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch){
	   $table_hrmgt_department = $wpdb->prefix. 'hrmgt_department';
	   $sQuery = "SELECT * FROM  $sTable  INNER JOIN wp_posts
		ON ($sTable.designation = wp_posts.ID) INNER JOIN $table_hrmgt_department
		ON ($sTable.department_id = $table_hrmgt_department.ID)  WHERE post_title LIKE '%$ssearch%' OR $table_hrmgt_department.department_name LIKE '%$ssearch%' OR job_title LIKE '%$ssearch%' OR department_id LIKE '%$ssearch%' OR designation LIKE '%$ssearch%' OR closing_date LIKE '%$ssearch%' OR status LIKE '%$ssearch%'  Group BY job_title , job_title DESC $sLimit"; 
	   }
	   else
	   {
	   $sQuery = "SELECT * FROM $sTable Group BY job_title , job_title DESC $sLimit";
	   }
	   $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		   
		  $wpdb->get_results("SELECT * FROM $sTable Group BY job_title , job_title DESC $sLimit"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results(" SELECT * FROM $sTable Group BY job_title , job_title DESC $sLimit");
		  $iTotal = $wpdb->num_rows;
          
  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
		  
 
		 foreach($rResult as $aRow)
		 {
			$row[0] = '<a href="?page=hrmgt-requirements&tab=add_job&action=edit&job_id='.$aRow['id'].'">'.$aRow['job_title'].'</a>';
			$row[1] = hrmgt_get_department_name($aRow['department_id']);
			$row[2] = get_the_title($aRow['designation']);
			$row[3] = $aRow['positions'];
			$row[4] = $aRow['closing_date'];
			$sttas = $aRow['status'];
			$row[5] = $sttas == '1'? 'Open':'Close';
			$row[6] = '<a href="#" id="'.$aRow['id'].'" class="btn btn-primary view-requirements">View</a>
				<a href="?page=hrmgt-requirements&tab=add_job&action=edit&job_id='.$aRow['id'].'" class="btn btn-info">Edit</a>
                <a href="?page=hrmgt-requirements&tab=job_list&action=delete&job_id='.$aRow['id'].'" class="btn btn-danger deletealert ">Delete</a>';
			$output['aaData'][] = $row;
		}
	
 echo json_encode( $output );
 die();
}
function datatable_campasion_ajax_to_load()
{
     global $wpdb;
	 $sTable = $wpdb->prefix . 'hrmgt_assets';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch){
	   $sQuery = "SELECT * FROM  $sTable  INNER JOIN wp_users ON ($sTable.employee_id = wp_users.ID) INNER JOIN wp_posts
		ON ($sTable.asset_id = wp_posts.ID)  WHERE post_title LIKE '%$ssearch%' OR display_name LIKE '%$ssearch%' OR assign_date LIKE '%$ssearch%' OR return_date LIKE '%$ssearch%'  Group BY employee_id , employee_id DESC $sLimit"; 
	   }
	   else
	   {
	   $sQuery = "SELECT * FROM $sTable Group BY employee_id , employee_id DESC $sLimit";
	   }
	   $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		   
		  $wpdb->get_results("SELECT * FROM $sTable Group BY employee_id , employee_id DESC $sLimit"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results(" SELECT * FROM $sTable Group BY employee_id , employee_id DESC $sLimit");
		  $iTotal = $wpdb->num_rows;
          
  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
		  
 
		 foreach($rResult as $aRow)
		 {
			$row[0] = '<a href="?page=hrmgt-assets_benefit&tab=assign_assets&action=edit&assign_id='.$aRow['id'].'">'. get_the_title($aRow['asset_id']).'</a>';
			$row[1] = hrmgt_get_display_name($aRow['employee_id']);
			$row[2] = hrmgt_change_dateformat($aRow['assign_date']);
			$row[3] = hrmgt_change_dateformat($aRow['return_date']);
			$row[4] = '<a href="?page=hrmgt-assets_benefit&tab=assign_assets&action=edit&assign_id='.$aRow['id'].'" class="btn btn-info">Edit</a>
                <a href="?page=hrmgt-assets_benefit&tab=assets_list&action=delete&assign_id='.$aRow['id'].'" class="btn btn-danger deletealert">
                Delete </a>';
			$output['aaData'][] = $row;
			
		 }
	
 echo json_encode( $output );
 die();
}
function datatable_payslip_record_ajax_to_load()
{
     global $wpdb;
	 $sTable = $wpdb->prefix . 'hrmgt_generated_salary_slip';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch){
	   $sQuery = "SELECT * FROM  $sTable INNER JOIN wp_users ON ($sTable.employee_id = wp_users.ID) WHERE display_name LIKE '%$ssearch%' OR account_number LIKE '%$ssearch%' OR total_earning LIKE '%$ssearch%' OR total_deduction LIKE '%$ssearch%' OR ctc_month LIKE '%$ssearch%' OR basic_salary LIKE '%$ssearch%' OR net_salary LIKE '%$ssearch%' ORDER BY employee_id DESC $sLimit"; 
	   }
	   else
	   {
	   $sQuery = "SELECT * FROM $sTable ORDER BY id DESC $sLimit";
	   }
	   $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		   
		  $wpdb->get_results("SELECT * FROM $sTable ORDER BY id DESC $sLimit"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results(" SELECT * FROM $sTable ORDER BY id DESC $sLimit");
		  $iTotal = $wpdb->num_rows;
          
  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
		  
 
		 foreach($rResult as $aRow)
		 {
			$row[0] = hrmgt_get_display_name($aRow['employee_id']);
			$row[1]= $aRow['account_number'];
			$row[2] = $aRow['total_earning'];
			$row[3] = $aRow['total_deduction'];
			$row[4] = $aRow['ctc_month'];
			$row[5] = $aRow['basic_salary'];
			$row[6] = $aRow['net_salary'];
            $row[7] = '<a  href="?page=hrmgt-payslip&print=pdf&type=salary_slip&AttDetail_id='.$aRow['id'].'" target="_blank"class="btn btn-success">PDF</a>
			<a href="admin.php?page=hrmgt-payslip&tab=payslip_record&action=delete_payslip&AttDetail_id='.$aRow['id'].'" class="btn btn-danger deletealert">
							Delete</a>
			';
			$output['aaData'][] = $row;
			
		 }
	
 echo json_encode( $output );
 die();
}
function datatable_payslip_ajax_to_load()
{
     global $wpdb;
	 $sTable = $wpdb->prefix . 'hrmgt_attendance_details';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch){
	   $sQuery = "SELECT * FROM  $sTable INNER JOIN wp_users ON ($sTable.employee_id = wp_users.ID) WHERE display_name LIKE '%$ssearch%' OR month LIKE '%$ssearch%' OR year LIKE '%$ssearch%' OR payable_days LIKE '%$ssearch%' ORDER BY id DESC $sLimit"; 
	   }
	   else
	   {
	   $sQuery = "SELECT * FROM $sTable ORDER BY id DESC $sLimit";
	   }
	   $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		   
		  $wpdb->get_results("SELECT * FROM $sTable ORDER BY id DESC $sLimit"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results(" SELECT * FROM $sTable ORDER BY id DESC $sLimit");
		  $iTotal = $wpdb->num_rows;
          
  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
		  
 
		 foreach($rResult as $aRow)
		 {
		    
			$row[0] = hrmgt_get_display_name($aRow['employee_id']);
			$row[1]= $aRow['month'].'-'.$aRow['year'];
			$row[2] = $aRow['payable_days'];
			$row[3] = '
               <a href="?page=hrmgt-payslip&tab=generate_slip&action=generate_slip&detail_id='.$aRow['id'].'" class="btn btn-primary" id="'.$aRow['id'].'">Generate Slip</a>
                ';
			$output['aaData'][] = $row;
			
		 }
	
 echo json_encode( $output );
 die();
}
function datatable_Project_tast_timelist_ajax_to_load()
{
     global $wpdb;
	 $sTable = $wpdb->prefix . 'hrmgt_task_tracker';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch){
	   $table_hrmgt_project = $wpdb->prefix. 'hrmgt_project';
	   $sQuery = "SELECT * FROM $sTable INNER JOIN wp_users ON ($sTable.employee_id = wp_users.ID) INNER JOIN $table_hrmgt_project ON ($sTable.task_cat_id = $table_hrmgt_project.id) WHERE display_name LIKE '%$ssearch%' OR work_title LIKE '%$ssearch%' OR project_title LIKE '%$ssearch%' OR working_date LIKE '%$ssearch%' OR start_time LIKE '%$ssearch%' OR end_time LIKE '%$ssearch%' OR $sTable.status LIKE '%$ssearch%' Group BY task_cat_id , task_cat_id DESC $sLimit"; 
	   }
	   else
	   {
	   $sQuery = "SELECT * FROM $sTable Group BY id , id DESC $sLimit";
	   }
	
		  $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		  
		  $wpdb->get_results(" SELECT * FROM $sTable"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results(" SELECT * FROM $sTable ");
		  $iTotal = $wpdb->num_rows;

  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
 
		 foreach($rResult as $aRow)
		 {
			$row[0] = '<a href="?page=hrmgt-project&tab=add_project&action=edit&project_id='.$aRow['id'].'">'.$aRow['work_title'].'</a>';
			$row[1]= hrmgt_get_display_name($aRow['employee_id']);
			$row[2] = hrmgt_get_project_title($aRow['task_cat_id']);
			$row[3]= hrmgt_change_dateformat($aRow['working_date']);
			$row[4]= $aRow['start_time'];
			$row[5]= $aRow['end_time'];
			$row[6]= $aRow['status'];
			$row[7] = '<a href="?page=hrmgt-project&tab=add_task_time&action=edit&task_id='.$aRow['id'].'" class="btn btn-info">Edit</a>
                <a href="?page=hrmgt-project&tab=add_task_time&action=delete&task_id='.$aRow['id'].'" class="btn btn-danger deletealert">
                Delete</a>';
			
				$output['aaData'][] = $row;
			
		 }
 echo json_encode( $output );
 die();
}
function datatable_Project_ajax_to_load()
{
     global $wpdb;
	 $sTable = $wpdb->prefix . 'hrmgt_project';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch){
	   $sQuery = "
	   SELECT * FROM  $sTable  WHERE project_title LIKE '%$ssearch%' OR client_name LIKE '%$ssearch%' OR start_date LIKE '%$ssearch%' OR end_date LIKE '%$ssearch%' OR completion_date LIKE '%$ssearch%'  OR status LIKE '%$ssearch%' Group BY project_title ,project_title DESC $sLimit"; 
	   }
	   else
	   {
	   $sQuery = "SELECT * FROM $sTable";
	   }
	
		  $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		  
		  $wpdb->get_results(" SELECT * FROM $sTable"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results(" SELECT * FROM $sTable ");
		  $iTotal = $wpdb->num_rows;

  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
 
		 foreach($rResult as $aRow)
		 {
			
			
			$row[0] = '<a href="?page=hrmgt-project&tab=add_project&action=edit&project_id='.$aRow['id'].'">'.$aRow['project_title'].'</a>';
			$row[1]=$aRow['client_name'];
			$row[2] = hrmgt_change_dateformat($aRow['start_date']);
			$row[3]= hrmgt_change_dateformat($aRow['end_date']);
			$row[4]= hrmgt_change_dateformat($aRow['completion_date']);
			$row[5]= $aRow['status'];
			$row[6] = '<a href="#" class="btn btn-primary view-project" id="'.$aRow['id'].'">View</a>
				<a href="?page=hrmgt-project&tab=add_project&action=edit&project_id='.$aRow['id'].'" class="btn btn-info">Edit</a>
                <a href="?page=hrmgt-project&tab=project_list&action=delete&project_id='.$aRow['id'].'" class="btn btn-danger" 
               >
               Delete</a>';
			
				$output['aaData'][] = $row;
			
		 }
 echo json_encode( $output );
 die();
}
function datatable_Perfomance_marks_ajax_to_load()
{
     global $wpdb;
	 $sTable = $wpdb->prefix . 'hrmgt_parfomance_marks';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch){
	   $table_hrmgt_project = $wpdb->prefix. 'hrmgt_project';
	   $sQuery = "
	   SELECT $sTable.project_id,$sTable.title,$table_hrmgt_project.project_title,$sTable.mark,$sTable.description FROM  $sTable INNER JOIN $table_hrmgt_project ON ($sTable.`project_id` = $table_hrmgt_project.`id`) WHERE  title LIKE '%$ssearch%' OR project_title LIKE '%$ssearch%' OR mark LIKE '%$ssearch%' OR $sTable.description LIKE '%$ssearch%' Group BY project_id ,project_id DESC $sLimit"; 
	   }
	   else
	   {
	   $sQuery = "SELECT * FROM $sTable";
	   }
	
		  $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		  
		  $wpdb->get_results(" SELECT * FROM $sTable"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results(" SELECT * FROM $sTable ");
		  $iTotal = $wpdb->num_rows;

  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
 
		 foreach($rResult as $aRow)
		 {
			
			$row[0]=hrmgt_get_project_title($aRow['project_id']);
			$row[1] = '<a href="?page=hrmgt-parfomance_marks&tab=add_parfomance_marks&action=edit&parfomance_id='.$aRow['id'].'">'.$aRow['title'].'</a>';
			$row[2] = $aRow['mark'];
			$row[3]= wp_trim_words($aRow['description'],3,'...');
			$row[4] = '<a href="#" class="btn btn-primary view-perfomance-mark" id="'.$aRow['id'].'"> View</a>
              	<a href="?page=hrmgt-parfomance_marks&tab=add_parfomance_marks&action=edit&parfomance_id='.$aRow['id'].'" class="btn btn-info">Edit</a>
                <a href="?page=hrmgt-parfomance_marks&tab=performance_mark_list&action=delete&parfomance_id='.$aRow['id'].'" class="btn btn-danger deletealert " ">
                Delete</a>';
			
				$output['aaData'][] = $row;
			
		 }
 echo json_encode( $output );
 die();
}
function datatable_Present_attendance_ajax_load1()
{
	 $date = $_REQUEST['attendance_date'];
	 global $wpdb;
	 $sTable = $wpdb->prefix . 'hrmgt_attendance';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
	   if($ssearch){
	   $sQuery = "
	   SELECT * FROM  $sTable INNER JOIN wp_users ON $sTable.employee_id = wp_users.ID WHERE display_name LIKE '%$ssearch%' OR  attendance_date LIKE '%$ssearch%' OR signin_time LIKE '%$ssearch%' OR signout_time LIKE '%$ssearch%' OR lunch_start_time LIKE '%$ssearch%' OR lunch_end_time LIKE '%$ssearch%' OR working_hours LIKE '%$ssearch%' OR lunch_hourse LIKE '%$ssearch%' Group BY employee_id ,employee_id DESC $sLimit"; 
	   }
	   else
	   {
			$sQuery = "SELECT * FROM $sTable where attendance_date='$date'";
	   }
	
		  $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		  
		  $wpdb->get_results(" SELECT * FROM $sTable where attendance_date='$date'"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results(" SELECT * FROM $sTable ");
		  $iTotal = $wpdb->num_rows;

  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
         if($rResult)
		 {
		 foreach($rResult as $aRow)
		 {
			$row[0] = '';
			$row[1] = '<a href="?page=hrmgt-attendance&tab=view_attendance&emp_id='.$aRow['employee_id'].'">'.hrmgt_get_display_name($aRow['employee_id']).'</a>';
			$row[2] = hrmgt_change_dateformat($aRow['attendance_date']);
			$row[3] = $aRow['signin_time'];
			$row[4] = $aRow['signout_time'];
			$row[5] = $aRow['lunch_start_time'];
			$row[6] = $aRow['lunch_end_time'];
			$working_hours = strtotime(get_option('full_working_hour'));			
		  $HalfDayHours = strtotime(get_option('half_working_hour'));	
		  $TodayWorkHour = strtotime($aRow['working_hours']);	
		  if($aRow['signout_time'] !='')
				{					
					if( $working_hours <= $TodayWorkHour)
					{						
						
						$class="bg-success";
						$Hours = '<p style="padding:0px 20px"class="'.$class.'">'.$aRow['working_hours'].'</p>';
						$status = "Full Day";
					} 
					elseif($working_hours > $TodayWorkHour && $HalfDayHours < $TodayWorkHour)
					{
						
						$class="bg-warning";
						$Hours = '<p style="padding:0px 20px"class="'.$class.'">'.$aRow['working_hours'].'</p>';
						$status = "Half Day";
					}
					elseif($working_hours > $TodayWorkHour && $HalfDayHours > $TodayWorkHour)
					{
						
						$class="bg-danger";
						$Hours = '<p style="padding:0px 20px"class="'.$class.'">'.$aRow['working_hours'].'</p>';
						$status = "Absent";
					}					
				} 
				else
				{									
					date_default_timezone_set('Asia/Calcutta');
					$totaltime = hrmgt_get_time_difference($aRow['signin_time'],date('H:i:s'));									
					$lunch = hrmgt_get_time_difference($aRow['lunch_start_time'],$aRow['lunch_end_time']);					
					//hrmgt_get_working_hours($totaltime,$lunch);
					$curutn_working_hours = hrmgt_get_time_difference($totaltime,$lunch);
					$class="bg-success";
					$Hours = '<p style="padding:0px 20px"class="'.$class.'">'.$curutn_working_hours.'</p>';
					$status = "Present";
				}
			$row[7] = $Hours;
			$row[8] = $status;
			$row[9] = $aRow['lunch_hourse'];
			$row[10] = '<a href="?page=hrmgt-attendance&tab=add_attendance&action=edit&attendance_id='.$aRow['id'].'" class="btn btn-info">Edit</a>
					<a href="?page=hrmgt-attendance&tab=attendance_list&action=delete&attendance_id='.$aRow['id'].'" class="btn btn-danger deletealert" >Delete</a>';
			    if($aRow['attendance_date'] == $date)
				{
				$output['aaData'][] = $row;
				}
			
		 }
	  }
 echo json_encode( $output );
 die();
}

function datatable_all_Accountant_list_ajax_to_load()
{
	 global $wpdb;
	 $sTable = $wpdb->prefix . 'users';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch){
	   $sQuery = "
	   SELECT ID,display_name,user_email
	   FROM  $sTable INNER JOIN wp_usermeta ON $sTable.ID = wp_usermeta.user_id WHERE display_name LIKE '%$ssearch%' OR user_email LIKE '%$ssearch%' OR wp_usermeta.meta_key = 'employee_code' 
	   AND wp_usermeta.meta_value LIKE '%$ssearch%' OR wp_usermeta.meta_key = 'mobile' 
	   AND wp_usermeta.meta_value LIKE '%$ssearch%'  Group BY wp_users.display_name , wp_usermeta.user_id DESC $sLimit"; 
	   }
	   else
	   {
	   $sQuery = "
	   SELECT ID,display_name,user_email
	   FROM  $sTable INNER JOIN wp_usermeta ON $sTable.ID = wp_usermeta.user_id WHERE wp_usermeta.meta_key = 'wp_capabilities' 
	   AND wp_usermeta.meta_value LIKE '%accountant%' Group BY wp_users.display_name , wp_usermeta.user_id DESC $sLimit";
	   }
	 
		  $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		  $wpdb->get_results(" SELECT ID,display_name,user_email
			   FROM  $sTable INNER JOIN wp_usermeta ON $sTable.ID = wp_usermeta.user_id WHERE wp_usermeta.meta_key = 'wp_capabilities' 
			   AND wp_usermeta.meta_value LIKE '%accountant%'"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results(" SELECT ID,display_name,user_email FROM  $sTable ");
		  $iTotal = $wpdb->num_rows;

  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
 
		 foreach($rResult as $aRow)
		 {
			$userimage=get_user_meta($aRow['ID'], 'hrmgt_user_avatar', true);
			if($userimage==null)
			{
				$row[0]='<img src='.get_option( 'hrmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
			}
			else
			{
				$row[0]='<img height="50px" width="50px" class="img-circle" src="'.$userimage.'">';
			}
			$id=$aRow['ID'];
			$user_roles = get_userdata($aRow['ID']);
			$user_role =  implode(', ', $user_roles->roles);
			$row[1] = '<a href="?page=hrmgt-user&tab=add_user&action=edit&user_type='.$user_role.'&id='.$id.'">'.$aRow['display_name'].'</a>';
			$Userrole=get_user_meta($aRow['ID'],'employee_code',true);
			$mobile=get_user_meta($aRow['ID'],'mobile',true);
			$row[2] = $Userrole;
			$row[3]=$aRow['user_email'];
			$row[4]=$mobile;
			$row[5] = '<a href="?page=hrmgt-user&tab=view_employee&action=view&employee_id='.$id.'" class="btn btn-primary"> View</a>
							<a href="?page=hrmgt-user&tab=add_user&action=edit&user_type='.$user_role.'&id='.$id.'" class="btn btn-info">Edit<a>
							<a href="?page=hrmgt-user&tab=all_user&action=delete&emp_id='.$id.'" class="btn btn-danger deletealert">
							Delete</a>';
			if($user_role!='administrator' && $user_role == 'accountant')
			  {
				$output['aaData'][] = $row;
			  }
		 }
 echo json_encode( $output );
 die(); 
}
function datatable_all_hr_list_ajax_to_load()
{
	 global $wpdb;
	 $sTable = $wpdb->prefix . 'users';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch){
	   $sQuery = "
	   SELECT ID,display_name,user_email
	   FROM  $sTable INNER JOIN wp_usermeta ON $sTable.ID = wp_usermeta.user_id WHERE display_name LIKE '%$ssearch%' OR user_email LIKE '%$ssearch%' OR wp_usermeta.meta_key = 'employee_code' 
	   AND wp_usermeta.meta_value LIKE '%$ssearch%' OR wp_usermeta.meta_key = 'mobile' 
	   AND wp_usermeta.meta_value LIKE '%$ssearch%'  Group BY wp_users.display_name , wp_usermeta.user_id DESC $sLimit"; 
	   }
	   else
	   {
	   $sQuery = "
	   SELECT ID,display_name,user_email
	   FROM  $sTable INNER JOIN wp_usermeta ON $sTable.ID = wp_usermeta.user_id WHERE wp_usermeta.meta_key = 'wp_capabilities' 
	   AND wp_usermeta.meta_value LIKE '%manager%' Group BY wp_users.display_name , wp_usermeta.user_id DESC $sLimit";
	   }
	 
		  $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		  $wpdb->get_results(" SELECT ID,display_name,user_email
			   FROM  $sTable INNER JOIN wp_usermeta ON $sTable.ID = wp_usermeta.user_id WHERE wp_usermeta.meta_key = 'wp_capabilities' 
			   AND wp_usermeta.meta_value LIKE '%manager%'"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results(" SELECT ID,display_name,user_email FROM  $sTable ");
		  $iTotal = $wpdb->num_rows;

  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
 
		 foreach($rResult as $aRow)
		 {
			$userimage=get_user_meta($aRow['ID'], 'hrmgt_user_avatar', true);
			if($userimage==null)
			{
				$row[0]='<img src='.get_option( 'hrmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
			}
			else
			{
				$row[0]='<img height="50px" width="50px" class="img-circle" src="'.$userimage.'">';
			}
			//$row[0]=$user_photo;
			$id=$aRow['ID'];
			$user_roles = get_userdata($aRow['ID']);
			$user_role =  implode(', ', $user_roles->roles);
			$row[1] = '<a href="?page=hrmgt-user&tab=add_user&action=edit&user_type='.$user_role.'&id='.$id.'">'.$aRow['display_name'].'</a>';
			$Userrole=get_user_meta($aRow['ID'],'employee_code',true);
			$mobile=get_user_meta($aRow['ID'],'mobile',true);
			$row[2] = $Userrole;
			$row[3]=$aRow['user_email'];
			$row[4]=$mobile;
			$row[5] = '<a href="?page=hrmgt-user&tab=view_employee&action=view&employee_id='.$id.'" class="btn btn-primary"> View</a>
							<a href="?page=hrmgt-user&tab=add_user&action=edit&user_type='.$user_role.'&id='.$id.'" class="btn btn-info">Edit<a>
							<a href="?page=hrmgt-user&tab=all_user&action=delete&emp_id='.$id.'" class="btn btn-danger deletealert">
							Delete</a>';
			if($user_role!='administrator' && $user_role == 'manager')
			  {
				$output['aaData'][] = $row;
			  }
		 }
 echo json_encode( $output );
 die();
}
function datatable_All_user_ajax_to_load()
{
     global $wpdb;
	 $sTable = $wpdb->prefix . 'users';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch){
	   $sQuery = "
	   SELECT ID,display_name,user_email
	   FROM  $sTable INNER JOIN wp_usermeta ON $sTable.ID = wp_usermeta.user_id WHERE display_name LIKE '%$ssearch%' OR user_email LIKE '%$ssearch%' OR wp_usermeta.meta_key = 'employee_code' 
	   AND wp_usermeta.meta_value LIKE '%$ssearch%' OR wp_usermeta.meta_key = 'wp_capabilities' 
	   AND wp_usermeta.meta_value LIKE '%$ssearch%'  Group BY wp_users.display_name , wp_usermeta.user_id DESC $sLimit"; 
	   
	   $wpdb->get_results(" SELECT ID,display_name,user_email
		   FROM  $sTable INNER JOIN wp_usermeta ON $sTable.ID = wp_usermeta.user_id WHERE display_name LIKE '%$ssearch%' OR user_email LIKE '%$ssearch%' OR wp_usermeta.meta_key = 'employee_code' 
		   AND wp_usermeta.meta_value LIKE '%$ssearch%' OR wp_usermeta.meta_key = 'wp_capabilities' 
		   AND wp_usermeta.meta_value LIKE '%$ssearch%'  Group BY wp_users.display_name , wp_usermeta.user_id DESC $sLimit"); 
		  $iFilteredTotal = $wpdb->num_rows;
		 
	   }
	   else
	   {
	   $sQuery = "
	   SELECT ID,display_name,user_email
	   FROM  $sTable INNER JOIN wp_usermeta ON $sTable.ID = wp_usermeta.user_id WHERE wp_usermeta.meta_key = 'wp_capabilities' 
	   AND wp_usermeta.meta_value LIKE '%manager%' OR wp_usermeta.meta_key = 'wp_capabilities' 
	   AND wp_usermeta.meta_value LIKE '%employee%' OR wp_usermeta.meta_key = 'wp_capabilities' 
	   AND wp_usermeta.meta_value LIKE '%accountant%' Group BY wp_users.display_name , wp_usermeta.user_id DESC $sLimit";
	   
	   $wpdb->get_results(" SELECT ID,display_name,user_email
			   FROM  $sTable INNER JOIN wp_usermeta ON $sTable.ID = wp_usermeta.user_id WHERE wp_usermeta.meta_key = 'wp_capabilities' 
			   AND wp_usermeta.meta_value LIKE '%manager%' OR wp_usermeta.meta_key = 'wp_capabilities' 
			   AND wp_usermeta.meta_value LIKE '%employee%' OR wp_usermeta.meta_key = 'wp_capabilities' 
			   AND wp_usermeta.meta_value LIKE '%accountant%'"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  
	   }
	 
		  $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		   $wpdb->get_results(" SELECT ID,display_name,user_email FROM  $sTable ");
		  $iTotal = $wpdb->num_rows;

  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
 
         $role1 = hrmgt_get_user_role(get_current_user_id());
         if($role1=='administrator'){
		 foreach($rResult as $aRow)
		 {
			$userimage=get_user_meta($aRow['ID'], 'hrmgt_user_avatar', true);
			if($userimage==null)
			{
				$row[0]='<img src='.get_option( 'hrmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
			}
			else
			{
				$row[0]='<img height="50px" width="50px" class="img-circle" src="'.$userimage.'">';
			}
			//$row[0]=$user_photo;
			$id=$aRow['ID'];
			$user_roles = get_userdata($aRow['ID']);
			$user_role =  implode(', ', $user_roles->roles);
			$row[1] = '<a href="?page=hrmgt-user&tab=add_user&action=edit&user_type='.$user_role.'&id='.$id.'">'.$aRow['display_name'].'</a>';
			$Userrole=get_user_meta($aRow['ID'],'employee_code',true);
			$mobile=get_user_meta($aRow['ID'],'mobile',true);
			$row[2] = $Userrole;
			$row[3]=$aRow['user_email'];
			$row[4]=$user_role;
			$row[5] = '<a href="?page=hrmgt-user&tab=view_employee&action=view&employee_id='.$id.'" class="btn btn-primary"> View</a>
							<a href="?page=hrmgt-user&tab=add_user&action=edit&user_type='.$user_role.'&id='.$id.'" class="btn btn-info">Edit<a>
							<a href="?page=hrmgt-user&tab=all_user&action=delete&emp_id='.$id.'" class="btn btn-danger deletealert">
							Delete</a>';
			if($user_role!='administrator')
			  {
				$output['aaData'][] = $row;
			  }
		 }
		 }
		 else
		 {
		 
		 foreach($rResult as $aRow)
		 {
			$userimage=get_user_meta($aRow['ID'], 'hrmgt_user_avatar', true);
			if($userimage==null)
			{
				$row[0]='<img src='.get_option( 'hrmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
			}
			else
			{
				$row[0]='<img height="50px" width="50px" class="img-circle" src="'.$userimage.'">';
			}
			//$row[0]=$user_photo;
			$id=$aRow['ID'];
			$user_roles = get_userdata($aRow['ID']);
			$user_role =  implode(', ', $user_roles->roles);
			if($role1 == "manager")
			{ 
					$user_name = '<a href="?page=hrmgt-user&tab=add_user&action=edit&user_type='.$user_role.'&id='.$id.'">'.$aRow['display_name'].'</a>';
			}
			else
			{ 
					$user_name = $aRow['display_name'];		 
			}
			$row[1] = $user_name ;
			$Userrole=get_user_meta($aRow['ID'],'employee_code',true);
			$mobile=get_user_meta($aRow['ID'],'mobile',true);
			$row[2] = $Userrole;
			$row[3]=$aRow['user_email'];
			$row[4]=$user_role;
			$action='';
			$action1='';
			if( $id == get_current_user_id() ||  $role1=='manager'){
				$action = '<a href="?hr-dashboard=user&page=user&tab=view_employee&ction=view&employee_id='.$id.'" class="btn btn-primary">View</a>';
			}
			if($id == get_current_user_id() && $role1 =='manager' )
			{ 
				$action1 = '<a href="?hr-dashboard=user&page=user&tab=add_user&action=edit&user_type=employee&id='.$id.'" class="btn btn-info">Edit</a>';
			} 
            $row[5] = $action.' '.$action1 ;	
			if($user_role!='administrator')
			  {
				$output['aaData'][] = $row;
			  }
		 }
		 }
 echo json_encode( $output );
 die();
}
function datatable_All_employee_ajax_to_load()
{    
    $status = $_REQUEST['working_status'];
	global $wpdb;

	$sTable = $wpdb->prefix . 'users';
	$sLimit = "";
	 if(isset($_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch){
	   $table_hrmgt_department = $wpdb->prefix. 'hrmgt_department';
	   $sQuery = "
	   SELECT u1.ID,u1.display_name,dd1.post_title,m1.department_name,m1.id,um1.meta_value AS department,um1.meta_value AS designation
	   FROM  $sTable u1  JOIN wp_usermeta um1 ON (u1.ID = um1.user_id)  JOIN wp_hrmgt_department m1 ON (m1.id = um1.meta_value) JOIN wp_posts dd1 ON (u1.ID = um1.user_id) WHERE u1.display_name LIKE '%$ssearch%' OR dd1.post_title LIKE '%$ssearch%' OR m1.department_name LIKE '%$ssearch%' OR um1.meta_key = 'employee_code' 
	   AND um1.meta_value LIKE '%$ssearch%' OR um1.meta_key = 'department' 
	   AND um1.meta_value LIKE '%$ssearch%' OR um1.meta_key = 'designation' 
	   AND um1.meta_value LIKE '%$ssearch%' Group BY u1.ID , u1.ID DESC $sLimit";  
        	  
	  }
	   else
	   {
	   $sQuery = "
	   SELECT ID,display_name,user_email
	   FROM  $sTable INNER JOIN wp_usermeta ON $sTable.ID = wp_usermeta.user_id WHERE wp_usermeta.meta_key = 'wp_capabilities' 
	   AND wp_usermeta.meta_value LIKE '%employee%' Group BY wp_users.display_name , wp_usermeta.user_id DESC $sLimit";
	   }
	 
		  $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		  $wpdb->get_results(" SELECT ID,display_name,user_email
			   FROM  $sTable INNER JOIN wp_usermeta ON $sTable.ID = wp_usermeta.user_id WHERE wp_usermeta.meta_key = 'wp_capabilities' 
			   AND wp_usermeta.meta_value LIKE '%employee%'"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results(" SELECT ID,display_name FROM  $sTable ");
		  $iTotal = $wpdb->num_rows;

  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
		 $role1 = hrmgt_get_user_role(get_current_user_id());
         if($role1=='administrator'){
		 foreach($rResult as $aRow)
		 {
			$userimage=get_user_meta($aRow['ID'], 'hrmgt_user_avatar', true);
			if($userimage==null)
			{
				$row[0]='<img src='.get_option( 'hrmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
			}
			else
			{
				$row[0]='<img height="50px" width="50px" class="img-circle" src="'.$userimage.'">';
			}
			//$row[0]=$user_photo;
			$id=$aRow['ID'];
			$user_roles = get_userdata($aRow['ID']);
			$user_role =  implode(', ', $user_roles->roles);
			$working_status=get_user_meta($aRow['ID'],'working_status',true);
			$department=get_user_meta($aRow['ID'],'department',true);
			$designation=get_user_meta($aRow['ID'],'designation',true);
			$row[1] = '<a href="?page=hrmgt-user&tab=add_user&action=edit&user_type='.$user_role.'&id='.$id.'">'.$aRow['display_name'].'</a>';
			$Userrole=get_user_meta($aRow['ID'],'employee_code',true);
			$row[2] = $Userrole;
			$row[3]=!empty($department) ? hrmgt_get_department_name($department):'';
			$row[4]= get_the_title($designation);
			$row[5] = '<a href="?page=hrmgt-user&tab=view_employee&action=view&employee_id='.$id.'" class="btn btn-primary"> View</a>
							<a href="?page=hrmgt-user&tab=add_user&action=edit&user_type='.$user_role.'&id='.$id.'" class="btn btn-info">Edit<a>
							<a href="?page=hrmgt-user&tab=all_user&action=delete&emp_id='.$id.'" class="btn btn-danger deletealert">
							Delete</a>';
			if($user_role!='administrator' && $user_role == 'employee' && $working_status == $status)
			  {
				$output['aaData'][] = $row;
			  }
		 }
		 }
		 else
		 {
		  foreach($rResult as $aRow)
		 {
			$userimage=get_user_meta($aRow['ID'], 'hrmgt_user_avatar', true);
			if($userimage==null)
			{
				$row[0]='<img src='.get_option( 'hrmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
			}
			else
			{
				$row[0]='<img height="50px" width="50px" class="img-circle" src="'.$userimage.'">';
			}
			//$row[0]=$user_photo;
			$id=$aRow['ID'];
			$user_roles = get_userdata($aRow['ID']);
			$user_role =  implode(', ', $user_roles->roles);
			$working_status=get_user_meta($aRow['ID'],'working_status',true);
			$department=get_user_meta($aRow['ID'],'department',true);
			$designation=get_user_meta($aRow['ID'],'designation',true);
			if($role1 == "manager")
			{ 
					$user_name = '<a href="?page=hrmgt-user&tab=add_user&action=edit&user_type='.$user_role.'&id='.$id.'">'.$aRow['display_name'].'</a>';
			}
			else
			{ 
					$user_name = $aRow['display_name'];		 
			}
			$row[1] = $user_name;
			$Userrole=get_user_meta($aRow['ID'],'employee_code',true);
			$row[2] = $Userrole;
			$row[3]=!empty($department) ? hrmgt_get_department_name($department):'';
			$row[4]= get_the_title($designation);
			
			$action='';
			$action1='';
			if( $id == get_current_user_id() ||  $role1=='manager'){
				$action = '<a href="?hr-dashboard=user&page=user&tab=view_employee&ction=view&employee_id='.$id.'" class="btn btn-primary">View</a>';
			}
			if($id == get_current_user_id() && $role1 =='manager' )
			{ 
				$action1 = '<a href="?hr-dashboard=user&page=user&tab=add_user&action=edit&user_type=employee&id='.$id.'" class="btn btn-info">Edit</a>';
			} 
            $row[5] = $action.' '.$action1 ;			
			if($user_role!='administrator' && $user_role == 'employee' && $working_status == $status)
			  {
				$output['aaData'][] = $row;
			  }
			if($user_role!='administrator' && $user_role == 'employee')
			  {
			   $output['aaData'][] = $row;
			  }
		 }
		 }
		 
		 
 echo json_encode( $output );
 die();
}
function datatable_employee_leave_ajax_to_load()
{
    $employee = $_REQUEST['employee'];
 
	 global $wpdb;
	 $sTable = $wpdb->prefix . 'hrmgt_leave';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch){
	   $sQuery = "
	   SELECT *
	   FROM  $sTable INNER JOIN wp_users ON ($sTable.employee_id = wp_users.ID) INNER JOIN wp_posts
		ON ($sTable.leave_type = wp_posts.ID)  WHERE post_title LIKE '%$ssearch%' OR display_name LIKE '%$ssearch%' OR $sTable.id LIKE '%$ssearch%' OR leave_duration LIKE '%$ssearch%' OR start_date LIKE '%$ssearch%' OR end_date LIKE '%$ssearch%' OR status LIKE '%$ssearch%' OR reason LIKE '%$ssearch%' Group BY start_date , start_date DESC $sLimit"; 
	   }
	   else if($employee == 0){
	   $sQuery = "SELECT * FROM $sTable";
	   }
	   else
	   {
	   $sQuery = "SELECT * FROM $sTable where employee_id='$employee'";
	   }

		  $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		  
		  $wpdb->get_results("SELECT * FROM $sTable"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results("SELECT * FROM $sTable");
		  $iTotal = $wpdb->num_rows;

  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );

		 foreach($rResult as $aRow)
		 {
			$row[0]=$aRow['id'];
			$row[1] = hrmgt_get_display_name($aRow['employee_id']);
			$row[2] = get_the_title($aRow['leave_type']);
			$row[3]= hrmgt_leave_duration_label($aRow['leave_duration']);
			$row[4]= hrmgt_change_dateformat($aRow['start_date']);
			$row[5]= hrmgt_change_dateformat($aRow['end_date']);
			$row[6]=$aRow['status'];
			$row[7]= wp_trim_words( $aRow['reason'],3,'...');
			$button='';
			$button1='';
			if(($aRow['status']!='Approved') AND ($aRow['status']!='Rejected'))
			{
				$button = '<a href="#" leave_id="'.$row[0].'" class="btn btn-default leave-approve">Approve</a>';
			}
			if(($aRow['status']!='Approved') AND ($aRow['status']!='Rejected'))
			{
				$button1 = '<a href="#" leave_id="'.$row[0].'" class="btn btn-default leave-reject">Reject</a>';
			}
						
			$row[8]=$button.' '.$button1.'<a href="?page=hrmgt-leave&tab=add_leave&action=edit&leave_id='.$row[0].'" class="btn btn-info">Edit</a>
					 <a href="?page=hrmgt-leave&tab=leave_list&action=delete&leave_id='.$row[0].'"  class="btn btn-danger deletealert">
					Delete</a>';
			$output['aaData'][] = $row;
		 }
 echo json_encode( $output );
 die();
}
function datatable_employee_training_ajax_to_load()
{
     global $wpdb;
	 $sTable = $wpdb->prefix . 'hrmgt_training';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch){
	   $sQuery = "
	   SELECT * FROM  $sTable INNER JOIN wp_posts  WHERE post_title LIKE '%$ssearch%' OR training_type LIKE '%$ssearch%' OR training_title LIKE '%$ssearch%' OR training_subject LIKE '%$ssearch%' OR start_date LIKE '%$ssearch%' OR end_date LIKE '%$ssearch%' OR description LIKE '%$ssearch%' Group BY start_date , start_date DESC $sLimit"; 
	   }
	   else
	   {
	   $sQuery = "SELECT * FROM $sTable";
	   }

		  $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		  
		  $wpdb->get_results("SELECT * FROM $sTable"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results("SELECT * FROM $sTable");
		  $iTotal = $wpdb->num_rows;

  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );

		 foreach($rResult as $aRow)
		 {
			$row[0] = get_the_title($aRow['training_type']);
			$row[1] = $aRow['training_title'];
			$row[2] = get_the_title ($aRow['training_subject']);
			$row[3]= hrmgt_change_dateformat($aRow['start_date']);
			$row[4]= hrmgt_change_dateformat($aRow['end_date']);
			$row[5]= wp_trim_words( $aRow['description'],3,'...');
			
			
			$row[6]=' <a href="#" class="btn btn-primary view-training-imployee" id="'.$aRow['id'].'"> View Trainee</a>
              	<a href="?page=hrmgt-employee_training&tab=add_training&action=edit&training_id='.$aRow['id'].'" class="btn btn-info"> Edit</a>
				 <a href="?page=hrmgt-employee_training&tab=training_list&action=delete&training_id='.$aRow['id'].'" class="btn btn-danger deletealert" 
                >
                Delete</a>';
			$output['aaData'][] = $row;
		 }
 echo json_encode( $output );
 die();
}
function datatable_events_ajax_to_load()
{
     global $wpdb;
	 $sTable = $wpdb->prefix . 'posts';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	    if($ssearch){
		
	   $sQuery = "
	   SELECT p.post_title,p.post_content,p.post_type,p1.meta_value AS event_start_date,p2.meta_value AS event_end_date ,p3.meta_value AS event_place FROM wp_posts p JOIN wp_postmeta p1 ON (p1.post_id = p.ID AND p1.meta_key ='event_start_date' ) JOIN wp_postmeta p2 ON (p2.post_id = p.ID AND p2.meta_key ='event_end_date' )JOIN wp_postmeta p3 ON (p3.post_id = p.ID AND p3.meta_key ='event_place' ) where p.post_type='hrmgt_events' AND p.post_title LIKE '%$ssearch%' OR p.post_content LIKE '%$ssearch%' OR p1.meta_key LIKE 'event_start_date' AND p3.meta_value LIKE '%$ssearch%' OR p1.meta_key LIKE 'event_end_date' AND p3.meta_value LIKE '%$ssearch%' OR p1.meta_key LIKE 'event_place' AND p3.meta_value LIKE '%$ssearch%' Group BY p.id , p.id DESC $sLimit"; 
	   }
	   else
	   {
	   $sQuery = "SELECT p.id,p.post_title,p.post_content,p.post_type,p1.meta_value AS event_start_date,p2.meta_value AS event_end_date ,p3.meta_value AS event_place FROM wp_posts p JOIN wp_postmeta p1 ON (p1.post_id = p.ID AND p1.meta_key ='event_start_date' ) JOIN wp_postmeta p2 ON (p2.post_id = p.ID AND p2.meta_key ='event_end_date' )JOIN wp_postmeta p3 ON (p3.post_id = p.ID AND p3.meta_key ='event_place' ) where p.post_type='hrmgt_events'  Group BY p.id , p.id DESC $sLimit";
	   }
         
		  $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		  $wpdb->get_results("SELECT p.id,p.post_title,p.post_content,p.post_type,p1.meta_value AS event_start_date,p2.meta_value AS event_end_date ,p3.meta_value AS event_place FROM wp_posts p JOIN wp_postmeta p1 ON (p1.post_id = p.ID AND p1.meta_key ='event_start_date' ) JOIN wp_postmeta p2 ON (p2.post_id = p.ID AND p2.meta_key ='event_end_date' )JOIN wp_postmeta p3 ON (p3.post_id = p.ID AND p3.meta_key ='event_place' ) where p.post_type='hrmgt_events'  Group BY p.id , p.id DESC $sLimit");
		  $iFilteredTotal = $wpdb->num_rows;
		   $wpdb->get_results("SELECT * From $sTable");
		  $iTotal = $wpdb->num_rows;

  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
         
		 foreach($rResult as $aRow)
		 {
			$row[0] = $aRow['post_title'];
			$row[1] = hrmgt_change_dateformat($aRow['event_start_date']);
			$row[2] = hrmgt_change_dateformat($aRow['event_end_date']);
			$row[3]= $aRow['event_place'];
			$row[4]= wp_trim_words( $aRow['post_content'],3,'...');
			$row[5]=' <a href="#" class="btn btn-primary view-event" id="'.$aRow['id'].'">View</a>
				<a href="?page=hrmgt-event&tab=add_event&action=edit&event_id='.$aRow['id'].'" class="btn btn-info">Edit</a>
                <a href="?page=hrmgt-event&tab=event_list&action=delete&event_id='.$aRow['id'].'" class="btn btn-danger deletealert" 
                >
              Delete </a>';
			$output['aaData'][] = $row;
		 }
 echo json_encode( $output );
 die();
}
function datatable_travelling_ajax_to_load()
{
     global $wpdb;
	 $sTable = $wpdb->prefix . 'hrmgt_travel';
	 $sLimit = "";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch){
	   $sQuery = "
	   SELECT * FROM  $sTable  INNER JOIN wp_users ON $sTable.employee_id = wp_users.ID WHERE display_name LIKE '%$ssearch%' OR visit_purpose LIKE '%$ssearch%' OR start_date LIKE '%$ssearch%' OR end_date LIKE '%$ssearch%' OR description LIKE '%$ssearch%' Group BY start_date , start_date DESC $sLimit"; 
	   }
	   else
	   {
	   $sQuery = "SELECT * FROM $sTable";
	   }

		  $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		  
		  $wpdb->get_results("SELECT * FROM $sTable"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  $wpdb->get_results("SELECT * FROM $sTable");
		  $iTotal = $wpdb->num_rows;

  
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );

		 foreach($rResult as $aRow)
		 {
			//$comfrim ="<script>alert(\'You have to tick the box\')</script>";
			$row[0] = hrmgt_get_display_name($aRow['employee_id']);
			$row[1] = wp_trim_words($aRow['visit_purpose'],4,'...');
			$row[2] = hrmgt_change_dateformat($aRow['start_date']);
			$row[3]= hrmgt_change_dateformat($aRow['end_date']);
			$row[4]= wp_trim_words( $aRow['description'],3,'...');
			$row[5]='<a href="#" class="btn btn-primary view-travel" id="'.$aRow['id'].'">View</a>
				<a href="?page=hrmgt-travel&tab=add_travel&action=edit&travel_id='.$aRow['id'].'" class="btn btn-info">Edit</a>
                <a href="?page=hrmgt-travel&tab=travel_list&action=delete&travel_id='.$aRow['id'].'"   class="btn btn-danger deletealert" 
                ">
                Delete</a>';
			$output['aaData'][] = $row;
		 }
 echo json_encode( $output );
 die();
}
/* function hrmgt_add_profile_exe()
{
	
	$ProfileExe	= explode(",",get_option('profile_picture_exetesion'));	
	array_push($ProfileExe,$_REQUEST['profile_exe']);
	$NewExe = implode(",",$ProfileExe);	
	update_option("profile_picture_exetesion",$NewExe);
	die;
} */
/* function datatable_ajax_load()
{
	//echo "asdasd"; die;
    global $wpdb;
	$table = $wpdb->prefix .'users';
	$primaryKey = 'ID';
	
	$columns = array(
	array(
		'db' => 'ID',
		'dt' => 'DT_RowId',
		'formatter' => function( $d, $row ) {
			// Technically a DOM id cannot start with an integer, so we prefix
			// a string. This can also be useful if you have multiple tables
			// to ensure that the id is unique with a different prefix
			return 'row_'.$d;
		}
	),
	array( 'db' => 'ID', 'dt' => 0 ),	
	//array( 'db' => 'photo', 'dt' => 1 ),
	array( 'db' => 'display_name',  'dt' =>1),
	/* array( 'db' => 'phone', 'dt' => 3 ),
	array( 'db' => 'type', 'dt' => 4 ),	
 
 array( 'db' => 'user_email',  'dt' => 2),	
	

);
	
	$sql_details = array(
		'user' => DB_USER,
		'pass' => DB_PASSWORD,
		'db'   => DB_NAME,
		'host' => DB_HOST
	);
	
	require( 'ajax_load_class.php' );
 
	echo json_encode(
		SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
	);	 
} */
function hrmgt_add_or_remove_category()
{
	$model = $_REQUEST['model'];
	$title = __("title",'hr_mgt');
	$table_header_title =  __("header",'hr_mgt');
	$button_text=  __("Add category",'hr_mgt');
	$label_text =  __("category Name",'hr_mgt');
	
	if($model == 'parent_dept_cat')
	{

		$title = __("Parent Department",'hr_mgt');
		$table_header_title =  __("Department Name",'hr_mgt');
		$button_text=  __("Add Department Name",'hr_mgt');
		$label_text =  __("Department Name",'hr_mgt');	

	}
	
	if($model == 'unit_category')
	{
		$title = __("Add Unit Category",'hr_mgt');
		$table_header_title =  __("Unit Category Name",'hr_mgt');
		$button_text=  __("Add Unit Category",'hr_mgt');
		$label_text =  __("Unit Category Name",'hr_mgt');	
	}
	
	if($model == 'leave_type_cat')
	{
		$title = __("Add Leave Type",'hr_mgt');
		$table_header_title =  __("Leave Type Name",'hr_mgt');
		$button_text=  __("Add Leave Type",'hr_mgt');
		$label_text =  __("Leave Type Name",'hr_mgt');	
	}
	if($model == 'task_cat')
	{
		$title = __("Add Task",'hr_mgt');
		$table_header_title =  __("Task Name",'hr_mgt');
		$button_text=  __("Add Task",'hr_mgt');
		$label_text =  __("Task Name",'hr_mgt');
	}
	
	if($model == 'policy_cat')
	{
		$title = __("Add Policy Type",'hr_mgt');
		$table_header_title =  __("Policy Type Name",'hr_mgt');
		$button_text=  __("Add Policy Type",'hr_mgt');
		$label_text =  __("Policy Type Name",'hr_mgt');	
	}
	
	if($model == 'training_type_cat')
	{
		$title = __("Add Training Type",'hr_mgt');
		$table_header_title =  __("Training Type Name",'hr_mgt');
		$button_text=  __("Add Training Type",'hr_mgt');
		$label_text =  __("Training Type Name",'hr_mgt');	
	}
	
	if($model == 'assets_cat')
	{
		$title = __("Add Assets",'hr_mgt');
		$table_header_title =  __("Assets Name",'hr_mgt');
		$button_text=  __("Add Assets",'hr_mgt');
		$label_text =  __("Assets Name",'hr_mgt');	
	}
	
	if($model == 'designation_cat')
	{

		$title = __("Add Designation",'hr_mgt');
		$table_header_title =  __("Designation Name",'hr_mgt');
		$button_text=  __("Add Designation",'hr_mgt');
		$label_text =  __("Designation Name",'hr_mgt');	
	}
	
	if($model=="training_skill_cat")
	{		
		$title = __("Training Subject ( Skill )",'hr_mgt');
		$table_header_title =  __("Training Subject Name",'hr_mgt');
		$button_text=  __("Add Subject",'hr_mgt');		
		$label_text =  __("Subject Name",'hr_mgt');	
	}
	
	$cat_result = hrmgt_get_all_category( $model );
?>
<div class="modal-header"> <a href="#" class="close-btn badge badge-success pull-right">X</a>
	<h4 id="myLargeModalLabel" class="modal-title"><?php echo $title;?></h4>	
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#category_form').validationEngine();
	});
</script>
<div class="panel panel-white">
  	<div class="category_listbox">
  		<div class="table-responsive">
		  	<table class="table">
			  	<thead>
					<tr>
						<th><?php echo $table_header_title;?></th>
			            <th><?php _e('Action','hr_mgt');?></th>
			        </tr>
			    </thead>
				<?php
				$i = 1;
				if(!empty($cat_result))
				{ 
					foreach ($cat_result as $retrieved_data)
					{
						echo '<tr id="cat-'.$retrieved_data->ID.'">';
						echo '<td>'.$retrieved_data->post_title.'</td>';
						echo '<td id='.$retrieved_data->ID.'><a class="btn-delete-cat badge badge-delete" model='.$model.' href="#" id='.$retrieved_data->ID.'>X</a></td>';
						echo '</tr>';
						$i++;		
					}
				} ?>
			</table>
		</div>
	</div>
	
	<form name="category_form" action="" method="post" class="form-horizontal " id="category_form">
		<div class="form-group">
			<label class="col-sm-4 control-label" for="category_name"><?php echo $label_text;?><span class="require-field">*</span></label>
			<div class="col-sm-4">
				<input type="text" id="category_name" value="" class="form-control validate[required] text-input category_name" name="category_name" required >
			</div>
			<div class="col-sm-4">
				<input type="button" value="<?php echo $button_text;?>" name="save_category" class="hi btn btn-success" model="<?php echo $model;?>" id="btn-add-cat"/>						
			</div>
		</div>
	</form>
</div>
<?php 
die();
}

function hrmgt_get_user_category()
{	
	$user_id = get_current_user_id();
	$metaquery[] = array(
		'key' => 'complaint_from',
		'value' => $user_id,
		'compare' => '=',
	);
	$args = array( 'post_type'  => 'hrmgt_complaint','meta_query' => $metaquery );
	$posts = query_posts($args);
	return $posts;
}

function  hrmgt_get_all_category($model)
{	
	$args= array('post_type'=> $model,'posts_per_page'=>-1,'orderby'=>'post_title','order'=>'Asc');
	$cat_result = get_posts( $args );
	return $cat_result;
}

function hrmgt_add_category()
{
	global $wpdb;
	$model = $_REQUEST['model'];	
	$array_var = array();
	$data['category_name'] = $_REQUEST['category_name'];
	$data['category_type'] = $_REQUEST['model'];
	
	$id = hrmgt_add_categorytype($data);
	$row1 = '<tr id="cat-'.$id.'"><td>'.$_REQUEST['category_name'].'</td><td><a class="btn-delete-cat badge badge-delete" href="#" id='.$id.' model="'.$model.'">X</a></td></tr>';
	$option = "<option value='$id'>".$_REQUEST['category_name']."</option>";
	$array_var[] = $row1;
	$array_var[] = $option;
	echo json_encode($array_var);
	die();

}

function hrmgt_experience_letter()
{
	$curr_role = hrmgt_get_user_role(get_current_user_id());
	$employee_id = $_REQUEST[employee_id];
	$employeedata = get_userdata($employee_id);
	$arr = array();
	$arr['{{system_name}}']=get_option('hrmgt_system_name');
	$arr['{{join_date}}']=hrmgt_change_dateformat($employeedata->joining_date);
	$arr['{{leave_date}}']=hrmgt_change_dateformat($employeedata->contract_end_date);
	$arr['{{department_name}}']=hrmgt_get_department_name($employeedata->department);
	$arr['{{employee_name}}']=$employeedata->display_name;

	$content = get_option('hrmgt_exprience_latter_content');
	$presentto = get_option('hrmgt_exprience_latter_to');

	$replace_content =  hrmgt_string_replacemnet($arr,$content);
	$replace_to =  hrmgt_string_replacemnet($arr,$presentto);
?>
<style>
.exprience{
	float:left;
	width:100%;	
	background-position: center center;
	background-size:200px 200px;
	background-repeat:no-repeat;
	border:3px solid lightblue;
	padding:10px;
}
</style>

<a href="#" class="close-btn badge badge-success pull-right">X</a>
<div class="div">
<div id="printcontent" class="exprience">
<form action="" method="post" id="submit_data">
	<div class="header">	
		<div class="col-md-4"><img  height="30%" width="30%" class="img-responsive" src="<?php  print get_option('hrmgt_system_logo'); ?>" /></div>
		<div class="col-md-8 header_right"> <h3><?php print  get_option('hrmgt_system_name'); ?><h3></div>
	</div>
	<div class="col-md-12">
		<div class="letter_heading"><h2><?php print get_option('hrmgt_exprience_latter_heading');?></h2></div>
		<div class="div"><h4 ><?php print $replace_to; ?></h4></div>		
		<div class=""><p><?php print $replace_content; ?></p></div>	
	</div>
	<div class="col-md-12">
		<div class="col-md-7"></div>
		<div class="col-md-5">
			<div class="signeture"></div>
			<p>
			<?php				
				if($curr_role=='employee'){
					print get_option('hrmgt_system_name');
				}else{
					print hrmgt_get_display_name(get_current_user_id());
				}
			?></p>			
		</div>
	</div>
	<div class="footer">
		<p><b><?php _e('Address :','hr_mgt'); ?> </b><?php print get_option('hrmgt_office_address').",". get_option('hrmgt_contry'); ?></p>
		<p><b><?php _e('Email :','hr_mgt'); ?> </b><?php print get_option('hrmgt_email'); ?></p>
		<p><b><?php _e('Official Phone Number :','hr_mgt'); ?> </b><?php print get_option('hrmgt_contact_number'); ?></p>
	</div>	
	</form>
	</div>
	<a id="exprience_latter" href="?page=hrmgt-user&print=print&type=exepriance&employee_id=<?php print $employee_id; ?>" id="print_exprience_latter" class="btn btn-primary"  target="_blank" ><?php _e('Print','hr_mgt'); ?></a>
</div>
<?php 	
die();
}

function hrmgt_add_categorytype($data)
{	
	global $wpdb;		
	$result = wp_insert_post( array( 
		'post_status' => 'publish',
		'post_type' => $data['category_type'],
		'post_title' => $data['category_name']) );
	$id = $wpdb->insert_id;	
	return $id;
}

function hrmgt_remove_category()
{
	wp_delete_post($_REQUEST['cat_id']);	
}

function hrmgt_load_multiple_day()
{
	$obj_leave=new HrmgtLeave;
	$duration = $_REQUEST['duration'];
	$leave_id = $_REQUEST['idset'];
	$edit=0;
	if($leave_id!='')
	{
		$edit=1;
		$result = $obj_leave->hrmgt_get_single_leave($leave_id);	
	}
?>
<script>
 $('#start_date').datepicker({
	 dateFormat:'yy-mm-dd',
	 changeMonth: true,
	 changeYear: true,
	 yearRange:'-65:+10',
	 //minDate:0,
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
	 yearRange:'-65:+10',
	// minDate:0,
	 onChangeMonthYear: function(year, month, inst) {
	     $(this).val(month + "/" + year);
	},
	onSelect: function(selected) {
		$("#start_date").datepicker("option","maxDate", selected)
	}
}); 
 </script>
<?php
if($duration=='more_then_day')
{ ?>
	<div class="form-group">
		<label class="col-sm-2 control-label" for="attendance_date"><?php _e('Leave Start Date','hr_mgt');?><span class="require-field">*</span></label>
		<div class="col-sm-8">
			<input id="start_date" class="form-control date validate[required]" type="text"  name="start_date" value="<?php if($edit){ echo $result->start_date;} elseif(isset($_POST['start_date'])) echo $_POST['start_date'];?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2  control-label" for="attendance_date"><?php _e('Leave End Date','hr_mgt');?></label>
		<div class="col-sm-8">
			<input id="end_date" class="form-control date " type="text"  name="end_date" 	value="<?php if($edit){ echo $result->end_date;} elseif(isset($_POST['end_date'])) echo $_POST['end_date'];?>">
		</div>
	</div>
		
<?php } 
else { ?>
	<div class="form-group">
		<label class="col-sm-2   control-label" for="attendance_date"><?php _e('Leave Start Date','hr_mgt');?><span class="require-field">*</span></label>
		<div class="col-sm-8">
			<input id="start_date" class="form-control date validate[required]" type="text"  name="start_date" value="<?php if($edit){ echo $result->start_date;} elseif(isset($_POST['start_date'])) echo $_POST['start_date'];?>">
		</div>
	</div>
<?php } ?>
	
<?php 
die();
} 
function hrmgt_view_faq(){		
	 $obj_policy	=	new HrmgtCompanyPolicy;
	 $faqdata	= 	$obj_policy->hrmgt_get_single_faq($_REQUEST['faq_id']);
?>
<div class="form-group"> 	<a href="#" class="close-btn badge badge-success pull-right">X</a>
  <h4 class="modal-title" id="myLargeModalLabel"><?php _e('FAQ Detail','hr_mgt'); ?></h4>
</div>
<hr>
<div class="panel panel-white form-horizontal">
  <div class="form-group">
 <label class="col-sm-3" for="notice_title"><?php _e(' Title','hr_mgt');?>: </label>
    <div class="col-sm-9"> <?php echo $faqdata->title;?> </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Description','hr_mgt');?>: </label>
    <div class="col-sm-9"><?php echo $faqdata->description;?></div>
  </div>
</div>
<?php 
	die();
}
function hrmgt_view_policy()
{	
	 $obj_policy = new HrmgtCompanyPolicy;
	 $policydata= $obj_policy->hrmgt_get_single_police($_REQUEST['policy_id']);
?>
<div class="form-group"> 	<a href="#" class="close-btn badge badge-success pull-right">X</a>
  <h4 class="modal-title" id="myLargeModalLabel">
    <?php _e('Policy Detail','hr_mgt'); ?>
  </h4>
</div>
<hr>
<div class="panel panel-white form-horizontal">
  <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Title','hr_mgt');?>: </label>    
    <div class="col-sm-9"> <?php echo $policydata->policy_title;?> </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Status','hr_mgt');?>: </label>
    <div class="col-sm-9"><?php if($policydata->status==0)print "Deactive"; else print "Active"; ?></div>
  </div>
  <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Description','hr_mgt');?>: </label>    
    <div class="col-sm-9"> <?php echo $policydata->description;?> </div>
  </div>  
</div>
<?php 
	die();
}
function hrmgt_view_trainee()
{
	$obj_training	=	new HrmgtTraining;
	$employees 	= 	$obj_training->check_training_emp($_REQUEST['training_id']);
	$training 	= 	$obj_training->hrmgt_get_single_training($_REQUEST['training_id']);	
	$id 	= 	get_current_user_id();
	$meta 	= 	get_usermeta($id);	
?>
<script type="text/javascript">	
/* function PrintElem(elem){
	Popup($(elem).html());
}
function Popup(data){
    var mywindow = window.open('', '', 'height=700,width=800');       
        mywindow.document.write(data);
        mywindow.document.close();
        mywindow.focus();
        mywindow.print();
        mywindow.close();
        return true;
    } */
</script>
<div class="print_show" style="max-height:500px">
<div class="modal-header"> <a href="#" class="close-btn badge badge-success pull-right">X</a>
	<h4 id="myLargeModalLabel" class="modal-title">
	<?php _e("Employee Training","hr_mgt"); 
	//echo get_the_title($training->training_type);?>
	</h4>
</div>
<div class="panel-body " style="height:500px; overflow:auto" >
	<table class="table">
		<tbody>
			<tr>
				<td><?php _e("Training Type","hr_mgt");?></td>
				<td><?php  print $training->training_title  ?></td>
			</tr>
			<tr>
				<td><?php _e("Training Subject","hr_mgt");?></td>
				<td><?php  print get_the_title($training->training_subject)  ?></td>
			</tr>
			<tr>
				<td><?php _e("Trainer","hr_mgt");?></td>
				<td><?php  print hrmgt_get_display_name($training->traininer)  ?></td>
			</tr>
			<tr>
				<td><?php _e("Training Location","hr_mgt");?></td>
				<td><?php  print $training->training_location  ?></td>
			</tr>
			<tr>
				<td><?php _e("Training Start Date","hr_mgt");?></td>
				<td><?php  print hrmgt_change_dateformat($training->start_date)  ?></td>
			</tr>
			<tr>
				<td><?php _e("Training End Date","hr_mgt");?></td>
				<td><?php  print hrmgt_change_dateformat($training->end_date)  ?></td>
			</tr>
			<tr>
				<td><?php _e("Description","hr_mgt");?></td>
				<td><?php  print $training->description  ?></td>
			</tr>
		</tbody>
	</table>
	<p class="student_name"><?php  _e("View Trainee List","hr_mgt"); ?></p>
	<table class="table table-bordered" border="1">
		<tr>
			<th><?php _e('Photo','hr_mgt');?></th>
			<th><?php _e('Name','hr_mgt');?></th>
			<th> <?php _e('Designation','hr_mgt');?></th>
		</tr>
<?php 
	if(!empty($employees))
	{
		$employees = array_filter($employees);
		foreach($employees as $emp_id)
		{
			$emp=get_userdata($emp_id);
?>
	<tr>
		<td><?php $userimage=get_user_meta($emp_id, 'hrmgt_user_avatar', true);			
		if(empty($userimage))
		{
			echo '<img src='.get_option( 'hrmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
		}
		else
		echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';?></td>
      <td><?php echo $emp->display_name;?></td>
		<td>
			<?php 
			$designationid=0;
			$designationid=get_user_meta($emp_id,'designation',true);
			echo get_the_title($designationid);?>
		</td>
    </tr>
<?php
		}
	}
	else{
		echo '<td colspan=3>';_e('No Employees','hr_mgt');	echo '</td>';
	}?>
	</table>

</div>
<!--<a id="exprience_latter" href="?page=hrmgt-user&print=print&type=exepriance&employee_id=<?php print $employee_id; ?>" id="print_exprience_latter" class="btn btn-primary"  target="_blank" ><?php _e('Print','hr_mgt'); ?></a>-->
<a href="?page=hrmgt-user&print=print&type=tranee&training_id=<?php print $_REQUEST['training_id']; ?>" target="_blank" class="btn btn-primary pull-right"><?php _e('Print','hr_mgt'); ?></a>
<!--<button type="button" style="padding:6px 20px; margin:10px;" class="btn btn-primary pull-right" id="" onclick="PrintElem('.print_show')"><?php _e('Print','hr_mgt'); ?></button>-->
</div>
<hr/>

<?php
	die();
}
function hrmgt_view_perfomance_mark()
{
	$obj_par_mark=new HrmgtParfomanceMark;
	$marksdata = $obj_par_mark->hrmgt_get_single_parfomance_marks($_REQUEST['perfomance_id']);
	$performance_metadata=$obj_par_mark->hrmgt_get_performace_employee($_REQUEST['perfomance_id']);
?>
<a href="#" class="close-btn badge badge-success pull-right">X</a>
<div class="form-group"> 	
	  <h4 class="modal-title" id="myLargeModalLabel">
		<?php _e('Perfomance Mark Detail','hr_mgt'); ?>
	  </h4>
</div>
<hr>
<div class="panel panel-white form-horizontal">
	<div class="form-group">
		<label class="col-sm-3" for="notice_title"> <?php _e(' Project','hr_mgt');?>: </label>
		<div class="col-sm-9"> <?php echo hrmgt_get_project_title($marksdata->project_id);?> </div>
	</div>    
	<div class="form-group">
		<label class="col-sm-3" for="notice_title"> <?php _e(' Title','hr_mgt');?>: </label>
		<div class="col-sm-9"> <?php echo $marksdata->title;?> </div>
	</div>    
	<div class="form-group">
		<label class="col-sm-3" for="notice_title"><?php _e(' Mark','hr_mgt');?>: </label>
		<div class="col-sm-9"> <?php echo $marksdata->mark ;?> </div>
	</div>  
	<div class="form-group">
		<label class="col-sm-3" for="notice_title"><?php _e(' Performance Evaluation period','hr_mgt');?>: </label>
		<div class="col-sm-9"> <?php echo $marksdata->period_start . "  TO  " .  $marksdata->period_end;?>  </div>
	</div>
   
	<div class="form-group">
		<label class="col-sm-3" for="notice_title"><?php _e(' Description','hr_mgt');?>: </label>
		<div class="col-sm-9"> <?php echo $marksdata->description;?> </div>
  </div>
</div>
<table class="table table-bordered" border="1" style="overflow-y:scroll;">
<tbody>
	<tr>
		<th><?php _e('Photo','hr_mgt'); ?></th>
		<th><?php _e('Name','hr_mgt'); ?></th>
		<th> <?php _e('Designation','hr_mgt');?></th>
	</tr>							
	<?php 
		foreach($performance_metadata as $key=>$val){ ?>
		<tr>
			<?php 	$userdata = get_userdata($val->employee_id);
				if(!empty($userdata->hrmgt_user_avatar)){
			?>
			<td><img src="<?php print $userdata->hrmgt_user_avatar; ?>" class="img-circle" width="50px" height="50px"></td>
			<?php } else{ ?> 
			 <td><img src="<?php print get_option('hrmgt_system_logo'); ?>" class="img-circle" width="50px" height="50px"></td>
			<?php } ?>
			<td><?php print  hrmgt_get_display_name($val->employee_id); ?></td>
			<td><?php print get_the_title($userdata->designation); ?></td>
		</tr>
		<?php }	?>
	</tbody>
</table>
					
<?php 
	die();
}
function hrmgt_view_suggestion()
{
	
	$obj_suggestion=new HrmgtSuggestion;
	$suggestiondata = $obj_suggestion->hrmgt_get_single_suggestion($_REQUEST['suggestion_id']);
?>
<div class="form-group"> 	<a href="#" class="close-btn badge badge-success pull-right">X</a>
  <h4 class="modal-title" id="myLargeModalLabel">
<?php _e('Suggestion Detail','hr_mgt'); ?>
  </h4>
</div>
<hr>
<div class="panel panel-white form-horizontal">
  <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Title','hr_mgt');?>: </label>    
    <div class="col-sm-9"><?php echo $suggestiondata->suggetion_title;?></div>
  </div>
   <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Suggestion From','hr_mgt');?>: </label>
    <div class="col-sm-9"><?php echo hrmgt_get_display_name($suggestiondata->employee_id);?> </div>
  </div>
   <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Suggestion Date','hr_mgt');?>: </label>
    <div class="col-sm-9"><?php echo hrmgt_change_dateformat($suggestiondata->suggestion_date);?> </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Suggestion','hr_mgt');?>: </label>    
    <div class="col-sm-9"><?php echo $suggestiondata->suggestion;?></div>
  </div>
</div>
<?php 
	die();
}
function hrmgt_view_event()
{
	$event_id=$_REQUEST['event_id'];
	$postdata=get_post($event_id);	
?>
<div class="form-group"> 	<a href="#" class="close-btn badge badge-success pull-right">X</a>
  <h4 class="modal-title" id="myLargeModalLabel">
<?php _e('Event Detail','hr_mgt'); ?>
  </h4>
</div>
<hr>
<div class="panel panel-white form-horizontal">
  <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Title','hr_mgt');?>: </label>
    <div class="col-sm-9"><?php echo $postdata->post_title;?></div>
  </div>
	<?php
		$ed1 = strtotime(get_post_meta($event_id,'event_start_date',true));
		$ed2 = strtotime(get_post_meta($event_id,'event_end_date',true));
		if($ed1==$ed2)
		{
			$EventDate = hrmgt_change_dateformat(get_post_meta($event_id,'event_start_date',true));
		}
		else
		{
			$EventDate = hrmgt_change_dateformat(get_post_meta($event_id,'event_start_date',true)) .' To '.hrmgt_change_dateformat(get_post_meta($event_id,'event_end_date',true));
		} 
	?>
   <div class="form-group">
    <label class="col-sm-3" for="notice_title">
	<?php _e(' Event  Date','hr_mgt');?>
	: </label>
    <div class="col-sm-9"><?php echo $EventDate; ?></div>
  </div>
 
   <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Event Place','hr_mgt');?>: </label>
    <div class="col-sm-9"><?php echo get_post_meta($event_id,'event_place',true);?> </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Description','hr_mgt');?>: </label>
    <div class="col-sm-9"><?php echo $postdata->post_content;?></div>
  </div>
</div>
<?php 
	die();
}

function hrmgt_view_notice ()
{
	$notice_id=$_REQUEST['notice_id'];
	$postdata=get_post($notice_id);	
?>
<div class="form-group"> 	<a href="#" class="close-btn badge badge-success pull-right">X</a>
  <h4 class="modal-title" id="myLargeModalLabel">
<?php _e('Notice Detail','hr_mgt'); ?>
  </h4>
</div>
<hr>
<div class="panel panel-white form-horizontal">
  <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Title','hr_mgt');?>: </label>
    <div class="col-sm-9"><?php echo $postdata->post_title;?></div>
  </div>
	<?php
		$nd1 = strtotime(get_post_meta($notice_id,'start_date',true));
		$nd2 = strtotime(get_post_meta($notice_id,'end_date',true));
		if($nd1==$nd2)
		{
			$NoticeDate = hrmgt_change_dateformat(get_post_meta($notice_id,'start_date',true));
		}
		else
		{
			$NoticeDate = hrmgt_change_dateformat(get_post_meta($notice_id,'start_date',true)).' To '.hrmgt_change_dateformat(get_post_meta($notice_id,'end_date',true));
		}
	?>   
	<div class="form-group">
		<label class="col-sm-3" for="notice_title"><?php _e(' Notice Date','hr_mgt');?>: </label>
		<div class="col-sm-9"><?php echo $NoticeDate;?></div>
	</div>  
  <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Description','hr_mgt');?>: </label>
    <div class="col-sm-9"><?php echo $postdata->post_content;?></div>
  </div>
</div>
<?php 
	die();
}


function hrmgt_view_complaint()
{
	$postdata=get_post($_REQUEST['complaint_id']);?>
<div class="form-group"> 	<a href="#" class="close-btn badge badge-success pull-right">X</a>
  <h4 class="modal-title" id="myLargeModalLabel"><?php _e('Complaint Detail','hr_mgt'); ?></h4>
</div>
<hr>
<div class="panel panel-white form-horizontal">
  <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Title','hr_mgt');?>: </label>    
    <div class="col-sm-9"><?php echo $postdata->post_title;?></div>
  </div>
   <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Complaint Date','hr_mgt');?>: </label>    
    <div class="col-sm-9"> <?php echo hrmgt_change_dateformat($postdata->complaint_date);?> </div>
  </div>
    <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Complaint Status','hr_mgt');?>: </label>
    <div class="col-sm-9"><?php echo $postdata->complaint_status;?></div>
  </div>
  
   <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Complaint From','hr_mgt');?>: </label>
    <div class="col-sm-9"><?php echo hrmgt_get_display_name($postdata->complaint_from);?></div>
  </div>
  <div class="form-group">
    <label class="col-sm-3" for="notice_title"><?php _e(' Description','hr_mgt');?>: </label>
    <div class="col-sm-9"><?php echo $postdata->post_content;?></div>
  </div>
</div>
<?php 
	die();
}
function hrmgt_view_payslip(){
	$obj_payslip=new HrmgtPayslip;	
	$payslip_data=$obj_payslip->hrmgt_get_single_payslips($_REQUEST['payslip_id']);	
?>
	<div class="modal-header">
		<a href="#" class="close-btn badge badge-success pull-right">X</a>
		<h4 class="modal-title"><?php echo get_option('hrmgt_system_name');?></h4>
	</div>
	<div class="modal-body" style="height:500px; overflow:auto;">
		<div id="invoice_print"> 
			<table width="100%" border="0">
				<tbody>
					<tr>
						<td width="66%">
							<img style="max-height:80px;" src="<?php echo get_option( 'hrmgt_system_logo' ); ?>">
						</td>
						<td align="right" width="35%">
							<h5><?php $issue_date='DD-MM-YYYY';
								if(!empty($payslip_data)){ 
									$salary_date=hrmgt_change_dateformat($payslip_data->salary_date);
								}								
								echo __('Salary Date','hr_mgt')." : ".$salary_date;?></h5>
									<h5><?php echo __('Salary Month','hr_mgt')." : ".hrmgt_change_dateformat($payslip_data->start_date)." TO ".hrmgt_change_dateformat($payslip_data->end_date);?></h5>
						</td>
					</tr>
				</tbody>
			</table>
			<hr>
			<table width="100%" border="0">
				<tbody>
					<tr>
						<td align="left"><h4><?php _e('Company','hr_mgt');?> </h4></td>
						<td align="right"><h4><?php _e('Employee','hr_mgt');?> </h4></td>
					</tr>
					<tr>
						<td valign="top" align="left">
							<?php echo get_option( 'hrmgt_system_name' )."<br>"; 
							echo get_option( 'hrmgt_office_address' ).","; 
							echo get_option( 'hrmgt_contry' )."<br>"; 
							echo get_option( 'hrmgt_contact_number' )."<br>"; 
						?>
						</td>
						<td valign="top" align="right">
							<?php 
							if(!empty($payslip_data)){
								$employee=get_userdata($payslip_data->employee_id);
								echo $employee->display_name; 
							} ?>
						</td> 
					</tr>
				</tbody>
			</table>
			<hr>
			<h4><?php _e('Payslip Entries','hr_mgt');?></h4>
			<table class="table table-bordered" border="1" style="border-collapse:collapse; width:50% !important;float:left;">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th><?php _e('Allowance','hr_mgt');?> </th>
						<th><?php _e('Price','hr_mgt');?></th>
					</tr>
					</thead>
					<tbody>
						<?php 
							$total_amount=0;
							$extra_salary_entry=json_decode($payslip_data->extra_salary_entry);
							if(!empty($extra_salary_entry))
							{	$i=1;
								$total_extra_amount=0;
								foreach($extra_salary_entry as $salary_entry){ ?>
							<tr>
								<td class="text-center"><?php echo $i;?></td>
								<td><?php echo $salary_entry->entry; ?> </td>
								<td class="text-right"> <?php echo $salary_entry->amount; ?></td>
							</tr>
							<?php 
							$total_extra_amount+=$salary_entry->amount;	
							$i++;	}
						} ?>
						</tbody>
					</table>
					<table class="table table-bordered" border="1" style="border-collapse:collapse; width:50% !important; float:right;">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th><?php _e('Deduction','hr_mgt');?> </th>
								<th><?php _e('Price','hr_mgt');?></th>
								
							</tr>
						</thead>
						<tbody>
						<?php
						$total_amount=0;
							$extra_deduction_entry=json_decode($payslip_data->extra_deduction_entry);
							if(!empty($extra_deduction_entry))
							{	$i=1;
								$total_deduction_amount=0;
								foreach($extra_deduction_entry as $salary_entry){ ?>
							<tr>
								<td class="text-center"><?php echo $i;?></td>
								<td><?php echo $salary_entry->entry; ?> </td>
								<td class="text-right"> <?php echo $salary_entry->amount; ?></td>
							</tr>
						<?php
						$total_deduction_amount+=$salary_entry->amount;
							$i++;	}
						} ?>
						</tbody>
					</table>
					<table width="100%" border="0">
						<tbody>
						<tr>
								<td width="80%" align="right"><?php _e('Basic Salary :','apartment_mgt');?></td>
								<td align="right"><?php echo $payslip_data->basic_salary;?></td>
							</tr>
							
							<tr>
								<td width="80%" align="right"><?php _e('Allowance :','apartment_mgt');?></td>
								<td align="right"><?php echo $total_extra_amount;?></td>
							</tr>
							<tr>
								<td width="80%" align="right"><?php _e('Deduction :','apartment_mgt');?></td>
								<td align="right"><?php echo $total_deduction_amount;?></td>
							</tr>
							<tr>
								<td colspan="2">
									<hr style="margin:0px;">
								</td>
							</tr>
													
							<tr>
								<td width="80%" align="right"><?php _e('Grand Total :','apartment_mgt');?></td>
								<td align="right"><h4><?php $sub_total=$payslip_data->basic_salary+$total_extra_amount;
										$grand_total=$sub_total-$total_deduction_amount;
										echo $grand_total; ?></h4></td>
							</tr>
						
						</tbody>
					</table>
				</div>
				<div class="print-button pull-left">
					<a  href="?page=hrmgt-payslip&print=print&type=payslip&payslip_id=<?php echo $_REQUEST['payslip_id'];?>" target="_blank"class="btn btn-success"><?php _e('Print','hr_mgt');?></a>
				</div>
			</div>
			
<?php die();
}

function hrmgt_view_project(){	
	$obj_project=new HrmgtProject;	
	$project_data=$obj_project->hrmgt_get_single_project($_REQUEST['project_id']);	
	$project_metadata=$obj_project->hrmgt_get_project_employee($_REQUEST['project_id']);

?><div class="modal-header">
			<a href="#" class="close-btn badge badge-success pull-right">X</a>
			<h4 class="modal-title"><?php _e("Project Detail","hr_mgt");?></h4>
		</div>
			<div class="modal-body" style="min-height:200px;">
				<div id="invoice_print"> 				
														
					<table class="table">
						<tbody>
							<tr>
								<th><?php _e('Project Title','hr_mgt');?></th>
								<td><?php print $project_data->project_title ?></td>
							</tr>
								<th><?php _e('Client Name','hr_mgt');?></th>
								<td><?php print $project_data->client_name ?></td>
							<tr>
								<th><?php _e(' Project Start Date','hr_mgt');?></th>
								<td><?php print hrmgt_change_dateformat($project_data->start_date) ?></td>
							</tr>
							<tr>
								<th><?php _e(' Project End Date','hr_mgt');?></th>
								<td><?php print hrmgt_change_dateformat($project_data->end_date) ?></td>
							</tr>							
							<tr>
								<th><?php _e(' Description','hr_mgt');?></th>
								<td><?php print $project_data->description ?></td>
							</tr>					
							
						</tbody>
					</table>
					
					<table class="table table-bordered" border="1" style="overflow-y:scroll;">
						<tbody>
							<tr>
							  <th><?php _e('Photo','hr_mgt'); ?></th>
							  <th><?php _e('Name','hr_mgt'); ?></th>
							  <th> <?php _e('Designation','hr_mgt');?></th>
							</tr>							
							<?php
							foreach($project_metadata as $key=>$val){ ?>
									<tr>
										<?php 	$userdata = get_userdata($val->employee_id);
										if(!empty($userdata->hrmgt_user_avatar)){
										?>
										<td><img src="<?php print $userdata->hrmgt_user_avatar; ?>" class="img-circle" width="50px" height="50px"></td>
										<?php } else{ ?>
										<td><img src="<?php print get_option('hrmgt_system_logo'); ?>" class="img-circle" width="50px" height="50px"></td>
										<?php } ?>
										<td><?php print  hrmgt_get_display_name($val->employee_id); ?></td>
										 <td><?php print get_the_title($userdata->designation); ?></td>
									</tr>
								<?php }	?>
							</tbody>
					</table>
				</div>				
			</div>	
			
	<?php die();
}
function hrmgt_view_client_feedback(){	
	$obj_feedback=new HrmgtCientFeedBack;
	
	$cf_data=$obj_feedback->hrmgt_get_single_c_feedback($_REQUEST['feddback_id']);
	$cf_metadata=$obj_feedback->hrmgt_get_cf_employee($_REQUEST['feddback_id']);
	
	?>
	<script type="text/javascript">					
		$(function () { 
			$(".rateYo").rateYo({ 
				rating    :<?php print $cf_data->rate; ?>,
				readOnly:true				
			});
		});		
	</script>
									
		<div class="modal-header">
			<a href="#" class="close-btn badge badge-success pull-right">X</a>
			<h4 class="modal-title"><?php _e("Client Feedback Detail","hr_mgt");?></h4>
		</div>
			<div class="modal-body" style="min-height:200px;">
				<div id="invoice_print">														
					<table class="table">
						<tbody>
							<tr>
								<th><?php _e('Client Name','hr_mgt');?></th>
								<td><?php print $cf_data->client_name; ?></td>
							</tr>
							<tr>
								<th><?php _e('Project Title','hr_mgt');?></th>
								<td><?php print hrmgt_get_project_title($cf_data->project_id); ?></td>
							</tr>
								<th><?php _e('Comment','hr_mgt');?></th>
								<td><?php print $cf_data->comment ?></td>
							</tr>														
							<tr>
								<th><?php _e(' Ratting','hr_mgt');?></th>
								<td> <div class="rateYo"></div>																		
								</td>
							</tr>				
							
						</tbody>
					</table>
					
					<table class="table table-bordered" border="1" style="overflow-y:scroll;">
						<tbody>
							<tr>
							  <th><?php _e('Photo','hr_mgt'); ?></th>
							  <th><?php _e('Name','hr_mgt'); ?></th>
							  <th> <?php _e('Designation','hr_mgt');?></th>
							</tr>							
							<?php foreach($cf_metadata as $key=>$val){ ?>
									<tr>
										<?php 	$userdata = get_userdata($val->employee_id);
										if(!empty($userdata->hrmgt_user_avatar)){
										?>
										 <td><img src="<?php print $userdata->hrmgt_user_avatar; ?>" class="img-circle" width="50px" height="50px"></td>
										<?php } else{ ?> 
										 <td><img src="<?php print get_option('hrmgt_system_logo'); ?>" class="img-circle" width="50px" height="50px"></td>
										<?php } ?>
										 <td><?php print  hrmgt_get_display_name($val->employee_id); ?></td>
										 <td><?php print get_the_title($userdata->designation); ?></td>
									</tr>
								<?php }	?>													
						</tbody>
					</table>
				</div>				
			</div>	
			
<?php die();
}
function hrmgt_print_payslip($id){	
	$obj_payslip=new HrmgtPayslip;	
	$payslip_data=$obj_payslip->hrmgt_get_single_payslips($id);
	?>
	<div class="modal-header">		
			<h4 class="modal-title"><?php echo get_option('hrmgt_system_name');?></h4>
		</div>
			<div class="modal-body" style="height:500px; overflow:auto;">
				<div id="invoice_print"> 
					<table width="100%" border="0">
						<tbody>
							<tr>
								<td width="70%">
									<img style="max-height:80px;" src="<?php echo get_option( 'hrmgt_system_logo' ); ?>">
								</td>
								<td align="right" width="24%">
									<h5><?php $issue_date='DD-MM-YYYY';
										if(!empty($payslip_data)){ 
											$salary_date=hrmgt_change_dateformat($payslip_data->salary_date);
										}									
									echo __('Salary Date','hr_mgt')." : ".$salary_date;?></h5>
									<h5><?php echo __('Salary Month','hr_mgt')." : ".hrmgt_change_dateformat($payslip_data->start_date) ." TO ".hrmgt_change_dateformat($payslip_data->end_date);?></h5>
								</td>
							</tr>
						</tbody>
					</table>
					<hr>
					<table width="100%" border="0">
						<tbody>
							<tr>
								<td align="left">
									<h4><?php _e('Company','hr_mgt');?> </h4>
								</td>
								<td align="right">
									<h4><?php _e('Employee','hr_mgt');?> </h4>
								</td>
							</tr>
							<tr>
								<td valign="top" align="left">
									<?php echo get_option( 'hrmgt_system_name' )."<br>"; 
									 echo get_option( 'hrmgt_office_address' ).","; 
									 echo get_option( 'hrmgt_contry' )."<br>"; 
									 echo get_option( 'hrmgt_contact_number' )."<br>"; 
									?>
								</td>
								<td valign="top" align="right">
									<?php 
									if(!empty($payslip_data)){
										$employee=get_userdata($payslip_data->employee_id);
									echo $employee->display_name; 
									} ?>
								</td> 
							</tr>
						</tbody>
					</table>
					<hr>
					<h4><?php _e('Payslip Entries','hr_mgt');?></h4>
					<table class="table table-bordered" border="1" style="border-collapse:collapse; width:50% !important;float:left;">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th><?php _e('Entry','hr_mgt');?> </th>
								<th><?php _e('Price','hr_mgt');?></th>
								
							</tr>
						</thead>
						<tbody>
						<?php
						$total_amount=0;
							$extra_salary_entry=json_decode($payslip_data->extra_salary_entry);
							if(!empty($extra_salary_entry))
							{	$i=1;
								$total_extra_amount=0;
								foreach($extra_salary_entry as $salary_entry){ ?>
							<tr>
								<td class="text-center"><?php echo $i;?></td>
								<td><?php echo $salary_entry->entry; ?> </td>
								<td class="text-right"> <?php echo $salary_entry->amount; ?></td>
							</tr>
						<?php 
						$total_extra_amount+=$salary_entry->amount;	
							$i++;	}
						} ?>
						</tbody>
					</table>
					<table class="table table-bordered" border="1" style="border-collapse:collapse; width:50% !important; float:right;">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th><?php _e('Deduction','hr_mgt');?> </th>
								<th><?php _e('Price','hr_mgt');?></th>
								
							</tr>
						</thead>
						<tbody>
						<?php 
							$total_amount=0;
							$extra_deduction_entry=json_decode($payslip_data->extra_deduction_entry);
							if(!empty($extra_deduction_entry))
							{	$i=1;
								$total_deduction_amount=0;
								foreach($extra_deduction_entry as $salary_entry){ ?>
							<tr>
								<td class="text-center"><?php echo $i;?></td>
								<td><?php echo $salary_entry->entry; ?> </td>
								<td class="text-right"> <?php echo $salary_entry->amount; ?></td>
							</tr>
						<?php 
								$total_deduction_amount+=$salary_entry->amount;
							$i++;	}
						} ?>
						</tbody>
					</table>
					<table width="100%" border="0">
						<tbody>
						<tr>
								<td width="80%" align="right"><?php _e('Basic Salary :','apartment_mgt');?></td>
								<td align="right"><?php echo $payslip_data->basic_salary;?></td>
							</tr>
							
							<tr>
								<td width="80%" align="right"><?php _e('Allowance :','apartment_mgt');?></td>
								<td align="right"><?php echo $total_extra_amount;?></td>
							</tr>
							<tr>
								<td width="80%" align="right"><?php _e('Deduction :','apartment_mgt');?></td>
								<td align="right"><?php echo $total_deduction_amount;?></td>
							</tr>
							<tr>
								<td colspan="2">
									<hr style="margin:0px;">
								</td>
							</tr>
													
							<tr>
								<td width="80%" align="right"><?php _e('Grand Total :','apartment_mgt');?></td>
								<td align="right"><h4><?php $sub_total=$payslip_data->basic_salary+$total_extra_amount;
										$grand_total=$sub_total-$total_deduction_amount;
										echo $grand_total; ?></h4></td>
							</tr>
						
						</tbody>
					</table>
				</div>
			</div>		
	<?php die();
}
function hrmgt_print_tranee($id)
{
	$obj_training	=	new HrmgtTraining;
	$employees 	= 	$obj_training->check_training_emp($id);
	$training 	= 	$obj_training->hrmgt_get_single_training($id);	
	$id 	= 	get_current_user_id();
	$meta 	= 	get_userdata($id);	
?>

<div class="print_show" style="">
	<h4 id="myLargeModalLabel" class="modal-title">
	<?php _e("Employee Training","hr_mgt"); 
	//echo get_the_title($training->training_type);?>
	</h4>
</div>
<div class="panel-body " style="height:500px; overflow:auto" >
	<table class="table">
		<tbody>
			<tr>
				<td><?php _e("Training Type","hr_mgt");?></td>
				<td><?php  print $training->training_title  ?></td>
			</tr>
			<tr>
				<td><?php _e("Training Subject","hr_mgt");?></td>
				<td><?php  print get_the_title($training->training_subject)  ?></td>
			</tr>
			<tr>
				<td><?php _e("Trainer","hr_mgt");?></td>
				<td><?php  print hrmgt_get_display_name($training->traininer)  ?></td>
			</tr>
			<tr>
				<td><?php _e("Training Location","hr_mgt");?></td>
				<td><?php  print $training->training_location  ?></td>
			</tr>
			<tr>
				<td><?php _e("Training Start Date","hr_mgt");?></td>
				<td><?php  print hrmgt_change_dateformat($training->start_date)  ?></td>
			</tr>
			<tr>
				<td><?php _e("Training End Date","hr_mgt");?></td>
				<td><?php  print hrmgt_change_dateformat($training->end_date)  ?></td>
			</tr>
			<tr>
				<td><?php _e("Description","hr_mgt");?></td>
				<td><?php  print $training->description  ?></td>
			</tr>
		</tbody>
	</table>
	<p class="student_name"><?php  _e("View Trainee List","hr_mgt"); ?></p>
	<table class="table table-bordered" border="1">
		<tr>
			<th><?php _e('Photo','hr_mgt');?></th>
			<th><?php _e('Name','hr_mgt');?></th>
			<th><?php _e('Designation','hr_mgt');?></th>
		</tr>
	<?php 
	if(!empty($employees))
	{
		$employees = array_filter($employees);
		foreach($employees as $emp_id)
		{
			$emp=get_userdata($emp_id);
	?>
	<tr>
		<td><?php $userimage=get_user_meta($emp_id, 'hrmgt_user_avatar', true);			
		if(empty($userimage))
		{
			echo '<img src='.get_option( 'hrmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
		}
		else
		echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';?></td>
      <td><?php echo $emp->display_name;?></td>
		<td>
			<?php 
			$designationid=0;
			$designationid=get_user_meta($emp_id,'designation',true);
			echo get_the_title($designationid);?>
		</td>
    </tr>
<?php
		}
	}
	else
	{
		echo '<td colspan=3>';_e('No Employees','hr_mgt');	echo '</td>';
	}
	?>
	</table>

</div>
</div>
<hr/>
<?php 
die; 
}
function hrmgt_print_exprience_latter($employee_id){
$employeedata = get_userdata($employee_id);
$arr = array();
$arr['{{system_name}}']=get_option('hrmgt_system_name');
$arr['{{join_date}}']=$employeedata->joining_date;
$arr['{{leave_date}}']=$employeedata->contract_end_date;
$arr['{{department_name}}']=hrmgt_get_department_name($employeedata->department);
$arr['{{employee_name}}']=$employeedata->display_name;
$content = get_option('hrmgt_exprience_latter_content');
$presentto = get_option('hrmgt_exprience_latter_to');
$replace_content =  hrmgt_string_replacemnet($arr,$content);
$replace_to =  hrmgt_string_replacemnet($arr,$presentto);
?>
<style>
.exprience{
	float:left;
	width:90%;	
	background-position: center center;
	background-size:200px 200px;
	background-repeat:no-repeat;
	border:3px solid lightblue;
	padding: 2% 5% ;
}
.letter_heading{
	float:left;
	text-align:center;
	width:100%;
	
}

.exprience .header{
	float:left;
	width:100%;
}
.exprience .header .header_right{
	background:lightblue;
	text-align:right;
}

.exprience .footer{
	width:100%;
	float:left;
	background:lightblue;
	text-align:center;
}
.exprience .footer p{
	margin:0;
}
.exprience .signeture{
	float:left;
	width:100%;
	border-bottom:1px solid lightblue;
	margin-top:25px;
}
.div{
	 float: left;
    width: 100%;
}
</style>



<div class="div">
<div id="printcontent" class="exprience">
<form action="" method="post" id="submit_data">
	<div class="header">	
		<div style="float:left;width:20%;"><img  height="10%" width="90%" class="img-responsive" src="<?php  print get_option('hrmgt_system_logo'); ?>" /></div>
		<div class="header_right"  style="float: left; width: 78%; padding-right: 20px;"> <h3><?php print  get_option('hrmgt_system_name'); ?><h3></div>
	</div>
	<div class="col-md-12">
		<div class="letter_heading"><h2><?php print get_option('hrmgt_exprience_latter_heading');?></h2></div>
		<div  class="div"><h4 ><?php print $replace_to; ?></h4></div>		
		<div class=""><p><?php print $replace_content; ?></p></div>	
	</div>
	<div class="col-md-12">
		<div class="col-md-7"></div>
		<div class="col-md-5" style="float:right; width:30%;">
			<div class="signeture"></div>
			<p><?php print hrmgt_get_display_name(get_current_user_id()); ?></p>
			<p><?php print get_option('hrmgt_system_name');?></p>
		</div>
	</div>
	<div class="footer">
		<p><b><?php _e('Address :','hr_mgt'); ?> </b><?php print get_option('hrmgt_office_address').",". get_option('hrmgt_contry'); ?></p>
		<p><b><?php _e('Email :','hr_mgt'); ?> </b><?php print get_option('hrmgt_email'); ?></p>
		<p><b><?php _e('Official Phone Number :','hr_mgt'); ?> </b><?php print get_option('hrmgt_contact_number'); ?></p>
	</div>	
	</form>
	</div>
</div>
<?php 	
die();
}

function hrmgt_view_holiday(){
	$id = $_REQUEST['holiday_id'];
	$obj_holiday = new HrmgtHoliday();	
	$holiday_data = $obj_holiday->hrmgt_get_single_holidays($id);
?>
	
<div class="modal-header">	
<a class="close-btn badge badge-success pull-right" href="#">X</a>
<h4 class="modal-title"><?php _e("Holiday Detail");?></h4>
</div>
<div class="modal-body">
<div id="invoice_print"> 
	<hr>
	<table class="" style="width:100%">						
		  <tr>
			<th><p><?php _e('Holiday Title','hr_mgt') ?></p></th>
			<td><p><?php print $holiday_data->holiday_title ?></p></td>
		  </tr>
		  <?php 
			
			if(strtotime($holiday_data->start_date)==strtotime($holiday_data->end_date))
			{
				$HolidayDate = hrmgt_change_dateformat($holiday_data->start_date);
			}
			else
			{
				$HolidayDate = hrmgt_change_dateformat($holiday_data->start_date).' To '.hrmgt_change_dateformat($holiday_data->end_date);
			}							
		  ?>
		  
		  <tr>
			<th><p><?php _e('Holiday Date ','hr_mgt') ?></p></th>
			<td><p><?php print $HolidayDate ?></p></td>
		  </tr>						 
		  
		   <tr>
			<th><p><?php _e('Description','hr_mgt') ?></p></th>
			<td><?php print $holiday_data->description ?></p></td>
		  </tr>

<?php die();} 

function hrmgt_view_tasklist(){
	$id = $_REQUEST['tasklist'];
	
	$obj_tasklist = new HrmgtOfficeMgt();	
	$tasklist_data = $obj_tasklist->hrmgt_get_single_tasks($id);
		
?>	
		<div class="modal-header">	
			<a class="close-btn badge badge-success pull-right" href="#">X</a>
			<h4 class="modal-title"><?php _e("Task Detail");?></h4>
		</div>
			<div class="modal-body">
				<div id="invoice_print"> 
					<hr>
					<table class="" style="width:100%">	 
						  
						  <tr>
							<th><p><?php _e('Work Title','hr_mgt') ?></p></th>
							<td><p><?php print $tasklist_data->work_title; ?></p></td>
						  </tr>
						  <tr>
							<th><p><?php _e('Working Date','hr_mgt') ?></p></th>
							<td><p><?php print hrmgt_change_dateformat($tasklist_data->working_date) ?></p></td>
						  </tr>						 
						   <tr>
							<th><p><?php _e('Work Start  Time','hr_mgt') ?></p></th>
							<td><p><?php print $tasklist_data->start_time ?></p></td>
						  </tr>
						   <tr>
							<th><p><?php _e('Work End Time','hr_mgt') ?></p></th>
							<td><?php print $tasklist_data->end_time ?></p></td>
						  </tr>
						  <tr>
							<th><p><?php _e('Description','hr_mgt') ?></p></th>
							<td><?php print $tasklist_data->description ?></p></td>
						  </tr>

<?php 
die();
}
function hrmgt_view_requirements(){
	$id = $_REQUEST['requirements'];	
	$obj_requirements = new HrmgtRequirements();	
	$requirements_data = $obj_requirements->hrmgt_get_single_posted_job($id);
?>
<div class="modal-header">	
			<a class="close-btn badge badge-success pull-right" href="#">X</a>
			<h4 class="modal-title"><?php _e("Requirement Detail");?></h4>
		</div>
			<div class="modal-body">
				<div id="invoice_print"> 
					<hr>
					<table class="" style="width:100%">					  
					  <tr>
						<th><p><?php _e('Job Title','hr_mgt') ?></p></th>
						<td><p><?php print $requirements_data->job_title; ?></p></td>
					  </tr>
					  <tr>
						<th><p><?php _e('Department','hr_mgt') ?></p></th>
						<td><p><?php print hrmgt_get_department_name($requirements_data->department_id); ?></p></td>
					  </tr>
					   <tr>
						<th><p><?php _e('Designation','hr_mgt') ?></p></th>
						<td><p><?php print get_the_title($requirements_data->designation); ?></p></td>
					  </tr>						  
					  <tr>
						<th><p><?php _e('No of Positions','hr_mgt') ?></p></th>
						<td><p><?php print $requirements_data->positions ?></p></td>
					  </tr>						 
					   <tr>
						<th><p><?php _e('Job Post Closing Date','hr_mgt') ?></p></th>
						<td><p><?php print hrmgt_change_dateformat($requirements_data->closing_date) ?></p></td>
					  </tr>
					  <tr>
						<th><p><?php _e('Status','hr_mgt') ?></p></th>
						<td><?php $requirements_data->status=='1'?print 'Open':print 'Close'; ?></p></td>
					  </tr>
					   <tr>
						<th><p><?php _e('Description','hr_mgt') ?></p></th>
						<td><?php print $requirements_data->description ?></p></td>
					  </tr>
					</table>
						  

<?php 
die();
} 
?>
<?php
function hrmgt_view_travel(){
	$id = $_REQUEST['travel_id'];	
	
	$obj_travel = new HrmgtTravel();	
	$travel_data = $obj_travel->hrmgt_get_single_travel($id);
?>	
		<div class="modal-header">	
			<a class="close-btn badge badge-success pull-right" href="#">X</a>
			<h4 class="modal-title"><?php _e("Travel Detail");?></h4>
		</div>
			<div class="modal-body">
				<div id="invoice_print"> 
					<hr>
					<table class="" style="width:100%">					 
						  
						  <tr>
							<th><p><?php _e('Visit Purpose','hr_mgt') ?></p></th>
							<td><p><?php print $travel_data->visit_purpose; ?></p></td>
						  </tr>
						  <tr>
							<th><p><?php _e('Travel Start Date','hr_mgt') ?></p></th>
							<td><p><?php print hrmgt_change_dateformat($travel_data->start_date); ?></p></td>
						  </tr>
						   <tr>
							<th><p><?php _e('Travel End Date','hr_mgt') ?></p></th>
							<td><p><?php print hrmgt_change_dateformat($travel_data->end_date); ?></p></td>
						  </tr>						  
						  <tr>
							<th><p><?php _e('Expected Budget','hr_mgt') ?></p></th>
							<td><p><?php print $travel_data->expected_budget ?></p></td>
						  </tr>	
						 <tr>
							<th><p><?php _e('Actual Budget','hr_mgt') ?></p></th>
							<td><p><?php print $travel_data->actual_budget ?></p></td>
						  </tr>
						<tr style="min-height:80px;">
							<td><p><?php _e('Destination','hr_mgt') ?></p></td>
							<td>
								<?php						
									$result = json_decode($travel_data->destination_data);
									foreach($result as $results){
										print rtrim($results->entry." ",',');									
									}							
								?>
							</td>
						</tr>						
						<tr>
							<th><p><?php _e(' Description','hr_mgt') ?></p></th>
							<td><p><?php print $travel_data->description ?></p></td>
						</tr>
					</table>
					</div>
					</div>
						  
<?php 
die();
} 

function hrmgt_view_employee(){
	$id = $_REQUEST['employee'];	
	$obj_employee = new HrmgtEmployee();	
	$emp_id = $obj_employee->hrmgt_get_single_employee_data($id);
	$result = get_user_meta($emp_id);
	print_r($result);
	exit;
?>
<div class="modal-header">	
	<a class="close-btn badge badge-success pull-right" href="#">X</a>
	<h4 class="modal-title"><?php _e("Travel Detail");?></h4>
</div>
			<div class="modal-body">
				<div id="invoice_print"> 
					<hr>
					<table class="" style="width:100%">						  
						  <tr>
							<th><p><?php _e('Visit Perpose','hr_mgt') ?></p></th>
							<td><p><?php print $travel_data->visit_purpose; ?></p></td>
						  </tr>
						  <tr>
							<th><p><?php _e('Travel Start Date','hr_mgt') ?></p></th>
							<td><p><?php print hrmgt_change_dateformat($travel_data->start_date); ?></p></td>
						  </tr>
						   <tr>
							<th><p><?php _e('Travel End Date','hr_mgt') ?></p></th>
							<td><p><?php print hrmgt_change_dateformat($travel_data->end_date); ?></p></td>
						  </tr>						  
						  <tr>
							<th><p><?php _e('Expected Budget','hr_mgt') ?></p></th>
							<td><p><?php print $travel_data->expected_budget ?></p></td>
						  </tr>	
						 <tr>
							<th><p><?php _e('Actual Budget','hr_mgt') ?></p></th>
							<td><p><?php print $travel_data->actual_budget ?></p></td>
						  </tr>
						<tr style="min-height:80px;">
							<td><p><?php _e('Destination','hr_mgt') ?></p></td>
								</table>	
							<?php
							$result = json_decode($travel_data->destination_data);
							foreach($result as $results){
								print rtrim($results->entry." ",',');	
							}
							?>
						</td>
						</tr>
 <tr>
	<th><p><?php _e('Status','hr_mgt') ?></p></th>
	<td><p><?php print $travel_data->status ?></p></td>
 </tr>
 <tr>
	<th><p><?php _e(' Description','hr_mgt') ?></p></th>
	<td><p><?php print $travel_data->description ?></p></td>
</tr>						  
<?php die();
} 
function hrmgt_view_criere(){ ?> 
<script>
	$(document).ready(function() {
		$("#employees").select2();
	});
</script>
<?php 
	$obj_requirements = new HrmgtRequirements();	
	$result =$obj_requirements->hrmgt_get_single_job($_REQUEST['job_id']);
	$allcriere = json_decode($result->criere_entry);
	foreach($allcriere as $key=>$value){ ?>
		<option value="<?php print $value; ?>"><?php print $value; ?></option>
<?php }	die();} 

function hrmgt_view_project_employee(){
?>
<?php 
	$obj_client_feedback = new HrmgtCientFeedBack();	
	$result =get_employee_by_project_id($_REQUEST['project_id']);	

	foreach($result as $key=>$value){?>
	<!--<option><?php /*_e('Select Employee','hr_mgt');*/?></option> -->
	<option value="<?php print $value->employee_id; ?>"><?php print hrmgt_get_display_name($value->employee_id); ?></option>
<?php }	die();} ?>
<?php

function hrmgt_update_attendance_detail_status()
{
	$obj_HrmgtAttendanceDetails=new HrmgtAttendanceDetails;
	$detail_id = $_REQUEST['detail_id'];
	$data = $_REQUEST['data'];
	$datedata = $_REQUEST['data'];
	$currantstatus = $_REQUEST['currantstatus'];
	$row = $obj_HrmgtAttendanceDetails->get_single_attendance_deatail($detail_id);
?>
<div class="row">
	<div class="col-sm-11"><strong><?php _e('CHANGE ATTENDANCE STATUS','hr_mgt');?></strong></div>
	<div class="col-sm-1"><a class="close-btn badge badge-success pull-right" href="#">X</a></div>
</div>
<hr>
<div class="row">
	<div class="col-sm-7"><strong><?php _e('Name');?> : </strong><?php print hrmgt_get_display_name($row[0]->employee_id) ?></div>
	<div class="col-sm-5"><strong><?php _e("Date : ");?></strong><?php print $_REQUEST['date'] ?></div>
</div>
<hr>
	<form name="category_form" action="" method="post" class="form-horizontal" id="category_form">
	<div class="form-group">		
		<div class="col-sm-4"><label class="control-label" for="category_name"><?php _e('Change To','hr_mgt');?><span class="require-field">*</span></label></div>
		<input type="hidden" name="attendancedetailid" value="<?php print $detail_id ?>"/>
		<input type="hidden" name="data" value="<?php print $data ?>"/>
		<div class="col-sm-4">
			<select name="status" class="form-control" >
				<option value="P" <?php selected('P',$currantstatus) ?> ><?php _e('P','hr_mgt'); ?></option>
				<option value="H" <?php selected('H',$currantstatus) ?> ><?php _e('H','hr_mgt'); ?></option>
				<option value="HL" <?php selected('HL',$currantstatus) ?> ><?php _e('HL','hr_mgt'); ?></option>
				<option value="A" <?php selected('A',$currantstatus) ?> ><?php _e('A','hr_mgt'); ?></option>
				<option value="AA" <?php selected('AA',$currantstatus) ?> ><?php _e('AA','hr_mgt'); ?></option>
				<option value="P.5" <?php selected('P.5',$currantstatus) ?> ><?php _e('P.5','hr_mgt'); ?></option>
			</select>
		</div>
		<div class="col-sm-4">
			<input type="submit" value="<?php _e('Update','hr_mgt'); ?>" name="update_attendance" class="btn btn-success"  id="btn-add-cat"/>	
		</div>			
	</div>
	</form>	
<?php die(); }
 
function hrmgt_leave_approve()
{ ?>
<div class="row">
	<div class="col-sm-11"><strong><?php _e('Leave Approve Comment','hr_mgt');?></strong></div>
	<div class="col-sm-1"><a class="close-btn badge badge-success pull-right" href="#">X</a></div>
</div>
<br><br>
	<form method="post">
		<div class="row">
			<div class="col-sm-2"><label class="control-label" for="category_name"><?php _e('Comment','hr_mgt');?></label></div>
			<input type="hidden" name="leave_id" value="<?php print $_REQUEST['leave_id'] ?>">
			<div class="col-sm-8">
				<textarea name="comment" cols="50" rows="2"></textarea>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<input type="submit" value="<?php _e('Submit','hr_mgt'); ?>" name="approve_comment" class="btn btn-success"  id="btn-add-cat"/>	
			</div>
		</div>	
	</form>
<?php 
die;	
}
function hrmgt_leave_reject()
{ ?>
<div class="row">
	<div class="col-sm-11"><strong><?php _e('Leave Reject Comment','hr_mgt');?></strong></div>
	<div class="col-sm-1"><a class="close-btn badge badge-success pull-right" href="#">X</a></div>
</div>
<br><br>
	<form method="post">
		<div class="row">
			<div class="col-sm-2"><label class="control-label" for="category_name"><?php _e('Comment','hr_mgt');?></label></div>
			<input type="hidden" name="leave_id" value="<?php print $_REQUEST['leave_id'] ?>">
			<div class="col-sm-8">
				<textarea name="comment" cols="50" rows="2"></textarea>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<input type="submit" value="<?php _e('Submit','hr_mgt'); ?>" name="reject_leave" class="btn btn-success"  id="btn-add-cat"/>	
			</div>
		</div>	
	</form>
<?php 
die;	
}


function hrmgt_delete_earning_deduction()
{	
	$key = $_REQUEST['key'];	
	$data_set = $_REQUEST['data_set'];
	if($data_set=='earning')
	{
		$OldEarning = get_option('earning');		
		$rem_earning = array_search($key,$OldEarning);
			unset($OldEarning[$rem_earning]);
		update_option('earning',$OldEarning);		
	}
	if($data_set=='deduction')
	{
		$OldDeduction = get_option('deduction');		
		$rem_earning = array_search($key,$OldDeduction);
			unset($OldDeduction[$rem_earning]);			
		update_option('deduction',$OldDeduction);
	}
die;	
}

function hrmgt_custom_payslip_emp()
{
	$EmpData = get_userdata($_REQUEST['employee_id']);
	$account_number = get_user_meta($EmpData->ID,'account_number',true);	
	$employee['userid'] 		= $EmpData->ID;
	$employee['accont_no'] 		= $account_number;
	$employee['department'] 	= get_user_meta($EmpData->ID,'department',true);
	$employee['joining_date'] 	= hrmgt_change_dateformat(get_user_meta($EmpData->ID,'joining_date',true));
	$employee['contract_end_date'] = hrmgt_change_dateformat(get_user_meta($EmpData->ID,'contract_end_date',true));
	$employee['ctc_month'] = get_user_meta($EmpData->ID,'employee_salary',true);
	print json_encode($employee);
	die;
}
?>
