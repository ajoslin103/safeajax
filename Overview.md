General information about the safeAjax plugin by Allen Joslin

### In Summary ###

Ajax is a thing of beauty, combining Ajax and jQuery creates elegance -- an insideous elegance resulting in a need for truly seamless protection, protection that is offered via safeAjax.

I wrote this plugin to password protect my own web pages/sites and also to safeguard my backend resources and actions. It's originally based upon Chris Shifletts article: the truth about sessions, and uses the cross-platform JSON notation for communications between the javascript and the server-side code.

It's been thru a few upgrades over the years, Enjoy !!

Version 4.5 extends the Authentication framework to include User Management functions (select/add/delete/update/passwordReset) -- currently implemented in Cassandra, MongoDB, MySQL, and SQLite. NOTE: this style of user management supports users creating/updating/deleting other users with lower permissions than the creator/deletor holds. As such the most-super user needs to be inserted out-of-band -- for which purpose cmdline functions are provided, to avoid the need for db management tools. The MongoDB & Cassandra classes support adding new key:values to the user tables on the fly. All the old-style Authenticators have been updated and the old-style Authentication class files are included as Deprecated for now.

### Web-side Usage ###

At this time there are several plugins that safeAjax depends upon, they are included in the distribution and loaded automatically -- safeAjax will log credit to their creators upon startup.

Step 1.

Include safeAjax and identify the connector when your page loads -- OptionsAndDefaults

```
<script type='text/javascript'      src='./lib/safeAjax/jquery.safeAjax_v4.js'></script>
<script type='text/javascript'>
$(document).ready(function() {

	var sacv4 = new SafeAjax({ 
		ajaxConnector: "./lib/safeAjax/saConnector.php"
		,loginFirst: false ,handleLogin: true, sha1Logins: false
		,debug: true ,notify: true ,duration: "5m"
	});

</script>
```

Step 2.

Use the connector at will to request info and actions from the backend, should your backend deem that a particular resource/action needs protection then safeAjax will enforce the protection automatically according to the startup options you supply.

The jqModal plugin will be used to present a login dialog which will not go away until the backend accepts the given username and password combination, and cookies the user's browser (the cookie does not contain any info that can be used to authorize any other browser or session and has a configurable expiry date.)

Once the user succeeds then the request is re-submitted and approved using the just deposited cookie.

The safeAjax-bottlenecked request/response that caused the login to be required is discarded and a copy is automatically re-submitted by safeAjax to streamline the process of approving requests as well as [slightly](slightly.md) improving the overall security -- your code will not know this has happened.

**javascript (jQuery) calling samples**  -- CallingOptions

```

// for our purposes, the backend allows this
$('#safeAjax').asyncRequest({ load: 'address', id: addrId },function(data){ 
   $('#addr').val(data.addr);    $('#city').val(data.city);
   $('#state').val(data.state);  $('#zip').val(data.zip);
});

// for our purposes, the backend restricts this
$('#saveBtn').click(function(){
   dataItems = { save: 'address', id: addrId };
   dataItems.addr = $('#addr').val();    dataItems.city = $('#city').val();
   dataItems.state = $('#state').val();  dataItems.zip =$('#zip').val();
   $('#safeAjax').syncRequest(dataItems,function(result){ 
      $('#savedStatus').html('['+(result. authOK)?'saved ok':'save failed'+']');
   });
});

```

### Server-side Usage ###

This plugin requires a server-based connector (provided as part of this package, implemented in PHP) which manages the connections to and interactions with the database. This connector is where you will select the level of protection desired from a set of options -- see the saConnector.php file.

The levels of protection are provided in a class hierarchy instatiate whichever one you want and the usage is identical -- Lower security: single username/password or codeBased verification for all resources (no database table of usernames and passwords required.)  Or High security: database based multipleUser+accessLevel configuration which allows for different logins to have different powers.  SQLite, MySQL, MongoDB, and Cassandra are supported out of the box.

**A word on parameters, I use a single JSON object to handle everything.  period.  full-stop.**

