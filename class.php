<?php

include('data.php');

class WebEstimator {

	// Temporary Data
	var $mainChoices;
	var $steps;

	// == INIT ==================================================
	function __construct() {
		global $mainChoices, $steps;

		$this->mainChoices = $mainChoices;
		$this->steps = $steps;

		session_start();
		// Login
		if ( isset($_GET["login"]) && isset($_POST["login-name"]) && isset($_POST["login-pass"]) ) $this->logIn();

		// Logout
		if ( isset($_GET["logout"]) ) $this->logOut();

		// PRINT THE TEMPLATE
		ob_start();
		include('view/main.php');
		ob_end_flush();
	}


	// == SET HOME PAGE URL ==================================================
	function homePageURL() {
		return "http://".$_SERVER["SERVER_NAME"].str_replace("/index.php", "", $_SERVER["PHP_SELF"]);
	}


	// == SET CURRENT PAGE URL ==================================================
	function currentPageURL($add = "") {

		$pageURL = 'http';

		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") $pageURL .= "s";

		$pageURL .= "://";

		if ($_SERVER["SERVER_PORT"] != "80") $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		else $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

		if ($add != "") {
			if ( strpos($pageURL,'?') == false ) { $pageURL .= "?".$add; } else { $pageURL .= "&".$add; }
		}

		return $pageURL;
	}


	// == LOG IN ==================================================
	function logIn() {

		$username = stripslashes($_POST["login-name"]);
		$password = stripslashes($_POST["login-pass"]);

		if ( ($username=="admin" && $password=="121212") || ($username=="cuneyttas" && $password=="121212") ) {
			$_SESSION['login_user'] = $username;
			header("location: ".$_SERVER['HTTP_REFERER']);
			die();
		}else {
			echo "ERROR";
		}

	}


	// == LOG OUT ==================================================
	function logOut() {

		if( session_destroy() ) {
			header("Location: ".$_SERVER['HTTP_REFERER']); // Redirecting To Home Page
			die();
		}

	}


	// == USER LOGGED IN? ==================================================
	function isLoggedIn() {
		return ( isset($_SESSION['login_user']) ) ? true : false;
	}


	// == SHOW CONTENT ==================================================
	function showContent() {

		if ( $this->isLoggedIn() ) {

			// STEP BAR
			include("view/show_steps.php");

			// SHOW PAGES
			if ( file_exists("steps/".$this->currentStep().".php") ) include("steps/".$this->currentStep().".php");

		}else {

			echo "<center><h1>WE ARE COMING SOON!</h1></center>";

		}

	}


	// == CURRENT STEP ==================================================
	function currentStep($step="") {

		if ($_SERVER["QUERY_STRING"]=="") { // If it's Home Page

			if ($step!="" && $step=="website") {
				return true;
			}elseif ($step!="" && $step!="website") {
				return false;
			} else {
				return "website";
			}

		} elseif ( isset($_GET['go']) ) { // ...&go=xxx

			if ($step!="" && $step==$_GET['go']) {
				return true;
			}elseif ($step!="" && $step!=$_GET['go']) {
				return false;
			} else {
				return $_GET['go'];
			}

		} else { // ...&xxx=current...

			$new_gets = array_flip($_GET);
			//print_r( $new_gets );
//			if (isset($new_gets['current']) ) {

				if ($step!="" && $step==$new_gets['current']) {
					return true;
				}elseif ($step!="" && $step!=$new_gets['current']) {
					return false;
				} else {
					return $new_gets['current'];
				}

/*
			} else {
				return false;
			}
*/

		}

	}


	// == GET SELECTED SITE TYPE ==================================================
	function selectedOption() {

		if ( isset($_GET[$this->selectedMainChoice()]) )
			return $_GET[$this->selectedMainChoice()];
		else
			return "";

	}


	// == GET SELECTED MAIN CHOICE ==================================================
	function selectedMainChoice() {

		if ( isset($_GET['website']) )
			return "website";
		else if ( isset($_GET['feature']) )
			return "feature";
		else
			return "website";

	}


	// == STEP TITLE ==================================================
	function stepTitle( $step="" ) {

		if ( isset($this->steps[$this->selectedMainChoice()][$this->selectedOption()]) ) {

			if ($step!="") {
				return $this->steps[$this->selectedMainChoice()][$this->selectedOption()][ $step ];
			} else {
				if ( isset($this->steps[$this->selectedMainChoice()][$this->selectedOption()][ $this->currentStep() ]) ) {
					return $this->steps[$this->selectedMainChoice()][$this->selectedOption()][ $this->currentStep() ];
				} else {
					return "";
				}
			}

		} else {
			return "";
		}

	}


	// == STEP NUMBER ==================================================
	function stepNumber( $step="" ) {

		if ($step == "")
			$step = $this->currentStep();

		$count = 1;
		foreach( $this->steps[$this->selectedMainChoice()][$this->selectedOption()] as $stepp => $titlee) {
			if ($stepp==$step) {
				return $count;
				break;
			}
			$count++;
		}

	}


	// == STEP STATUS ==================================================
	function stepStatus($step) {

		if (
			( isset($_GET[$step]) && $_GET[$step]=="current" ) ||
			( $this->isFirstStep($step) && !isset($_GET[$step]) ) ||
			( isset($_GET["go"]) && $_GET["go"]==$step) )
		{
			return "current";
		}
		elseif ( !isset($_GET[$step]) && !$this->isFirstStep($step) )
		{
			return "notyet";
		}
		elseif ( isset($_GET[$step]) && $_GET[$step]=="" )
		{
			return "skipped";
		}
		elseif ( isset($_GET[$step]) && $_GET[$step]!="" )
		{
			return "done";
		}

	}


