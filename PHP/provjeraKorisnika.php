<?php
include_once './baza.class.php';

$baza = new Baza();
$baza ->spojiDB();

$username = $_POST["korisnicko"];
$upit = "select count(*) as broj from clan where username = '".$username."'";
$rezultat = oci_fetch_array($baza->selectDB($upit));
//var_dump($rezultat);
if($rezultat[0] > 0){
    echo '<span id="dostupnost"> Korisnicko ime zauzeto</span> ';
    
}else{
    echo '<span id="dostupnost"> Korisnicko ime je slobodno </span> ';
}

?>