I long ago settled on using properties lists (maps/hashes/associativeArrays) to encapsulate all parameters sent to and received from routines.  While a little bit of predictability and perhaps some type-safety was lost the overall increase in ease-of-use far outweighed the required increase in stack memory.  When it came time to implement safeAjax there was no second thought -- I hope you will enjoy this usage as much as I do.

On the request side I merge the _GET and_POST parameter arrays into one $params [associative](associative.md) array so that you don't have to care how the values were sent when your code is executed.

For the return I provide a variable $json into which everything to be returned is to be put.  The authorization routines will fill the safeAjax and safeAjaxRequires values and you should load up the rest with your outputs.  The [provided](provided.md) connector will encode the $json variable at the completion of the request and the web-side plugin will parse it back into a variable ready for your usage.

**A word on code organization, segregate and compartmentalize wherever possible !!**

This plugin was written to support a drop-in methodology for easily extending the server-side codebase using a predefined interface which your classes must implement.  You then populate a particular directory with your class files and every request/response that goes thru the connector is given to each class to see if they want to do something with the request.

This support for drop-in classes allows one to easily group sets of routines related to particular actions or entities.  It's far easier to compartmentalize your code and limit the ripples of change and testing when you can segment your codebase in this way.  Even though all code is instatiated for each request and response whether it will be used or not I believe the tradeoff to code stability and maintainablity to be completely worth the cost of a few more milliseconds per request/response cycle.

The current implementation looks for the drop-ins folder as a sibling to the folder where safeAjax was loaded from -- you can change this (carefully) to wherever you wish.  Note: there is a required naming convention for these files -- do not fail to name your files properly! <pre> <className>.class.php </pre> Only files matching this naming convention will be loaded and executed !!

There are prefix and suffix files (safeAjax\_requestStart.php & safeAjax\_requestStop.php) provided and loaded before and after each request-response cycle -- in these you can put some amount of code that MUST be execute before/after the cycle.

Here's a sample server side class file:

```

<?php

require_once(dirname(__FILE__)."/safeAjax_SiteCode.interface.php"); 

// This drop-in is not using databases - anything over accessLevel = 1 needs a login/cookie

class protectedResource implements safeAjax_SiteCode {

	function handleRequest ( &$params, &$json, &$auth ) {

		if (! empty($params['protect'])) { //----------------------------------------------------
			if ($params['protect'] == 'sampleRequest') {
				if ($auth->testAccessLevel(1,$json)) {

					$json['returnedResource'] = " this string is protected by a login";
				}
			}
		}

	}

}

?>

```

### Changelog ###

<pre>
see allen @joslin .net for changes<br>
09/10/10 - vers 4.5: adding userManagement functions add/modify/delete/find/reset users - access levels are enforced, password reset hash codes are generated/stored upon demand.  Added MySQL & SQLite.<br>
08/22/10 - vers 4: adding Cassandra and MongoDB authentications, large de-confusion effort. NOTE: syncRequest() deprecates syncDBMS() & asyncRequest() deprecates safeDBMS()<br>
02/14/10 - vers 3: nearly done !! syncRequest only supports login on page load so far<br>
01/30/10 - vers 3: rewriting w/resig's help (ninjascript !) as a library rather than a plugin<br>
01/14/10 - vers 3: internal&external login dialog support options<br>
12/14/09 - vers 3: cookie duration as strings, auto cookie domain from php backend<br>
11/01/09 - vers 3: added synchronous ajax support & failure callbacks<br>
10/01/09 - vers 3: rewriting & documenting, WILL NOT be backwards compatible<br>
09/27/09 - vers 2.3: combine reader & writer in connector<br>
07/01/09 - vers 2.2: extract html to dialogs.html<br>
06/14/09 - vers 2.1: modifications to support IE<br>
05/20/09 - vers 2.0: rewrite/refactor, encapsulate connector, return JSON structure<br>
03/08/09 - vers 1.0, code collection from dev/test/debug<br>
</pre>