<!doctype html>
<html>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BotMan Demo | Vismay Oza</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
    </style>

</head>

<body>
    <div class="container">
        <h1 style="text-align: center">Welcome to the Demo Integration of BotMan <br> Powered by @VismayOza!</h1>
    </div>
</body>

<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/css/chat.min.css') }}">

<script>
    var botmanWidget = {
        aboutText: 'Reference :- devtechnosys.ae',
        introMessage: "✋ Hi! I'm Vismay Oza's Chatbot",
    };
</script>

<script src='{{ asset('assets/js/widget.js') }}'></script>



</html>