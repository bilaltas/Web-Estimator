<?php

class WebEstimator {

	// The Data Connection
	private $db;

	// The Steps List
	public $steps = array();


	// == INIT ==================================================
	function __construct() {

		session_start();

		// DB Connect
		$this->db = $this->dbConnect();

		// List Steps
		$this->steps = $this->listSteps();

		// Login
		if ( isset($_GET["login"]) && isset($_POST["login-name"]) && isset($_POST["login-pass"]) )
			$this->logIn($_POST["login-name"], $_POST["login-pass"]);

		// Logout
		if ( isset($_GET["logout"]) ) $this->logOut();

		// AJAX Handler
		if ( isset($_POST["ajax_action"]) )
			$this->ajaxHandler($_POST);

		// PRINT THE TEMPLATE
		ob_start();
		include('view/main.php');
		ob_end_flush();

		// DB Disconnect
		$this->db = $this->dbDisconnect();
	}


	// == DATA CONNECTION ==================================================
	function dbConnect() {

		require "config.php";

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
	function dbQuery($query, $prepare = false) {

		if ($prepare)
			return $this->db->prepare($query);

		return $this->db->query($query);

	}


	// == HOME PAGE URL ==================================================
	function homePageURL() {
		return "http://".$_SERVER["SERVER_NAME"].str_replace("/index.php", "", $_SERVER["PHP_SELF"]);
	}


	// == AJAX HANDLER ==================================================
	function ajaxHandler($data) {

		$response['success'] = false;

		if ($data['ajax_action'] == 'update-time' && $this->userInfo('user_level') == 0) { // Admin Update Input Time

			$stmt = $this->dbQuery("UPDATE inputs SET input_time='".$data['input_time']."' WHERE input_ID='".$data['input_ID']."'", true);
			$stmt->execute();

			$response['success'] = $stmt->rowCount() == 1 ? true : false;
			$response['input_time'] = $data['input_time'];
			$response['input_ID'] = $data['input_ID'];

		} elseif ($data['ajax_action'] == 'duplicate-input' && $this->userInfo('user_level') == 0) { // Admin Duplicate an Input

			// Prepare the duplicate data
			$result = $this->dbQuery("SELECT * FROM inputs WHERE input_ID = ".$data['input_ID']." LIMIT 1");
			$row = $result->fetch(PDO::FETCH_ASSOC);

			$SQL = "INSERT INTO inputs (";

			// Add the keys
			$first = true;
			foreach($row as $key => $val) {

				if($key != "" && !is_numeric($key) && $key != 'input_ID' && $val != null) {

					if (!$first) $SQL .= ', ';
					$SQL .= $key;

					$first = false;
				}

			}

			$SQL .= ') VALUES (';

			// Add the Values
			$first = true;
			foreach($row as $key => $val) {

				if($key != "" && !is_numeric($key) && $key != 'input_ID' && $val != null) {

					if (!$first) $SQL .= ', ';
					if ($key == "input_slug") $val = $val."_new";
					$SQL .= "'". addslashes($val)."'";

					$first = false;
				}

			}

			$SQL .= ')';



			$stmt = $this->dbQuery($SQL, true);
			$stmt->execute();

			$response['success'] = $stmt->rowCount() == 1 ? true : false;
			$response['input_ID'] = $data['input_ID'];

			//$response['success'] = $SQL;

		} elseif ($data['ajax_action'] == 'delete-input' && $this->userInfo('user_level') == 0) { // Admin Duplicate an Input

			$stmt = $this->dbQuery("DELETE FROM inputs WHERE input_ID='".$data['input_ID']."'", true);
			$stmt->execute();

			$response['success'] = $stmt->rowCount() == 1 ? true : false;
			$response['input_ID'] = $data['input_ID'];

		} else {

			$response['success'] = false;

		}

		echo json_encode($response);
		die();
	}


	// == CURRENT PAGE URL ==================================================
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
	function logIn($userName, $password) {

		$userName = stripslashes($userName);
		$password = stripslashes($password);

		$stmt = $this->dbQuery("SELECT * FROM users WHERE user_name='".$userName."' OR user_email='".$userName."' LIMIT 1");
		$row = $stmt->fetch(PDO::FETCH_ASSOC);


		if($stmt->rowCount() > 0 && password_verify($password, $row['user_password'])) {

			$_SESSION['user_ID'] = $row['user_ID'];

			header("location: ".$this->removeQueryArg('error', $_SERVER['HTTP_REFERER']) );
			die();

		} else {

			header("location: ".$this->queryArg('error', 'wrong', $_SERVER['HTTP_REFERER']) );
			die();

		}

	}


	// == LOG OUT ==================================================
	function logOut() {

		if( session_destroy() ) {
			header("Location: ".$_SERVER['HTTP_REFERER']); // Redirecting to previous page
			die();
		}

	}


	// == USER LOGGED IN? ==================================================
	function isLoggedIn() {
		return ( isset($_SESSION['user_ID']) ) ? true : false;
	}


	// == CURRENT USER INFO ==================================================
	function userInfo($info, $userID = "") {

		if ( !$this->isLoggedIn() ) return false;
		if ( $userID == "" ) $userID = $_SESSION['user_ID'];

		$stmt = $this->dbQuery("SELECT * FROM users WHERE user_ID='".$userID."' LIMIT 1");
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		return $row[$info];

	}


	// == SHOW PAGE CONTENT ==================================================
	function showContent() {

		if ( $this->isLoggedIn() ) {

			// STEP BAR
			include("view/progress_bar.php");

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
		$steps_query = $this->dbQuery('SELECT step_slug, step_name FROM steps WHERE main_choice_ID = '.$this->mainChoiceCategoryID().' OR main_choice_ID = '.$this->mainChoiceID().' ORDER BY step_order');
		while ($step = $steps_query->fetch()) {

			$steps[$stepNo] = array(
								'step_name' => $step['step_name'],
								'step_slug' => $step['step_slug']
							);
			$stepNo++;
		}

		return $steps;

	}


	// == CURRENT STEP SLUG ==================================================
	function stepSlug($isStepSlug = "") {

		if ($_SERVER["QUERY_STRING"] == "") { // If it's Home Page


			if ($isStepSlug != "" ) {
				return ($isStepSlug == "concept" ? true : false);
			} else {
				return "concept";
			}


		} elseif ( isset($_GET['go']) ) { // ...&go=xxx


			if ($isStepSlug != "" ) {
				return ($isStepSlug == $_GET['go'] ? true : false);
			} else {
				return $_GET['go'];
			}


		} else { // ...&xxx=current...


			$new_gets = array_flip($_GET);

			if ($isStepSlug != "" ) {
				return (isset($new_gets['current']) && $isStepSlug == $new_gets['current'] ? true : false);
			} else {
				return (isset($new_gets['current']) ? $new_gets['current'] : 'other');
			}


		}

	}


	// == CURRENT STEP ID ==================================================
	function stepID( $stepSlug = "" ) {

		$stmt = $this->dbQuery("SELECT step_ID FROM steps WHERE step_slug = '".($stepSlug != '' ? $stepSlug : $this->stepSlug())."' LIMIT 1");
		$row = $stmt->fetch();

		return $row['step_ID'];

	}


	// == STEP TITLE ==================================================
	function stepTitle($stepSlug = "") {

		$stmt = $this->dbQuery("SELECT step_name FROM steps WHERE step_slug = '".($stepSlug != '' ? $stepSlug : $this->stepSlug())."' LIMIT 1");
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

		if ($stepSlug == "") $stepSlug = $this->stepSlug();

		return $this->steps[ $this->stepNo($stepSlug) + 1 ]['step_slug'];


	}


	// == MAIN CHOICE TITLE ==================================================
	function mainChoiceTitle($main_choice = "") {

		$stmt = $this->dbQuery("SELECT main_choice_name FROM main_choices WHERE main_choice_slug = '".($main_choice != '' ? $main_choice : $this->mainChoice())."' LIMIT 1");
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
		elseif ( isset($_GET[$step]) && $_GET[$step] == "" )
		{
			return "skipped";
		}
		elseif ( isset($_GET[$step]) && $_GET[$step] != "" )
		{
			return "done";
		}

	}


	// == FIELD SLUG ==================================================
	function fieldSlug($stepSlug, $fieldIndex = 0) {

		$stmt = $this->dbQuery("SELECT field_slug FROM fields WHERE step_ID = '".$this->stepID($stepSlug)."' LIMIT 1 OFFSET $fieldIndex");
		$row = $stmt->fetch();

		if ( $row['field_slug'] == "" )
			return "NOT FOUND";
		else
			return $row['field_slug'];

	}


	// == FIELD SHORT NAME ==================================================
	function fieldShortName($fieldSlug) {

		$stmt = $this->dbQuery("SELECT field_short_name FROM fields WHERE field_slug = '".$fieldSlug."' LIMIT 1");
		$row = $stmt->fetch();

		return $row['field_short_name'];

	}


	// == INPUT VALUES  ==================================================
	function inputValues($findSlug = null, $stepSlug = "") {

		// DATA SAMPLE
		// &domain=yes&server=other&static_pages=home--about--privacy--terms--contact--more_static-4


		// If not stepSlug specified, use the current step slug
		$stepSlug = $stepSlug != '' ? $stepSlug : $this->stepSlug();


		// Parse the fields in the step
		$fields = explode('--', $_GET[$stepSlug]);


		// Parse the field data
		$values = array();
		foreach ($fields as $field) {

			if ($field != "current" && $field != "na") {

				if ( strpos($field, "-") ) { // xxxx-y

					$parsedField = explode('-', $field);
					$inputSlug = $parsedField[0];
					$inputValue = $parsedField[1];

					$values[$inputSlug] = $inputValue;

				} else { // xxx--yyy--zzz

					$values[$stepSlug][] = $field;

				}

			}

		}


		// Check
		if ( $findSlug !== null ) {

			if ( isset($values[$findSlug]) ) $return = $values[$findSlug];
			else $return = false;

		} else {

			$return = $values;

		}


		// If result is an array and has only one item
		if ( is_array($return) && count($return) == 1 )
			return current($return);
		else
			return $return;

	}


	// == INPUT TIME ==================================================
	function inputTime($inputSlugOrID, $inputValue = "", $singular = false) {

		if ( is_numeric($inputSlugOrID) )
			$sqlBeginning = "SELECT input_time FROM inputs WHERE input_ID = ".$inputSlugOrID;
		else
			$sqlBeginning = "SELECT input_time FROM inputs WHERE input_slug = '".$inputSlugOrID."'";

		$stmt = $this->dbQuery("$sqlBeginning LIMIT 1");
		$row = $stmt->fetch();

		if ( !is_numeric($inputValue) && !is_numeric($inputSlugOrID) ) {
			$stmt = $this->dbQuery("$sqlBeginning AND input_value = '".$inputValue."' LIMIT 1");
			$row = $stmt->fetch();

			$time =  $row['input_time'];

		} else {

			if ( $singular ) $inputValue = 1;
			$time =  intval($row['input_time']) * $inputValue;

		}

		return $time;

	}


	// == INPUT NAME ==================================================
	function inputName($inputSlug, $inputValue = "") {

		if (is_numeric($inputValue)) return $inputValue;

		$stmt = $this->dbQuery("SELECT input_name FROM inputs WHERE input_slug = '".$inputSlug."' LIMIT 1");

		if ($inputValue != "" && !is_numeric($inputValue))
			$stmt = $this->dbQuery("SELECT input_name FROM inputs WHERE input_slug = '".$inputSlug."' AND input_value = '".$inputValue."' LIMIT 1");

		$row = $stmt->fetch();

		return $row['input_name'];

	}


	// == INPUT SHORT NAME ==================================================
	function inputShortName($inputSlug, $inputValue = "") {

		if (is_numeric($inputValue)) return $inputValue;

		$stmt = $this->dbQuery("SELECT input_name, input_short_name, input_value FROM inputs WHERE input_slug = '".$inputSlug."' LIMIT 1");

		if ($inputValue != "" && !is_numeric($inputValue))
			$stmt = $this->dbQuery("SELECT input_name, input_short_name, input_value FROM inputs WHERE input_slug = '".$inputSlug."' AND input_value = '".$inputValue."' LIMIT 1");

		$row = $stmt->fetch();

		if ( $inputValue == "" && !is_numeric($row['input_value']) ) return false;

		if ($row['input_short_name'] != "")
			return $row['input_short_name'];
		else
			return $row['input_name'];

	}


	// == INPUT ADMIN ==================================================
	function inputAdmin($inputID) {

		$output = "";


		if ( $this->isLoggedIn() && $this->userInfo('user_level') == 0 ) {

			$inputTime = $this->inputTime($inputID, "", true);

			$output .= '
				<span class="input-admin">

					<span class="field update-time">
						<span data-toggle="tooltip" title="Change and Press enter to update">
							<input type="number" value="'.$inputTime.'"> minutes
						</span>
						<a href="#" data-toggle="tooltip" title="Update the time">
							<span class="fui-time"></span>
						</a>
					</span>

					<span class="field duplicate-input">
						<a href="#" data-toggle="tooltip" data-title="Duplicate">
							<span class="fui-windows"></span>
						</a>
					</span>

					<span class="field edit-input">
						<a href="#" data-toggle="tooltip" data-title="Edit">
							<span class="fui-new"></span>
						</a>
					</span>

					<span class="field delete-input">
						<a href="#" data-toggle="tooltip" data-title="Delete">
							<span class="fui-trash"></span>
						</a>
					</span>

				</span>
			';

		}

		return $output;

	}


	// == IS FIRST STEP? ==================================================
	function isLastStep($step) {

		$steps = $this->steps;
		$totalSteps = count($this->steps);
		$lastStepNumber = $totalSteps - 1;

		if ( isset($steps[$lastStepNumber]['step_slug']) && $steps[$lastStepNumber]['step_slug'] == $step )
			return true;
		else
			return false;

	}


	// == IS LAST STEP? ==================================================
	function isFirstStep($step) {
		return ($step == "concept") ? true : false;
	}


	// == PROGRESS BAR LINKS ==================================================
	function stepLink($step) {

		$url = $this->currentPageURL();

		if ( $this->stepSlug($step) ) { // Avoid if the destination step is our current step

			$url = "#";

		} elseif ( $this->stepStatus($step) == "notyet" ) { // Avoid if the destination step is not seen yet

			$url = "#";

		} else {

			// If the current step has no data yet, make this step skipped
			if ( isset($_GET[$this->stepSlug()]) && $_GET[$this->stepSlug()] == "current" )
				$url = $this->queryArg( $this->stepSlug(), "", $url );

			// If destination step is skipped, put "=current" to destination
			if( $this->stepStatus($step) == "skipped" ) {

				$url = $this->removeQueryArg( "go", $url );
				$url = $this->queryArg( $step, "current", $url );

			// If destination step is input, put "&go=destination"
			} elseif ( $this->stepStatus($step) == "done" ) {

				$url = $this->queryArg( "go", $step, $url );

			}

		}

		return $url;

	}


	// == ADD/UPDATE QUERY ARGUMENT ==================================================
	function queryArg($key, $value, $url) {

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

			return $parsed['scheme']."://".$parsed['host'].$parsed['path'].(empty($newQuery) ? "" : "?").$newQuery;

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
		$url = $this->queryArg( $this->stepSlug(), $data, $url );


		// If destination is not empty
		if ( isset($_GET[$next_step]) && $_GET[$next_step] != "" ) {

			$url = $this->queryArg( "go", $next_step, $url );

		} else {

			$url = $this->removeQueryArg( "go", $url );
			$url = $this->queryArg( $next_step, "current", $url );

		}

		return $url;

	}


	// == BEAUTIFY MINUTES ==================================================
	function beautifyMinutes($minutes) {
	    if ($minutes < 0 || !is_numeric($minutes)) return;

	    $hours = floor($minutes / 60);
	    $hoursText = $hours." hour".($hours > 1 ? "s" : "");

	    $minutes = ($minutes % 60);
	    $minutesText = $minutes." minute".($minutes > 1 ? "s" : "");

	    $separator = " ";
	    if (
	    	($hours == 0 && $minutes != 0) ||
			($hours != 0 && $minutes == 0) ||
			($hours == 0 && $minutes == 0)
		) $separator = "";

	    $time = ($hours != 0 ? $hoursText : '').$separator.($minutes != 0 ? $minutesText : '');

	    if ($time == "") $time = "Nothing";

	    return $time;
	}


	// == BRING THE OLD DATA ==================================================
	function bringData() {

		foreach ($_GET as $data => $value) {
	    	echo "<input type='text' name='$data' value='$value' hidden='true'>\n";
		}

	}

}

?>