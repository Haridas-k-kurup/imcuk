$(document).on("click",".admin_notfn_hide",function(){
	$(this).fadeOut(1000);
});
window.setInterval(function(){
	$(".admin_notfn_hide").fadeOut(5000);
},5000)
$(document).on("click",".checkall",function(){
	var checked_status = this.checked;
	$(".mglr_checkbox").each(function(){
		this.checked = checked_status;
	});
});
$('.outer_admin_action').tooltipsy();
