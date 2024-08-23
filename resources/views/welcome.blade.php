<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BotMan Demo Integration</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .hero {
            background-color: #007bffa1;
            color: #fff;
            padding: 60px 20px;
            text-align: center;
            border-bottom: 5px #007bffa1;
        }

        .hero h1 {
            font-size: 2.5rem;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .section {
            padding: 204px 20px;
            text-align: center;
        }

        .section h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .section p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .contact-info a {
            color: #007bff;
            text-decoration: none;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 15px;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        .btn-primary-custom {
            background-color: #007bff;
            border: none;
        }

        .btn-primary-custom:hover {
            background-color: #0056b3;
        }

        .list-unstyled {
            background-color: #ebe8e8a1 !important;
            border-radius: 90px;
        }

        @media screen and (max-width: 768px) {
            .list-unstyled {
                border-radius: 25px;
            }
        }
    </style>
</head>

<body>

    <!-- Hero Section -->
    <div class="hero">
        <div class="container">
            <h1>Welcome to the Demo Integration of BotMan</h1>
            <p>Powered by @VismayOza</p>
        </div>
    </div>

    <!-- About Section -->
    <div id="about" class="section">
        <div class="container">
            <h2>The questions you can ask to our ChaBot/Botman</h2>
            <p>This demo showcases the integration of BotMan, a PHP framework for building chatbots. Key
                features/questions
                that I have included:</p>
            <ul class="list-unstyled">
                <li><strong>Start a Conversation:</strong> Say <code>Hi</code> or <code>Hello</code> (or even
                    <code>HELLO</code> or <code>HI</code>) to kick things off.
                </li>
                <li><strong>Explore Ahmedabad:</strong> Ask for recommendations on <code>places to visit</code> in
                    Ahmedabad.</li>
                <li><strong>Get Market Insights:</strong> Inquire about the <code>stock market</code> basic
                    details.</li>
                <li><strong>Learn About India:</strong> Request a brief <code>description of India</code>.</li>
                <li><strong>Find Out the Creator:</strong> Discover who <code>developed this BotMan chatbot</code>.</li>
                <li><strong>Map Your Location:</strong> Follow the process by typing <code>'you first'</code>, after
                    <code>Hi/Hello</code> to get your address on the map.
                </li>
            </ul>
        </div>
    </div>


    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 BotMan Demo Powered by @VismayOza. No rights reserved.</p>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="{{ asset('assets/js/jquery-3.5.1.slim.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</body>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chat.min.css') }}">

@php
    $isLocal = request()->getHost() == 'localhost';
    $botmanUrl = $isLocal ? url('/botman') : '';
    $botmanFrame = $isLocal ? url('/botman/chat') : '';
@endphp

<script>
    // Check if botmanFrame and botmanUrl are not empty strings
    if ("{{ $botmanFrame }}" !== "" && "{{ $botmanUrl }}" !== "") {
        var botmanWidget = {
            frameEndpoint: "{{ $botmanFrame }}",
            chatServer: "{{ $botmanUrl }}",
            aboutText: 'Reference :- devtechnosys.ae',
            introMessage: "✋ Hi! I'm Vismay Oza's Chatbot",
        };
    } else {
        var botmanWidget = {
            aboutText: 'Reference :- devtechnosys.ae',
            introMessage: "✋ Hi! I'm Vismay Oza's Chatbot",
        };
    }
</script>


<script src='{{ asset('assets/js/widget.js') }}'></script>

</html>
