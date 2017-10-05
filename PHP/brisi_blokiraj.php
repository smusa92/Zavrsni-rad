<?php

session_start();

include './baza.class.php';

$baza = new Baza();
$baza->spojiDB();


$vrijemOdjave = date('Y-m-d H:i:s', time());

$sifra = $_GET['sifra'];
$odabit = $_GET['odabir']; 
    if ($odabit == 1) {

        $upit = "UPDATE clan SET status = '3' WHERE clan.ID_clan = '".$sifra."'";
        $baza->updateDB($upit); 
       
        $upit = "insert into dnevnik (akcija, vrijeme, clan) values ('Blokiran korisnik od ADMINA: ".$_SESSION["korisnickoImeSesija"]."',TO_TIMESTAMP('".$vrijemOdjave."', 'YYYY-MM-DD HH24:MI:SS'),'".$_SESSION['id_clan']."')";
        $baza ->updateDB($upit);
       
    
        
        
        if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
        
    }elseif ($odabit == 0) {

        $upit="DELETE FROM clan WHERE ID_clan ='".$sifra."'";
        $baza->updateDB($upit);
        
        $upit = "insert into dnevnik (akcija, vrijeme, clan) values ('Izbrisan korisnik od ADMINA: ".$_SESSION["korisnickoImeSesija"]."',TO_TIMESTAMP('".$vrijemOdjave."', 'YYYY-MM-DD HH24:MI:SS'),'".$_SESSION['id_clan']."')";
        $baza ->updateDB($upit);
       
        
        if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        }  
        
    }


?>