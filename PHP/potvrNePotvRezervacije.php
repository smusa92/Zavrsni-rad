<?php

include '../PHP/uloga.php';

?>

<html class="pozadina">
    
<header class="sadrzaj"  >
<h1>Lokacije projekcija</h1>
<?php
include "../PHP/baza.class.php";
$baza = new Baza;
$baza->spojiDB();

if(isset($_GET['stranica'])){
    
    $stranica=$_GET['stranica'];
    
}  else {
    $stranica=1;
}
        $baza = new Baza();
        $baza->spojiDB();
        //racuna broj za straničenje
        $sql="SELECT COUNT(*) AS broj FROM lokacije";
        $broj = oci_fetch_array($baza->selectDB($sql));


include '../PHP/pretrazivanje.php';
include '../PHP/stranicenje.class.php';

 //funkcija za ispis brojeva straničenja
        brojevi($broj[0],'potvrNePotvRezervacije',$stranica);
 
if (isset ($_SESSION['unos'])) {
$upit = "SELECT lokacija.ID_lokacija, drzave.naziv, lokacija.grad, "
        . "lokacija.ulica, lokacija.broj from drzave right "
        . "JOIN lokacija ON drzave.ID_drzave=lokacija.drzava"
        . " WHERE lokacija.grad LIKE '".$_SESSION['unos']."%' "
        . " OR lokacija.ulica LIKE '".$_SESSION['unos']."%' "
        . " OR drzave.naziv LIKE '".$_SESSION['unos']."%' ";
} else {
    $upit= prikazi_stranicenjeLokacije($stranica);
}
$rez = $baza->selectDB($upit);

$ispis = "";
while ($jos = oci_fetch_array($rez)){

    $ispis.="<div class='pregled'>";
    $ispis.="<img src =\"../slike/kino_king.jpg\" >";
    $ispis.="<p>Šifra : ".$jos[0]."<br>";
    $ispis.="Država : ".$jos[1]."<br>";
    $ispis.="Grad : ".$jos[2]."<br>";
    $ispis.="Ulica : ".$jos[3]." <br>";
    $ispis.="Broj : ".$jos[4]." </p>";
    $ispis.="<a  href=\"../PHP/odaberiLokaciju.php?&sifra=".$jos[0]."&g=".$jos[2]."&u=".$jos[3]. "&b=".$jos[4]."\"> Odaberi lokaciju </a>";
    $ispis.= "<a href=\"https://maps.google.com?q=".$jos[4]."+".$jos[3]."+".$jos[2]."+".$jos[1]."\"> Google Maps</a>";
    $ispis.="</div>";


}
echo $ispis;
?>
</header>
<?php
include '../PHP/footer.php';
unset( $_SESSION['unos']);
?>
</html>