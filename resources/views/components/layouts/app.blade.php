<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'My App' }}</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body>
    <div class="container mx-auto py-8">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
