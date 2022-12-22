<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <title>
        <?php echo NAME_PROJECT ?>
    </title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .container {
            height: 100vh;
            position: relative;
            font-family: 'Roboto', sans-serif;
            text-align: center;
        }

        .container p {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-right: -50%;
            transform: translate(-50%, -50%);
        }

        span {
            font-size: 10rem;
            display: block;
            color: #1d1c1e;
        }

        a {
            display: bl;
            text-decoration: none;
            font-size: 1rem;
            color: black;
            padding: 10px;
            border-radius: 10px;
            border: 4px solid #1d1c1e;
            transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
            -moz-transition: all .2s ease-in-out;
            -webkit-transition: all .2s ease-in-out;
        }

        a:hover {
            background-color: #1d1c1e;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <p>
            <span class="erro-404">404</span>
            <a href="<?php echo BASE_URL ?>">Página Inicial</a>
        </p>
    </div>
</body>

</html>