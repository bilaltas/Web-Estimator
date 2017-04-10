<?php

class WebEstimator {

	// The Data Connection
	private $db;

	// The Steps List
	public $steps = array();


	// == INIT ==================================================
	function __construct() {
		global $mainChoices, $steps;

		session_start();

		// DB Connect
		$this->db = $this->dbConnect();

		// List Steps
		$this->steps = $this->listSteps();

		// Login
		if ( isset($_GET["login"]) && isset($_POST["login-name"]) && isset($_POST["login-pass"]) ) $this->logIn();

		// Logout
		if ( isset($_GET["logout"]) ) $this->logOut();

		// PRINT THE TEMPLATE
		ob_start();
		include('view/main.php');
		ob_end_flush();

		// DB Disconnect
		$this->db = $this->dbDisconnect();
	}


	// == DATA CONNECTION ==================================================
	function dbConnect() {

		$servername = "localhost";
		$username = "root";
		$password = "root";
		$database = "aweb_estimator";

		$conn_error = "";
		try {
		    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
		    // set the PDO error mode to exception
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    //echo "Connected successfully";
		}
		catch(PDOException $e) {
			$conn_error = "Connection failed: " . $e->getMessage();
			return $conn_error;
		}

		return $conn;

	}


	// == DB DISCONNECTION ==================================================
	function dbDisconnect() {

		$this->db = null;

	}


