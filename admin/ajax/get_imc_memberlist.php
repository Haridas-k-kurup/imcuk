<?php 
session_start();
include_once('../../includes/site_root.php');
include_once(DIR_ROOT."includes/action_functions.php");
include_once(DIR_ROOT."class/registration_details.php");

$objCommon		=	new common_functions();
$objReg			=	new registration_details();
$adminSession	=	$_SESSION['adminid'];
$adminType		=	$_SESSION['admintype'];

 ?>
 <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="1%"><input type="checkbox" name="checkbox" class="checkall" id="checkbox"></th>
                                                <th width="15%">Name</th>
                                                <th width="10%" class="text-center">Profile</th>
                                                <th width="10%">Reg-Type</th>
                                                <th width="14%">Registered Date</th>
                                                <th width="10%">Country</th>
                                                <th width="15%">Email</th>
                                                <th width="15%">Last Visit IP</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
/*-----------Pagination start----------------*/
if(isset($_POST['srch']) && $_POST['srch']){
	$item							=	$objCommon->esc(trim($_POST['srch']));
	if($adminType == 1){
	$loginSql 						= 	"select * from registration_details as reg left join user_details as user on reg.reg_id = user.reg_id left join user_professionals_details as prof on prof.reg_id = reg.reg_id where user.ud_name_title like '%".$item."%' or user.ud_first_name like '%".$item."%' or user.ud_country like '%".$item."' or user.ud_state like '%".$item."' or user.ud_city like '%".$item."%' or user.ud_town like '%".$item."%' or user.ud_street_name like '%".$item."%' or user.ud_post_code like '%".$item."%' or user.ud_dob like '%".$item."%' or user.ud_email like '%".$item."%' or user.ud_tel_home like '%".$item."%' or user.ud_tel_work like '%".$item."%' or user.ud_tel_mob like '%".$item."%' or prof.up_student_course like '%".$item."%' or prof.up_profession_type like '%".$item."%' order by reg.reg_id desc";
	}else{
		$loginSql 					= 	"select * from registration_details as reg left join user_details as user on reg.reg_id = user.reg_id where reg.reg_staff_manage = 0 and (user.ud_name_title like '%".$item."%' or user.ud_first_name like '%".$item."%' or user.ud_country like '%".$item."%' or user.ud_state like '%".$item."%' or user.ud_city like '%".$item."%' or user.ud_town like '%".$item."%' or user.ud_street_name like '%".$item."%' or user.ud_post_code like '%".$item."%' or user.ud_dob like '%".$item."%' or user.ud_email like '%".$item."%' or user.ud_tel_home like '%".$item."%' or user.ud_tel_work like '%".$item."%' or user.ud_tel_mob like '%".$item."%') order by reg.reg_id desc";
	}

}

$page_list							=	$objReg->listQuery($loginSql);
if(count($page_list) >0){
	$count=	1;
	foreach($page_list as $all){
/*-----------Pagination End----------------*/
?>                                          <tr>
                                                <td><input type="checkbox" class="mglr_checkbox" value="<?php echo $all['reg_id']?>" name="del_id[]"></td>
                                                <td><?php echo $all['ud_name_title']." : ";  echo $all['ud_first_name']; ?></td>
                                                <td class="text-center">
												<?php if($all['ud_pofile_pic']){
														$profPic		=  "/profiles/".stripslashes($all['ud_pofile_pic']);
														$chkProfPic		=  "../../profiles/".stripslashes($all['ud_pofile_pic']);
														if(file_exists($chkProfPic)){
														?>
                                                        <img src="<?php echo SITE_ROOT.$profPic; ?>" width="75%" height="75" >
                                                        <?php } else{ ?>
                                                        <img src="<?php echo SITE_ROOT; ?>images/profile.jpg" width="75%" height="75" >
                                                        <?php }  }else{ ?>
                                                        <img src="<?php echo SITE_ROOT; ?>images/profile.jpg" width="75%" height="75" >
													<?php } ?>	 
                                                </td>
                                                <td><?php 
													$regType	 =	$all['reg_type'];
													if($regType	 ==	1){
														echo "Professional";
													}
													else if($regType ==	2){
														echo "Organization";
													}
													else if($regType ==	3){
														echo "Patient";
													} ?>
                   								</td>
                                                <td><?php echo $all['reg_createdon'];?></td>
                                                <td><?php echo $all['ud_country'];?></td>
                                                <td><?php echo $all['ud_email'];?></td>
                                                <td><?php echo $all['last_visit_ip'];?></td>
                                                <td>
                          <?php if($adminType == 1 && $all['reg_staff_manage'] == 1){ ?> 
                          <a class="tiptip outer_admin_action" data-original-title="Click For all delete" data-toggle="tooltip" title="Appeal" href="<?php echo SITE_ROOT?>admin/index.php?page=login_details&dsid=<?php echo $all['reg_id']?>" >
                          <img  src="<?php echo SITE_ROOT; ?>admin/img/question.png" title="Deleted from Sub-Admin">
                          </a>
                          <?php }else{ ?>                     	
						<a class="tiptip outer_admin_action" data-original-title="Click For all delete" data-toggle="tooltip" title="Block/Unblock" href="<?php echo SITE_ROOT?>admin/index.php?page=login_details&sid=<?php echo $all['reg_id']?>" >
                        	<?php if($all['reg_status'] == 1){ ?>
							<img  src="<?php echo SITE_ROOT; ?>admin/img/icon_green_dot.png" title="Clik to deactivate : <?php echo $all['ud_name_title']." : ";  echo $all['ud_first_name']; ?>">
                            <?php }else{ ?>
                            <img src="<?php echo SITE_ROOT; ?>admin/img/red_dot.png" title="Clik to activate : <?php echo $all['ud_name_title']." : ";  echo $all['ud_first_name']; ?>">
                            <?php } ?>
						</a>
                        <?php } ?>
						<a class="tiptip outer_admin_action" data-original-title="Click For all delete" data-toggle="tooltip" href="javascript:;" title="Delete" onclick="return del('<?php echo $phpSelf ?>&del_id[]=<?php echo $all['reg_id']?>');">
							<span class="inner_admin_action admin_action_delete"><i class="fa fa-trash-o"></i></span>
						</a> 
                        <a class="tiptip outer_admin_action" href="<?php echo SITE_ROOT."my_profile.php" ?>" data-original-title="Click For View Profile" data-toggle="tooltip" href="javascript:;" title="Click for View Profile" >
							<span class="inner_admin_action admin_action_delete"><i class="fa fa-user"></i></span>
						</a>
                                                </td>
                                            </tr>
                                     <?php } }else{ ?> 
                                     <tr>
                                     	<td colspan="9"><label class="text-warning">Sorry ! No result found</label>t</td>
                                     </tr> 
                                     <?php } ?> 
                                      </tbody>
                                    </table>