<style>
.pagination_outer_div a { 
	font-size:14px;
	font-weight:bold;
	color:#039;
	padding: 0.5%;
	margin:0.2%;
	background: rgba(183,222,237,1);
	background: -moz-linear-gradient(top, rgba(183,222,237,1) 0%, rgba(183,222,237,1) 0%, rgba(113,206,239,1) 53%, rgba(113,206,239,1) 100%);
	background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(183,222,237,1)), color-stop(0%, rgba(183,222,237,1)), color-stop(53%, rgba(113,206,239,1)), color-stop(100%, rgba(113,206,239,1)));
	background: -webkit-linear-gradient(top, rgba(183,222,237,1) 0%, rgba(183,222,237,1) 0%, rgba(113,206,239,1) 53%, rgba(113,206,239,1) 100%);
	background: -o-linear-gradient(top, rgba(183,222,237,1) 0%, rgba(183,222,237,1) 0%, rgba(113,206,239,1) 53%, rgba(113,206,239,1) 100%);
	background: -ms-linear-gradient(top, rgba(183,222,237,1) 0%, rgba(183,222,237,1) 0%, rgba(113,206,239,1) 53%, rgba(113,206,239,1) 100%);
	background: linear-gradient(to bottom, rgba(183,222,237,1) 0%, rgba(183,222,237,1) 0%, rgba(113,206,239,1) 53%, rgba(113,206,239,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b7deed', endColorstr='#71ceef', GradientType=0 );
}
.pagination_outer_div span {
	font-size:14px;
	font-weight:bold;
	padding: 0.5%;
	margin:0.2%;
}
</style>
<div class="outer_select_pages ovr" style="margin-top:5px;">
    <div class="pagination_outer_div">
            <?php echo $paginate; ?>
    </div>
</div>