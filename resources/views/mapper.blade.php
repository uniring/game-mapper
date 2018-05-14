<!DOCTYPE html>
<html>
<head>
    <title>Game Mapper</title>

    <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <script src="https://openlayers.org/en/v4.6.5/build/ol.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
        html, body, #app {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: #010101;
            position: relative;
        }
        .panel {
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
        }
        .panel-body {
            padding: 5px;
        }
    </style>
</head>
<body>
    <div id="app">
        <map-panel></map-panel>
    </div>
</body>
<script src="{{asset('js/app.js')}}" ></script>
</html>
