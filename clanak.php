<?php
include 'connect.php';
$id = $_GET['id'];
$query = "SELECT * FROM vijest WHERE id='$id'";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' type='text/css' href='style.css'>
    <link rel='icon' href='https://assets.debate.com.mx/__export/1513187264000/sites/debate/arte/el-debate/apps/favicon.png_2040392579.png'>
    <title><?php echo $row['naslov']; ?></title>
</head>
<body>
    <header>
        <img src='https://assets.debate.com.mx/__export/1508771766000/sites/debate/arte/el-debate/logo-blanco.svg'>
        <nav>
            <ul>
                <li><a href='index.php'>HOME</a></li>
                <li><a href='kategorija.php?id=politika'>POLITIKA</a></li>
                <li><a href='kategorija.php?id=sport'>SPORT</a></li>
                <li><a href='unos.html'>UNOS</a></li>
                <li><a href='administracija.html'>ADMINISTRACIJA</a></li>
                <li><a href="registracija.html">REGISTRACIJA</a></li>
            </ul>
        </nav>
    </header>
    <section class='clanak'>
        <h5 class='h6gore'><?php echo $row['kategorija']; ?></h5>
        <h1><?php echo $row['naslov']; ?></h1>
        <p><?php echo $row['sazetak']; ?></p>
        <p><?php echo $row['datum']; ?></p>
    </section>
    <img src='slike/<?php echo $row['slika']; ?>' class='slikaclanka'>
    <section class='clanakdolje'>
        <p><?php echo $row['sadrzaj']; ?></p>
    </section>
    <footer>
        <div class='gore'></div>
        <div class='dolje'>
            © Copyright EL DEBATE. Todos los derechos reservados.
        </div>
    </footer>
</body>
</html>