	// == DB QUERY ==================================================
	function dbQuery($query) {

		return $this->db->query($query);

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

			// SHOW Questions
			include("view/step_content.php");

		}else {

			echo "<center><h1>WE ARE COMING SOON!</h1></center>";

		}

	}


	// == LIST STEPS ==================================================
	function listSteps() {

		$steps = array();
		$stepNo = 1;
		$steps_query = $this->dbQuery('SELECT * FROM steps WHERE main_choice_ID = '.$this->mainChoiceCategoryID().' OR main_choice_ID = '.$this->mainChoiceID().' ORDER BY step_order');
		while ($step = $steps_query->fetch()) {

			$steps[$stepNo] = array(
								'step_name' => $step['step_name'],
								'step_slug' => $step['step_slug']
							);
			$stepNo++;
		}

		return $steps;

	}


	// == CURRENT STEP ==================================================
	function stepSlug($stepSlug = "") {

		if ($_SERVER["QUERY_STRING"] == "") { // If it's Home Page

			if ($stepSlug!="" && $stepSlug=="concept") {
				return true;
			}elseif ($stepSlug!="" && $stepSlug!="concept") {
				return false;
			} else {
				return "concept";
			}

		} elseif ( isset($_GET['go']) ) { // ...&go=xxx

			if ($stepSlug!="" && $stepSlug==$_GET['go']) {
				return true;
			}elseif ($stepSlug!="" && $stepSlug!=$_GET['go']) {
				return false;
			} else {
				return $_GET['go'];
			}

		} else { // ...&xxx=current...

			$new_gets = array_flip($_GET);

			if ($stepSlug!="" && $stepSlug==$new_gets['current']) {
				return true;
			}elseif ($stepSlug!="" && $stepSlug!=$new_gets['current']) {
				return false;
			} else {
				return $new_gets['current'];
			}

		}

	}


	// == CURRENT STEP ID ==================================================
	function stepID( $stepSlug = "" ) {

		$stmt = $this->dbQuery("SELECT * FROM steps WHERE step_slug = '".($stepSlug != '' ? $stepSlug : $this->stepSlug())."' LIMIT 1");
		$row = $stmt->fetch();

		return $row['step_ID'];

	}


	// == STEP TITLE ==================================================
	function stepTitle($stepSlug = "") {

		$stmt = $this->dbQuery("SELECT * FROM steps WHERE step_slug = '".($stepSlug != '' ? $stepSlug : $this->stepSlug())."' LIMIT 1");
		$row = $stmt->fetch();

		return $row['step_name'];

	}


	// == STEP NUMBER ==================================================
	function stepNo($stepSlug = "") {

		if ($stepSlug == "") $stepSlug = $this->stepSlug();

		foreach ($this->steps as $no => $step) {

			if ($step['step_slug'] == $stepSlug ) {
				return $no;
				break;
			}

		}

	}


	// == NEXT STEP ==================================================
	function nextStepSlug($stepSlug = "") {

		if ($step == "") $stepSlug = $this->stepSlug();

		return $this->steps[ $this->stepNo($stepSlug) + 1 ]['step_slug'];


	}


	// == MAIN CHOICE TITLE ==================================================
	function mainChoiceTitle( $main_choice = "" ) {

		$stmt = $this->dbQuery("SELECT * FROM main_choices WHERE main_choice_slug = '".($main_choice != '' ? $main_choice : $this->mainChoice())."' LIMIT 1");
		$row = $stmt->fetch();

		return $row['main_choice_name'];

	}


	// == GET SELECTED MAIN CHOICE ==================================================
	function mainChoice() {

		if ( isset($_GET['concept']) )
			return $_GET['concept'];
		else
			return "ecommerce";

	}


	// == GET SELECTED MAIN CHOICE ID ==================================================
	function mainChoiceID() {

		$stmt = $this->dbQuery("SELECT main_choice_ID FROM main_choices WHERE main_choice_slug = '".$this->mainChoice()."' LIMIT 1");
		$row = $stmt->fetch();

		return $row['main_choice_ID'];

	}


	// == GET SELECTED MAIN CHOICE CATEGORY ==================================================
	function mainChoiceCategory() {

		$stmt = $this->dbQuery("SELECT main_choice_name FROM main_choices WHERE main_choice_ID = '".$this->mainChoiceCategoryID()."' LIMIT 1");
		$row = $stmt->fetch();

		return $row['main_choice_name'];

	}


	// == GET SELECTED MAIN CHOICE CATEGORY ID ==================================================
	function mainChoiceCategoryID() {

		$stmt = $this->dbQuery("SELECT main_choice_parent_ID FROM main_choices WHERE main_choice_ID = '".$this->mainChoiceID()."' LIMIT 1");
		$row = $stmt->fetch();

		return $row['main_choice_parent_ID'];

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
		return ($step == "concept") ? true : false;
	}


	// == PROGRESS BAR LINKS ==================================================
	function stepLink($step) {

		$url = $this->currentPageURL();

		if ( $this->stepSlug() == $step ) { // Avoid if the destination is our current step

			$url = "#";

		} elseif ( $this->stepStatus($step) == "notyet" ) { // Avoid if the destination is not seen yet

			$url = "#";

		} else {

			if( isset($_GET[$step]) && $_GET[$step] == "" ) { // ...&destination...    ->    Put "=current" to destination

				$url = $this->removeQueryArg( "go", $url );
				$url = $this->addQueryArg( $step, "current", $url );

			} elseif ( isset($_GET[$step]) && $_GET[$step] != "" ) { // ...&mystep=current&destination=xxx    ->    Put "&go=destination"

				$url = $this->removeQueryArg( $this->stepSlug(), $url );

				if ( isset($_GET[$this->stepSlug()]) && $_GET[$this->stepSlug()] != "current" )
					$url = $this->addQueryArg( $this->stepSlug(), $_GET[$this->stepSlug()], $url );
				else
					$url = $this->addQueryArg( $this->stepSlug(), "", $url );

				$url = $this->addQueryArg( "go", $step, $url );

			}

		}

		return $url;

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


	// == SUBMIT LINK ==================================================
	function submitLink($data, $next_step, $delete = "") {

		$url = $this->currentPageURL();

		// Clear unnecessary variables if requested
		if ( $delete != "" ) {
			foreach ($delete as $del) {
				$url = $this->removeQueryArg( $del, $url );
			}
		}


		// Always add the data to current step
		$url = $this->addQueryArg( $this->stepSlug(), $data, $url );


		// If destination is not empty
		if ( isset($_GET[$next_step]) && $_GET[$next_step] != "" ) {

			$url = $this->addQueryArg( "go", $next_step, $url );

		} else {

			$url = $this->removeQueryArg( "go", $url );
			$url = $this->addQueryArg( $next_step, "current", $url );

		}

		return $url;

	}


	// == GET INPUT VALUE  ==================================================
	function inputValues($step = "") {

		$values = explode(',', $_GET[($step != '' ? $step : $this->stepSlug())]);

		return $values;

	}


	// == BRING THE OLD DATA ==================================================
	function bringdata() {

		foreach ($_GET as $data => $value) {
	    	echo "<input type='text' name='$data' value='$value' hidden='true'>\n";
		}

	}

}

?>