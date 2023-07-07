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
        <section class="container">
        <?php
            include 'connect.php';
            define('UPLPATH', 'img/');
            
            $kategorija=$_GET['id'];
            $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='$kategorija'";
            $result = mysqli_query($dbc, $query);
            $i=0;
            echo '<div class="row sport">';
            echo '<h2 class="prvi col-12">';
            echo $kategorija;
            echo '</h2>';
            while($row = mysqli_fetch_array($result)) {
                echo '<article class="col-4">';
                echo '<img class="col-12" alt="" src="'.UPLPATH. $row['slika'].'">';
                echo '<h6>';
                echo '<a href="clanak.php?id='.$row['id'].'">';
                echo $row['naslov'];
                echo '</a></h6>';
                echo '<p>';
                echo $row['sadrzaj'];
                echo '</p>';
                echo '</article>';
            }
            echo '</div>';  
        ?>
        </section>
        <br>
        <footer class="container-fluid">
            <div class="container zadnje">
                <p>Weitere Online-Angebote der Axel Springer SE:</p>
            </div>
        </footer>
    </body>
</html>
