<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="shortcut icon" href="assets/images/favicon.ico"> -->
    <title>Laravel</title>
    <!-- App css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet"  />
    <link href="/assets/css/app.min.css" rel="stylesheet"  id="app-style" />
    <!-- Fonts
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    -->
    <style>
        /* body {
            font-family: 'Nunito', sans-serif;
        } */
        [v-cloak]>* {
            display: none
        }

        [v-cloak]::before {
            content: "Loading…"
        }
    </style>
    
    <script defer src="/assets/js/vendor.min.js" ></script>
    <script defer src="/assets/js/app.min.js" ></script>
    @vite(['resources/js/app.js'])
</head>
<body class="loading" data-layout-color="light" data-leftbar-theme="dark" data-layout-mode="fluid" data-rightbar-onstart="true">
    <div id="app" v-cloak>
    </div>
</body>
<script>
   
</script>
</html>