<?php
include '../PHP/uloga.php';
?>
<html class="pozadina">

    <header class="sadrzaj"  > <h1>Ispis svih korisnika</h1>
        <?php
        include_once '../XML/navigacija_za_inc.xml';
        include_once '../PHP/baza.class.php';
        $baza = new Baza();
        $baza->spojiDB();

        $upit = "SELECT clan.ID_clan, clan.ime, clan.prezime , clan.username, clan.lozinka, clan.email,  tip_korisnika.uloga from clan LEFT JOIN tip_korisnika ON  clan.tip_korisnika=tip_korisnika.ID_tip_korisnika WHERE clan.status!= '3' AND clan.tip_korisnika != '1' ORDER BY 1 ";

        $rezultat =  $baza->selectDB($upit);

        $ispis = "<table ><thead><th>ID</th><th>Ime</th><th>Prezime</th><th>Korisnicko ime</th><th>Lozinka</th><th>E-mail</th><th>Uloga</th><th>Blokiraj</th><th>Brisi</th></thead>";
        while ($jos=oci_fetch_array($rezultat)){

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
            $ispis.=$jos[4];
            $ispis.="</td>";
            $ispis.="<td>";
            $ispis.=$jos[5];
            $ispis.="</td>";
            $ispis.="<td>";
            $ispis.=$jos[6];
            $ispis.="</td>";
            $ispis.="<td>";
            $ispis.="<a href=\"../PHP/brisi_blokiraj.php?&odabir=1&sifra=".$jos[0]."\"><h7>Blokiraj</h7></a>";
            $ispis.="</td>";
            $ispis.="<td>";
            $ispis.="<a href=\"../PHP/brisi_blokiraj.php?&odabir=0&sifra=".$jos[0]."\"><h7>Brisi</h7></a>";
            $ispis.="</td>";
            $ispis.="</tr>";     

       }
       echo $ispis;
       
       ?>
    </header>
<?php
include '../PHP/footer.php';
?>
</html>