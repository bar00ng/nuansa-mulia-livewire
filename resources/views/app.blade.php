<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/" />

    <title>{{ $title ?? 'Page Title' }}</title>

    <link href="/assets/css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    @vite(['resources/js/app.js', 'resources/css/app.css'])

    @stack('style')
</head>

<body>
    <div class="wrapper">

        <x-sidebar />

        <div class="main">
            <x-topbar />

            <main class="content">
                <div class="container-fluid p-0">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <script src="/assets/js/app.js"></script>

    @stack('scripts')
</body>

</html>
