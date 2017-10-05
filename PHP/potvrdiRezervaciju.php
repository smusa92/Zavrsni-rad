<?php

session_start();

include './baza.class.php';

$baza = new Baza();
$baza->spojiDB();

$trenutno = time() ;
$vrijemOdjave = date('Y-m-d H:i:s', $trenutno);

$sifra = $_GET['sifra'];
$odabit = $_GET['odabir'];     
$broj_mjesta = $_GET['broj_m'];
$clan = $_GET['clan'];
$sifra_p = $_GET['sifra_p'];



    if ($odabit == 1) {

        $upit = "UPDATE rezervacije SET potvrda = '2' WHERE rezervacije.ID_rezervacije = '".$sifra."'";
        $baza->updateDB($upit); 

        
        $upit="UPDATE projekcije SET max_broj_posjetitelja=max_broj_posjetitelja-'".$broj_mjesta."' WHERE ID_projekcije='".$sifra_p."'";
        $baza->updateDB($upit);
        
        $upit = "insert into dnevnik (akcija, vrijeme, clan) values ('Potvrda rezervacija Moderator: ".$_SESSION["korisnickoImeSesija"]."',TO_TIMESTAMP('".$vrijemOdjave."', 'YYYY-MM-DD HH24:MI:SS'),'".$_SESSION['id_clan']."')";
        $baza ->updateDB($upit);
       
    
        
        echo 'Potvrđena rezervacija';
        header("Refresh:3; ../PHP/rezervacijeModerator.php");
        
    }elseif ($odabit == 0) {

        $upit="DELETE FROM rezervacije WHERE rezervacije.ID_rezervacije ='".$sifra."'";
        $baza->updateDB($upit);
        
        $upit = "insert into dnevnik (akcija, vrijeme, clan) values ('Odbijena rezervacija Moderator: ".$_SESSION["korisnickoImeSesija"]."',TO_TIMESTAMP('".$vrijemOdjave."', 'YYYY-MM-DD HH24:MI:SS'),'".$_SESSION['id_clan']."')";
        $baza ->updateDB($upit);
       
        echo 'Odbijena rezervacija';
        header("Refresh:3; ../PHP/rezervacijeModerator.php");   
        
    }


?>