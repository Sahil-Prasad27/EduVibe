<?php
session_start();
@include 'config.php';


if (isset($_POST['submit'])) {
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   
   $select = "SELECT * FROM user WHERE email = '$email' AND password = '$pass'";
   $result = mysqli_query($conn, $select);

   if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_array($result);
      if ($row['type'] == 'admin') {
         $_SESSION['admin_name'] = $row['name'];
         header('location:admin.php');
      } elseif ($row['type'] == 'user') {
         $_SESSION['user_name'] = $row['email'];
         header('location:user.php');
      }
   } else {
      $error[] = 'Incorrect email or password!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>
   <script src="https://cdn.tailwindcss.com"></script>
   <script>
      tailwind.config = {
         theme: {
            extend: {
               colors: {
                  'custom-red': '#FF6363',
                  'custom-dark': '#1F2937',
               },
               screens: {
                  xs: "320px",
                  sm: "640px",
                  md: "768px",
                  lg: "1024px",
                  xl: "1280px",
                  "2xl": "1536px",
               },
            }
         }
      }
   </script>
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
   <style>
      body {
         font-family: "Poppins", sans-serif;
         margin: 0;
         padding: 0;
         height: 100vh;
         display: flex;
         justify-content: center;
         align-items: center;
         background-image: url('image/beautiful.jpg');
         background-size: cover;
         background-position: center;
         background-repeat: no-repeat;
      }
   </style>
</head>

<body>
   <header class="flex justify-between items-center p-5 absolute top-0 left-0 right-0 bg-transparent text-white">
      <div class="text-3xl font-bold">
         <span class="text-custom-red">Edu</span>Vibe
      </div>
      <nav class="hidden md:flex space-x-8">
         <a href="index.php" class="hover:text-custom-red">Home</a>
         <a href="login.php" class="hover:text-custom-red">Feedback</a>
         <a href="login.php" class="hover:text-custom-red">About Us</a>
      </nav>
      <div class="md:hidden text-3xl cursor-pointer">
         <ion-icon name="menu" onclick="toggleMenu()"></ion-icon>
      </div>
   </header>

   <nav id="mobileMenu" class="hidden absolute top-0 left-0 w-full bg-custom-dark text-white p-5 flex flex-col space-y-4">
      <a href="index.php" class="hover:text-custom-red">Home</a>
      <a href="login.php" class="hover:text-custom-red">Feedback</a>
      <a href="login.php" class="hover:text-custom-red">About Us</a>
   </nav>

   <script>
      function toggleMenu() {
         const menu = document.getElementById('mobileMenu');
         menu.classList.toggle('hidden');
      }
   </script>

   <div class="flex flex-col justify-center items-center h-full">
      <form class="bg-custom-dark bg-opacity-60 p-10 rounded-lg shadow-lg max-w-md w-full" action="" method="post" style="margin-top: -50px;">
         <h3 class="text-4xl font-bold text-white mb-8"><span class="text-custom-red">Login</span> Now</h3>
         <?php
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<div class="bg-red-500 text-white p-3 rounded mb-4">' . $error . '</div>';
            }
         }
         ?>
         <div class="mb-6">
            <input class="w-full p-4 rounded bg-transparent border border-gray-400 placeholder-gray-300 text-white focus:outline-none focus:border-custom-red" type="email" name="email" required placeholder="Enter your email">
         </div>
         <div class="mb-6">
            <input class="w-full p-4 rounded bg-transparent border border-gray-400 placeholder-gray-300 text-white focus:outline-none focus:border-custom-red" type="password" name="password" required placeholder="Enter your password">
         </div >
         <input class="ml-[86px] bg-custom-red hover:bg-red-700 text-white font-bold py-3 px-6 rounded cursor-pointer" type="submit" name="submit" value="Login Now">
        
         <p class="ml-[42px] text-white text-sm">Don't have an account? <a href="register.php" class="text-custom-red hover:underline">Register now</a></p>
         
      </form>
   </div>
</body>

</html>
