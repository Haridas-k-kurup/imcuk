<?php 
ob_start();
session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past 
date_default_timezone_set("asia/kolkata");
include_once('includes/site_root.php');
include_once(DIR_ROOT."includes/session_check.php");
include_once(DIR_ROOT."class/manage_pages.php");
include_once(DIR_ROOT."class/imc_pages.php");
include_once(DIR_ROOT."class/forum_topics.php");
include_once(DIR_ROOT."includes/action_functions.php");
include_once(DIR_ROOT."class/registration_details.php");
include_once(DIR_ROOT."class/manage_sub_menu.php");
include_once(DIR_ROOT."class/ad_management.php");
include_once(DIR_ROOT."includes/pagination.php");
include_once(DIR_ROOT."class/promotional_ads.php");
$notfn			= new notification_types();
$objCommon		= new common_functions();
$objMgPage		= new manage_pages();
$objPage		= new imc_pages();
$objThread		= new forum_topics();
$objReg			= new registration_details();
$objSubMenu		= new manage_sub_menu();
$objAds			= new ad_management();
$objPromoAdvs	= new promotional_ads();
$allPromoAdvs	= $objPromoAdvs->getAll();
	foreach ($allPromoAdvs as $promoAd) {
		if ($promoAd['p_cat_id'] == 1) {
			$plabLink	= stripslashes($promoAd['p_ads_link']);
		}
		if ($promoAd['p_cat_id'] == 2) {
			$umleLink	= stripslashes($promoAd['p_ads_link']);
		}
	}
$allPages		= $objPage->getAll('page_status = 1','page_position asc');
if ($_GET['dept']) {
$currentPage	= $objCommon->esc($_GET['dept']);	
$currentTime	= date("Y-m-d H:i:s");
} else {
$currentPage	= 1;	
}

if($currentPage){
	/*get plab(Mobile) menu start*/
  $mobileSql	= "select subCat.subcat_name, subPages.sub_id, subPages.sub_heading, subPages.sub_information from manage_sub_pages as subPages left join manage_sub_category as subCat on subPages.subcat_id = subCat.subcat_id left join submenu_page_connection as subcon on subPages.sub_id = subcon.sub_id  where subcon.page_id = '".$currentPage."' and subPages.cat_id = '7' and subPages.sub_status = '1' order by subCat.subcat_position asc";
 
$mobileMenu		= $objSubMenu->listQuery($mobileSql);
/*get plab(Mobile) menu end*/
}
/*get top meu menu start*/
  $topMenuSql	= "select subCat.subcat_name, subPages.sub_id, subPages.sub_heading, subPages.sub_information from manage_sub_pages as subPages left join manage_sub_category as subCat on subPages.subcat_id = subCat.subcat_id left join submenu_page_connection as subcon on subPages.sub_id = subcon.sub_id where subcon.page_id = '".$currentPage."' and subPages.cat_id = '8' and subPages.sub_status = '1' order by subCat.subcat_position asc";
 
$topMenu		= $objSubMenu->listQuery($topMenuSql);
/*get top meu menu end*/

/*get middle menu start*/
  $midMenuSql	= "select subCat.subcat_name, subPages.sub_id, subPages.sub_heading, subPages.sub_information from manage_sub_pages as subPages left join manage_sub_category as subCat on subPages.subcat_id = subCat.subcat_id left join submenu_page_connection as subcon on subPages.sub_id = subcon.sub_id where subcon.page_id = '".$currentPage."' and subPages.cat_id = '9' and subPages.sub_status = '1' order by subCat.subcat_position asc";
 
$middleMenu		= $objSubMenu->listQuery($midMenuSql);
/*get middle menu end*/

/*get top right menu start*/
/*  $topRightSql	=	"select subCat.subcat_name, subPages.sub_id, subPages.sub_heading, subPages.sub_information from manage_sub_pages as subPages left join manage_sub_category as subCat on subPages.subcat_id = subCat.subcat_id where subPages.page_id = '".$currentPage."' and subPages.cat_id = '10' and subPages.sub_status = '1' order by subPages.sub_id desc limit 0,1";
 
$topRightMenu	=	$objSubMenu->listQuery($topRightSql);*/
/*get top right  menu end*/

