SafeAjax -- Options and Defaults

```

defaults = {
    ajaxConnector: "./lib/safeAjax/saConnector.php"    // backend connector script
    ,cookieName: "sacv4"                               // cookie setting, default
    ,duration: "24h"                                   // cookie setting, default
    ,debug: false                                      // throw logic points at the console
    ,notify: true                                      // throw panic/failure alerts at the user
    ,type: "GET"                                       // ajax call settings, default
    ,error: ""                                         // our last known error
    ,ready: true                                       // our state
    ,loginFirst: false                                 // safeAjax option to login on page load
    ,handleLogin: false                                // safeAjax option to use our own login dialog
    ,loginReady: false                                 // state of login codebase
    ,loginMissing: false                               // state of login codebase
    ,unFieldName: "sa_UName"                           // login option
    ,pwFieldName: "sa_PWord"                           // login option
    ,sha1Logins: true                                  // login option
    ,json_js: "./lib/safeAjax/js/json2.js"             // working resource
    ,sha1_js: "./lib/safeAjax/js/jquery.sha1.js"       // login resource
    ,jqModal_js: "./lib/safeAjax/js/jqModal.js"        // login resource
    ,jqModal_css: "./lib/safeAjax/js/jqModal.css"      // login resource
    ,useJQueryUI: true                                 // use jQuery UI dialogs and routines - avoids jqModal
};

```