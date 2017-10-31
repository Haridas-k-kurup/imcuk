var CurrentUrl=""
var Sendto=""
function insertUserDetails(Email,Password,ScreenName,CategoryID,NewsLetter)
{
	Sendto=window.parent.location;
	return clientvalidation("email="+Email+"&username="+ScreenName+"&password="+Password+"&CategoryID="+CategoryID+"&insertMode=1&newsletter="+NewsLetter+"&Sendto="+Sendto);
}
function insertUserDetailsTopPopUp(Email,Password,ScreenName,CategoryID,NewsLetter)
{
	Sendto=window.parent.location;
	return clientvalidation("email="+Email+"&username="+ScreenName+"&password="+Password+"&CategoryID="+CategoryID+"&insertMode=1&toppopup=yes&newsletter="+NewsLetter+"&Sendto="+Sendto);
}
function userDetails(parameters,returnvalue)
{
	var rvalues=clientvalidation(parameters)
	arr1=returnvalue.split(",")
	if(rvalues!="")
	{
		arr=rvalues.split("-:-")
		for(i=0;i<arr1.length;i++)
			eval(arr1[i]).value=arr[i];
	}
	else
	{
		arr=rvalues.split("-:-")
		for(i=0;i<arr1.length;i++)
			eval(arr1[i]).value="";
	}
}
function GetSessionValues()
{
	return clientvalidation("viewmode=sessionvalues");
}
function isValidUser(username,password)
{
	return clientvalidation("username="+username+"&password="+password);
}
function isValidUserByEmail(email,password)
{
	return clientvalidation("email="+email+"&password="+password);
}
function isEmailExist(email)
{
	var rvalues=clientvalidation("email="+email);
	if(rvalues=="")
		return false;
	else
		return true;
}
function isUsernameExist(username)
{
	var rvalues=clientvalidation("username="+username);
	if(rvalues=="")
		return false;
	else
		return true;
}
function isUserNameorEmailExist(UserName,Email)
{
	return clientvalidation("username="+UserName+"&email="+Email);
}
function SetUrl(MyUrl)
{
	CurrentUrl=MyUrl
}
function clientvalidation(UrlParameters) 
{
	if(CurrentUrl=="")
		url='http://www.medindia.net/regis/quick-regis/server-validation.asp?'+UrlParameters
	else if(CurrentUrl!="medindia") 
		url="http://"+CurrentUrl+"/regis/quick-regis/server-validation.asp?"+UrlParameters
	else
		url="http://medindia/newmedindia/regis/quick-regis/server-validation.asp?"+UrlParameters
	
	var req = false;
	if (window.XMLHttpRequest) 
	{
		try { req = new XMLHttpRequest();} 
		catch (e) {	req = false;}
	} 
	else if (window.ActiveXObject) 
	{
		try {	req = new ActiveXObject("Msxml2.XMLHTTP");} 
		catch (e) { try {req = new ActiveXObject("Microsoft.XMLHTTP");}  catch (e) {req = false;}}
	}
	if (req) 
	{
		req.open('GET', url, false);
		req.send(null);
		return req.responseText;
	} 
	else 
	{
		alert("Sorry, your browser does not support XMLHTTPRequest objects. This page requires Internet Explorer 5 or better for Windows, or Firefox for any system, or Safari. Other compatible browsers may also exist.");
		return "Not a valid One";
	}
}
function checkLoginName(LoginName)
{
	//var LoginNameRE =/^[a-zA-Z0-9]+$/
	var LoginNameRE =/^[a-zA-Z0-9\.\-\_]+$/
	if (LoginName.match(LoginNameRE)){
		return true;
	}else{
		return false;
	}
}
function checkLoginNameLastChar(LoginName)
{
	var LoginNameRE =/^[a-zA-Z0-9\.\-\_]+[a-zA-Z0-9\-\_]$/
	if (LoginName.match(LoginNameRE)){
		return true;
	}else{
		return false;
	}
}
function isvalidEmail(emailid)
{
	var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(emailid!="" && emailid.match(emailRegEx))
		return true;
	else
		return false;
}
function Trim(val) 
{
	return val;	
}
function ltrim(lval) 
{
	if(lval=="" || lval.charAt(0)!=' ')  
		return rtrim(lval);
	else
		ltrim(lval.substring(1,lval.length));
}
function rtrim(rval) 
{
	if(rval=="" || rval.charAt(rval.length-1)!=' ')  	 
		return rval;
	else
		rtrim(rval.substring(0,(rval.length-1)));
}
function extensioncheck(filename,option)
{
    var ext = filename.substring(filename.lastIndexOf('.') + 1).toLowerCase();
    if(option=="images")
	{
		if(ext == "gif" || ext == "png" || ext == "jpg")
	        return true;
	}
	else if(option=="movies")
	{
		if(ext == "wmv" || ext == "mov" || ext == "avi" || ext == "mpeg" || ext == "flv" || ext == "mp4")
	        return true;
	}
	return false;
}
function increaseFontSize() 
{
	var p = document.getElementsByTagName('p');
	for(i=0;i<p.length;i++) 
	{
		p[i].style.fontSize = 18+"px"
		p[i].style.lineHeight = 25+"px"
	}
}
function increaseFontSize1() 
{
   var p = document.getElementsByTagName('p');
   for(i=0;i<p.length;i++) 
   {
      p[i].style.fontSize = 24+"px"
      p[i].style.lineHeight = 30+"px"
   }
}
function decreaseFontSize() 
{
   var p = document.getElementsByTagName('p');
   for(i=0;i<p.length;i++) 
   { 
         p[i].style.fontSize = 12+"px"
         p[i].style.lineHeight = 20+"px"
   } 
}
/******************************includes/js/top-loginnew.js - social network  and forgot password functions included - START  **********/
var _siteURL;
function aspx(){
		var _top = ($(window).height()-450)/2;
		var _left = ($(window).width()-700)/2;
  		window.open (_siteURL+"/socialnetwork/default.aspx?fr=medindia", "_blank" , 'directories=0,titlebar=0,addressbar=no,width=700, height=450, top='+_top+',left='+_left);
	};
