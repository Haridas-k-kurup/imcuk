<?php 
	if($page == "login_details" || $page == "online_users" || $page == "offline_users"){
		$users		=	true;
	}else if($page == "list_medical_forum" || $page == "list_slider"){
		$medical	=	true;
	}else if($page == "country_control" || $page == "states_control" || $page == "add_category" || $page == "imc_pages" || $page == "add_sub_category" || $page == "add_content_position" || $page == "city_controls"){
		$control	=	true;
	}else if($page == "advertisement"){
		$ads		=	true;
	}else if($page == "manage_inner_pages" || $page == "manage_sub_menu" || $page == "edit_inner_pages" || $page == "add_sub_menu"){
		$inner		=	true;
	}else if($page == "manage_sub_menu_pluse" || $page == "manage_subsub_menu_pluse" || $page == "edit_inner_submenu" || $page == "add_inner_sub_menu"){
		$subPluse	=	true;
	}else if($page == "add_ad" || $page == "list_ads" || $page == "promotion-ads"){
		$ads		=	true;
	}
	else if($page == "mailbox" || $page	==	"mailread" || $page	==	"sentbox" || $page	==	"sentread" || $page	==	"draftbox"){
		$mailBox	=	true;
	}else if($page == "staff_mailbox" || $page	==	"staff_sentbox" || $page	==	"staff_mailread" ){
		$stfMail	=	true;
	}else if( $page == "contactus" || $page == "contact_read"){
		$contactUS	=	true;
	}
	if($_GET['search_field']){
		$search		=	$objCommon->esc($_GET['search_field']);
	}
 ?>

