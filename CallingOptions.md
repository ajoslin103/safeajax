SafeAjax -- Calling Options

```

    /*********** push a call to the backend with full blocking ***********/
    function syncRequest ( requestObj ); 
    
    /********** push a call to the backend without blocking ***********/
    function asyncRequest ( requestObj, callbackPass, callbackFail ); 



    /*********** make a [blocking] call for logout to the backend ***********/
    function syncLogout (  );

    /*********** make a [blocking] call for login to the backend ***********/
    function syncLogin ( username, password ); // calls logout() 

```