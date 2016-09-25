<!doctype html>
<html lang="en">
<?php
	// Server, user & database information
	$db_server = "localhost";
	$db_user = "db_user";
	$db_password = "db_password!";
	$db_name = "db_name";

	$debug_string = "";

	// Get number of rows in specified table
	function countRows($table_name) {
		// Create and test database connection
		global $db_server, $db_user, $db_password, $db_name;
		$conn = new mysqli($db_server, $db_user, $db_password, $db_name);
		if ($conn->connect_error) {
			die("<p>Connection failed: " . $conn->connect_error . "</p>");
		}
		// Get number of rows
		$query = "SELECT COUNT(*) FROM " . $table_name;
		$result = $conn->query($query);
		$conn->close();
		
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			return intval($row["COUNT(*)"]);
		} else {
			return NIL;
		}
	}
	
	// Get the name field from the specified row number and table
	function selectName($row_number, $table_name) {
		global $db_server, $db_user, $db_password, $db_name;
		$conn = new mysqli($db_server, $db_user, $db_password, $db_name);
		if ($conn->connect_error) {
			die("<p>Connection failed: " . $conn->connect_error . "</p>");
		}
		$query = "SELECT * FROM " . $table_name . " LIMIT " . $row_number . ",1";
		$result = $conn->query($query);
		$conn->close();
		
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			return $row["name"];
		} else {
			return NIL;
		}
		
	}

	// Get a random name from the specified table
	function selectRandomName($table_name) {
		global $debug_string;
		$count = countRows($table_name);
		$random_number = mt_rand(0, $count);
		$debug_string .= $random_number . " ";
		return strtoupper(htmlspecialchars(selectName($random_number, $table_name)));	
	}
	
	// Get an entire row at random from the colors table;
	// the row has color name and hex value, among other properties
	function selectRandomColor() {
		global $debug_string;
		$count = countRows("colors");
		$random_number = mt_rand(0, $count);
		$debug_string .= $random_number . " ";
		global $db_server, $db_user, $db_password, $db_name;
		$conn = new mysqli($db_server, $db_user, $db_password, $db_name);
		if ($conn->connect_error) {
			die("<p>Connection failed: " . $conn->connect_error . "</p>");
		}
		$query = "SELECT * FROM colors LIMIT " . $random_number . ",1";
		$result = $conn->query($query);
		$conn->close();
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			return $row;
		} else {
			return NIL;
		}
	}

	$color_object = selectRandomColor();
	$color = strtoupper(htmlspecialchars($color_object["name"]));
	$color_hex = $color_object["hexcode"];

	$color_first_letter = substr($color, 0, 1);
	switch ($color_first_letter) {
		case "A": case "E": case "I": case "O": case "U":
			$determiner = "an";
			break;
		default:
			$determiner = "a";
	}
	
	$animal = selectRandomName("animals");
	$adjective = selectRandomName("adjectives");
?>
<head>
  <meta charset="utf-8">
  <title>Spirit Animal Generator</title>
  <meta name="description" content="Spirit Animal Generator">
  <meta name="author" content="Eric C. Black">

  <link rel="stylesheet" href="./css/styles.css?v=1.0">

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>

<body>
<div class="body-overlay"></div>
<div class="page-container">
	<div class="page-child">
		<p>
		<?php
			echo "Your spirit animal is " . $determiner .
				" <a href='https://www.google.com/#q=color+" . urlencode($color) .
				"' target='_blank' style='text-shadow: 1px 1px 2px #000000; color: " . $color_hex . "'>" .
				$color . "</a> <a class='animal' href='https://www.google.com/#q=animal+" .
				urlencode($animal) . "' target='_blank'>" . $animal .
				"</a> named <a class='name' href='https://www.google.com/#q=definition+of+" .
				urlencode($adjective) . "' target='_blank'>" . $adjective . "</a>!";
		?>
		<form><button class="btn" onclick="history.go(0)">Give me another</button></form>
			
<?php
	$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$twitter_url = "http://twitter.com/share?text=My+spirit+animal+is+" . $determiner . "+" .
		urlencode($color) . "-colored+" . urlencode($animal) . "+named+" . urlencode($adjective) .
		"!&url=" . $url . "&via=vidantiger";
	$facebook_url = "http://www.facebook.com/sharer/sharer.php?u=" . $url;
?>
		<button class="btn btn-minor" onclick="location.href='<?php echo $twitter_url; ?>'">Share my results on Twitter</button>
		</p>
	</div>
 </div>
 <div class="byline">v1.0 - created by <a href="http://twitter.com/vidantiger" target="_blank">@vidantiger</a></div>
 <div class="debug"><?php echo $debug_string; ?></div>
 </body>
 </html>