function _popup_center(){
	var _popup_height = $('.pop-up').outerHeight();
	var _popup_width = $('.pop-up').outerWidth();
	var _win_height = $(window).height();
	var _win_width = $(window).width();		
	var _top = (_win_height-_popup_height)/2;
	var _left = (_win_width-_popup_width)/2;
	$('.pop-up').css({"top":_top,"left":_left});
}
function OpenForgotPass()
{
	_black_screen();
	_forgot_elm();
	_forgot_content();
	_popup_center();
}
function _black_screen(){
	$('body').append("<div id='black-screen'></div>");	
	$('#black-screen').css('opacity','0.7');
	if($.browser.msie){
		$('html,body').css('overflow','hidden');	
	}
}
function _forgot_elm(){
	$('body').append("<div id='popup_elm' class='pop-up forgot-cont'></div>");
}
function _forgot_content(){
	$('.forgot-cont').load(_siteURL+'/forgotpwd.asp');	
}
function _close_popup(){
	$('#popup_elm').remove();
	$('#black-screen,#popup_sub').remove();
	if($.browser.msie){
		$('html,body').css('overflow','');	
	}
}
function _forgot_submit(){
		$('#popup_elm').hide();
		$('body').append("<div id='popup_sub' class='pop-up forgot-cont'></div>");
		var $email = $("#forgot-pass-form input[name='email']").val();
		$('#popup_sub').load(_siteURL+'/verify.asp?email='+$email);
		_popup_center();
}
function _popup_focus(obj){
	if(obj.value==obj.defaultValue) {obj.value = ''; }	
	obj.style.color ='#333';
	obj.style.borderColor='#4169e1';
}
function _popup_blur(obj){
	if(obj.value == '') { obj.value=obj.defaultValue; }	
	obj.style.color ='#999999';
	obj.style.borderColor='';
}
/******************************includes/js/top-loginnew.js -social network  and forgot password functions  - END  **********/
/****************************** jquery/jquery-functions.js - included here - START  ****************************/
function ShowBackground(elementID)
{
    $("#"+elementID).hide();
    $("select").show();
	$("#myright1").show();
}
function HideBackground(elementID)
{
    $("#" + elementID).css("width",getPageWidth());
    $("#" + elementID).css("height",getPageHeight());
    $("#"+elementID).css("opacity",0.5);
    $("#"+elementID).show();
	$("#myright1").hide();
}
function setCenter(elementID)
{
    $("#" + elementID).css("left",(getPageWidth())/2 - $("#" + elementID).width()/2);
    $("#"+elementID).css("top",50);
	$('html, body').animate({scrollTop:0},500);
}
function animateToCenter(elementID)
{
    $("#" + elementID).css('left',0);
    $("#" + elementID).show();
    $("#" + elementID).animate({ left: getPageWidth()/2 - $("#" + elementID).width()/2 },500);
}
/****************************** jquery/jquery-functions.js - included here - END  ****************************/
/****************************** facebook/medconnect/js/MedConnect.js - included here - START *******************/
function MedConnect() {
    if (location.host == 'www.medindia.net') {
        jQuery('#fbConDiv').html("");
        ifrm = document.createElement("iframe");
        ifrm.setAttribute("name", "medCon");
        ifrm.setAttribute("id", "medCon");
        ifrm.setAttribute("frameborder", "0");
        ifrm.setAttribute("scrolling", "auto");
        ifrm.style.width = "300px";
        ifrm.style.height = "200px";
        ifrm.style.margin = "0px";
        ifrm.style.padding = "0px";
        ifrm.style.border = "none";
        jQuery('#fbConDiv').append(ifrm);
        HideBackgroundCustom('HideDiv');
        setFBCenter('fbConDiv');
        jQuery('#fbConDiv').fadeIn(500);
        if (document.getElementById("fbClose"))
            jQuery('#fbClose').fadeIn(500);
        document.getElementById("medCon").src = "http://" + location.host + "/facebook/medconnect/default.aspx";
        return true;
    }
    else {
        window.location.href = "http://www.medindia.net/faceConnect.asp?r=" + escape(location.href);
    }
}
function fbDivClose() {
    jQuery('#fbConDiv').fadeOut(500);
    if (document.getElementById("fbClose"))
        jQuery('#fbClose').fadeOut(500);
    ShowBackgroundCustom('HideDiv');
}
function ShowBackgroundCustom(DivID) {
    jQuery("#" + DivID).hide();
    jQuery("select").show();
}
function HideBackgroundCustom(DivID) {
    jQuery("#" + DivID).css("width", getPageWidth());
    jQuery("#" + DivID).css("height", getPageHeight());
    jQuery("#" + DivID).css("opacity", 0.5);
    jQuery("#" + DivID).show();
}
function setFBCenter(elementID) {
    jQuery("#" + elementID).css("left", (getPageWidth()) / 2 - jQuery("#" + elementID).width() / 2);
    jQuery("#" + elementID).css("top", 70);
    if (document.getElementById("fbClose")) {
        fbDivLeft = jQuery('#fbConDiv').css("left");
        fbDivLeft = fbDivLeft.replace("px", "");
        jQuery('#fbClose').css("left", (parseInt(fbDivLeft) + parseInt(jQuery('#fbConDiv').width()) - parseInt(parseInt(jQuery('#fbClose').width()) / 2)  )-12);
        jQuery('#fbClose').css("top", (82 - parseInt(parseInt(jQuery('#fbClose').height()) / 2) ));
    }
}
function getPageWidth() {
    return jQuery(document).width() > 1008 ? jQuery(document).width() : 1008;
}
function getPageHeight() {
    return jQuery(document).height() > 1200 ? jQuery(document).height() : 1200;
}
function setFBsize(width, height) {
    jQuery("#fbConDiv").css("height", height);
    jQuery("#medCon").css("height", height);
    jQuery("#fbConDiv").css("width", width);
    jQuery("#medCon").css("width", width);
    setFBCenter("fbConDiv");
}
function reloadMedConnect() {
    var myhref = "";
    myhref = window.location.href;
    myhref = myhref.replace('.com', '.net').replace('.org', '.net').replace('medConnect=1','medConnect=0');
    top.window.location.href = myhref;
}
/****************************** facebook/medconnect/js/MedConnect.js - included here - END *******************/
/****************************** includes/js/common.js - included here - START *******************/
function css_browser_selector(u){var ua=u.toLowerCase(),is=function(t){return ua.indexOf(t)>-1},g='gecko',w='webkit',s='safari',o='opera',m='mobile',h=document.documentElement,b=[(!(/opera|webtv/i.test(ua))&&/msie\s(\d)/.test(ua))?('ie ie'+RegExp.$1):is('firefox/2')?g+' ff2':is('firefox/3.5')?g+' ff3 ff3_5':is('firefox/3.6')?g+' ff3 ff3_6':is('firefox/3')?g+' ff3':is('gecko/')?g:is('opera')?o+(/version\/(\d+)/.test(ua)?' '+o+RegExp.$1:(/opera(\s|\/)(\d+)/.test(ua)?' '+o+RegExp.$2:'')):is('konqueror')?'konqueror':is('blackberry')?m+' blackberry':is('android')?m+' android':is('chrome')?w+' chrome':is('iron')?w+' iron':is('applewebkit/')?w+' '+s+(/version\/(\d+)/.test(ua)?' '+s+RegExp.$1:''):is('mozilla/')?g:'',is('j2me')?m+' j2me':is('iphone')?m+' iphone':is('ipod')?m+' ipod':is('ipad')?m+' ipad':is('mac')?'mac':is('darwin')?'mac':is('webtv')?'webtv':is('win')?'win'+(is('windows nt 6.0')?' vista':''):is('freebsd')?'freebsd':(is('x11')||is('linux'))?'linux':'','js']; c = b.join(' '); h.className += ' '+c; return c;}; css_browser_selector(navigator.userAgent);
function pollcheck()									// for Health Poll
{
	var fname = document.Poll;
	var chlen = fname.choice.length;
	var count=0;
	var isSelected=false;
	var selChoice;
	for (count = 0; count < chlen; count++)
	{
		if (fname.choice[count].checked == true)
		{
			selChoice=fname.choice[count].value;
			isSelected=true;
			break;
		}
	}
	if (isSelected == true)
	{
		window.location.href='poll/index.asp?Choice='+selChoice
		return true;
	}
	else
	{
		alert("Please Select A Choice");
		return false;
	}

}
function newspollcheck()									// for News Poll
{
	var fname = document.Poll;
	var chlen = fname.choice.length;
	var count=0;
	var isSelected=false;
	var selChoice;
	for (count = 0; count < chlen; count++)
	{
		if (fname.choice[count].checked == true)
		{
			selChoice=fname.choice[count].value;
			isSelected=true;
			break;
		}
	}
	if (isSelected == true)
	{
		window.location.href='../poll/index.asp?category=news&Choice='+selChoice
		return true;
	}
	else
	{
		alert("Please Select A Choice");
		return false;
	}

}
//----------------------------------------navigations-------------------------//
	$(function(){
		$(".nav-main li,.nav-left li,.header-left li").hover(function()
			{
				$('.nav-main li').removeClass("hover");
					totalWidth = $(this).width() + parseInt($(this).css("padding-left"), 10) + parseInt($(this).css("padding-right"), 10);
					$('.hide-border', this).css('width', totalWidth);
				$(this).addClass("hover");
			},
			function()
			{
			$(this).removeClass("hover");
			}
		);
		
	});
	//----------------------------------------footer bookmarks animation-------------------------//
	$(document).ready(function() {
		$("#footer-fuoc-links li").append('<img class="shadow" src="http://www.medindia.net/images/icons-shadow.png" width="42" height="15" alt="" />');
		$("#footer-fuoc-links li").hover(function() {
			var e = this;
		    $(e).find("a").stop().animate({ marginTop: "-20px" }, 250, function() {
		    	$(e).find("a").animate({ marginTop: "-10px" }, 250);
		    });
		    $(e).find("img.shadow").stop().animate({ width: "80%", height: "20px", marginLeft: "0px", opacity: 0.25 }, 250);
		},
		function(){
			var e = this;
		    $(e).find("a").stop().animate({ marginTop: "4px" }, 250, function() {
		    	$(e).find("a").animate({ marginTop: "0px" }, 250);
		    });
		    $(e).find("img.shadow").stop().animate({ width: "100%", height: "15px", marginLeft: "0", opacity: 1 }, 250);
		});
	});