/*get page name*/
$pageName		= $objPage->getRow("page_id = '".$currentPage."'");
/*get page end*/
$loginSql		= "select reg.reg_id, reg.reg_private_id, reg.reg_createdon,user.ud_id, user.ud_name_title,user.ud_first_name, user.ud_country, user.ud_pofile_pic,user.ud_state, prof.up_profession_name from registration_details as reg left join user_details as user on reg.reg_id=user.reg_id left join user_professionals_details as prof on reg.reg_id = prof.reg_id where reg.reg_id != 1 and reg.reg_staff_manage = 0 and reg.reg_status = 1 order by reg.reg_createdon desc";
$recentJoin		= $objReg->listQuery($loginSql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>IMC</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta property="fb:app_id" content="708286809285991"/>
<link rel="icon" href="<?php echo SITE_ROOT; ?>images/object956289543.png" media="screen">
<link rel="stylesheet" href="<?php echo SITE_ROOT; ?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo SITE_ROOT; ?>assets/css/imc-css.css">
<link rel="stylesheet" href="<?php echo SITE_ROOT; ?>assets/css/leftmenu/styles.css" type="text/css" media="all" />
<!-- Image Hover Start-->
<link href="<?php echo SITE_ROOT; ?>assets/css/imghover/effects.css" rel="stylesheet">
<link href="<?php echo SITE_ROOT; ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo SITE_ROOT; ?>assets/css/imghover/styles.css">
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="<?php echo SITE_ROOT; ?>assets/js/imghover/script.js"></script>
<!-- Image Hover Menu Ends-->
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>assets/js/leftmenu/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>assets/js/leftmenu/superfishverticalmenu.js"></script>
<script src="<?php echo SITE_ROOT; ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>assets/js/jquery.flexisel.js"></script>
<script src="<?php echo SITE_ROOT; ?>assets/js/script/jquery.easing-1.3.js"></script>
<script src="<?php echo SITE_ROOT; ?>assets/js/script/jquery.mousewheel-3.1.12.js"></script>
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>js/jquery.upload-1.0.2.js"></script>
<script src="<?php echo SITE_ROOT; ?>assets/js/script/jquery.jcarousellite.js"></script>
<script type="text/javascript" src="<?php echo SITE_ROOT; ?>ckeditor/ckeditor.js"></script>
<!--<script type="text/javascript" src="<?php echo SITE_ROOT; ?>ckeditor/ckfinder.js"></script>-->
 <!--- Responsive tab Start  ----->
<link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT; ?>assets/Plugin/ResponsiveTab/easy-responsive-tabs1.css" />
<script src="<?php echo SITE_ROOT; ?>assets/Plugin/ResponsiveTab/easyResponsiveTabs.js"></script>
  <!--- Responsive tab Ends  ----->
</head>
<body>
<header class="imc-header">
  <nav class="navbar navbar-inverse imc-navbar">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      </div>
      <div class="collapse navbar-collapse imc-nav-wrapper" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li class="<?php echo $currentPage == 1 ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>">Home</a></li>
          <li><a href="<?php echo SITE_ROOT ?>about-us.php">About us</a></li>
          <?php if($sessionval	==	true) { ?>
          <li><a href="<?php echo SITE_ROOT ?>my_profile.php"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
          <?php } ?>
          <?php if($sessionval	==	false) { ?>
          <li><a href="<?php echo SITE_ROOT ?>registration_form.php"><span class="glyphicon glyphicon-user"></span> Register</a></li>
          <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-log-in"></span> Login</a>
            <ul id="login-dp" class="dropdown-menu">
              <li>
                <div class="row">
                  <div class="col-md-12">
                    <div style="background-color:#3399cc; padding:15px 0px; width:100%; font-weight:bold; color:#FFF; text-align:center; margin-bottom:10px; font-size:18px; font-family:Cambria;">Log In</div>
                    <form class="form" role="form" action="<?php echo SITE_ROOT ?>action.php?act=login" method="post" action="login" accept-charset="UTF-8" id="login-nav">
                      <div class="form-group">
                        <label class="sr-only" for="exampleInputEmail2">User Name</label>
                        <input type="text" name="user" class="form-control" placeholder="User name" required>
                      </div>
                      <div class="form-group">
                        <label class="sr-only" for="exampleInputPassword2">Password</label>
                        <input type="password" class="form-control" name="pass" placeholder="Password" required>
                      </div>
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                      </div>
                    </form>
                  </div>
                  <div class="bottom text-center"> <a href="<?php echo SITE_ROOT ?>pssword-reset.php"><b>Forgot Password / User name</b></a> </div>
                </div>
              </li>
            </ul>
          </li>
           <?php } else { ?>
           
          <li><a href="<?php echo SITE_ROOT; ?>logout.php" id="logout"><i class="fa fa-sign-out"></i> Log Out</a></li>
            <?php } ?>
          <li><a href="javascript:;"><i class="fa fa-facebook-square"></i> Facebook</a></li>
          <li><a href="javascript:;"><i class="fa fa-twitter-square"></i> Twitter</a></li>
          <li><a href="<?php echo SITE_ROOT ?>contactus.php">Contact us</a> </li>
          <li><a href="<?php echo SITE_ROOT ?>find_members.php"><i class="fa fa-search"></i> Search Member</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row imc-site-header">
      <div class="col-xs-12 col-md-2 imc-logo"> <img src="<?php echo SITE_ROOT ?>assets/img/object956289543.png" class="img-responsive"> </div>
      <div class="col-xs-12 col-md-10">
        <div class="row">
          <div class="col-md-9">
            <div class="row">
              <div class="col-sm-12">
                <h1 class="text-center imc-web-head">International Medical Connections</h1>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 text-center caption-bar"> <a href="#" class=" caption-text">A web portal for all health professionals all around the world</a> </div>
            </div>
          </div>
          <div class="col-md-3"><img src="<?php echo SITE_ROOT ?>assets/img/object1107173146.png" class="img-responsive pull-right dr-img"> </div>
        </div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-inverse nav-page-bar">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#page-dtils"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      </div>
      <div class="collapse navbar-collapse imc-nav-wrapper" id="page-dtils">
        <ul class="nav navbar-nav" style="font-size:13px !important">
         <?php $navCount = 1; foreach($allPages as $menuPage) { 
        	if($menuPage['page_id'] && ($menuPage['par_id'] == 0 || $menuPage['par_id'] == 1) && $menuPage['page_id'] != 1) {
			?>
        
          <li class="boder-right <?php echo $currentPage == $menuPage['page_id'] ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>index.php?dept=<?php echo $menuPage['page_id']; ?>"><?php echo strtoupper( stripslashes($menuPage['page_name'])); ?></a></li>
          <?php 
		  if ($navCount%11 == 0) { ?>
            </ul>
      </div>
    </div>
  </nav>
  <nav class="navbar navbar-inverse nav-page-bar">
    <div class="container-fluid">
    
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#page-dtils<?php echo $i ?>"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      </div>
      <div class="collapse navbar-collapse imc-nav-wrapper" id="page-dtils<?php echo $i ?>">
        <ul class="nav navbar-nav" style="font-size:13px !important">	
		<?php	}
				$navCount++;
			}
			 } ?>
        </ul>
      </div>
    </div>
  </nav>
  
</header>
<?php $notific	= $notfn->msg();
	if($notific) { 
 ?>
<div class="modal fade" id="alert-popup" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div style="border:8px double #000066;">
              <div class="modal-header imc-alert-head">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><strong>International Medical Connection</strong></h4>
              </div>
              <div class="modal-body">
               <?php echo $notific; ?>
              </div>
              <div class="modal-footer" align="center" style="padding:5px;">
                <button type="button" class="forum_post_replay_btn" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
<?php } ?>