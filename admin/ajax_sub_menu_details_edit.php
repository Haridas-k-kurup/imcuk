<?php 
	session_start();
	include_once('../includes/site_root.php');
	include_once(DIR_ROOT."admin/includes/action_functions.php");
	include_once(DIR_ROOT."class/manage_sub_category.php");
	include_once(DIR_ROOT."class/manage_sub_pages.php");
	include_once(DIR_ROOT."class/manage_sub_menu.php");
	include_once(DIR_ROOT."class/manage_sub_sub_menu.php");
	$objSubCat		=	new manage_sub_category();
	$objSubPage		=	new manage_sub_pages();
	$objCommon		=	new common_functions();
	$notfn			=	new notification_types();
	$objSubMenu		=	new manage_sub_menu();
	$objSubSub		=	new manage_sub_sub_menu();

	$id				=	$objCommon->esc($_POST['id']);
	$flag			=	$objCommon->esc($_POST['flag']);
	
				echo $notfn->msg(); // print action msg
		
	if($flag == 1){
		
	 $pageCatDetls	=	$objSubPage->getRow('sub_id ='.$id,'sub_id');
	 $pageDetail	=   $objSubCat->getRow('subcat_id ='.$pageCatDetls['subcat_id'], 'subcat_id');
	  ?>
 
     							<div class="box-body">
                                	<input type="hidden" name="menu_id" id="menu_id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="menu_flag" id="menu_flag" value="<?php echo $flag; ?>">
                                    <!-- This is only for show the edit flag of update. hardcoding for php submit -->
                                    <input type="hidden" name="menu_act_flag" value="1">
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" type="button">Menu / Heading</button>
                                        </div><!-- /btn-group -->
                                        	<input type="text" class="form-control" name="new_head" id="new_head" required value="<?php echo $pageCatDetls['sub_heading']; ?>">
                                    </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <textarea name="new_desc" id="new_desc" class="form-control" ><?php echo stripslashes($pageCatDetls['sub_information']); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" type="button">Position</button>
                                        </div><!-- /btn-group -->
                                        	<input type="number" class="form-control" name="new_position" id="new_position" value="<?php echo $pageDetail['subcat_position']; ?>">
                                    </div>
                                        </div>
                                         </div>
                                    </div>
                                    </div>
  <?php
	} else if($flag == 2){
		$allSubMenus	=	$objSubMenu->getRow('sub_menu_id = "'.$id.'"', 'sub_menu_id'); ?> 
        
        <div class="box-body">
                                	<input type="hidden" name="menu_id" id="menu_id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="menu_flag" id="menu_flag" value="<?php echo $flag; ?>">
                                      <!-- This is only for show the edit flag of update. hardcoding for php submit -->
                                    <input type="hidden" name="menu_act_flag" value="1">
                                    <div class="row">
                                        <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" type="button">Menu / Heading</button>
                                        </div><!-- /btn-group -->
                                        	<input type="text" class="form-control" name="new_head" id="new_head" required value="<?php echo $allSubMenus['sub_menu_name']; ?>">
                                    </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <textarea name="new_desc" id="new_desc" class="form-control" ><?php echo stripslashes($allSubMenus['sub_menu_details']); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" type="button">Position</button>
                                        </div><!-- /btn-group -->
                                        	<input type="number" class="form-control" name="new_position" id="new_position" value="<?php echo $allSubMenus['position']; ?>">
                                    </div>
                                        </div>
                                         </div>
                                    </div>
                                    </div>
	
<?php	}else if($flag == 3){
		$allSubMenus	=	$objSubSub->getRow('sub_sub_id = "'.$id.'"', 'sub_sub_id'); ?> 
        
        <div class="box-body">
                                	<input type="hidden" name="menu_id" id="menu_id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="menu_flag" id="menu_flag" value="<?php echo $flag; ?>">
                                      <!-- This is only for show the edit flag of update. hardcoding for php submit -->
                                    <input type="hidden" name="menu_act_flag" value="1">
                                    <div class="row">
                                        <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" type="button">Menu / Heading</button>
                                        </div><!-- /btn-group -->
                                        	<input type="text" class="form-control" name="new_head" id="new_head" required value="<?php echo $allSubMenus['sub_sub_menu']; ?>">
                                    </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Description</label>
                                            <textarea name="new_desc" id="new_desc" class="form-control" ><?php echo stripslashes($allSubMenus['sub_sub_menu_details']); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" type="button">Position</button>
                                        </div><!-- /btn-group -->
                                        	<input type="number" class="form-control" name="new_position" id="new_position"  value="<?php echo $allSubMenus['position']; ?>">
                                    </div>
                                        </div>
                                         </div>
                                    </div>
                                    </div>
        <?php } ?>
 