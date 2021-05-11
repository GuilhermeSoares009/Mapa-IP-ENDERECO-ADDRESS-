<?php

    require_once 'api/config/config.php';
    require_once 'api/modules/keyApi.php';
    
    $k = new KEYAPI(chave);
    
    $local = $k->country();
    if(!empty($_GET['ip']))
    {
         $ip = $_GET['ip'];
         $k->pegarip($ip);
    }else{
       $ip = $local['ip'];
    }
    
    $lat = $local['location']['lat'];
    $lng = $local['location']['lng'];
    $cidade = $local['location']['city'];
    $região = $local['location']['region'];
    $timezone = $local['location']['timezone'];
    //Endereço padrão
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/estilo.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
  <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin="">
   

   </script>
</head>
<body>
    <section id="principal">

        <!--Topo-->
        <div id="topo">
            <header>
            <h1>Ip Address Tracker</h1>
            <div>
                <form method="GET" action="">
                <input type="text" placeholder="0.0.0.0" name="ip" id="IP" >
                <button id="seta"  onclick="pegaIp()"> <img src="img/icon-arrow.svg" alt="imagem de seta"></button>
                </form>
            </div>

            </header>
        </div>
        
        <div  id="info">
            <div class="espaco">
                <h2 class="titulos">IP ADRESS</h2>
                <p class="conteudo"><?php echo $ip;?></p>
            </div>

            <div class="linha"></div>

            <div  class="espaco">
                <h2 class="titulos">LOCATION</h2>
                <p class="conteudo"><?php echo $cidade.",".$região;?></p>
            </div  class="espaco">

            <div class="linha"></div>

            <div  class="espaco">
                 <h2 class="titulos">TIMEZONE</h2>
                <p class="conteudo"><?php echo $timezone; ?></p>
            </div>

            <div class="linha"></div>

            <div  class="espaco">  
                <h2 class="titulos">ISP</h2>
                <p class="conteudo"><?php echo $ip; ?>
                </p>
            </div>
        </div>
        
        <div id="mapid"></div>


</section>
    <script>

    var mymap = L.map('mapid').setView([<?php echo($lat);?>, <?php echo($lng);?>], 18);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(mymap);

L.marker([<?php echo $lat;?>, <?php echo $lng;?>]).addTo(mymap)
    .bindPopup('Você esta aqui!')
    .openPopup();

    </script>
</body>
</html>