<?php
ob_start();

//
//	rwConnector.php - database connector for the safeAjax system
//
//		I wrote this plugin & connector pair to password protect web pages 
//		and safeguard my ajax communications from web pages.  
//		
//		It's based upon chris shifletts article: the truth about sessions 
//		
//		use this file for read-write and secure requests for data/updates
//
//	author: allen @joslin .net 
//
//		03/08/09 - version 1.0, code collection from dev/test/debug
//

require_once("./db_access.php");
require_once("./PasswordAccess.php");

$params = array_merge($_GET,$_POST);

$json = array();

if (requestCredsOK($json,$params)) {	

	db_creds("localhost", "<dbName>", "<readWriteUserName>", "<readWritePassword>");

	if ($params['action'] == 'delete') {

		// if ($params['set'] == 'teachers') {
		// 	$updateSQL = " update tbl_teachers set deleted=1 where id = ".$params['teacherId'];
		// 	$deleteResult = db_update("del.teachers.0",$updateSQL);
		// }

	}
}

print json_encode($json);
ob_end_flush();
?>