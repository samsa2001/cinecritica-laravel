<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vue</title>

</head>

<body>

    <!-- @if (auth()->check())
        <script>
            window.Laravel =
                {!! json_encode([
                    'isLoggedIn' => true,
                    'user' => auth()->user(),
                    'token' => session('token'),
                ]) !!}
        </script>
    @else
        <script>
            window.Laravel =
                {!! json_encode([
                    'isLoggedIn' => false,
                ]) !!}
        </script>
    @endif -->



    <div id="app"></div>


    @vite(['resources/js/vue/main.js'])


</body>

</html>