<div class="row">
 <div class="col-xs-6">
 <div class="dataTables_info" id="example2_info">
			<?php
			 if($countpageList>$num_results_per_page){?>
			
				<select name="view_count" class="form-control" style="width:50%" onchange="changeViewCount(this.value);">
					<option value="10" <?php echo ($_GET['new_view']==10)?'selected="selected"':'';?>>10 results</option>
					<option value="20" <?php echo ($_GET['new_view']==20)?'selected="selected"':'';?>>20 results</option>
					<option value="30" <?php echo ($_GET['new_view']==30)?'selected="selected"':'';?>>30 results</option>
					<option value="40" <?php echo ($_GET['new_view']==40)?'selected="selected"':'';?>>40 results</option>
					<option value="50" <?php echo ($_GET['new_view']==50)?'selected="selected"':'';?>>50 results</option>
				</select>
			
			<?php
			}
			?>
            </div>
             </div>
			<div class="col-xs-6">
                   <div class="dataTables_paginate paging_bootstrap">
					<?php echo $pagination_output; ?>
					</div>
		</div>
        </div>