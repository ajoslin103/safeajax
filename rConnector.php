<?php
ob_start();

//
//	rConnector.php - database connector for the safeAjax system
//
//		I wrote this plugin & connector pair to password protect web pages 
//		and safeguard my ajax communications from web pages.  
//		
//		It's based upon chris shifletts article: the truth about sessions 
//		
//		use this file for read-only and no-security requests for data
//
//	author: allen @joslin .net 
//
//		03/08/09 - version 1.0, code collection from dev/test/debug
//

require_once("./db_access.php");

$params = array_merge($_GET,$_POST);

$json = array();

db_creds("localhost", "<dbName>", "<readOnlyUserName>", "<readOnlyPassword>");

if ($params['action'] == 'one') {
	
	// if ($params['set'] == 'teachers') {
	// 	$selectSQL = " select id,fullName from tbl_teachers where deleted=0 order by fullName ";
	// 	if ($selectResult = db_select("select.teachers.0",$selectSQL)) {
	// 		while ($eachRow = mysql_fetch_assoc($selectResult)) {
	// 			$json[$eachRow[id]] = $eachRow[fullName];
	// 		}
	// 	}
	// }

}

print json_encode($json);
ob_end_flush();
?>