	// == IS FIRST STEP? ==================================================
	function isFirstStep($step) {
		return ($step == "website") ? true : false;
	}


	// == ADD/UPDATE QUERY ARGUMENT ==================================================
	function addQueryArg($key, $value, $url) {

		$parsed = parse_url($url);

		if ( isset($parsed['query']) ) {

			$query = $parsed['query'];

			// Parse the query
			parse_str($query, $params);

			// Add
			$params[$key] = $value;

			// Build new query
			$newQuery = http_build_query($params);

			return $parsed['scheme']."://".$parsed['host'].$parsed['path']."?".$newQuery;

		} else {

			return $url."?".$key."=".$value;

		}



	}


	// == REMOVE QUERY ARGUMENT ==================================================
	function removeQueryArg($key, $url) {

		$parsed = parse_url($url);

		if ( isset($parsed['query']) ) {

			$query = $parsed['query'];

			// Parse the query
			parse_str($query, $params);

			// Delete
			unset($params[$key]);

			// Build new query
			$newQuery = http_build_query($params);

			return $parsed['scheme']."://".$parsed['host'].$parsed['path']."?".$newQuery;

		} else {

			return $url;

		}

	}


	// == PROGRESS BAR LINKS ==================================================
	function stepLink($step) {

		$url = $this->currentPageURL();

		if ( $this->currentStep() == $step ) { // Avoid if the destination is our current step

			$url = "#";

		} elseif ( $this->stepStatus($step) == "notyet" ) { // Avoid if the destination is not seen yet

			$url = "#";

		} else {

			if( isset($_GET[$step]) && $_GET[$step] == "" ) { // ...&destination...    ->    Put "=current" to destination

				$url = $this->removeQueryArg( "go", $url );
				$url = $this->addQueryArg( $step, "current", $url );

			} elseif ( isset($_GET[$step]) && $_GET[$step] != "" ) { // ...&mystep=current&destination=xxx    ->    Put "&go=destination"

				$url = $this->removeQueryArg( $this->currentStep(), $url );

				if ( isset($_GET[$this->currentStep()]) && $_GET[$this->currentStep()] != "current" )
					$url = $this->addQueryArg( $this->currentStep(), $_GET[$this->currentStep()], $url );
				else
					$url = $this->addQueryArg( $this->currentStep(), "", $url );

				$url = $this->addQueryArg( "go", $step, $url );

			}

		}

		return $url;

	}


	// == SUBMIT LINK ==================================================
	function submit_link($data, $next_step, $delete = "") {

		$url = $this->currentPageURL();

		// Clear unnecessary variables if requested
		if ( $delete != "" ) {
			foreach ($delete as $del) {
				$url = $this->removeQueryArg( $del, $url );
			}
		}


		// Always add the data to current step
		$url = $this->addQueryArg( $this->currentStep(), $data, $url );


		// If destination is not empty
		if ( isset($_GET[$next_step]) && $_GET[$next_step] != "" ) {

			$url = $this->addQueryArg( "go", $next_step, $url );

		} else {

			$url = $this->removeQueryArg( "go", $url );
			$url = $this->addQueryArg( $next_step, "current", $url );

		}

		return $url;

	}


	// == PREFIXER ==================================================
	function prefixer($prefix="") {

		if ($prefix!="") return (isset($_GET[$this->currentStep()]) && $_GET[$this->currentStep()]!="current" ? 'tmp_' : $prefix);
		else return  (isset($_GET[$this->currentStep()]) && $_GET[$this->currentStep()]!="current" ? 'tmp_' : prfx());

	}


	// == DISABLER ==================================================
	function disabler($id) {

		if ( function_exists( 'prfx' ) ) return (isset($_GET[prfx().$id]) && $_GET[prfx().$id]!="" ? '' : 'disabled');
		else return (isset($_GET[$id]) && $_GET[$id]!="" ? '' : 'disabled');

	}


	// == HIDER ==================================================
	function hider($id) {

		if ( function_exists( 'prfx' ) ) return (isset($_GET[prfx().$id]) && $_GET[prfx().$id]!="" ? 'block' : 'none');
		else return (isset($_GET[$id]) && $_GET[$id]!="" ? 'block' : 'none');

	}


	// == VALUER ==================================================
	function valuer($id, $default) {

		if ( function_exists( 'prfx' ) ) return (isset($_GET[prfx().$id]) && $_GET[prfx().$id]!="" && $_GET[prfx().$id]!="current" ? $_GET[prfx().$id] : $default);
		else return (isset($_GET[$id]) && $_GET[$id]!="" && $_GET[$id]!="current" ? $_GET[$id] : $default);

	}


	// == CHECKER ==================================================
	function checker($id) {

		if ( function_exists( 'prfx' ) ) return (isset($_GET[prfx().$id]) && $_GET[prfx().$id]!="" ? 'checked="" ' : '');
		else return (isset($_GET[$id]) && $_GET[$id]!="" ? 'checked="" ' : '');

	}


	// == RADIO CHECKER ==================================================
	function radiochecker($id, $answer) {

		if ( function_exists( 'prfx' ) ) return (isset($_GET[prfx().$id]) && $_GET[prfx().$id]==$answer ? 'checked="" ' : '');
		else return (isset($_GET[$id]) && $_GET[$id]==$answer ? 'checked="" ' : '');

	}


	// == NAMER ==================================================
	function namer($id) {

		return $this->prefixer().$id;

	}


	// == BRING THE OLD DATA ==================================================
	function bringdata() {

		foreach ($_GET as $data => $value) {
	    	echo "<input type='text' name='$data' value='$value' hidden='true'>\n";
		}

	}

}

?>