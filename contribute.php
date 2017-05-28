<?php
include "translator.html";
$connection = mysqli_connect("mysql13.000webhost.com", user, password, name);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$word1 = $_POST["word1"];
$word2 = $_POST["word2"];
if($_POST["languages"] == "1") {
    $lang1 = "English";
    $lang2 = "Madurese";
} elseif ($_POST["languages"] == "2") {
    $lang1 = "Indonesian";
    $lang2 = "Madurese";
} elseif ($_POST["languages"] == "3") {
    $lang1 = "Madurese";
    $lang2 = "English";
} else {
    $lang1 = "Madurese";
    $lang2 = "indonesian";
}
$feedback = $_POST["feedback"];
$adding = $connection->prepare("INSERT INTO userfeedback (`word1`, `word2`, `lang1`, `lang2`, `feedback`) VALUES ('$word1', '$word2','$lang1','$lang2','$feedback')");
$adding->execute();
mysqli_close($connection);

echo "<div style='padding-top: 80px; text-align: center; color: #FFFFFF; min-height: 700px; font-size: 30px'>
			  <p style='font-size: 70px'>Thank you!</p>
			  <p style='padding-top: 20px'>Your contribution and feedback very meaningful for us and all people.</p>
	  </div>";
?>
