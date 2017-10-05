<?php
include '../PHP/uloga.php';

    $id = $_GET['sifra'];
    $g= $_GET['g'];
    $u = $_GET['u'];
    $b= $_GET['b'];

    ?>

<html class="pozadina">
    
<header class="sadrzaj"  ><h2>Odabrali ste  lokaciju: <?php echo $g,' ', $u,' ', $b ;?> </h2>
    
<?php
include "../PHP/baza.class.php";
$baza = new Baza;
$baza->spojiDB();


$vrijemeTrenutno = date('Y-m-d H:i:s', time());


$upit = "SELECT filmovi.naziv, filmovi.trajanje, filmovi.redatelj, zanrovi.naziv, TO_CHAR(projekcije.od, 'DD-MON-YYYY HH24:MI:SS') "
        . ",TO_CHAR(projekcije.do, 'DD-MON-YYYY HH24:MI:SS'), projekcije.max_broj_posjetitelja FROM filmovi, projekcije, zanrovi "
        . "WHERE projekcije.lokacije=".$id." AND  projekcije.film=filmovi.ID_filmovi AND zanrovi.ID_zanrovi=filmovi.zanr";

$rezultat = $baza->selectDB($upit);

$ispis = "";


while ($jos = oci_fetch_array($rezultat)){
    
    if($vrijemeTrenutno<$jos[3]){
    
    
    
    $ispis.="<div class='pregled_film'>";
    $ispis.="<img src =\"../slike/film.png\" >";
    $ispis.="<p>Film : ".$jos[0]."<br>";
    $ispis.="Redatelj : ".$jos[2]."<br>";
    $ispis.="Žanr : ".$jos[3]."<br>";
    $ispis.="Početak : ".$jos[4]." <br>";
    $ispis.="Kraj projekcije : ".$jos[5]." <br>";
    $ispis.="Trajanje : ".$jos[1]." min <br>";
    $ispis.="Slobodna mjesta : ".$jos[6]." </p>";
    $ispis.="</div>";
    

}
    }
echo $ispis;

?>
    </header>
<?php
include '../PHP/footer.php';
?>
</html>