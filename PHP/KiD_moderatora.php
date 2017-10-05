<?php
include "../PHP/uloga.php";
include_once '../PHP/baza.class.php';
$greske="";
$ispis= "";
$ispisM= "";
$ispisC= "";
if(!isset($_SESSION))
{
	session_start();
}
$baza = new Baza;
$baza->spojiDB();
$id_clan=$_SESSION['id_clan'];

    $upit="SELECT ID_clan, ime, prezime, username FROM clan WHERE tip_korisnika=3";
    $film=$baza->selectDB($upit);
    $ispisC.="<select name=\"clan\">";
    while ($jos = oci_fetch_array($film)){
        $ispisC.="<option value=\"";
        $ispisC.=$jos[0];
        $ispisC.="\">";
        $ispisC.=$jos[1];
        $ispisC.=" ";
        $ispisC.=$jos[2];
        $ispisC.=", ";
        $ispisC.=$jos[3];
        $ispisC.=" ";
        $ispisC.="</option>";
    }
    $ispisC.="</select><br><br>";

    $upit="SELECT ID_clan, ime, prezime, username FROM clan WHERE tip_korisnika=2";
    $film=$baza->selectDB($upit);
    $ispisM.="<select name=\"moderator\">";
    while ($jos = oci_fetch_array($film)){
        $ispisM.="<option value=\"";
        $ispisM.=$jos[0];
        $ispisM.="\">";
        $ispisM.=$jos[1];
        $ispisM.=" ";
        $ispisM.=$jos[2];
        $ispisM.=", ";
        $ispisM.=$jos[3];
        $ispisM.=" ";
        $ispisM.="</option>";
    }
    $ispisM.="</select>";
    
    $ispis.="</select>";
    $upit="SELECT ID_lokacije, lokacije.grad, lokacije.ulica, lokacije.broj FROM "
            . " lokacije ";

    $lokacije =$baza->selectDB($upit);
    $ispis.="<select name=\"lokacija\">";
    while ($jos = oci_fetch_array($lokacije)){
        $ispis.="<option value=\"";
        $ispis.=$jos[0];
        $ispis.="\">";
        $ispis.=$jos[0];
        $ispis.=", ";
        $ispis.=$jos[1];
        $ispis.=" ";
        $ispis.=$jos[2];
        $ispis.=" ";
        $ispis.=$jos[3];
        $ispis.=" ";
        $ispis.="</option>";
    }
    $ispis.="</select>";

    $ispisML="<table ><thead><th>Moderator</th><th>ID_lokacije</th></thead>";;
    
    $upit="SELECT clan.username, moderator_lokacija.lokacija from clan, "
            . "moderator_lokacija WHERE clan.ID_clan=moderator_lokacija.clan";
    $rezultat =  $baza->selectDB($upit);
    while ($nesto=oci_fetch_array($rezultat)){

            $ispisML.="<tr class='redak'>";
            $ispisML.="<td id='id'>";
            $ispisML.=$nesto[0];
            $ispisML.="</td>";
            $ispisML.="<td>";
            $ispisML.=$nesto[1];
            $ispisML.="</td>";
            $ispisML.="</tr>";  
    }
    
if(isset($_POST['rezervacija'])) {

    
    $moderator = $_POST["moderator"];
    $lokacija = $_POST["lokacija"]; 
    
    $greske = "";

    $upit = "INSERT INTO moderator_lokacija( lokacija, clan) VALUES "
            . "('".$lokacija."','".$moderator."')";
    $baza->updateDB($upit);
    $greske .="<hr>Uspjesno ste dodjelili moderatora lokaciji";
    
}
elseif(isset($_POST['postavi'])){

    
    $clan = $_POST["clan"];
    
    $greske = "";

    $upit = "UPDATE clan SET tip_korisnika = '2' WHERE clan.ID_clan ='".$clan."'";
    $baza->updateDB($upit);
    $greske .="<hr>Uspjesno ste postavili korisnika '".$clan."' za moderatora";
    
}

?>
<html class="pozadina">
    <head>
        <meta charset="UTF-8">

        
        <title></title>
    </head>
    <body >
    <fieldset class="regOkvir">
                <fieldset>
                    <legend><strong>Kreiranje i dodjela moderatora</strong></legend> 
                           
   
                    
                    
                    <h2>Postavi korisnika za moderatora: </h2> 
    <form id="pos" name="postavi" method="POST"  enctype="multipart/form-data">
       <p>
           <label for="clan">Korisnik: </label>
           <?php echo $ispisC; ?>


           <input class="gumb" name="postavi" type="submit" value=" Postavi ">
       </p> 
    </form>
<p class="isp_greski"><?php  echo $greske;?></p>
    <hr>
    
     <h2>Dodjelite moderatora nekoj lokaciji: </h2> 
    <form method="POST" name="rezervacija">
            <p>
                <label for="moderator">Moderator: </label>
                <?php echo $ispisM; ?><br><br>

                <label for="lokacija">Lokacija : </label>
                <?php echo $ispis; ?><br><br>

                <input class="gumb" id="registracija" name="rezervacija" type="submit" value=" Spremi ">
            </p> 
            <hr>
            <?php echo $ispisML; ?><br><br>
        </form>
 
    </fieldset>

</body>
</html>


<?php
include_once '../PHP/footer.php';
?>