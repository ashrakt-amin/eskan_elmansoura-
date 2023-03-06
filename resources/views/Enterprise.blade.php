<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eskan Elmansoura</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style1.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,700;1,200;1,300;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">
</head>
<body>
    <section class="header">
        <nav>
            <a href=""><img src="{{asset('assets/images/logo.png')}}" alt=""></a>
            <div class="nav-links" id="navLinks">
                <i class="fa fa-times" onclick="hideMenu()"></i>

                <ul>
                    <li><a href="">HOME</a></li>
                    <li><a href="">ABOUT</a></li>
                    <li><a href="">CONTACT</a></li>
                </ul>
            </div>
            <i class="fa fa-bars" onclick="showMenu()"></i>

        </nav>
        <div class="text-box">
            <h1>Enterprise for Projects Management</h1>
            <p>Projects needed you care what are dependences to be in the top in this world now.
                 you just need to call us<br>phone
                   
            </p>
            <a href="{{ url('index') }}" class="hero-btn">Eskan Elmansoura</a>
        </div>

    </section>


    <!-- javascript for toggle menu -->

    <script>
        var navLinks = document.getElementById("navLinks");
        function showMenu(){
            navLinks.style.right = "0";
        }
        function hideMenu(){
            navLinks.style.right = "-200px";
        }
    </script>


</body>
</html>