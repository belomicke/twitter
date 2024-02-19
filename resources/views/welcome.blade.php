<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0,viewport-fit=cover"
    >
    <title>X</title>

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    />

    <link rel="shortcut icon" href="//abs.twimg.com/favicons/twitter.3.ico">

    @vite('resources/js/app.js')
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
</head>
<body>
<div id="portals"></div>
<div id="app"></div>
</body>
</html>
