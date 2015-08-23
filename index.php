<!doctype HTML>
<head>
	<title>Paste</title>
	<link rel="stylesheet" type="text/css" href="./paste.css"/>
</head>
<body>
<?php
	function is_hash($hash) {	
		if(count(hash("sha256", "a")) != count($hash)) { return false; }
		foreach(["://", "/", "."] as $element) {
			if(strpos($hash, $element) != false) { return false; }
		}
		return true;
	}

	if(isset($_GET['hash'])) {
		if(is_hash($_GET['hash']) == false) { return; }

		$text = htmlspecialchars(file_get_contents($_GET['hash'].".txt"));

		echo $_GET['hash'].".txt";
		?>

		<form action="/paste/" method="GET" class="action">
			<input type="submit" value="New"/>
		</form>

		<?php
		echo "<pre>{$text}</pre>";

	} else if(isset($_POST['file'])) {
		$hash = hash("sha256", $_POST['file']);
		file_put_contents("{$hash}.txt", $_POST['file']);
		header("Location:/paste/?hash={$hash}");

	} else {
		?>

		<form action="/paste/" method="POST">
			<textarea rows="40" cols="80" name="file"></textarea>
			<input type="submit" class="top action" value="Paste"/>
		</form>

		<?php

	}

?>
</body>
</html>
