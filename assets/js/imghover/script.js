//( function( $ ) {
//$( document ).ready(function() {
//$('.cssmenu li.has-sub>a').on('click', function(){
//		$(this).removeAttr('href');
//		var element = $(this).parent('li');
//		if (element.hasClass('open')) {
//			element.removeClass('open');
//			element.find('li').removeClass('open');
//			element.find('ul').slideUp();
//		}
//		else {
//			element.addClass('open');
//			element.children('ul').slideDown();
//			element.siblings('li').children('ul').slideUp();
//			element.siblings('li').removeClass('open');
//			element.siblings('li').find('li').removeClass('open');
//			element.siblings('li').find('ul').slideUp();
//		}
//	});
//});
//} )( jQuery );

$vm=jQuery.noConflict();$vm(document).ready(function(){$vm(".vertical-menu ul li").hover(function(){$vm(this).children(".vertical-menu .drop-down").stop().slideDown(400)},function(){$vm(this).children(".vertical-menu .drop-down").stop().slideUp(400)});$vm(".vertical-menu > ul > li:first-child").hover(function(){$vm(".vertical-menu .more").stop().fadeIn(400)},function(){$vm(".vertical-menu .more").stop().delay(400).fadeOut(400)});$vm(".vertical-menu > ul > li:last-child").click(function(){$vm(".vertical-menu").animate({left:"-50%"},800);$vm(".vertical-menu .vertical-menu-show-button").delay(400).show(400)});$vm(".vertical-menu .vertical-menu-show-button").click(function(){$vm(".vertical-menu").animate({left:"0%"},800);$vm(".vertical-menu .vertical-menu-show-button").delay(400).hide(400)})})
