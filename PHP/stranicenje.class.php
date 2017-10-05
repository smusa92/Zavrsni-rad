<?php
include_once '../PHP/baza.class.php';
$baza = new Baza();
$baza->spojiDB();


$GLOBALS['$odabir_stranicenje']= 20;

function promjeni_odabirt (){
include_once '../PHP/baza.class.php';
$baza = new Baza();
$baza->spojiDB();

   $_SESSION['odabir']=$GLOBALS['$odabir_stranicenje'];
   ?>  

<form method="POST" name="promjeni_stranicenje" enctype="multipart/form-data">
<input  type="text" name = "odabir" placeholder="broj_stranicenje"  />
<input type="submit" name="promjeni_stranicenje"  class="gumb">
</form> 
    
<?php 
}
                   

function prikazi_stranicenje ($test, $tablica){
    $limit_kraj=$GLOBALS['$odabir_stranicenje']*$test;
    $limit_start=($limit_kraj)-$GLOBALS['$odabir_stranicenje'];
    $sql_stranicenje="SELECT * FROM ".$tablica." where ID_".$tablica." BETWEEN ".$limit_start."and  ".$limit_kraj."";
    
    return $sql_stranicenje;
    
}
function prikazi_stranicenjeLajk ($test){
    $limit_kraj=$GLOBALS['$odabir_stranicenje'];
    $limit_start=($test*$limit_kraj)-$limit_kraj;
    $sql_stranicenje="SELECT projekcije.ID_projekcije, filmovi.naziv, projekcije.od "
            . ",projekcije.do, lajkovi.lajk, lajkovi.clan FROM filmovi RIGHT JOIN "
            . "projekcije ON projekcije.film=filmovi.ID_filmovi RIGHT JOIN lajkovi "
            . "ON projekcije.ID_projekcije=lajkovi.projekcija "
            . "where ROWNUM > ".$limit_start."and ROWNUM < ".$limit_kraj."";
    
    return $sql_stranicenje;
    
}
function prikazi_stranicenjeLokacije ($test){
    $limit_kraj=$GLOBALS['$odabir_stranicenje'];
    $limit_start=($test*$limit_kraj)-$limit_kraj;
    $sql_stranicenje="SELECT lokacije.ID_lokacije, drzave.naziv, lokacije.grad, "
        . "lokacije.ulica, lokacije.broj from drzave right "
        . "JOIN lokacije ON drzave.ID_drzave=lokacije.drzave "
            ." where ROWNUM > ".$limit_start."and ROWNUM < ".$limit_kraj."";
    
    return $sql_stranicenje;
    
}

function brojevi ($broj,$putanja,$stranica){
$rez = $broj/$GLOBALS['$odabir_stranicenje'];
        $test=0;
        
    $naprijed=$stranica+1;
    $nazad=$stranica-1;
    if($nazad<1) {$nazad=1;}
    if($naprijed>  ceil($rez)) {$naprijed=ceil($rez);}
    
$strani="<div class=\"pagination\"><h4>Straničenje: ".$GLOBALS['$odabir_stranicenje']." Stranica: $stranica </h4><a href=\"../PHP/$putanja.php?stranica=$nazad\">&laquo;</a>";

        
        for($i=$rez;$i>0;$i--){ 
           $test++; 
           if($test<10){
            $strani.="<a href=\"../PHP/$putanja.php?stranica=$test\">$test</a>";
        }  else if($test==ceil($rez)) {
            $strani.="<a >...</a><a href=\"../PHP/$putanja.php?stranica=$test\">$test</a>";
        }}
        
        
        
$strani.="<a href=\"../PHP/$putanja.php?stranica=$naprijed\">&raquo;</a></div></br></br></br>";
echo $strani;
}
?>