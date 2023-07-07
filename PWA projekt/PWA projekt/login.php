<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>PWA projekt</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" 
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" 
        crossorigin="anonymous">

        <link rel="stylesheet" href="style.css">
        
    </head>
    <body>
        <header class="container-fluid">
            <div class="row pocetak">
                <p class="zaglavlje col-12"></p>
                <img class="logo" alt="logo" src="img/B.Z..svg.png">
                <nav class="col-12">
                    <ul class="col-12 row">
                        <li class="col-2"><a href="index.php">Home</a></li>
                        <li class="col-2"><a href="kategorija.php?id=sport">Berlin-sport</a></li>
                        <li class="col-2"><a href="kategorija.php?id=kultura">Kultur und show</a></li>
                        <li class="col-2 zadnji"><a href="administracija.php">Administracija</a></li>
                        <li class="col-2 zadnji"><a href="unos.html">Unos</a></li>
                        <li class="col-2 zadnji"><a href="login.php">Prijava</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <section class="container forma">
            <form enctype="multipart/form-data" action="" method="POST">
                <div class="form-item">
                    <span id="porukaUsername" class="bojaPoruke"></span>
                    <label for="content">Korisničko ime:</label>
                    <div class="form-field">
                        <input type="text" name="username" id="username" class="form-field-textual">
                    </div>
                </div>
                <div class="form-item">
                    <span id="porukaPass" class="bojaPoruke"></span>
                    <label for="pphoto">Lozinka: </label>
                    <div class="form-field">
                        <input type="password" name="pass" id="pass" class="form-field-textual">
                    </div>
                </div>
                <div class="form-item">
                    <button type="submit" value="Prijava" id="slanje">Prijava</button>
                    <button type="submit" value="Prijava" id=""><a href="registracija.php">Registracija</a></button>
                </div>
            </form>
        </section>
        <br>
        <footer class="container-fluid">
            <div class="container zadnje">
                <p>Weitere Online-Angebote der Axel Springer SE:</p>
            </div>
        </footer>
    </body>
</html>
<script type="text/javascript">
    document.getElementById("slanje").onclick = function(event) {
        var slanjeForme = true;
        // Korisničko ime mora biti uneseno
        var poljeUsername = document.getElementById("username");
        var username = document.getElementById("username").value;
        if (username.length == 0) {
            slanjeForme = false;
            poljeUsername.style.border="1px dashed red";
            document.getElementById("porukaUsername").innerHTML="<br>Unesite korisničko ime!<br>";
        } else {
            poljeUsername.style.border="1px solid green";
            document.getElementById("porukaUsername").innerHTML="";
        }
        // Provjera podudaranja lozinki
        var poljePass = document.getElementById("pass");
        var pass = document.getElementById("pass").value;
        if (pass.length == 0) {
            slanjeForme = false;
            poljePass.style.border="1px dashed red";
            document.getElementById("porukaPass").innerHTML="<br>Lozinka mora biti unešena!<br>";
        } else {
            poljePass.style.border="1px solid green";
            document.getElementById("porukaPass").innerHTML="";
        }
        if (slanjeForme != true) {
            event.preventDefault();
        }
    };
</script>
<?php
    include 'connect.php';

    $username = $_POST['username'];
    $lozinka = $_POST['pass'];

    $sql="SELECT korisnicko_ime, lozinka FROM korisnik WHERE korisnicko_ime=? AND lozinka=?";
    /* Inicijalizira statement objekt nad konekcijom */
    $stmt=mysqli_stmt_init($dbc);
    /* Povezuje parametre statement objekt s upitom */
    if (mysqli_stmt_prepare($stmt, $sql)){
        /* Povezuje parametre i njihove tipove s statement objektom */
        mysqli_stmt_bind_param($stmt,'ss',$username,$hashed_password);
        /* Izvršava pripremljeni upit i pohranjuje rezultate */
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    }
    /* Povezuje atribute iz rezultata s varijablama */
    mysqli_stmt_bind_result($stmt, $a, $b);
    /* Dohvaća redak iz rezultata, i posprema vrijednosti atributa u varijable
    navedene funkcijom mysqli_stmt_bind_result() */
    mysqli_stmt_fetch($stmt);

    if (mysqli_stmt_num_rows($stmt)>0) echo ('Uspjesan login');


    mysqli_close($dbc);
?>