<script>
$(document).ready(function(){
	$('#alert-popup').modal('show'); // pop up alert
	
	$("html, body").animate({scrollTop: $('#scroll_to_this').offset().top }, 1000); // animate to scroll_to_this
   
    $(".nav-tabs1 a").click(function(){
        $(this).tab('show');
    });
window.setInterval(function(){ // read more page stroy rate info
  getRate();	
}, 5000);

});
</script>