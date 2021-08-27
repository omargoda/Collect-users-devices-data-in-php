<?php
	class DB {
		  private static function connect () {
			$pdo = new PDO('mysql:host=host-name;dbname=db-name;charset=utf8', 'username', 'password');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		  }
		  public static function query ($query, $params = array()) {
			$statement = self::connect()->prepare($query);
			$statement->execute($params);
			if (explode(' ', $query)[0] == 'SELECT') {
			$data = $statement->fetchAll();
			return $data;
			}
		  }
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<title>Response Counter</title>
	</head>
	<body style="background-color: #FFDEAD">
	<p class="counter" style="text-align: center; font-size: 120px; color: #696969;">
<?php
	echo (int)DB::query('SELECT COUNT(*) FROM screens', array())[0]['COUNT(*)'] - 2;
?>
	</p>
	<script>
		var xmlHttp = createXmlHttpRequestObject ();
		function createXmlHttpRequestObject () {
		  var xmlHttp;
		  // if running Internet Explorer 6 or older
		  if (window.ActiveXObject) {
			try {
			  xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) {
			  xmlHttp = false;
			}
		  } else {
			try {
			  xmlHttp = new XMLHttpRequest();
			}
			catch (e) {
			  xmlHttp = false;
			}
		  }
		  if (!xmlHttp)
			alert ("Error creating the XMLHttpRequest object.");
		  else
			return xmlHttp;
		}
		function process () {
		  if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) {
			xmlHttp.open("GET", "counterApp.php", true);
			xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlHttp.onreadystatechange = handleRequestStateChange;
			xmlHttp.send();
		  }
		}
		function handleRequestStateChange () {
		  if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
			  try {
				HandleServerResponse();
			  } catch(e) {
				alert("Error reading the response: " + e.toString());
			  }
			}
		  }
		}
		function HandleServerResponse () {
		  if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				var response = xmlHttp.responseText;
				document.getElementsByClassName("counter")[0].innerHTML = response;
			}
		  }
		}
		setInterval('process()', 1000);
	</script>
	</body>
</html>
