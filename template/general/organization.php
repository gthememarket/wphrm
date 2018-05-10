<?php
$obj_department = new HrmgtDepartment(); 		
$obj_travel=new HrmgtTravel; ?>
<div id="main-wrapper">
<script type="text/javascript">
	$(function () {
    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', '');
    $('.tree li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li ').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).attr('title', '').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
        } else {
            children.show('fast');
            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
        }
        e.stopPropagation();
    });
});
</script>
<style>
.padding-0{
	padding:0;
}
</style>
<div class="tree well">
	<ul>
		<?php 
			$result = $obj_department->get_all_parents_departments();
			foreach($result as $kay=>$value)
			{
				$dept_id = $value->id;				
				$head_department = $value->department_name;				
				$dept_head_id = $value->dept_head_id;				
				$result = get_userdata($dept_head_id);				
				if(!empty($result))
				{
					$dept_head_name = $result->display_name;
					$designation_id = get_user_meta($dept_head_id,'designation',true);
				}
				else 
				{
					$dept_head_name=""; 					
				}				
				$user_avatar = get_user_meta($dept_head_id,'hrmgt_user_avatar',true);		
				
		?>
			<li>
				<span><i class="icon-folder-open parent_dept"></i>
					<div class="inbox-item">
						<div class="col-md-12">
							<h4 class="dept_title"><?php print $head_department;?></h4>
						</div>
                        <div class="inbox-item-img">
							<?php if(!empty($user_avatar)){?>
								<img src="<?php print $user_avatar;?>" class="img-circle" >
							<?php } else{?>
								<img src="<?php print get_option('hrmgt_system_logo');?>" class="img-circle" >
							<?php  } ?>
							
						</div>
						<div class="content">							
							<p class="inbox-item-author"><?php  if(isset($dept_head_name)) print $dept_head_name  ?></p>
							<p class="inbox-item-text">
								<?php 									
									if(isset($designation_id)){
										print get_the_title($designation_id);
									}else{
										print "No Head";
									}
								?></p>
						</div>
                    </div>				 
				</span> 
				<ul>
					<?php 
						$result = $obj_department->get_all_clild_departments($dept_id);
						if(empty($result)){
							$args = array('meta_key'=>'department','meta_value'=>(int)$dept_id);							
							$result = get_users($args);							
							foreach($result as $key=>$value){
							$subchild_user_id = $value->ID;
							$subchild_name =  $value->display_name;
							$subchild_user_avatar = get_user_meta($subchild_user_id,'hrmgt_user_avatar',true);
							$subchild_designation_id = get_user_meta($subchild_user_id,'designation',true);
							?> 
							<li>
								<span><i class="icon-leaf"></i> 
								<div class="inbox-item">
									<div class="inbox-item-img">
									<?php if(!empty($subchild_user_avatar)){ ?>
										<img src="<?php print $subchild_user_avatar; ?>" class="img-circle" alt="">
									<?php } else{ ?> 
										<img src="<?php print get_option('hrmgt_system_logo'); ?>" class="img-circle" alt="">
									<?php } ?> 
									</div>
										<div class="content">							
											<p class="inbox-item-author"><?php print $subchild_name  ?></p>
											<p class="inbox-item-text"><?php print get_the_title($subchild_designation_id) ?></p>
										</div>
									</div>
								</span> 
							</li>
							<?php } }else{
							foreach($result as $key=>$value){							
							$sub_dept_name = $value->department_name;
							$sub_dept_id = $value->id;
							$sub_dept_head_id = $value->dept_head_id;
							$result = get_userdata($sub_dept_head_id);			
							
							if(empty($result->display_name)){
								$sub_dept_head_name = "No Head";
							}
							else{
								$sub_dept_head_name = $result->display_name;
							$sub_designation_id = get_user_meta($sub_dept_head_id,'designation',true);
							$sub_user_avatar = get_user_meta($sub_dept_head_id,'hrmgt_user_avatar',true);
							}
							?>
					<li>
							<span><i class="icon-minus-sign">							
							<div class="inbox-item">
								<div class="col-md-12">
									<h4 class="dept_title"><?php print $sub_dept_name;?></h4>
								</div>
								<div class="inbox-item-img">
								<?php if(isset($sub_user_avatar)){ ?>
									<img src="<?php print $sub_user_avatar; ?>" class="img-circle" alt="">
								<?php } else { ?> 
									<img src="<?php print get_option('hrmgt_system_logo'); ?>" class="img-circle" alt="">
								<?php } ?>	
								</div>
								<div class="content">							
									<p class="inbox-item-author"><?php print $sub_dept_head_name  ?></p>
									<p class="inbox-item-text"><?php print isset($sub_designation_id)?get_the_title($sub_designation_id):''; ?></p>
								</div>
							</div>	
							</i></span> 
							<ul>
							<?php 
							$args = array('meta_key'=>'department','meta_value'=>$sub_dept_id);
							$result = get_users($args);								
								
							foreach($result as $key=>$value){
								$subchild_user_id = $value->ID;
								$subchild_name =  $value->display_name;
								$subchild_user_avatar = get_user_meta($subchild_user_id,'hrmgt_user_avatar',true);
								$subchild_designation_id = get_user_meta($subchild_user_id,'designation',true);
								if(!($sub_dept_head_id ==$subchild_user_id) ){	?>
								<li>
									<span><i class="icon-leaf"></i> 
										<div class="inbox-item">
										<div class="inbox-item-img">
										<?php if(!empty($subchild_user_avatar)){ ?>
											<img src="<?php print $subchild_user_avatar; ?>" class="img-circle" alt="">
										 <?php } else{?> 
											<img src="<?php print get_option('hrmgt_system_logo'); ?>" class="img-circle" alt="">
										 <?php }?>	
										</div>
											<div class="content" style="padding-left:10px">							
												<p class="inbox-item-author"><?php print $subchild_name  ?></p>
												<p class="inbox-item-text"><?php print get_the_title($subchild_designation_id) ?></p>
											</div>
										</div>
									</span> 
								</li>
							<?php  } } ?>
							</ul>
						</li>
					<?php }	}?>	       
				</ul>
			</li>
			<?php } ?>		   
		</ul>
	</div>
	</div>