<aside class="left-side sidebar-offcanvas" style="">                
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                    <input type="hidden" name="page" value="<?php echo $page; ?>" />
                    <?php if(isset($_GET['dept'])){ ?>
                    <input type="hidden" name="dept" value="<?php echo $_GET['dept']; ?>" />
                    <?php } ?>
                        <div class="input-group">
                            <input type="text" name="search_field" class="form-control" value="<?php echo $objCommon->html2text($search); ?>" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="<?php echo ($page == "dashboard" ) ? 'active' : '' ?>">
                            <a href="<?php echo SITE_ROOT ?>admin/index.php?page=dashboard">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="<?php echo ($mailBox == true || $unread > 0) ? 'active' : '' ?>">
                            <a href="<?php echo SITE_ROOT ?>admin/index.php?page=mailbox">
                                <i class="fa fa-envelope"></i> <span><?php echo ($adminType == 1) ? "Admin's " : "" ?>Mailbox</span>
                                <?php  if($unread > 0){ ?>
                                <small class="badge pull-right bg-green"><?php echo $unread; ?></small>
                                <?php } ?>
                            </a>
                        </li>
                        <?php if($adminType == 1){ ?>
                        <li class="treeview <?php echo ($stfMail == true) ? 'active' : '' ?>">
                            <a href="#">
                                <i class="fa fa-folder-open"></i>
                                <span>Staff's Mailbox</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                            		<?php $allStaff	=	$objAdmin->getAll('admin_type = 2', 'admin_username');
										foreach($allStaff as $staffs){
									 ?>
                                     <li class="<?php echo ($_GET['stf'] == $staffs['admin_id']) ? 'active' : '' ?>">
                                        <a href="<?php echo SITE_ROOT ?>admin/index.php?page=staff_mailbox&stf=<?php echo $staffs['admin_id']; ?>">
                                            <i class="fa fa-envelope"></i><span><?php echo $staffs['admin_username']; ?></span>
                                        </a>
                                     </li>
                                    <?php } ?> 
                             	</ul>
                        </li>
                        <?php } ?>
                         <?php if($adminType == 1){ ?>
                        <li class="<?php echo ($page == "about_us") ? 'active' : '' ?>">
                         	<a href="<?php echo SITE_ROOT ?>admin/index.php?page=about_us">
                            	<i class="fa fa-pencil-square-o"></i><span>About Us</span>
                            </a>
                         </li>
                         <?php } ?>
                        <li class="treeview <?php echo ($contactUS == true) ? 'active' : '' ?>">
                            <a href="#">
                                <i class="fa fa-phone-square"></i>
                                <span>Contact Us</span>
                                <?php if ($con_unread) {  ?>
                                <small id="contact-notific" class="badge pull-right bg-green"><?=$con_unread?></small>
                                <?php } ?>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                            	<?php foreach($allContype as $type){
										if($type['contact_type_id'] == 3 && $adminType == 2){ }else{
									 ?>
                                     <li class="<?php echo ($_GET['type'] == $type['contact_type_id']) ? 'active' : '' ?>">
                                        <a href="<?php echo SITE_ROOT ?>admin/index.php?page=contactus&type=<?php echo $type['contact_type_id']; ?>">
                                            <i class="fa fa-angle-double-right"></i><span><?php echo $type['contact_type_name']; ?></span>
                                        </a>
                                     </li>
                               <?php } } ?>
                             	</ul>
                        </li>
                         <li class="<?php echo ($page == "manage_pages") ? 'active' : '' ?>">
                         	<a href="<?php echo SITE_ROOT ?>admin/index.php?page=manage_pages">
                            	<i class="fa fa-pencil-square-o"></i><span>Add Slider & Page <br><!--<small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;home, medical...ect</small>--></span>
                            </a>
                         </li>
                         
                         <li class="treeview <?php echo ($inner == true) ? 'active' : '' ?>">
                            <a href="#">
                                <i class="fa fa-files-o"></i>
                                <span>Manage Main Menus</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                                <ul class="treeview-menu">
                                     <li class="<?php echo ($page == "manage_inner_pages") ? 'active' : '' ?>">
                                        <a href="<?php echo SITE_ROOT ?>admin/index.php?page=manage_inner_pages">
                                            <i class="fa fa-pencil-square-o"></i><span>Add Menu & Sub menu</span>
                                        </a>
                                     </li>
                                     <li class="<?php echo ($page == "manage_sub_menu") ? 'active' : '' ?>">
                                     	<a href="<?php echo SITE_ROOT ?>admin/index.php?page=manage_sub_menu">
                                            <i class="fa fa-pencil-square-o"></i><span>Add Sub-sub Menu</span>
                                        </a>
                                     </li>
                                     <li class="<?php echo ($page == "edit_inner_pages") ? 'active' : '' ?>">
                                     	<a href="<?php echo SITE_ROOT ?>admin/index.php?page=edit_inner_pages">
                                            <i class="fa fa-list"></i><span>Manage All Menu</span>
                                        </a>
                                     </li>
                             	</ul>
                         </li>
                         <!--SUB-SUB_MENU PLUSE START-->
                         <li class="treeview <?php echo ($subPluse == true) ? 'active' : '' ?>">
                            <a href="#">
                                <i class="fa fa-th"></i>
                                <span>Manage Submenu</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                                <ul class="treeview-menu">
                                     <li class="<?php echo ($page == "manage_sub_menu_pluse") ? 'active' : '' ?>">
                                        <a href="<?php echo SITE_ROOT ?>admin/index.php?page=manage_sub_menu_pluse">
                                            <i class="fa fa-pencil-square-o"></i><span>Add Sub Menu</span>
                                        </a>
                                     </li>
                                     <li class="<?php echo ($page == "manage_subsub_menu_pluse") ? 'active' : '' ?>">
                                     	<a href="<?php echo SITE_ROOT ?>admin/index.php?page=manage_subsub_menu_pluse">
                                            <i class="fa fa-pencil-square-o"></i><span>Add Sub-sub Menu</span>
                                        </a>
                                     </li>
                                     <li class="<?php echo ($page == "edit_inner_submenu") ? 'active' : '' ?>">
                                     	<a href="<?php echo SITE_ROOT ?>admin/index.php?page=edit_inner_submenu">
                                            <i class="fa fa-list"></i><span>Manage All Menu</span>
                                        </a>
                                     </li>
                             	</ul>
                         </li>
                         <!--SUB-SUB_MENU PLUSE END-->
                        <li class="treeview <?php echo ($users == true) ? 'active' : '' ?>">
                            <a href="#">
                                <i class="fa  fa-group"></i>
                                <span>I M C Users</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo ($page == "login_details") ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=login_details"><i class="fa fa-angle-double-right"></i> List All Users</a></li>
                                <li class="<?php echo ($page == "online_users") ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=online_users"><i class="fa fa-angle-double-right"></i> List Online Users</a></li>
                                <li class="<?php echo ($page == "offline_users") ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=offline_users"><i class="fa fa-angle-double-right"></i> List Offline Users</a></li>
                            </ul>
                        </li>
                        <!-- control of each Page start -->
                        <?php foreach($allPages as $imcPages){ ?>
                        <li class="treeview <?php echo ($imcPages['page_id'] == $_GET['dept']) ? 'active' : '' ?>">
                            <a href="#">
                                <i class="fa fa-plus-square"></i>
                                <span>I M C <?php echo $imcPages['page_name']; ?> Page</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo ($page == "list_medical_forum" && $imcPages['page_id'] == $_GET['dept']) ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=list_medical_forum&dept=<?php echo $imcPages['page_id']; ?>"><i class="fa fa-angle-double-right"></i>List Forum</a></li>
                                <li class="<?php echo ($page == "list_page_details" && $imcPages['page_id'] == $_GET['dept']) ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=list_page_details&dept=<?php echo $imcPages['page_id']; ?>"><i class="fa fa-angle-double-right"></i>List Slider & Page Info</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                        <!-- control of each Page end -->
                        <!--IMC Control start-->
                        <li class="treeview <?php echo ($control == true) ? 'active' : '' ?>">
                            <a href="#">
                                <i class="fa fa-wrench"></i>
                                <span>I M C Controls</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo ($page == "imc_pages") ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=imc_pages"><i class="fa fa-angle-double-right"></i>Manage I M C Pages</a></li>
                                <li class="<?php echo ($page == "add_category") ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=add_category"><i class="fa fa-angle-double-right"></i>Manage I M C Categories</a></li>
                                <li class="<?php echo ($page == "add_sub_category") ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=add_sub_category"><i class="fa fa-angle-double-right"></i>Create Main menus</a></li>
<!--                                <li class="<?php echo ($page == "add_content_position") ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=add_content_position"><i class="fa fa-angle-double-right"></i>Manage Position</a></li>
-->                                 <li class="<?php echo ($page == "country_control") ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=country_control"><i class="fa fa-angle-double-right"></i>Manage Countries</a></li>
                                <li class="<?php echo ($page == "states_control") ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=states_control"><i class="fa fa-angle-double-right"></i>Manage States</a></li>
                                <li class="<?php echo ($page == "city_controls") ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=city_controls"><i class="fa fa-angle-double-right"></i>Manage Cities</a></li>
                            </ul>
                        </li>
                        <!--ads start-->
                        <li class="treeview <?php echo ($ads == true) ? 'active' : '' ?>">
                            <a href="#">
                                <i class="fa fa-picture-o"></i>
                                	<span>Advertisement</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo ($page == "add_ad") ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=add_ad"><i class="fa fa-angle-double-right"></i>Add Advertisement</a></li>
                                <li class="<?php echo ($page == "list_ads") ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=list_ads"><i class="fa fa-angle-double-right"></i>List Advertisement</a></li>
                                <li class="<?php echo ($page == "promotion-ads") ? 'active' : '' ?>"><a href="<?php echo SITE_ROOT ?>admin/index.php?page=promotion-ads"><i class="fa fa-angle-double-right"></i>Promotional Ads</a></li>
                            </ul>
                        </li>
                        <!--ads end-->
                        <!--IMC Control End-->
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>