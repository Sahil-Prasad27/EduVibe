<?php
session_start();



if (!isset($_SESSION['user_name'])) {
    header('location:login.php');
    exit();
}
@include 'config.php'; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .card {
            perspective: 1000px;
        }

        .card-inner {
            transition: transform 0.5s;
            transform-style: preserve-3d;
        }

        .card:hover .card-inner {
            transform: rotateY(180deg);
        }

        .card-front,
        .card-back {
            backface-visibility: hidden;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .card-back {
            transform: rotateY(180deg);
        }

        .animate-bounce {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(-10px);
            }

            50% {
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 font-sans">
<header class="flex justify-between items-center p-5 absolute top-0 left-0 right-0 bg-transparent text-black">
      <div class="text-3xl font-bold">Contact Us
      </div>
      <nav class="hidden md:flex space-x-8">
      
        <a href="user.php" class="hover:text-custom-red">Back</a>
         
        
      </nav>
      <div class="md:hidden text-3xl cursor-pointer">
         <ion-icon name="menu" onclick="toggleMenu()"></ion-icon>
      </div>
   </header>

   

    <main class="container mx-auto p-8 mt-[75px]">
        <section class="flex flex-col md:flex-row items-center justify-center space-y-8 md:space-y-0 md:space-x-8">

            <div class="card w-80 h-80 bg-white rounded-lg shadow-lg relative card">
                <div class="card-inner relative w-full h-full">
                    <div class="card-front absolute inset-0 bg-blue-500 rounded-lg flex items-center justify-center text-white">
                        <h2 class="text-xl font-semibold">Reach Out</h2>
                    </div>
                    <div class="card-back absolute inset-0 bg-blue-700 rounded-lg flex items-center justify-center text-white">
                        <p class="text-lg">We'd love to hear from you!</p>
                    </div>
                </div>
            </div>

            <form class="w-full max-w-lg bg-white rounded-lg shadow-lg p-8">
                <h1 class="text-xl font-bold mb-2">Address</h1>
                <p class="text-gray-800 font-semibold mb-4">Ravangla South Sikkim</p>

                <h1 class="text-xl font-bold mb-2">Phone No</h1>
                <p class="text-gray-800 font-semibold mb-4">+91 6734512827</p>

                <h1 class="text-xl font-bold mb-2">Email</h1>
                <p class="text-gray-800 font-semibold">B220027@nitsikkim.ac.in</p>
                <p class="text-gray-800 font-semibold">B220030@nitsikkim.ac.in</p>
                <p class="text-gray-800 font-semibold">B220022@nitsikkim.ac.in</p>
                <p class="text-gray-800 font-semibold">B220126@nitsikkim.ac.in</p>
                <p class="text-gray-800 font-semibold">B220132@nitsikkim.ac.in</p>
                <p class="text-gray-800 font-semibold">B220065@nitsikkim.ac.in</p>
            </form>

        </section>
    </main>

</body>

</html>