<?php
include 'connect.php';
define('UPLPATH', 'slike/');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="https://assets.debate.com.mx/__export/1513187264000/sites/debate/arte/el-debate/apps/favicon.png_2040392579.png">
    <title>El Debate</title>
</head>
<body>
    <header>
        <img src="https://assets.debate.com.mx/__export/1508771766000/sites/debate/arte/el-debate/logo-blanco.svg">
        <nav>
            <ul>
                <li><a href="index.php" class="active">HOME</a></li>
                <li><a href="kategorija.php?id=politika">POLITIKA</a></li>
                <li><a href="kategorija.php?id=sport">SPORT</a></li>
                <li><a href="unos.html">UNOS</a></li>
                <li><a href="administracija.html">ADMINISTRACIJA</a></li>
                <li><a href="registracija.html">REGISTRACIJA</a></li>
            </ul>
        </nav>
    </header>
    <section class="sec">
        <img src="slike/kocke.png" class="kocke">
        <h3 class="main">POLITIKA</h3>
        <?php
            $query = "SELECT * FROM vijest WHERE arhiva=0 AND kategorija='politika' LIMIT 4";
            $result = mysqli_query($dbc, $query);
            while($row = mysqli_fetch_array($result)) {
                echo '<article>';
                echo '<img class="img" src="' . UPLPATH . $row['slika'] . '">';
                echo '<h6 class="h6gore">';
                echo $row['kategorija'];
                echo '</h6>';
                echo '<h3>';
                echo '<a href="clanak.php?id='.$row['id'].'">';
                echo $row['naslov'];
                echo '</a></h3>';
                echo '</article>';
            }
        ?>
    </section>
    <hr>
    <section class="sec">
        <img src="slike/kocke.png" class="kocke">
        <h3 class="main">SPORT</h3>
        <?php
            $query = "SELECT * FROM vijest WHERE arhiva=0 AND kategorija='sport' LIMIT 4";
            $result = mysqli_query($dbc, $query);
            while($row = mysqli_fetch_array($result)) {
                echo '<article>';
                echo '<img class="img" src="' . UPLPATH . $row['slika'] . '">';
                echo '<h6 class="h6gore">';
                echo $row['kategorija'];
                echo '</h6>';
                echo '<h3>';
                echo '<a href="clanak.php?id='.$row['id'].'">';
                echo $row['naslov'];
                echo '</a></h3>';
                echo '</article>';
            }
        ?>
    </section>
    <hr>
    <footer>
        <div class="gore"></div>
        <div class="dolje">
            © Copyright EL DEBATE. Todos los derechos reservados.
        </div>
    </footer>
</body>
</html>