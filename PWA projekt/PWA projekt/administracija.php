<?php
    $uspjesnaPrijava = false;
    session_start();
    include 'connect.php';
    define('UPLPATH', 'img/');

    if (isset($_POST['prijava'])) {
        // Provjera da li korisnik postoji u bazi uz zaštitu od SQL injectiona
        $prijavaImeKorisnika = $_POST['username'];
        $prijavaLozinkaKorisnika = $_POST['pass'];
        $sql = "SELECT korisnicko, sifra, razina FROM korisnik WHERE korisnicko = ?";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $prijavaImeKorisnika);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
        }

        mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika);
        mysqli_stmt_fetch($stmt);

        //Provjera lozinke
        if (password_verify($_POST['pass'], $lozinkaKorisnika) && mysqli_stmt_num_rows($stmt) > 0) {
            $uspjesnaPrijava = true;

            // Provjera da li je admin
            if($levelKorisnika == 1) {
                $admin = true;
            }
            else {
                $admin = false;
            }
            
            //postavljanje session varijabli
            $_SESSION['username'] = $imeKorisnika;
            $_SESSION['razina'] = $levelKorisnika;
        }
        else {
            $uspjesnaPrijava = false;
        }
    }
    if (($uspjesnaPrijava == true && $admin == true) || (isset($_SESSION['username'])) && $_SESSION['razina'] == 1) {
                        
        $query = "SELECT * FROM vijesti";
        $result = mysqli_query($dbc, $query);
        while($row = mysqli_fetch_array($result)) {
            echo '<form enctype="multipart/form-data" action="skripta.php" method="POST">
                    <div class="form-item">
                        <label for="title">Naslov vjesti:</label>
                        <input type="text" name="title" class="form-field-textual" value="'.$row['naslov'].'">
                    </div>
                    <div class="form-item">
                        <label for="about">Kratki sadržaj vijesti:</label>
                        <div class="form-field">
                            <textarea name="about" id="" cols="50" rows="10" class="form-field-textual">'.$row['vijest'].'</textarea>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="content">Sadržaj vijesti:</label>
                        <div class="form-field">
                            <textarea name="content" id="" cols="50" rows="10" class="form-field-textual">'.$row['sadrzaj'].'</textarea>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="category">Kategorija vijesti:</label>
                        <select name="category" id="" class="form-field-textual" value="'.$row['kategorija'].'">
                            <option value="sport">Sport</option>
                            <option value="kultura">Kultura</option>
                        </select>
                    </div>
                    <div class="form-item">
                        <label for="pphoto">Slika:</label>
                        <input type="file" class="input-text" id="picture" name="picture" value="'.$row['slika'].'"/> <br><img src="' . UPLPATH . $row['slika'] . '" width=100px> 
                    </div>
                    <div class="form-item">
                        <label>Spremiti u arhivu:
                    <div class="form-field">';
                        if($row['arhiva'] == 0) {
                            echo '<input type="checkbox" name="archive" id="archive"/>
                            Arhiviraj?';
                        } else {
                            echo '<input type="checkbox" name="archive" id="archive"
                            checked/> Arhiviraj?';
                        }
                            echo '</div>
                        </label>
                    </div>
                    </div>
                    <div class="form-item">
                        <input type="hidden" name="id" class="form-field-textual" value="'.$row['id'].'">
                        <button type="reset" value="Poništi">Poništi</button>
                        <button type="submit" name="update" value="Prihvati">
                        Izmjeni</button>
                        <button type="submit" name="delete" value="Izbriši">
                        Izbriši</button>
                    </div>
                </form>';
        }        
        
        if(isset($_POST['delete'])){
            $id=$_POST['id'];
            $query = "DELETE FROM vijesti WHERE id=$id ";
            $result = mysqli_query($dbc, $query);
        }

        if(isset($_POST['update'])){
            $picture = $_FILES['picture']['name'];
            $title=$_POST['title'];
            $about=$_POST['about'];
            $content=$_POST['content'];
            $category=$_POST['category'];
            if(isset($_POST['arhiva'])){
                $arhiva=1;
            }else{
                $arhiva=0;
            }
            $target_dir = 'img/'.$picture;
            move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir);
            $id=$_POST['id'];
            $query = "UPDATE vijesti SET naslov='$title', vijest='$about', sadrzaj='$content', slika='$picture', kategorija='$category', arhiva='$arhiva' WHERE id=$id ";
            $result = mysqli_query($dbc, $query);
        }
        mysqli_close($dbc);
        // Pokaži poruku da je korisnik uspješno prijavljen, ali nije administrator
        }else if ($uspjesnaPrijava == true && $admin == false) {
            echo '<p>Bok ' . $imeKorisnika . '! Uspješno ste prijavljeni, ali niste administrator.</p>';
        }else if (isset($_SESSION['$username']) && $_SESSION['$level'] == 0) {
            echo '<p>Bok ' . $_SESSION['$username'] . '! Uspješno ste prijavljeni, ali niste administrator.</p>';
        }else if ($uspjesnaPrijava == false) {
        echo '<section class="container forma">
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
    </script>';
    }
?>