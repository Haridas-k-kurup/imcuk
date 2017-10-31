$('.top-links .drop-links').hover(function(){
	if($.browser.msie){
		var wid = $(this).outerWidth();
		$(this).find('.hide-line').css('width',wid+'px');		
	}
	$(this).find('.hide-line').show();
	$(this).css({'border':'1px solid #999999','background-color':'#fff'});
	$('.menu-links',this).show();
	},function(){
		$('.menu-links',this).hide();
		$(this).css({'border':'1px solid #f2f2f2','background-color':''});
		$(this).find('.hide-line').hide();
});
			
if($.browser.msie){
	/*var res = $(window).width();
	$('.navfullcont').css('width',res+'px');
	*/
	$('.nav li.drop-links').hover(function(){
		$(this).css('background-color','#0999d6');
	},function(){
		$(this).css('background-color','');
	});
}

//$('.navfullcont').hide();
$('.nav .drop-links').hover(function(){
	var _non_class_check = $(this).children('.navfullcont').hasClass('non-loaded');
	if(_non_class_check){
		$('.navfullcont',this).show();
	}
	var _data_role = $(this).attr('data-role');
	$('.navfullcont-main',this).show();
	var base_url = window.location.host;
	if(base_url == 'medindia'){
		_base_url = "medindia/newmedindia"	
	} else {
		_base_url = "medindia.net"
	}
	var _class_check = $(this).children('.navfullcont-main').hasClass('loaded');
	if(!_class_check){
		$(this).find('.navfullcont-main').load('http://www.medindia.net/includes/med-header/nav/'+_data_role+'.asp',function(){ $("#loader").fadeIn('slow', function() {$("#sub-menu").show('slow'); }) });	
	}
	$(this).children('.navfullcont-main').addClass('loaded');
	$('.navfullcont-main,.navfullcont').css({'border-top':'3px solid #0999d6','height':'280px'});
	if($.browser.msie){
		$('.navfullcont-main,.navfullcont').css({'border-top':'3px solid #0999d6','height':'auto'});
	}
},function(){
	$('.navfullcont',this).hide();
	$('.navfullcont-main',this).hide();
	$('#top-nav').css('margin-bottom','0px');
	$('#top-nav').css('border-bottom','3px solid #0999d6');
});