//-----------------------------mouse over function for top latest artical-------------------//
$(function(){
		$(".jcarousel-next").hover(function()
			{
				$('.jcarousel-next').removeClass("next");
				$(this).addClass("next");
			},
			function()
			{
			$(this).removeClass("next");
			}
		);
		
});
$(function(){
		$(".jcarousel-prev").hover(function()
			{
				$('.jcarousel-prev').removeClass("prev");
				$(this).addClass("prev");
			},
			function()
			{
			$(this).removeClass("prev");
			}
		);
		
});
//----------------------------- Home page banner animation -------------------//
//$(function(){$('#slider').anythingSlider();	});//
//------------------------------latest slider --------------/
$(function(){
	$("#next-latest").click(function(){
  $(".all-slides").animate({scrollLeft: "+=600"}, 300, "swing");
});
$("#prev-latest").click(function(){
  $(".all-slides").animate({scrollLeft: "-=600"}, 300, "swing");
});	
});
/*------------------------------home tabe section ----------------------*/
$(function(){
	$('.main-tab-nav li').bind('click',function(){
		var tab_target = $('span',this).attr('class');
		$('.main-tab').hide();$("#"+ tab_target).show();	
		$('.main-tab-nav li').removeClass('active');$(this).addClass('active');
	});
});
/*------------------------------whats-hot tabe section ----------------------*/
$(function(){
	$('.hot-nav li').bind('click',function(){
		var tab_target = $('span',this).attr('class');
		$('.hot-tab').hide();$("#"+ tab_target).show();	
		$('.hot-nav li').removeClass('active');$(this).addClass('active');
	});
});
/*------------------------------Accor tabe section ----------------------*/
$(function(){
	$('.accordion-slides .acc-photos').bind('click',function(){
		var tab_target = $(this).attr('id');
		$('.accordion-slides .acc-section').slideUp();
		$('.'+tab_target).slideDown();
	});
});
/****************************** includes/js/common.js - included here - END *******************/
/****************************** includes/med-header/js/ajax-search.js - included here- START *******************/
function getgenericlist(serviceurl,txt) {
	$.getJSON(serviceurl+'/med-search/generics.asp?txt='+txt, function(data) {
		$('#genericlist li').remove();
		gg =data.items;
		$.each(gg, function(index, generic) {				
			$('#genericlist').append('<li><a href="' + generic.pgurl + '"  style="cursor:pointer;width:230px">' + generic.name + '</a></li>');
		});
		if($("#genericlist li").length < 1){
			$('#genericlist').css('display','none');	
		} else {
			$('#genericlist').css('display','block');	
		}
	//$('#genericlist').listview('refresh');
	});
}
function getpricelist(serviceurl,txt) {
	$.getJSON(serviceurl+'/med-search/drug-price.asp?txt='+txt, function(data) {
		$('#pricelist li').remove();
		dp =data.items;
		$.each(dp, function(index, drugprice) {
							
			$('#pricelist').append('<li><a href="' + drugprice.pgurl + '"  style="cursor:pointer;width:230px">' + drugprice.name + '</a></li>');
		});
		if($("#pricelist li").length < 1){
			$('#pricelist').css('display','none');	
		} else {
			$('#pricelist').css('display','block');	
		}
	});
}
function getdrlist(serviceurl,txt,dircat,dircity) {
		$.getJSON(serviceurl+'/med-search/directoriesnew.asp?txt='+txt+'&dircat='+dircat+'&dircity='+dircity, function(data) {
		$('#'+dircat+'list li').remove();
		dr =data.items;
		$.each(dr, function(index, dirs) {
			$('#'+dircat+'list').append('<li><a href="' + dirs.dirurl + '"  style="cursor:pointer;width:300px;text-transform:capitalize">' + dirs.dirname + '</a></li>');
		});
		if($('#'+dircat+'list li').length < 1){
			$('#'+dircat+'list').css('display','none');	
		} else {
			$('#'+dircat+'list').css('display','block');	
		}
	});
}
function getcollegelist(serviceurl,txt,dircat,dircity) {
		$.getJSON(serviceurl+'/med-search/College.asp?txt='+txt+'&dircat='+dircat+'&dircity='+dircity, function(data) {
		$('#'+dircat+'list li').remove();
		dr =data.items;
		$.each(dr, function(index, dirs) {
			$('#'+dircat+'list').append('<li><a href="' + dirs.dirurl + '"  style="cursor:pointer;width:300px;text-transform:capitalize">' + dirs.dirname + '</a></li>');
		});
		if($('#'+dircat+'list li').length < 1){
			$('#'+dircat+'list').css('display','none');	
		} else {
			$('#'+dircat+'list').css('display','block');	
		}
	});
}
/****************************** includes/med-header/js/ajax-search.js - included here- END *******************/
/******************* includes/med-header/js/common-header-footer.js - included here - START ***************/
			enableSelectBoxes();
			var nav_bar = $('#top-nav').height();
			$('.navfullcont-main,.navfullcont').css('top',nav_bar+'px');
		$('.channel-link').hover(function(){$(this).parent().parent().find('.channel-content').hide();$(this).parent().find('.channel-content').show();	$(this).parent().parent().find('li').removeClass('act-channel');
		$(this).parent().addClass('act-channel');},function(){});
