<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <meta name="description"
        content="Undangan Pernikahan Christy Audy Valentine & Gideon Mula Gabe Sitorus — 12 Desember 2026">
    <title>Christy & Gideon — Wedding Invitation</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @include('guest.layout.partials.top.css')
    @include('guest.layout.partials.top.js')
</head>

<body id="pageBody" class="bg-ivory text-ink font-sans m-0 overflow-hidden pb-16">
    @yield('main')
    @include('Guest.Layout.Partials.Bottom.js')
</body>

</html>
