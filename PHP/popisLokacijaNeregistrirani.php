<?php

include '../PHP/uloga.php';

?>

<html class="pozadina">
    
<header class="sadrzaj"  ><h1>Lokacije projekcija</h1>
<?php
include "../PHP/baza.class.php";
$baza = new Baza;
$baza->spojiDB();

$upit = "SELECT lokacije.ID_lokacije, drzave.naziv, lokacije.grad,"
        . " lokacije.ulica, lokacije.broj from drzave right "
        . "JOIN lokacije ON drzave.ID_drzave=lokacije.drzave";
$rezultat = $baza->selectDB($upit);

$ispis= " " ;
while ($jos = oci_fetch_array($rezultat)){
    
    $ispis.="<div class='pregled'>";
    $ispis.="<img src =\"../slike/kino_king.jpg\" >";
    $ispis.="<p>Šifra : ".$jos[0]."<br>";
    $ispis.="Država : ".$jos[1]."<br>";
    $ispis.="Grad : ".$jos[2]."<br>";
    $ispis.="Ulica : ".$jos[3]." <br>";
    $ispis.="Broj : ".$jos[4]." </p>";
    $ispis.="<a  href=\"../PHP/odaberiLokaciju3.php?&sifra=".$jos[0]."&g=".$jos[2]."&u=".$jos[3]. "&b=".$jos[4]."\"> Odaberi lokaciju </a>";
    $ispis.= "<a href=\"https://maps.google.com?q=".$jos[4]."+".$jos[3]."+".$jos[2]."+".$jos[1]."\"> Google Maps</a>";
    $ispis.="</div>";

}
echo $ispis;
?>
</header>
<?php
include '../PHP/footer.php';
?>
</html>
