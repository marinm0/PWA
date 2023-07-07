
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

            $clanak=$_GET['id'];
            $query = "SELECT * FROM vijesti WHERE id=$clanak";
            $result = mysqli_query($dbc, $query);
            echo '<section class="container">';
            echo '<div class="row sport">';
            echo'<h2 class="prvi col-12">Berlin-sport ></h2>';
            while($row = mysqli_fetch_array($result)) {
                echo '<article class="col-12">';
                echo '<p>';
                echo $row['vijest'];
                echo '</p>';
                echo '<img class="col-12" alt="" src="'.UPLPATH. $row['slika'].'">';
                echo '<p>';
                echo $row['sadrzaj'];
                echo '</p>';
                echo '</article>';
            }
            echo '</div>';
            echo '</section>'  
        ?>
        <br>
        <footer class="container-fluid">
            <div class="container zadnje">
                <p>Weitere Online-Angebote der Axel Springer SE:</p>
            </div>
        </footer>
    </body>
</html>