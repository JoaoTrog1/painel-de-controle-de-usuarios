<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Painel</title>
    @yield('css')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex flex-col  bg-gray-100">
    <header class="w-full p-4 flex bg-blue-600 text-white items-center">
        <h1 class="text-xl flex flex-grow">Painel ADMIN</h1>
        @yield('actionheader')
    </header >

    <main class="w-full flex flex-grow">
        @yield('conteudo')
    </main>

    <footer class="w-full flex justify-center">
        <p>ByJMZ</p>
    </footer>
</body>
</html>