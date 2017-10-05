<?php

include '../PHP/uloga.php';

?>

<html class="pozadina">
    
<header class="sadrzaj"  ><h1>Potvrđene rezervacije</h1>
<?php

include "../PHP/baza.class.php";
$baza = new Baza;
$baza->spojiDB();

$id_clan =$_SESSION['id_clan'];

if (isset($_SESSION['tablica5'])){
          $upit = $_SESSION['tablica5']; 
       }  else {
$upit =  "SELECT filmovi.naziv, lokacije.grad,lokacije.ulica,lokacije.broj, rezervacije.broj_mjesta, rezervacije.vrijeme_rezervacije"
        . " FROM rezervacije "
        . "JOIN projekcije ON rezervacije.projekcija=projekcije.ID_projekcije "
        . "JOIN lokacije ON projekcije.lokacije=lokacije.ID_lokacije "
        . "JOIN filmovi ON filmovi.ID_filmovi=projekcije.film "
        . "AND rezervacije.clan= '".$_SESSION['id_clan']."' AND rezervacije.potvrda=2";
       }
$rez = $baza->selectDB($upit);

$ispis = "<table><thead><th><a href=\"../PHP/sortiraj.php?&tablica=5&order=1\"><h7>Film ˇ^ </h7></a></th><th>Grad</th><th>Ulica</th><th>Broj &nbsp</th><th>Zatrazena mjesta&nbsp</th><th><a href=\"../PHP/sortiraj.php?&tablica=5&order=5\"><h7>Vrijeme rezervacije ˇ^ </h7></a></th></thead>";
while ($jos = oci_fetch_array($rez)){

    $ispis.="<tr >";
    $ispis.="<td>";
    $ispis.=$jos[0];
    $ispis.="</td>";
    $ispis.="<td>";
    $ispis.=$jos[1];
    $ispis.="</td>";
    $ispis.="<td>";
    $ispis.=$jos[2];
    $ispis.="</td>";
    $ispis.="<td>";
    $ispis.=$jos[3];
    $ispis.="</td>";
    $ispis.="<td>";
    $ispis.=$jos[4];
    $ispis.="</td>";
    $ispis.="<td>";
    $ispis.=$jos[5];
    $ispis.="</td>";
    $ispis.="</tr>";


}
echo $ispis;
?>
</header>
<?php
include '../PHP/footer.php';
unset($_SESSION['tablica5']);
?>
</html>
