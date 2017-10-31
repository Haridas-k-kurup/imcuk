<?php 
session_start();
include_once("../../includes/site_root.php");
include_once(DIR_ROOT."class/abuse_forum.php");
include_once(DIR_ROOT."class/abuse_slider.php");
include_once(DIR_ROOT."class/user_delete_content_info.php");
$objAbuseSlide		=	new abuse_slider();
$objAbuseForum		=	new abuse_forum();
$obj_del_info		= 	new user_delete_content_info();
$forumUnread		=	$objAbuseForum->count('abuse_read_status = 0');
$SlideUnread		=	$objAbuseSlide->count('abuse_read_status = 0');
$con_del_count		=   $obj_del_info->count('status = 1');
$totalAbuse			=	$forumUnread+$SlideUnread;
?>

<a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Abuses"> <i class="fa fa-warning"></i> <?php echo ($totalAbuse) ? '<span class="label label-warning">'.$totalAbuse.'</span>' : ''; ?>  </a>
<ul class="dropdown-menu">
  <li class="header"><?php echo ($totalAbuse) ? 'You have '.$totalAbuse.' notifications' : 'No new notifications' ?></li>
  <li> 
    <!-- inner menu: contains the actual data -->
    <ul class="menu"  style="height:auto !important">
      <li> <a href="<?php echo SITE_ROOT; ?>admin/index.php?page=abuse_details&abtype=forum" > <i class="ion ion-ios7-people info"></i> IMC Forum Abuse &nbsp; <span class="label label-warning"><?php echo ($forumUnread) ? $forumUnread : ''; ?></span> </a> </li>
      <li> <a href="<?php echo SITE_ROOT; ?>admin/index.php?page=abuse_details&abtype=slider"> <i class="fa fa-warning danger"></i> IMC Page Details Abuse&nbsp; <span class="label label-warning"><?php echo ($SlideUnread) ? $SlideUnread : ''; ?></span></span> </a> </li>
       <?php if($_SESSION['admintype'] == 1){ ?>
      <li> <a href="<?php echo SITE_ROOT; ?>admin/index.php?page=user_del_details"> <i class="fa fa-warning danger"></i> IMC Content Delete &nbsp; <span class="label label-warning"><?php echo ($con_del_count) ? $con_del_count : ''; ?></span></span> </a> </li>
      <?php  } ?>
      
    </ul>
  </li>
  <li class="footer"><a href="#">IMC notifications list</a></li>
</ul>