function _focus(obj){
	if(obj.value==obj.defaultValue) {obj.value = ''; }	
	obj.style.color ='#333';
	obj.style.borderColor='#999999';
}
function _blur(obj){
	if(obj.value == '') { obj.value=obj.defaultValue; }	
	obj.style.color ='#666';
	obj.style.borderColor='';
}
	function _hide_ajax_list(){
		$('.ajax-search-box').hide();
	}
	function refreshDialer(){
			$('.search-box input').blur();	
			$('.allContent').find('form').find('.reset-btn').trigger('click');
			$('.ajax-search-box span').trigger('click');					
         }
	$('.allContent').hover(function(){},function(){refreshDialer();});
	$('#new-header .nav-channel ul li a.channel-link').hover(function(){refreshDialer();},function(){});
	$('#new-header .image-type ul li img').hover(function(){$(this).css('opacity','0.7')},function(){$(this).css('opacity','1')});
	function enableSelectBoxes(){
				$('div.selectBox').each(function(){
					$(this).children('span.selected').html($(this).children('div.selectOptions').children('span.selectOption:first').html());
					$(this).attr('value',$(this).children('div.selectOptions').children('span.selectOption:first').attr('value'));
					
					$(this).children('span.selected,span.selectArrow').click(function(){
						if($(this).parent().children('div.selectOptions').css('display') == 'none'){
							$(this).parent().children('div.selectOptions').css('display','block');
						}
						else
						{
							$(this).parent().children('div.selectOptions').css('display','none');
						}
					});
					$(this).find('div.selectOptions').hover(function(){
					},function(){$(this).hide();
					});
					$(this).find('span.selectOption').click(function(){
						$(this).parent().css('display','none');
						$(this).closest('div.selectBox').attr('value',$(this).attr('value'));
						$(this).parent().siblings('span.selected').html($(this).html());
						var dircat = $('div.selectBox').attr('value');
						document.frmdir.dircat.value=dircat;
					 	var dir_input = document.getElementById('dirkey');
						dircity_input=document.getElementById('dircity');
					});
				});		
				$("#dirkey").attr("autocomplete", "off");		
			}
	function isTouchDevice(){
    return "ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch;
	}
	if(isTouchDevice()){
		$("#new-header .nav li.drop-links").each(function() {
			$(this).find('a:first').click(function(event){
				event.preventDefault();  
				$(this).mouseenter();	
			});
        	$(this).find(".navfullcont").append('<a href="#" class="closemenu">X</a>'); 
        });
		setInterval (function(){
			$("#new-header .nav li.drop-links").each(function() {
				if(!$(this).find(".navfullcont-main a.closemenu").length){
					$(this).find(".navfullcont-main").append('<a href="#" class="closemenu">X</a>'); 
				}
				$('.navfullcont-main a.closemenu').css('opacity','0.3');
			});
			$(".navfullcont-main a.closemenu").click(function(event){
				event.preventDefault();
				$('.nav .drop-links').mouseleave();
			});
			},1000);
		
		$('.navfullcont a.closemenu').css('opacity','0.3');
		$("#new-header .nav-channel .channel-link").click(function(event){
				event.preventDefault(); 
				$(this).mouseenter();
		});
		$(".navfullcont a.closemenu").click(function(event){
			event.preventDefault();
			$('.nav .drop-links').mouseleave();
		});
	}; 
/******************* includes/med-header/js/common-header-footer.js - included here  - END *************************/