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
                        <li class="col-2"><a href="kategorija.php?ime=sport">Berlin-sport</a></li>
                        <li class="col-2"><a href="kategorija.php?ime=kultura">Kultur und show</a></li>
                        <li class="col-2 zadnji"><a href="administracija.php">Administracija</a></li>
                        <li class="col-2 zadnji"><a href="unos.html">Unos</a></li>
                        <li class="col-2 zadnji"><a href="login.php">Prijava</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <?php
            include 'connect.php';
            define('UPLPATH', 'img/');

            $query = "SELECT * FROM vijesti";
            $result = mysqli_query($dbc, $query);
            echo '<section class="container forma">';
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
            echo '</section>';

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
        ?>
        <input type="hidden" name="id" class="form-field-textual" value="'.$row['id'].'">
        <br>
        <footer class="container-fluid">
            <div class="container zadnje">
                <p>Weitere Online-Angebote der Axel Springer SE:</p>
            </div>
        </footer>
    </body>
</html>