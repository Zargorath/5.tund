<?php 
	// et saada ligi sessioonile
	require("functions.php");
	
	//ei ole sisseloginud, suunan login lehele
	if(!isset ($_SESSION["userId"])) {
		header("Location: login.php");
	}
	
	
	//kas kasutaja tahab välja logida
	// kas aadressireal on logout olemas
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		
	}
	function saveNote($note, $color) {
		
		$mysqli = new mysqli(
		
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"],  
		$GLOBALS["serverPassword"],  
		$GLOBALS["database"]
		
		);
		$stmt = $mysqli->prepare("INSERT INTO colorNotes (note, color) VALUES (?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $note, $color );
		if ( $stmt->execute() ) {
			echo "salvestamine õnnestus";	
		} else {	
			echo "ERROR ".$stmt->error;
		}
		
	}
	
	if (	isset($_POST["note"]) && 
			isset($_POST["color"]) && 
			!empty($_POST["note"]) && 
			!empty($_POST["color"]) 
	) {
		saveNote($_POST["note"], $_POST["color"]);
		
	}
	
	$notes = getAllNotes();

	echo "<pre>";
	var_dump($notes[1]->noteColor);
	echo "</pre>";
?>

<h1>Data</h1>
<p>
	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Logi välja</a>
</p>



<h2>Märkmed</h2>
<form method="POST">
			
			<label>Märkus</label><br>
			<input name="note" type="text">
			
			<br><br>
			
			<label>Värv</label><br>
			<input name="color" type="color">
						
			<br><br>
			
			<input type="submit">
		
		</form>
		
<h2>Arhiiv</h2>
<?php

	//iga liikme kohta massiivis
	foreach ($notes as $n) {
		
		$style = "float:left; width:150px; min-height:200px; border: 1px solid gray; background-color:".$n->noteColor.";";
		echo"<p style='".$style."'>".$n->note."</p>";
		
	}





?>