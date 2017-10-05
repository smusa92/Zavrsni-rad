<?php
include '../PHP/baza.class.php';
function autentikacija($user,$pass){
    
    $baza = new Baza();
    $baza ->spojiDB();
    $rezultat=0;
    $upit="select lozinka, status, greska_prijave from clan where username = '".$user."'";
    $rez = $baza->selectDB($upit);
    if($rez) {
        $status = oci_fetch_array($rez);
        if ($status[0] == $pass) {
        $upit = "UPDATE clan SET GRESKA_PRIJAVE = 0 WHERE clan.username = '".$user."'";
        $baza->updateDB($upit);  
            if ($status[1] == '1') {
                $rezultat = 1;
            }elseif ($status[1] == '3') {
                $rezultat = 3;
            }
        }
        elseif($status[2] == 3){
                // zaključavanje clana
                $upit = "UPDATE clan SET status = 3 WHERE clan.username = '".$user."'";
                $baza->updateDB($upit);
            }
            else {
                $upit = "UPDATE clan SET GRESKA_PRIJAVE = GRESKA_PRIJAVE + 1 WHERE username = '".$user."'";
                $baza->updateDB($upit);
                
          }   
    }
    else{$rezultat = 0;}return $rezultat;
}
?>

