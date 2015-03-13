safeAjax is a jQuery library and PHP ajax connector pair using JSON as the communications medium.

I wrote this javascript library & php connector pair to password protect web pages and safeguard my ajax communications and database actions from my web pages.

It was originally based upon chris shifletts article: the truth about sessions -- which proposed a best-practice method for creating/maintaining safe sessions and persisting logins via cookies.

Version 5 adds optional usage of JQueryUI and supplies all dialogs including a not-enough-privs dialog, jqModal will be obsoleted eventually.  Support for a new server-side action log has been added to aid in debugging the backend.  The client-side library has been wrapped as a module suitable for CommonJS usage.

Version 4.5 extends the Authentication framework to include User Management functions (select/add/delete/update/passwordReset) -- currently implemented in Cassandra, MongoDB, MySQL, and SQLite.  NOTE: this style of user management supports users creating/updating/deleting other users with lower permissions than the creator/deletor holds.  As such the most-super user needs to be inserted out-of-band -- for which purpose cmdline functions are provided, to avoid the need for db management tools.  The MongoDB & Cassandra classes support adding new key:values to the user tables on the fly.  Added functionality now includes login/logout/isLoggedIn calls.  All the old-style Authenticators have been updated and the old-style Authentication class files are included as Deprecated for now.  Pages demonstrating functionality and usability are included (index.html, actions.html, protectedPage.html, and protectedResource.html.

Version 4.2 is a full server-side re-organization with updates to the authentication methodology, including samples for code-based authentication as well as MySQL, MongoDB, & Cassandra.  Method names from the clientSide are renamed to improve readability and understanding.

Version 3 is a full client-side rewrite and updates/enhancements to the drop-in methodology (on the server side.)

Version 2 is a full server-side rewrite to create a drop-in methodology supporting painless extension of your server-side codebase.

Version 1, assembled from dev/test sources - bottlenecks your server requests to allow the server-side to determine which requests need authentication and which one's don't.

Enjoy!

Al;
