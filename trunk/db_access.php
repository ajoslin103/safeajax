<?php

//
//	db_access.php - utilities for mySQL access for the safeAjax system
//
//		I wrote this plugin & connector pair to password protect web pages 
//		and safeguard my ajax communications from web pages.  
//		
//		It's based upon chris shifletts article: the truth about sessions 
//		
//	author: allen @joslin .net
//
//		03/08/09 - version 1.0, code collection from dev/test/debug
//

####################################
# -- setup creds for the database
function db_creds ( $hoast, $dbas, $unam, $pwd )
{
	global $db_hostn;
	global $db_dbnam;
	global $db_uname;
	global $db_pword;

	$db_hostn = $hoast;
	$db_dbnam = $dbas;
	$db_uname = $unam;
	$db_pword = $pwd;
}

####################################
# -- select from database
function db_select ( $debug, $query )
{
	global $one_con;
	if ($one_con == null) {
		open_db($debug);
	}

	if ($one_con != null) {
		
		$result = mysql_query($query) 
			or die("<!-- in:$debug \n query:$query \n error:" .mysql_error(). " -->");

		return $result;
	}

	return null;
}

####################################
# -- select from database
function db_select_cell ( $debug, $query )
{                     
	global $one_con;
	if ($one_con == null) {
		open_db($debug);
	}

	$cellValue = "";
	
	if ($one_con != null) {
		
		$result = mysql_query($query) 
			or die("<!-- in:$debug \n query:$query \n error:" .mysql_error(). " -->");
		
		if ($result) {
			
			if ($first_row = mysql_fetch_row($result)) {

				$cellValue = $first_row[0];
			}
		}
	}

	return $cellValue;
}

####################################
# -- update database
function db_update ( $debug, $update )
{
	global $one_con;
	if ($one_con == null) {
		open_db($debug);
	}

	if ($one_con != null) {
		$result = mysql_query($update) 
			or die("<!-- in:$debug \n update:$update \n error:" .mysql_error(). " -->");
		return $result;
	}
	
	return null;
}

####################################
# -- connect to database
function open_db ( $debug )
{
	global $db_hostn;
	global $db_dbnam;
	global $db_uname;
	global $db_pword;

	global $one_con;

	$one_con = mysql_connect($db_hostn, $db_uname, $db_pword)
		or die('in: $debug, error: ' . mysql_error());
		
	mysql_select_db($db_dbnam) 
		or die('in: $debug, error: ' . mysql_error());
}

?>