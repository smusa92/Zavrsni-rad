<?php
include '../PHP/uloga.php';

    $id = $_GET['sifra'];
    $g= $_GET['g'];
    $u = $_GET['u'];
    $b= $_GET['b'];
    
    ?>

<html class="pozadina">
   
<header class="sadrzaj"  >
    <h2>Na lokaciji "<?php echo $g,' ', $u,' ', $b ;?>"  imate projekcije </h2>
<?php
include "../PHP/baza.class.php";
$baza = new Baza;
$baza->spojiDB();

$trenutno = time() ;



$upit = "SELECT projekcije.ID_projekcije, filmovi.naziv, filmovi.trajanje, filmovi.redatelj,"
        . " zanrovi.naziv, TO_CHAR(projekcije.od ,'DD.MM.YYYY HH24:MI'),TO_CHAR(projekcije.do,'DD.MM.YYYY HH24:MI'),"
        . " projekcije.max_broj_posjetitelja ,TO_CHAR(projekcije.od ,'MM.YYYY HH24:MI')FROM filmovi, projekcije, zanrovi WHERE projekcije.lokacije=".$id."AND  "
        . "projekcije.film=filmovi.ID_filmovi AND zanrovi.ID_ZANROVI=filmovi.zanr ";

$rez = $baza->selectDB($upit);

$ispis = "";
$vrijemeTrenutno = date('d',  time());
$vrijemeTrenutnoM = date('m.Y  ',  time());

$dizajn = "pregled_film";
while ($jos = oci_fetch_array($rez)){

    if($vrijemeTrenutnoM>$jos[8] && $jos[7]>0){
    $dizajn = "pregled_film_red"; 
    }else if($vrijemeTrenutnoM==$jos[8]&&$vrijemeTrenutno>$jos[5] && $jos[7]>0){
    $dizajn = "pregled_film_red"; 
    } else {
    $dizajn = "pregled_film";
    } 

$odabrao1 = "svidja";
$odabrao0 = "svidja";


    $upit = "SELECT lajkovi.projekcija, lajkovi.lajk FROM lajkovi WHERE lajkovi.clan='".$_SESSION['korisnickoImeSesija']."'";
    $sto_lajkas = $baza->selectDB($upit);
    

   //dodjeljujem posebnu class ako je lajkano ili dislajkano 
while ($odabraniLajk = oci_fetch_array($sto_lajkas)){
  
    if($odabraniLajk[0]==$jos[0]){
        
        if($odabraniLajk[1]==1){
            
            $odabrao1="odabrano";
            $odabrao0 = "svidja";
            
        }  elseif($odabraniLajk[1]==0) {
            $odabrao0="odabrano";
            $odabrao1 = "svidja";
}
        
    }
}
    //brojač za lajkove
    $upit = "SELECT COUNT(*) Total FROM lajkovi WHERE lajkovi.projekcija = '".$jos[0]."'AND lajkovi.lajk =1";
    
    $brojL=oci_fetch_array($baza->selectDB($upit));
    //brojač za dislajkove
    $upit = "SELECT COUNT(*)Total FROM lajkovi WHERE lajkovi.projekcija = '".$jos[0]."'AND lajkovi.lajk =0";
    $brojN=  oci_fetch_array($baza->selectDB($upit));
    
 
    //prikaz projekcije sa pod. iz baze

    
    $ispis.="<div class=".$dizajn.">";
    $ispis.="<img src =\"../slike/film.png\" >";
    $ispis.="<p>Film : ".$jos[1]."<br>";
    $ispis.="Redatelj : ".$jos[3]."<br>";
    $ispis.="Žanr : ".$jos[4]."<br>";
    $ispis.="Početak : ".$jos[5]." <br>";
    $ispis.="Kraj projekcije : ".$jos[6]." <br>";
    $ispis.="Trajanje : ".$jos[2]." min <br>";
    $ispis.="Slobodna mjesta : ".$jos[7]." </p>";
      //gumbovi za rezervaciju, sviđa, ne sviđa                                          
    $ispis.="<a class=\"rezerviraj\" href=\"../PHP/rezerviraj.php?sifra=".$jos[0]."&film=".$jos[1]."&od=".$jos[5]."&do=".$jos[6]."&slobodno=".$jos[7]."\">Rezerviraj</a>";
    
    
    $ispis.="<a class=\"zelenoLajk\">+".$brojL[0]."</a>";
    
    //prikaz clanova koji su lajkali projekciju
    $upit = "SELECT lajkovi.clan FROM lajkovi WHERE lajkovi.projekcija = '".$jos[0]."'AND lajkovi.lajk =1";
    $clanoviKojiSuLajkali = $baza->selectDB($upit);
    $ispis.="<div class=\"prikaziLajkase\" >";
    while ($lajkasi = oci_fetch_array($clanoviKojiSuLajkali)){
    $ispis.=$lajkasi[0]."<br>";
    }
    $ispis.="</div >";$ispis.="<a class=".$odabrao1." href=\"../PHP/lajk.php?sifra=".$jos[0]."&lajk=1\">Sviđa  </a>";
    $ispis.="<a class=".$odabrao0." href=\"../PHP/lajk.php?sifra=".$jos[0]."&lajk=0\">Ne sviđa</a>";
    $ispis.="<a class=\"crvenoLajk\">+".$brojN[0]."</a>";
    //prikaz clanova koji su dislajkali projekciju
    $upit = "SELECT lajkovi.clan FROM lajkovi WHERE lajkovi.projekcija = '".$jos[0]."'AND lajkovi.lajk =0";
    $clanoviKojiSuDislajkai = $baza->selectDB($upit);
    $ispis.="<div class=\"prikaziDislajk\" >";
    while ($dislajk = oci_fetch_array($clanoviKojiSuDislajkai)){
    $ispis.=$dislajk[0]."<br>";
    }
    $ispis.="</div >";
    
    $ispis.="<h1>Istekla/popunjena!</h1>";
    $ispis.="</div>";
 
    
    
    
   
    }

    
echo $ispis;
//echo $clan;

?>
    </header>
<?php
include '../PHP/footer.php';
?>
</html>