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
                    <span id="porukaIme" class="bojaPoruke"></span>
                    <label for="title">Ime: </label>
                    <div class="form-field">
                        <input type="text" name="ime" id="ime" class="form-field-textual">
                    </div>
                </div>
                <div class="form-item">
                    <span id="porukaPrezime" class="bojaPoruke"></span>
                    <label for="about">Prezime: </label>
                    <div class="form-field">
                        <input type="text" name="prezime" id="prezime" class="form-field-textual">
                    </div>
                </div>
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
                    <span id="porukaPassRep" class="bojaPoruke"></span>
                    <label for="pphoto">Ponovite lozinku: </label>
                    <div class="form-field">
                        <input type="password" name="passRep" id="passRep" class="form-field-textual">
                    </div>
                </div>
                <div class="form-item">
                    <button type="submit" value="Prijava" id="slanje">Registracija</button>
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
        // Ime korisnika mora biti uneseno
        var poljeIme = document.getElementById("ime");
        var ime = document.getElementById("ime").value;
        if (ime.length == 0) {
            slanjeForme = false;
            poljeIme.style.border="1px dashed red";
            document.getElementById("porukaIme").innerHTML="<br>Unesite ime!<br>";
        } else {
            poljeIme.style.border="1px solid green";
            document.getElementById("porukaIme").innerHTML="";
        }
        // Prezime korisnika mora biti uneseno
        var poljePrezime = document.getElementById("prezime");
        var prezime = document.getElementById("prezime").value;
        if (prezime.length == 0) {
            slanjeForme = false;
            poljePrezime.style.border="1px dashed red";
            document.getElementById("porukaPrezime").innerHTML="<br>Unesite Prezime!<br>";
        } else {
            poljePrezime.style.border="1px solid green";
            document.getElementById("porukaPrezime").innerHTML="";
        }
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
        var poljePassRep = document.getElementById("passRep");
        var passRep = document.getElementById("passRep").value;
        if (pass.length == 0 || passRep.length == 0 || pass != passRep) {
            slanjeForme = false;
            poljePass.style.border="1px dashed red";
            poljePassRep.style.border="1px dashed red";
            document.getElementById("porukaPass").innerHTML="<br>Lozinke nisu iste!<br>";
            document.getElementById("porukaPassRep").innerHTML="<br>Lozinke nisu iste!<br>";
        } else {
            poljePass.style.border="1px solid green";
            poljePassRep.style.border="1px solid green";
            document.getElementById("porukaPass").innerHTML="";
            document.getElementById("porukaPassRep").innerHTML="";
        }
        if (slanjeForme != true) {
            event.preventDefault();
        }
    };
</script>
<?php
    include 'connect.php';

    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $username = $_POST['username'];
    $lozinka = $_POST['pass'];
    $hashed_password = password_hash($lozinka, CRYPT_BLOWFISH);
    $razina = 0;
    $registriranKorisnik = '';
    //Provjera postoji li u bazi već korisnik s tim korisničkim imenom
    $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    }   
    if(mysqli_stmt_num_rows($stmt) > 0){
        $msg='Korisničko ime već postoji!';
    }else{
    // Ako ne postoji korisnik s tim korisničkim imenom - Registracija korisnika u bazi pazeći na SQL injection
        $sql = "INSERT INTO korisnik (ime, prezime,korisnicko_ime, lozinka, razina)VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ssssd', $ime, $prezime, $username, $hashed_password, $razina);
            mysqli_stmt_execute($stmt);
            $registriranKorisnik = true;
        }
    }
    mysqli_close($dbc);
?>
<?php
    include 'connect.php';
    //Registracija je prošla uspješno
    if($registriranKorisnik == true) {
        echo '<p>Korisnik je uspješno registriran!</p>';
    } else {
    //registracija nije protekla uspješno ili je korisnik prvi put došao nastranicu
?>
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
                    </ul>
                </nav>
            </div>
        </header>
        <section class="container forma">
            <form enctype="multipart/form-data" action="" method="POST">
                <div class="form-item">
                    <span id="porukaIme" class="bojaPoruke"></span>
                    <label for="title">Ime: </label>
                    <div class="form-field">
                        <input type="text" name="ime" id="ime" class="form-field-textual">
                    </div>
                </div>
                <div class="form-item">
                    <span id="porukaPrezime" class="bojaPoruke"></span>
                    <label for="about">Prezime: </label>
                    <div class="form-field">
                        <input type="text" name="prezime" id="prezime" class="form-field-textual">
                    </div>
                </div>
                <div class="form-item">
                    <span id="porukaUsername" class="bojaPoruke"></span>
                    <label for="content">Korisničko ime:</label>
                    <div class="form-field">
                        <?php 
                            echo '<br><span class="bojaPoruke">'.$msg.'</span>'; 
                        ?>
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
                    <span id="porukaPassRep" class="bojaPoruke"></span>
                    <label for="pphoto">Ponovite lozinku: </label>
                    <div class="form-field">
                        <input type="password" name="passRep" id="passRep" class="form-field-textual">
                    </div>
                </div>
                <div class="form-item">
                    <button type="submit" value="Prijava" id="slanje">Registracija</button>
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
        // Ime korisnika mora biti uneseno
        var poljeIme = document.getElementById("ime");
        var ime = document.getElementById("ime").value;
        if (ime.length == 0) {
            slanjeForme = false;
            poljeIme.style.border="1px dashed red";
            document.getElementById("porukaIme").innerHTML="<br>Unesite ime!<br>";
        } else {
            poljeIme.style.border="1px solid green";
            document.getElementById("porukaIme").innerHTML="";
        }
        // Prezime korisnika mora biti uneseno
        var poljePrezime = document.getElementById("prezime");
        var prezime = document.getElementById("prezime").value;
        if (prezime.length == 0) {
            slanjeForme = false;
            poljePrezime.style.border="1px dashed red";
            document.getElementById("porukaPrezime").innerHTML="<br>Unesite Prezime!<br>";
        } else {
            poljePrezime.style.border="1px solid green";
            document.getElementById("porukaPrezime").innerHTML="";
        }
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
        var poljePassRep = document.getElementById("passRep");
        var passRep = document.getElementById("passRep").value;
        if (pass.length == 0 || passRep.length == 0 || pass != passRep) {
            slanjeForme = false;
            poljePass.style.border="1px dashed red";
            poljePassRep.style.border="1px dashed red";
            document.getElementById("porukaPass").innerHTML="<br>Lozinke nisu iste!<br>";
            document.getElementById("porukaPassRep").innerHTML="<br>Lozinke nisu iste!<br>";
        } else {
            poljePass.style.border="1px solid green";
            poljePassRep.style.border="1px solid green";
            document.getElementById("porukaPass").innerHTML="";
            document.getElementById("porukaPassRep").innerHTML="";
        }
        if (slanjeForme != true) {
            event.preventDefault();
        }
    };
</script>
<?php
    }
?>