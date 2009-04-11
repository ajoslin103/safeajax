/*

jquery.safeAjax.js - jquery plugin for the safeAjax system

I wrote this plugin & connector pair to password protect web pages 
and safeguard my ajax communications from web pages.  

It's based upon chris shifletts article: the truth about sessions 

author: allen @joslin .net 

	03/08/09 - version 1.0, code collection from dev/test/debug

*/

$.fn.safeAjax = function(options) {  

	var defaults = {  
		debug: false,
		debugPane: '#debugPane',
		debugWithJSON: true,
		login: false,
		loginPane: '#loginDialog',
		jqModalLogin: true,
		pageProtector: true,
		ajaxConnector: null
	};  
	var options = $.extend(defaults, options);  

	return this.each(function() {  
		
		protectorPane = $(this);
		
		if (options.debug) {
			if (options.debugPane.length > 0) {
				protectorPane.append("<div id='debugPane'></div>"); //$(options.debugPane).hide();
				if (options.debugWithJSON) { // if the JSON stringify code is loaded
					$(options.debugPane).ajaxError(function(event, request, settings){ $(this).show().append( "ajax error: "+ JSON.stringify(settings)); });
				} else {
					$(options.debugPane).ajaxError(function(event, request, settings){ $(this).show().append( "ajax error: "+ settings.url); });
				}
			}
		}

		if (options.login) {
			if (options.loginPane.length > 0) {
				protectorPane.append("<div id='loginDialog' class='jqmWindow'></div>");
				if (options.jqModalLogin) { // if the jqModal code is loaded
					$(options.loginPane).hide().jqm({ modal: true });				
				}

				// build the login dialog into the loginPane
				$(options.loginPane).append("<h4 id='loginMsg'></h4>");
				$(options.loginPane).append("<p>username: <input class='loginDone' id='uname' value='' /></p>");
				$(options.loginPane).append("<p>password: <input class='loginDone' id='pword' type='password' value='' /></p>");
				$(options.loginPane).append("<p><button id='Login' value='Login' >Login</button></p>");
				$(options.loginPane).append("<div id='loginAnswer'></div>");

				$(".loginDone").keypress(function(e){
					if (e.which == 13) { $("#Login").click(); }
				});
			}

			if ((options.loginPane.length > 0) && (options.ajaxConnector.length > 0)) {
				$("#Login").click(function(){
					$.getJSON(options.ajaxConnector+"?uname="+$("#uname").val()+"&pword="+$("#pword").val(),function(json){
						$("#pword").val(""); $("#uname").val("");
						$("#loginAnswer").html(json.msg);
						if (! json.needsLogin) {
							$(options.debugPane).html(json.msg);
							$(options.loginPane).jqmHide();
						}
					});
				});
			}

			if ((options.pageProtector) && (options.loginPane.length > 0) && (options.ajaxConnector.length > 0)) {
				$.getJSON(options.ajaxConnector,function(json){
					if (json.needsLogin) {
						$("#loginMsg").html(json.msg);
						$(options.loginPane).jqmShow(); 
					}
				});
			}
		}

	});  

};

/* done */

