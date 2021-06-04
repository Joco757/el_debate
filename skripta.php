<?php
include 'connect.php';

if($dbc){
    if ($_POST['naslov'] != '' && $_POST['kratkisadrzaj'] != '' && $_POST['sadrzaj'] != '' ){
        $naslov=$_POST['naslov'];
        $kratkisadrzaj=$_POST['kratkisadrzaj'];
        $sadrzaj=$_POST['sadrzaj'];
        $kategorija=$_POST['kategorija'];
        $datum=date('d.m.Y.');
        $slika = $_FILES['slika']['name'];
        if (isset($_POST['arhiva'])){
            $arhiva = 1;
        } else {
            $arhiva = 0;
        }
        $dir = 'slike/'.$slika;
        move_uploaded_file($_FILES["slika"]["tmp_name"], $dir);
        $query = "INSERT INTO vijest (datum, naslov, sazetak, sadrzaj, slika, kategorija,
        arhiva ) VALUES ('$datum', '$naslov', '$kratkisadrzaj', '$sadrzaj', '$slika',
        '$kategorija', '$arhiva')";
        $result = mysqli_query($dbc, $query) or die('Error querying database.');

        echo "<head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' type='text/css' href='style.css'>
            <link rel='icon' href='https://assets.debate.com.mx/__export/1513187264000/sites/debate/arte/el-debate/apps/favicon.png_2040392579.png'>
            <title>$naslov</title>
        </head>
        <body>
            <header>
                <img src='https://assets.debate.com.mx/__export/1508771766000/sites/debate/arte/el-debate/logo-blanco.svg'>
                <nav>
                    <ul>
                        <li><a href='index.php'>HOME</a></li>
                        <li><a href='kategorija.php?id=politika'>POLITIKA</a></li>
                        <li><a href='kategorija.php?id=sport'>SPORT</a></li>
                        <li><a href='unos.html' class='active'>UNOS</a></li>
                        <li><a href='administracija.html'>ADMINISTRACIJA</a></li>
                        <li><a href='registracija.html'>REGISTRACIJA</a></li>
                    </ul>
                </nav>
            </header>
            <section class='clanak'>
                <h5 class='h6gore'>$kategorija</h5>
                <h1>$naslov</h1>
                <p>$kratkisadrzaj</p>
                <p>$datum</p>
            </section>
            <img src='$dir' class='slikaclanka'>
            <section class='clanakdolje'>
                <p>$sadrzaj</p>
            </section>
            <footer>
                <div class='gore'></div>
                <div class='dolje'>
                    © Copyright EL DEBATE. Todos los derechos reservados.
                </div>
            </footer>
        </body>";
    } else {
        echo "<head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' type='text/css' href='style.css'>
            <link rel='icon' href='https://assets.debate.com.mx/__export/1513187264000/sites/debate/arte/el-debate/apps/favicon.png_2040392579.png'>
            <title>Error</title>
        </head>
        <body>
            <header>
                <img src='https://assets.debate.com.mx/__export/1508771766000/sites/debate/arte/el-debate/logo-blanco.svg'>
                <nav>
                    <ul>
                        <li><a href='index.php'>HOME</a></li>
                        <li><a href='kategorija.php?id=politika'>POLITIKA</a></li>
                        <li><a href='kategorija.php?id=sport'>SPORT</a></li>
                        <li><a href='unos.html' class='active'>UNOS</a></li>
                        <li><a href='administracija.html'>ADMINISTRACIJA</a></li>
                        <li><a href='registracija.html'>REGISTRACIJA</a></li>
                    </ul>
                </nav>
            </header>
            <section class='clanak'>
                <h1 style='padding-top:50px;'>Niste unijeli sve potrebne podatke!</h1>
            </section>
            <footer style='position: absolute; bottom: 0; width:100%;'>
                <div class='gore'></div>
                <div class='dolje'>
                    © Copyright EL DEBATE. Todos los derechos reservados.
                </div>
            </footer>
        </body>";
    }

    mysqli_close($dbc);
}
?>