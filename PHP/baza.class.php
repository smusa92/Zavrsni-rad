<?php /*
$conn=oci_connect("C##","12345","localhost/Zrad");
If (!$conn)
    echo 'Failed to connect to Oracle';
else
    echo 'Succesfully connected with Oracle DB';

oci_close($conn);
*/?>
    <?php
    class Baza {
        const korisnik = "C##";
        const lozinka = "12345";
        const baza = "localhost/Zrad";

		
        function spojiDB(){
            $conn = oci_connect(self::korisnik,self::lozinka,self::baza);
            if(!$conn){
                echo "Neuspješno spajanje na bazu: ";
            }
            return $conn;
        }
        
        function selectDB($upit){
            $conn = $this->spojiDB();
            $rezultat = oci_parse($conn,$upit);
            if (!$rezultat) {
            $e = oci_error($conn);  // For oci_parse errors pass the connection handle
            trigger_error(htmlentities($e['message']), E_USER_ERROR);
            }

            $r=oci_execute($rezultat);
            if (!$r) {
            $e = oci_error($rezultat);  // For oci_execute errors pass the statement handle
            print htmlentities($e['message']);
            print "\n<pre>\n";
            print htmlentities($e['sqltext']);
            printf("\n%".($e['offset']+1)."s", "^");
            print  "\n</pre>\n";
                    }
            oci_close($conn);
            return $rezultat;
        }

        function updateDB($upit){
            $conn = $this->spojiDB();
            $rezultat = oci_parse($conn,$upit);
            if (!$rezultat) {
            $e = oci_error($conn);  // For oci_parse errors pass the connection handle
            trigger_error(htmlentities($e['message']), E_USER_ERROR);
            }

            $r=oci_execute($rezultat);
            if (!$r) {
            $e = oci_error($rezultat);  // For oci_execute errors pass the statement handle
            print htmlentities($e['message']);
            print "\n<pre>\n";
            print htmlentities($e['sqltext']);
            printf("\n%".($e['offset']+1)."s", "^");
            print  "\n</pre>\n";
                    }
            oci_close($conn);
            return $rezultat;
        }
        function closeDB($veza){
            $veza->close();
        }
    }


