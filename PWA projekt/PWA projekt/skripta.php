<?php
    include 'connect.php';

    $title=$_POST['title'];
    $about=$_POST['about'];
    $content=$_POST['content'];
    $category=$_POST['category'];
    $image=$_FILES['picture']['name'];

    if (isset($_POST['archive'])) {
        $arhiva=1;
    }else{
        $arhiva=0;
    }

    $target_dir = 'img/'.$image;
    move_uploaded_file($_FILES['picture']['tmp_name'], $target_dir);

    $query = "INSERT INTO vijesti (naslov, vijest, sadrzaj, kategorija, slika, arhiva) VALUES ('$title', '$about', '$content', '$category', '$image', '$arhiva')";

    $result = mysqli_query($dbc, $query) or die('Error connecting to MySQL server.'.mysqli_error($mysqli));

    if($result===TRUE){
        echo "\nA record has been inserted.";
    } else{
        echo "Could not insert record: %s\n",mysqli_error($mysqli);
    }

    mysqli_close($dbc);

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
                        <li class="col-2 zadnji"><a href="login.php">Prijava</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <footer class="container-fluid">
            <div class="container zadnje">
                <p>Weitere Online-Angebote der Axel Springer SE:</p>
            </div>
        </footer>
    </body>
</html>