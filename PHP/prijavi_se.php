<?php
include "../PHP/uloga.php";
include '../PHP/autentikacija.php';
include_once '../PHP/baza.class.php';
$baza = new Baza;
$baza->spojiDB();
$greskaPrijava = "";

$trenutno = time() ;
$vrijemPrijave = date('Y-m-d H:i:s', $trenutno);

if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) {
	$url = 'https://' . $_SERVER['HTTP_HOST']
		. $_SERVER['REQUEST_URI'];
	header('Location: ' . $url);
	exit;
}

if(!isset($_SESSION))
{
	session_start();
}

if(isset($_POST['prijava'])) {
	$user = $_POST['username'];
	$pass = $_POST['lozinka'];
	$provjera=autentikacija($user,$pass);
        
        $upit = "select tip_korisnika from clan where username = '".$user."'";
        $uloga= oci_fetch_array($baza->selectDB($upit));
        
        $_SESSION['upit']="select ID_clan from clan where username = '".$user."'";
        
        
        $upit = "select ID_clan from clan where username = '".$user."'";
        $id_clan =  oci_fetch_array($baza->selectDB($upit));
        
        $_SESSION['id_clan']=$id_clan[0];
        $_SESSION['uloga'] = $uloga[0];
        $_SESSION["korisnickoImeSesija"]=$user;
        
	if($provjera==1 ){
            
		header("Location: ../PHP/index.php");
		$greskaPrijava="";
		setcookie('username', $user, $trenutno);

		// dnevnik (Uspjesna prijava)
                   $upit = 'insert into dnevnik (akcija, vrijeme, clan) values ("Uspjesna prijava","'.$vrijemPrijave.'","'.$id_clan.'")';
                   $baza ->updateDB($upit);
	}
	elseif ($provjera==3){
		$greskaPrijava = "Zakljucan je korisnicki racuna";
		// dnevnik (Zaključan račun)
                $upit = 'insert into dnevnik (akcija, vrijeme, clan) values ("Zaključan račun","'.$vrijemOdjave.'","'.$id_clan.'")';
                $baza ->updateDB($upit);
                session_destroy();
		setcookie('username', $user, time() - 3600);
	}
	elseif ($provjera==0){
		$greskaPrijava = "Nije dobro unesena lozinka ili sifra";
		//Dnevnik (Krivo uneseni podaci)
                $upit = "INSERT INTO DNEVNIK (CLAN, VRIJEME, AKCIJA) VALUES  ('".$id_clan[0]."',TO_TIMESTAMP('".$vrijemPrijave."', 'YYYY-MM-DD HH24:MI:SS'),'Krivo uneseni podaci')";
                $baza ->updateDB($upit);
                session_destroy();
		setcookie('username', $user, time() - 3600);
	}
}

?>

<html class="pozadina">
    <head>
        <meta charset="UTF-8">

        <title></title>
    </head>
    <body>

        <div id="sadrzaj">
        <form method="POST" name="prijava" enctype="multipart/form-data">
            <fieldset class="sadrzaj">
                
            <fieldset class="prijava">
                <p class="greske">
                    <?php 
                    echo $greskaPrijava;
                    ?>
                </p>
                            <legend><strong>Obrazac za prijavu</strong></legend>

                            <p>
                            <label  for="korime">Korisničko ime</label>
                            <input class="prijava" type="text" id="korime" name="username"  placeholder="Korisničko ime" value="<?php if(isset($_COOKIE['username'])) echo $_COOKIE['username']; ?>"><span id="dostupnost"></span><br>
                            </p>
                            <p>
                            <label for="poljePassword">Lozinka</label>
                            <input class="prijava" type="password" name="lozinka" id="poljePassword"  placeholder="Unesite lozinku" />
                            </p>
                            <p>
                            <input type="submit" name="prijava" value="Prijavi se" class="gumb prijava">
                            </p>
            </fieldset>
                </fieldset>
        </form>
        </div>
    </body>    
</html>
<?php
include_once '../PHP/footer.php';
?>
