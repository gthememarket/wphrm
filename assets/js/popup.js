jQuery(document).ready(function($) {
$("body").on("click", "#varify_key", function(event){
	$(".cmgt_ajax-img").show();	
	$(".page-inner").css("opacity","0.5");
	event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	var res_json;
	var licence_key = $('#licence_key').val();
	var enter_email = $('#enter_email').val();	
	var curr_data = {
		action: 'hrmgt_verify_pkey',
		licence_key : licence_key,
		enter_email : enter_email,
		dataType: 'json'
	};	
	$.post(hrmgt.ajax, curr_data, function(response) { 						
		res_json = JSON.parse(response);		
		$('#message').html(res_json.message);		
		$("#message").css("display","block");
		$(".cmgt_ajax-img").hide();
		$(".page-inner").css("opacity","1");
		if(res_json.hrmgt_verify == '0')
		{
			window.location.href = res_json.location_url;
		}
		return true; 					
	});	
});

	// for profile image extesion... pending
	/* $("body").on("click", "#profile_ext_btn", function(event){
		 var profile_exe = $('#profile_exe').val();		 
		var curr_data = {
			action: 'hrmgt_add_profile_exe',
			profile_exe: profile_exe,			
			dataType: 'json'
		};
				
		$.post(hrmgt.ajax, curr_data, function(response) {
			alert(response);
	 		return false;
	 	});	 
	
	}); */
	//start data table Attendance Ajax to
	/* $("body").on("click", "#filter_attendance", function(event){

	 
	  var Date  = $('#sdate').val() ;	
		var curr_data = {
	 	action: 'datatable_Present_attendance_ajax_load1',
	 	Date : Date,
	 	dataType: 'json'
	 	};	
										
	 	$.post(hrmgt.ajax, curr_data, function(response) { 	
		var json_obj = $.parseJSON(response);		
	 		alert(json_obj);				
			return false; 					
	 	});	
  }); */
 /*  jQuery(document).on('click', '#filter_attendance', function () {
    var attendance_date = $('#sdate').val();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {"action": "datatable_Present_attendance_ajax_load1", "attendance_date": attendance_date},
		
        success: function (data, textStatus, jqXHR) {
		 var table_data = JSON.parse(data);
		 var table = $('#attendance_list').DataTable({
		  
        }); 
        }
    });
}); */
	//End Data table Using AJAX 
	//Category Add and Remove
  $("body").on("click", "#addremove", function(event){	
	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	  var model  = $(this).attr('model') ;	 
	  var curr_data = {
	 	action: 'hrmgt_add_or_remove_category',
	 	model : model,
	 		dataType: 'json'
	 	};	
										
	 	$.post(hrmgt.ajax, curr_data, function(response) { 				
	 		$('.popup-bg').show().css({'height' : docHeight});			
			$('.category_list').html('');
			$('.category_list').html(response);				
			return true; 					
	 	});	
  });
  
	$("body").on("click", ".close-btn", function(){		
		$( ".category_list" ).empty();
		$('.popup-bg').hide();
		$( ".faq-content" ).empty();		
		$('.faq-popup-bg').hide();		// hide the overlay
	});  
  
$("body").on("click", ".btn-delete-cat", function(){		
	var cat_id  = $(this).attr('id') ;	
	var model  = $(this).attr('model') ;
	if(confirm("Are you sure want to delete this record?"))
	{
		var curr_data = {
			action: 'hrmgt_remove_category',
			model : model,
			cat_id:cat_id,			
			dataType: 'json'
		};
					
		$.post(hrmgt.ajax, curr_data, function(response) {						
			$('#cat-'+cat_id).hide();						
			$("#"+model).find('option[value='+cat_id+']').remove();						
			return true;				
		});			
	}
});
	
	
$("body").on("click", "#btn-add-cat", function(){	
	var category_name  = $('#category_name').val();
	if(category_name == '')
	{
		alert("Please enter category name");
		return false;
	}
	var model  = $(this).attr('model');		
	var curr_data = {
		action: 'hrmgt_add_category',
		model : model,
		category_name: category_name,			
		dataType: 'json'
	};
					
	$.post(hrmgt.ajax, curr_data, function(response) {			
		 var json_obj = $.parseJSON(response);//parse JSON	
		 
		$('.category_listbox .table').append(json_obj[0]);
		$('#category_name').val("");	
		
		$('#'+model).append(json_obj[1]);			
		return false;					
	});		
	
});

	$("body").on("click", ".experience_letter", function(event){	
		var employee_id = $(this).attr('id');
		  var docHeight = $(document).height();
		var curr_data = {
			action: 'hrmgt_experience_letter',
			employee_id: employee_id,			
			dataType: 'json'
		};
				
		$.post(hrmgt.ajax, curr_data, function(response) {
			$('.popup-bg').show().css({'height' : docHeight});
			$('.category_list').html(response);	
	 			return true;
	 	});	
	
	});

	
	 jQuery("body").on("change", ".duration", function(event){		
		if($(this).is(':checked')){
			duration = $(this).val();
			idset = $(this).attr('idset');
			
				
			var curr_data = {
				action: 'hrmgt_load_multiple_day',
				duration: duration,
				idset: idset,
				dataType: 'json'
			};
			$.post(hrmgt.ajax, curr_data, function(response) {				
				$('#leave_date').html(response);				
			});
		}
	 });	 
	$(".duration").trigger("change");
	
	
	
		
  /*-----------View FAQ------------------*/
	 $("body").on("click", ".view-faq", function(event){		   
	  var faq_id = $(this).attr('id');	  
	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	  
	   var curr_data = {
			action: 'hrmgt_view_faq',
			faq_id: faq_id,			
			dataType: 'json'
		};
	 					
		$.post(hrmgt.ajax, curr_data, function(response) {
			//alert(response);
			$('.faq-popup-bg').show().css({'height' : docHeight});
			$('.faq-content').html(response);	
			return true; 					
		});	
	});
			
			
	/*------------View Policy----------------*/		
	$("body").on("click", ".view-policy", function(event){
		   
	  var policy_id = $(this).attr('id');
	 //alert(policy_id);
	  
	  event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	  
	   var curr_data = {
			action: 'hrmgt_view_policy',
			policy_id: policy_id,			
			dataType: 'json'
		};	 					
		$.post(hrmgt.ajax, curr_data, function(response) {
			//alert(response);
			$('.faq-popup-bg').show().css({'height' : docHeight});
			$('.faq-content').html(response);	
			return true; 					
		});	
	});
	/*------------View FAQ----------------*/
	 $("body").on("click", ".view-training-imployee", function(event){
	 var training_id = $(this).attr('id');
	
	 event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	  
	   var curr_data = {
			action: 'hrmgt_view_trainee',
			training_id: training_id,			
			dataType: 'json'
		};
	 					
		$.post(hrmgt.ajax, curr_data, function(response) {
			// alert(response);
			$('.popup-bg').show().css({'height' : docHeight});
			$('.category_list').html(response);	
			return true;
		});	
	});	
	/*------------View FAQ----------------*/
	 $("body").on("click", ".view-perfomance-mark", function(event){
		 
		var perfomance_id = $(this).attr('id');
	
		event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		var docHeight = $(document).height(); //grab the height of the page
		var scrollTop = $(window).scrollTop();
	  
		var curr_data = {
			action: 'hrmgt_view_perfomance_mark',
			perfomance_id: perfomance_id,			
			dataType: 'json'
		};
	 					
		$.post(hrmgt.ajax, curr_data, function(response) {
			
			$('.popup-bg').show().css({'height' : docHeight});
			$('.category_list').html(response);	
			return true;
		});	
	});			
	/*------------View SUGGESTION----------------*/
	 $("body").on("click", ".view-suggestion", function(event){
		 
	 var suggestion_id = $(this).attr('id');
	event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	  
	   var curr_data = {
			action: 'hrmgt_view_suggestion',
			suggestion_id: suggestion_id,			
			dataType: 'json'
		};
	 					
		$.post(hrmgt.ajax, curr_data, function(response) {
			
			$('.popup-bg').show().css({'height' : docHeight});
			$('.category_list').html(response);	
			return true;
		});	
	});	
	/*------------View Event----------------*/
	$("body").on("click", ".view-event", function(event){
		 
	 var event_id = $(this).attr('id');
	
		event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		var docHeight = $(document).height(); //grab the height of the page
		var scrollTop = $(window).scrollTop();
	 
		var curr_data = {
	 		action: 'hrmgt_view_event',
	 		event_id: event_id,			
	 		dataType: 'json'
	 	};
	 	
		$.post(hrmgt.ajax, curr_data, function(response) {
	 		$('.popup-bg').show().css({'height' : docHeight});
			$('.category_list').html(response);	
	 		return true;
	 	});	
	});	

	$("body").on("click", ".view-notice", function(event){
		 
	 var notice_id = $(this).attr('id');
	
		event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		var docHeight = $(document).height(); //grab the height of the page
		var scrollTop = $(window).scrollTop();
	 
		var curr_data = {
	 		action: 'hrmgt_view_notice',
	 		notice_id: notice_id,			
	 		dataType: 'json'
	 	};
	 	
		$.post(hrmgt.ajax, curr_data, function(response) {			
	 		$('.popup-bg').show().css({'height' : docHeight});
			$('.category_list').html(response);	
	 		return true;
	 	});	
	});	
	
	
	/*------------View Event----------------*/
	 $("body").on("click", ".view-complaint", function(event){
		 
	 var complaint_id = $(this).attr('id');
	event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	  
	   var curr_data = {
	 					action: 'hrmgt_view_complaint',
	 					complaint_id: complaint_id,			
	 					dataType: 'json'
	 					};
	 					
	 					$.post(hrmgt.ajax, curr_data, function(response) {
	 						
	 						$('.popup-bg').show().css({'height' : docHeight});
							$('.category_list').html(response);	
	 						return true;
	 					});	
	 		});	

	/*------------View Payslip----------------*/
	 $("body").on("click", ".view-payslip", function(event){
		 
	var payslip_id = $(this).attr('id');
	
	event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	 
	   var curr_data = {
	 					action: 'hrmgt_view_payslip',
	 					payslip_id: payslip_id,							
	 					dataType: 'json'
	 					};
	 				
	 					$.post(hrmgt.ajax, curr_data, function(response) {
	 						//alert(response);
							//return false;
	 						$('.popup-bg').show().css({'height' : docHeight});
							$('.category_list').html(response);	
	 						return true;
	 					});	
	 		});	
				
				
	//View User Project		
	$("body").on("click", ".view-project", function(event){
		 
	var project_id = $(this).attr('id');
	//alert(project_id);
	event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	 
		var curr_data = {
			action: 'hrmgt_view_project',
			project_id: project_id,							
			dataType: 'json'
		};
	 				
		$.post(hrmgt.ajax, curr_data, function(response) {
			//alert(response);
			//return false;
			$('.popup-bg').show().css({'height' : docHeight});
			$('.category_list').html(response);	
			return true;
		});	
	});	






//View User client feedback		
	$("body").on("click", ".view-client-feedback", function(event){		 
		var feddback_id = $(this).attr('id');
		event.preventDefault(); // disable normal link function so that it doesn't refresh the page
		var docHeight = $(document).height(); //grab the height of the page
		var scrollTop = $(window).scrollTop();
	 
		var curr_data = {
			action: 'hrmgt_view_client_feedback',
			feddback_id: feddback_id,							
			dataType: 'json'
		};
	 				
		$.post(hrmgt.ajax, curr_data, function(response) {
			//alert(response);
			//return false;
			$('.popup-bg').show().css({'height' : docHeight});
			$('.category_list').html(response);	
			return true;
		});	
	});
			
			
	
		/*------------View Hodiday----------------*/
	$("body").on("click", ".view-holiday", function(event){
		 
	var holiday_id = $(this).attr('id');	
	event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	var docHeight = $(document).height(); //grab the height of the page
	var scrollTop = $(window).scrollTop();	 
	var curr_data = {
		action: 'hrmgt_view_holiday',
		holiday_id: holiday_id,							
		dataType: 'json'
	};
	 				
	$.post(hrmgt.ajax, curr_data, function(response) {
		$('.popup-bg').show().css({'height' : docHeight});
		$('.category_list').html(response);	
		return true;
	});	
});



	/*------------View User Task List----------------*/
		$("body").on("click", ".view-tasklist", function(event){
		 
	var tasklist = $(this).attr('id');		
	event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	 
	   var curr_data = {
	 					action: 'hrmgt_view_tasklist',
	 					tasklist: tasklist,							
	 					dataType: 'json'
	 					};
	 				
	 					$.post(hrmgt.ajax, curr_data, function(response) {
	 						//alert(response);
							//return false;
	 						$('.popup-bg').show().css({'height' : docHeight});
							$('.category_list').html(response);	
	 						return true;
	 					});	
	 		});
			
			
	/*------------View Requrement List----------------*/
	$("body").on("click", ".view-requirements", function(event){
		 
	var requirements = $(this).attr('id');
	//alert(requirements);
	event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	 
	   var curr_data = {
	 					action: 'hrmgt_view_requirements',
	 					requirements: requirements,							
	 					dataType: 'json'
	 					};
	 				
	 					$.post(hrmgt.ajax, curr_data, function(response) {
	 						//alert(response);
							//return false;
	 						$('.popup-bg').show().css({'height' : docHeight});
							$('.category_list').html(response);	
	 						return true;
	 					});	
	 		});
	
/*------------get all criteare----------------*/
$("body").on("change", ".show_criere", function(event){		 
	var job_id = $('option:selected', this).attr('id');
	//alert(job_id);
	 var curr_data = {
			action: 'hrmgt_view_criere',
			job_id:job_id,							
			dataType: 'json'
	 	};
		
		$.post(hrmgt.ajax, curr_data, function(response) {
	 		//alert(response);
			//return false;
	 		//$('.popup-bg').show().css({'height' : docHeight});
			$('.shortlist').html(response);	
	 		return true; 
	 		});	
		
	});
	
	
		/*------------View Hodiday----------------*/
	$("body").on("click", ".view-travel", function(event){
		 
	var travel_id = $(this).attr('id');	
	event.preventDefault(); // disable normal link function so that it doesn't refresh the page
	  var docHeight = $(document).height(); //grab the height of the page
	  var scrollTop = $(window).scrollTop();
	 
	   var curr_data = {
	 					action: 'hrmgt_view_travel',
	 					travel_id: travel_id,							
	 					dataType: 'json'
	 					};
	 				
	 					$.post(hrmgt.ajax, curr_data, function(response) {
	 						//alert(response);
							//return false;
	 						$('.popup-bg').show().css({'height' : docHeight});
							$('.category_list').html(response);	
	 						return true;
	 					});	
	 		});
		
	
	
		
	//var u_role = $('input[type=radio][name=role]:checked').attr('id');
	
$("body").on("click", ".user", function(event){	
	var u_role = $('input[type=radio][name=role]:checked').attr('id');	
	 var curr_data = {
	 		action: 'hrmgt_add_userform',
	 		u_role:u_role,							
	 		dataType: 'json'
	 	};		
		$.post(hrmgt.ajax, curr_data, function(response) {				
			$('.user_form').html(response);	
	 		return true;
	 	});
		
});	




$("body").on("change", "#project_id", function(event){
	var $ = jQuery;
	var project_id = $('option:selected', this).attr('value');	
	$('.smgt_loading').css("visibility","visible");
	$('#employees').html('');
	$('#employees').multiselect('rebuild');
	var categCheck = $('#employees').multiselect({disableIfEmpty: true,disabledText:'Loading..'});	
	var curr_data = {
			action: 'hrmgt_view_project_employee',
			project_id:project_id,							
			dataType: 'json'
	};		
	$.post(hrmgt.ajax, curr_data, function(response) {
		//alert(response); return false;
		/* $('#employees').html('');	 */
		console.log(response);
		$('.smgt_loading').css("visibility","hidden");
		$('#employees').html(response);	
		categCheck.multiselect('rebuild');
		return true; 
	});			
});





	
	
/*------------ Approve Leave Botton ----------------*/
$("body").on("click", ".leave-approve", function(event){		 
	var leave_id = $(this).attr('leave_id');	
	event.preventDefault();
	  var docHeight = $(document).height();
	  var scrollTop = $(window).scrollTop();
	  var curr_data = {
	 	  action: 'hrmgt_leave_approve',
	 	  leave_id: leave_id,							
	 	  dataType: 'json'
	 };
	 
	 $.post(hrmgt.ajax, curr_data, function(response) {
			$('.popup-bg').show().css({'height' : docHeight});
			$('.category_list').html(response);	
	 		return true;
	 	});	
});

/*------------ Reject Leave Botton ----------------*/
$("body").on("click", ".leave-reject", function(event){		 
	var leave_id = $(this).attr('leave_id');	
	event.preventDefault();
	  var docHeight = $(document).height();
	  var scrollTop = $(window).scrollTop();
	  var curr_data = {
	 	  action: 'hrmgt_leave_reject',
	 	  leave_id: leave_id,							
	 	  dataType: 'json'
	 };
	 
	 $.post(hrmgt.ajax, curr_data, function(response) {
			$('.popup-bg').show().css({'height' : docHeight});
			$('.category_list').html(response);	
	 		return true;
	 	});	
});

			
	
		/*------------ Approve Leave Botton ----------------*/
$("body").on("click", "#salaryslip_approv", function(event){		 
	var detail_id = $(this).attr('detail_id');
	event.preventDefault();
	  var docHeight = $(document).height();
	  var scrollTop = $(window).scrollTop();
	  var curr_data = {
	 	  action: 'hrmgt_approve_salary_slip',
	 	  detail_id: detail_id,							
	 	  dataType: 'json'
	 };
	 
	 $.post(hrmgt.ajax, curr_data, function(response) {
			$('.popup-bg').show().css({'height' : docHeight});
			$('.category_list').html(response);	
	 		return true;
	 	});	
});


$("body").on("click", ".delete-earning-deduction", function(event){	
	var data_set = $(this).attr('data-set');	
	var key = $(this).attr('value');	
	var curr_data = {
	 	action: 'hrmgt_delete_earning_deduction',
	 	data_set: data_set,							
	 	key: key,							
	 	dataType: 'json'
	};	 
	$.post(hrmgt.ajax, curr_data, function(response) {
		if(data_set=='earning')
		{
			$('.del_'+key).remove();	
		}
		if(data_set=='deduction')
		{
			$('.del_ded_'+key).remove();	
		}
	});	
});

$("body").on("change", "#employee_id", function(event){		
	var employee_id = $(this).val();		
	var curr_data = {
	 	action: 'hrmgt_custom_payslip_emp',
	 	employee_id: employee_id, 							
	 	dataType: 'json'
	};	 
	$.post(hrmgt.ajax, curr_data, function(response)
	{		
		var json_obj = $.parseJSON(response);//parse JSON		
		$('#custom_slip_account_numner').val(json_obj['accont_no']);			
		$('#custom_slip_join_date').html(json_obj['joining_date']);			
		$('#custom_slip_contract_end_date').html(json_obj['contract_end_date']);			
		$('#custom_slip_ctc_month').val(json_obj['ctc_month']);			
		$('#testuserid').html(json_obj['userid']);			
	});	
});
	
	
	
	
	
	
	
$("body").on("click", ".change_status", function(event){			
	var data = $(this).attr("data");	
	var currantstatus = $(this).attr("status");
	var detail_id = $(this).attr("detail_id");
	var data = $(this).attr("data");	
	var date = $(this).attr("date");	
	var docHeight = $(document).height();
	var curr_data = {
		action: 'hrmgt_update_attendance_detail_status',
		data:data,							
		data:data,							
		date:date,							
		currantstatus:currantstatus,							
		detail_id:detail_id,							
		dataType: 'json'
	};
	$.post(hrmgt.ajax, curr_data, function(response) {
		//alert(response);
		//return false;
		$('.popup-bg').show().css({'height' : docHeight});
		$('.category_list').html(response);	
		return true; 
	});	 
		
});
	

	jQuery("body").on("click",".deletealert",function(){
	if(confirm("Are you sure you want to Delete?"))
	{
		return true;
	}
	else
	{
		return false;
	}
});

	
	
});
