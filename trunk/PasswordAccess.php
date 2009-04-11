<?php

//
//	PasswordAccess.php - password module for the safeAjax system
//
//		I wrote this plugin & connector pair to password protect web pages 
//		and safeguard my ajax communications from web pages.  
//		
//		It's based upon chris shifletts article: the truth about sessions 
//		
//		add your username/password checking to givenCredsAreGood()
//
//	author: allen @joslin .net 
//
//		03/08/09 - version 1.0, code collection from dev/test/debug
//

ob_start();

DEFINE(cookieDomain,"www.yourdomain.com");

// ------------------------------------------------------------------------------------
function requestCredsOK ( &$json, &$params )
{
	$jsonMsg = '';
	$jsonDenied = true;

	if (needsAskForCreds()) {

		$jsonDenied = true;
		$jsonMsg = 'login is required to access this resource';

		if ($params['pword'] != "") {

			$jsonMsg = 'unknown password';
			if (givenCredsAreGood($params['uname'],$params['pword'])) {

				$jsonDenied = false;
				$jsonMsg = 'password accepted';
			}
		}

	} else {

		$jsonDenied = false;
		$jsonMsg = 'login confirmed';

	}

	$json += array('needsLogin' => $jsonDenied);
	$json += array('msg' => $jsonMsg);
	
	return (! $jsonDenied);
}

// ------------------------------------------------------------------------------------
function needsAskForCreds ()
{
	if (! $_COOKIE["fprnt"]) {
		return true;
	}

	$today = getdate();
	$salt = $today[year] . $today[yday];

	$allegedPrint = $salt . $_SERVER['HTTP_USER_AGENT'];
	if (md5($allegedPrint) != $_COOKIE["fprnt"]) {
		return true;
	}

	return false;
}

// ------------------------------------------------------------------------------------
function givenCredsAreGood ( $allegedUsername, $allegedPassword )
{
	
	$usrnm = "usr"; $paswd = "pwd";
	if (0 == strcmp($allegedUsername,$usrnm)) {
		if (0 == strcmp($allegedPassword,$paswd)) {

			cookieTheUser();
			return true;
		}
	}

	return false;
} 

// ------------------------------------------------------------------------------------
function cookieTheUser ()
{
	$today = getdate();
	$salt = $today[year] . $today[yday];
	$fingerprint = $salt . $_SERVER['HTTP_USER_AGENT'];
	setcookie("fprnt", md5($fingerprint), time() + 86400, "/", ".".cookieDomain);
}

ob_end_flush();

// 
// done
// 

?>