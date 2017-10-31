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
        fbDivLeft = $('#fbConDiv').css("left");
        fbDivLeft = fbDivLeft.replace("px", "");
        jQuery('#fbClose').css("left", (parseInt(fbDivLeft) + parseInt($('#fbConDiv').width()) - parseInt(parseInt($('#fbClose').width()) / 2)  )-12);
        jQuery('#fbClose').css("top", (82 - parseInt(parseInt($('#fbClose').height()) / 2) ));
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
