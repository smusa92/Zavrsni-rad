<?php
include '../PHP/uloga.php';
?>

<html class="pozadina">
    
<header class="sadrzaj"  >
    <h2>Statistika lajkova </h2>
<?php
include "../PHP/baza.class.php";
if(isset($_GET['stranica'])){
    
    $stranica=$_GET['stranica'];
    
}  else {
    $stranica=1;
}
$baza = new Baza;
$baza->spojiDB();
//racuna broj za straničenje
$sql="SELECT COUNT(*) AS broj FROM lajkovi";
$broj = oci_fetch_array($baza->selectDB($sql));

include '../PHP/pretrazivanje.php';
include '../PHP/stranicenje.class.php';
//funkcija za ispis brojeva straničenja
brojevi($broj[0],'statistikaLajkova',$stranica);

$trenutno = time();
$vrijemeTrenutno = date('Y-m-d H:i:s', $trenutno);


$sortiranje = 1;
       if (isset($_SESSION['tablica3'])){
          $upit = $_SESSION['tablica3']; 
       } elseif (isset ($_SESSION['unos'])){
           $upit="SELECT projekcije.ID_projekcije, filmovi.naziv, "
                   . "projekcije.od ,projekcije.do, lajkovi.lajk,  "
                   . "lajkovi.clan FROM filmovi, projekcije, lajkovi  "
                   . "WHERE  projekcije.film=filmovi.ID_filmovi AND "
                   . "projekcije.ID_projekcije=lajkovi.projekcija  AND "
                   . "filmovi.naziv LIKE '".$_SESSION['unos']."%' ";
       } else {
$upit = prikazi_stranicenjeLajk($stranica);//tutututututu
       }
$rez = $baza->selectDB($upit);


$ispis = "<table class='tab'><thead><th>ID projekcije</th><th>Film</th><th><h7>OD</th><th>DO </th><th>Sviđa </a></th><th>Ne sviđa </a></th></thead>";
$ponavljanje = array();
$ponavljanje []=0;
while ($jos = oci_fetch_array($rez)){

    $upit = "SELECT COUNT(*)as broj FROM lajkovi WHERE lajkovi.projekcija = '".$jos[0]."'AND lajkovi.lajk ='1'";
    $brojL=oci_fetch_array($baza->selectDB($upit));

    $upit = "SELECT COUNT(*)as broj FROM lajkovi WHERE lajkovi.projekcija = '".$jos[0]."'AND lajkovi.lajk ='0'";
    $brojN=oci_fetch_array($baza->selectDB($upit));
           
           
    
    foreach ($ponavljanje as $pon){
        
            if($pon != $jos[0]){
                $jump = 0;
            }elseif ($pon == $jos[0]) {
                $jump = 1;
                break;
            }   
       
    }       
    if($jump==0){
           $ispis.="<tr class='redak'>";
           $ispis.="<td id='id'>";
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
           $ispis.=$brojL[0];
           $ispis.="</td>";
           $ispis.="<td>";
           $ispis.=$brojN[0];
           $ispis.="</td>";
           $ispis.="</tr>";
           
           
           
           $ponavljanje[]=$jos[0];
    }
    
    }
    
    

echo $ispis;


?>
    </header>
<?php
include '../PHP/footer.php';
unset($_SESSION['tablica3']);
unset($_SESSION['unos']);
?>
</html>

