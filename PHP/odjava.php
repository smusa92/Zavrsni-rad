<?php
include '../PHP/baza.class.php';
$baza = new Baza();

$trenutno = time() ;
$vrijemOdjave = date('Y-m-d H:i:s', $trenutno);

session_start();

$id_clan=$_SESSION['id_clan'];
$upit = "INSERT INTO DNEVNIK (CLAN, VRIJEME, AKCIJA) VALUES  "
        . "('".$id_clan[0]."',TO_TIMESTAMP('".$vrijemOdjave."', 'YYYY-MM-DD HH24:MI:SS')"
        . ",'Uspjesna odjava')";

$baza ->updateDB($upit);

session_destroy();
header("Location: ../PHP/prijavi_se.php");

?>