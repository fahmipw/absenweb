<?php include __DIR__ . "/../title.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />

    <title><?= $judul ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Import Mapbox GL JS -->
    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v2.9.2/mapbox-gl.js"></script>
    <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v2.9.2/mapbox-gl.css" rel="stylesheet" />

    <!-- Import Mapbox GL Directions -->
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.css" type="text/css" />

    <!-- Import Turf & Polyline -->
    <script src="https://npmcdn.com/@turf/turf/turf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mapbox-polyline/1.1.1/polyline.js"></script>

</head>

<body>

    <?php include($content . ".php"); ?>

</body>

</html>