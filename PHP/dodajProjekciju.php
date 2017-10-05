<?php
include "../PHP/uloga.php";
include_once '../PHP/baza.class.php';
$greske="";
$ispis= "";
$ispisF= "";
if(!isset($_SESSION))
{
	session_start();
}
$baza = new Baza;
$baza->spojiDB();

$trenutno = time() ;
$vrijemOdjave = date('Y-m-d H:i:s', $trenutno);

$id_clan=$_SESSION['id_clan'];

    $upit="SELECT ID_filmovi, naziv FROM filmovi";
    $film=$baza->selectDB($upit);
    $ispisF.="<select name=\"film\">";
    while ($jos = oci_fetch_array($film)){
        $ispisF.="<option value=\"";
        $ispisF.=$jos[0];
        $ispisF.="\">";
        $ispisF.=$jos[1];
        $ispisF.=" ";
        $ispisF.="</option>";
    }
    $ispisF.="</select>";
    
    $ispis.="</select>";
    $upit="SELECT moderator_lokacija.lokacija, lokacije.grad, lokacije.ulica, "
            . "lokacije.broj FROM moderator_lokacija, lokacije WHERE moderator_lokacija.clan='".$id_clan."' "
            . "AND lokacije.ID_lokacije=moderator_lokacija.lokacija";

    $lokacije =$baza->selectDB($upit);
    $ispis.="<select name=\"lokacija\">";
    while ($jos = oci_fetch_array($lokacije)){
        $ispis.="<option value=\"";
        $ispis.=$jos[0];
        $ispis.="\">";
        $ispis.=$jos[1];
        $ispis.=" ";
        $ispis.=$jos[2];
        $ispis.=" ";
        $ispis.=$jos[3];
        $ispis.=" ";
        $ispis.="</option>";
    }
    $ispis.="</select>";


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    
    $film = $_POST["film"];
    $lokacija = $_POST["lokacija"]; 
    $od = $_POST["od"];
    $do = $_POST["do"];
    $max_broj_posjetitelja = $_POST["max_broj_posjetitelja"];
   
    
    $greske = "";
    $brojac = 1;

    if (empty($film)) {
        $greske .= $brojac . '.' . ' ' . 'film nije upisana' . "<br>";
        $brojac++;
    }
    
    elseif (empty($lokacija)) {
        $greske .= $brojac . '.' . ' ' . 'lokacija nije upisan' . "<br>";
        $brojac++;
    }
    
    elseif (empty($od)) {
        $greske .= $brojac . '.' . ' ' . 'Početqak projekcije nije upisano' . "<br>";
        $brojac++;
    }
    
    elseif (empty($do)) {
        $greske .= $brojac . '.' . ' ' . 'Kraj projekcije nije upisano' . "<br>";
        $brojac++;
    }
    elseif (empty($max_broj_posjetitelja)) {
        $greske .= $brojac . '.' . ' ' . 'Max broj posjetitelja nije upisan!' . "<br>";
        $brojac++;
    }

    if (empty($greske)) {
    $upit = "INSERT INTO projekcije (film, lokacije, od, do, max_broj_posjetitelja) VALUES "
            . "( '".$film."', '".$lokacija."', TO_TIMESTAMP('".$od."', 'YYYY-MM-DD HH24:MI:SS'),TO_TIMESTAMP('".$do."', 'YYYY-MM-DD HH24:MI:SS') , '".$max_broj_posjetitelja."')";
    $baza->updateDB($upit);

$upit = "INSERT INTO DNEVNIK (CLAN, VRIJEME, AKCIJA) VALUES  "
        . "('".$id_clan[0]."',TO_TIMESTAMP('".$vrijemOdjave."', 'YYYY-MM-DD HH24:MI:SS')"
        . ",'Moderator dodaje projekciju')";
    $baza ->updateDB($upit);
    $greske .="Uspjesno ste unjeli Projekciju, ne treba ništa prepravljati";
    }
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
                    <legend><strong>Dodaj projekciju</strong></legend> 
                    <fieldset class="greske">          
                    <legend><strong>Što je potrebno prepraviti</strong></legend>    
                    
                    <p class="isp_greski"><?php  echo $greske;?></p>
                </fieldset>
    
    <form id="reg" name="reg" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <p>
                <label for="film">Filma ID: </label>
                <?php echo $ispisF; ?><br><br>

                <label for="lokacija">Lokacija ID: </label>
                <?php echo $ispis; ?><br><br>

                <label for="od">Početak projekcije: </label>
                <input type="datetime" name="od" placeholder="2017-02-20 18:00:00" ><br><br>
                
                <label for="do">Kraj projekcije: </label>
                <input type="datetime" name="do" placeholder="2017-02-20 20:00:00" ><br><br>
                
                <label for="max_broj_posjetitelja">Maksimalni broj posjetitelja: </label>
                <input  type="text" name="max_broj_posjetitelja" ><br><br>

                <input class="gumb" id="registracija" type="submit" value=" Spremi ">
            </p> 
        </form>
    
    </fieldset>
                    </fieldset> 
</body>
</html>


<?php
include_once '../PHP/footer.php';
?>