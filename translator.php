<?php
	include "translator.html";
	$connection = mysqli_connect("mysql13.000webhost.com", user, password, name);
	if (mysqli_connect_errno()) {
    		printf("Connect failed: %s\n", mysqli_connect_error());
    		exit();
	}
	if($_GET["languages"] == "1") {
		$lang1 = "English";
		$lang1ab = "e";
		$lang2 = "Madurese";
		$lang2ab = "m";
	} elseif ($_GET["languages"] == "2") {
		$lang1 = "Indonesian";
		$lang1ab = "i";
		$lang2 = "Madurese";
		$lang2ab = "m";	
	} elseif ($_GET["languages"] == "3") {
		$lang1 = "Madurese";
		$lang1ab = "m";
		$lang2 = "English";
		$lang2ab = "e";
	} else {
		$lang1 = "Madurese";
		$lang1ab = "m";
		$lang2 = "Indonesian";
		$lang2ab = "i";
	}		
	
	$text = $_GET["name"];
	$test = $connection->query("SELECT word FROM $lang1 WHERE word = '$text'");
	echo "<div style='min-height: 700px'>";
	if ($test && mysqli_num_rows($test) > 0) {
		$result = $connection->prepare("SELECT $lang2ab.word FROM $lang2 $lang2ab, $lang1 $lang1ab WHERE ($lang1ab.word = '$text' and $lang1ab.wid = $lang2ab.wid)");
		$result->execute();
		$result->bind_result($word);
		echo "<div style='padding-top: 100px; text-align: center; color: #FFFFFF; font-size: 30px'><h1>$text</h1>";
		echo "<h3 style='color: #B6B6B6; padding-top: 25px'>in $lang2 is</h3>";
		while ($result->fetch()) {
        		echo "<h1 style='padding-top: 25px; text-align: center; color: #FFFFFF; font-size: 30px'>$word</h1></div>";
		}
		$result->close();
		echo "<div style='position: fixed; bottom: 0; width: 100%; padding-bottom: 30px'><p style='font-size: 17px; padding-bottom: 20px; text-align: center; color: #FFFFFF; font-size: 16px'>
        Find out wrong translation? Help us make it better by</p>
		<div id=\"cssmenu\" class='align-center' style='width: 150px; border-radius: 10px;'>
    		<ul>
        		<li><a href='contribute.html'><span>Contribute</span></a></li>
   			</ul>
		</div></div>";
	}
	else {
		echo "<div style='padding-top: 80px; text-align: center; color: #FFFFFF; font-size: 30px'>
			  <p style='font-size: 70px'>Oops!</p>
			  <p style='padding-top: 20px'>Sorry! the meaning of $text in $lang2 could not be found.</p>
			  <p style='padding-bottom: 90px'>It will be added as soon as possible!</p>
			  <p style='padding-bottom: 20px; font-size: 15px'>go</p>
			  <div id=\"cssmenu\" class='align-center' style='width: 100px; border-radius: 10px'>
    				<ul>
        				<li><a href='index.html'><span>Home</span></a></li>
   					</ul>
			  </div>
			  <p style='padding-top: 20px; padding-bottom: 20px; font-size: 15px'>or help us add new words by</p>
			  <div id=\"cssmenu\" class='align-center' style='width: 150px; border-radius: 10px'>
    				<ul>
        				<li><a href='contribute.html'><span>Contribute</span></a></li>
   					</ul>
			  </div>
			  </div>";
		$adding = $connection->prepare("INSERT INTO userfeedback (`word1`, `lang1`, `lang2`) VALUES ('$text','$lang1','$lang2')");
		$adding->execute();
	}	
	echo "</div>";
	mysqli_close($connection);
?>
