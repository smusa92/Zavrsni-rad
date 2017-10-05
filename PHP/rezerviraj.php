<?php

include '../PHP/uloga.php';
include "../PHP/baza.class.php";


$baza = new Baza;
$baza->spojiDB();

$id_clan =$_SESSION['id_clan'];

$obavjest = "";

$trenutno = time() ;
$vrijemeTrenutno = date('Y-m-d H:i:s', $trenutno);


    $id = $_GET['sifra'];
    $film= $_GET['film'];
    $od= $_GET['od'];
    $do= $_GET['do'];
    $slobodno= $_GET['slobodno'];
    
    
    if(isset($_POST['rezervacija'])){
    $odabir = $_POST['odabir'];
    $id = $_GET['sifra'];
    
    if( $odabir<=$slobodno && $odabir>0){
    
    $upit="INSERT INTO rezervacije (clan, projekcija, potvrda, vrijeme_rezervacije, broj_mjesta) VALUES ( '".$id_clan."','".$id."','1',TO_TIMESTAMP('".$vrijemeTrenutno."', 'YYYY-MM-DD HH24:MI:SS'),'".$odabir."')";
    $baza->updateDB($upit);
    $obavjest="Poslali ste rezervaciju, sad se čeka na odobrenje moderatora.";
    
    $upit = "insert into dnevnik (akcija, vrijeme, clan) values ('Zahtjev za rezervacijom',TO_TIMESTAMP('".$vrijemeTrenutno."', 'YYYY-MM-DD HH24:MI:SS'),'".$id_clan."')";
    $baza ->updateDB($upit);
    
    header("Refresh: 7; ../PHP/potvrNePotvRezervacije.php");
    }  else {   
       $obavjest="Slobodno je ".$slobodno." mjesta, ne mozete rezervirati ".$odabir." mjesta."; 
    if($odabir==0){$obavjest="Slobodno je ".$slobodno." mjesta, nema smisla rezervirati 0 mjesta :P !!"; }
    }
    }
?>

<html class="pozadina">

<header class="sadrzaj"  >
    <h2>Trenutno je slobodnih mjesta: <?php echo $slobodno; ?> </h2>
    <h2>Koliko mjesta zelite rezervirati </h2>
    
<form method="POST" name="rezervacija" enctype="multipart/form-data">
    
<input  type="text" name = "odabir" placeholder="Broj mjesta" max="50" />
   
<h2>Želite li rezervirati projekciju za film  <?php echo '"',$film,'" koja će se održati od ', $od,'h do ', $do ;?>h ?</h2>  
    

        <input type="submit" name="rezervacija" value="DA" class="gumb">
                    <?php 
                    echo $obavjest;
                    ?>
 
</form>    
</header>
<?php
include '../PHP/footer.php';
?>
</html>