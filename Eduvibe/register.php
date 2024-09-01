<?php
session_start();


@include 'config.php'; 



if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $mobile = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    if (strlen($pass) < 8) {
        $error[] = 'Password must be at least 8 characters long';
    } elseif ($pass !== $cpass) {
        $error[] = 'Passwords do not match';
    } else {
        $pass = md5($pass);

        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error[] = 'User already exists!';
        } else {
            $stmt = $conn->prepare("INSERT INTO user(name, password, gender, email, mobile, dob, type) VALUES(?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $name, $pass, $gender, $email, $mobile, $dob, $type);
            $stmt->execute();
            header('location:login.php');
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'custom-red': '#FF6363',
                        'custom-dark': '#1F2937',
                        'custom-blue': '#1E40AF'
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
            background-image: url('image/beautiful.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body>
    <header class="flex justify-between items-center p-5 bg-transparent text-white">
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

    <div class="flex items-center justify-center min-h-screen">
        <div class="flex flex-col justify-center items-center w-full max-w-xs mx-2 my-4">
            <form class="bg-custom-dark bg-opacity-60 p-6 rounded-lg shadow-lg w-full" action="" method="post">
                <h3 class="text-2xl font-semibold text-white mb-4 text-center"><span class="text-custom-red">Register</span> Now</h3>
                <?php
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo '<div class="bg-red-500 text-white p-2 rounded mb-4">' . $error . '</div>';
                    }
                }
                ?>
                <div class="mb-3">
                    <input class="w-full p-2 rounded bg-transparent border border-gray-400 placeholder-gray-300 text-white focus:outline-none focus:border-custom-red" type="text" name="name" required placeholder="Enter your name">
                </div>
                <div class="mb-3">
                    <input class="w-full p-2 rounded bg-transparent border border-gray-400 placeholder-gray-300 text-white focus:outline-none focus:border-custom-red" type="email" name="email" required placeholder="Enter your email">
                </div>
                <div class="mb-3">
                    <input class="w-full p-2 rounded bg-transparent border border-gray-400 placeholder-gray-300 text-white focus:outline-none focus:border-custom-red" type="date" name="dob" required placeholder="Enter your Date Of Birth">
                </div>
                <div class="mb-3">
                    <input class="w-full p-2 rounded bg-transparent border border-gray-400 placeholder-gray-300 text-white focus:outline-none focus:border-custom-red" type="tel" name="phone" required placeholder="Enter your mobile number">
                </div>
                <div class="mb-3">
                    <input class="w-full p-2 rounded bg-transparent border border-gray-400 placeholder-gray-300 text-white focus:outline-none focus:border-custom-red" type="password" name="password" required placeholder="Enter your password (min 8 characters)" pattern=".{8,}">
                </div>
                <div class="mb-3">
                    <input class="w-full p-2 rounded bg-transparent border border-gray-400 placeholder-gray-300 text-white focus:outline-none focus:border-custom-red" type="password" name="cpassword" required placeholder="Confirm your password" pattern=".{8,}">
                </div>
                <div class="mb-4">
                    <select name="gender" class="w-full p-2 rounded bg-transparent border border-gray-400 placeholder-gray-300 text-white focus:outline-none focus:border-custom-red">
                        <option class="text-black" value="Male">Male</option>
                        <option class="text-black" value="Female">Female</option>
                        <option class="text-black" value="no">Not to prefer</option>
                    </select>
                </div>
                <div class="mb-5">
                    <select name="type" class="w-full p-2 rounded bg-transparent border border-gray-400 placeholder-gray-300 text-white focus:outline-none focus:border-custom-red">
                        <option class="text-black" value="user">User</option>
                        <option class="text-black" value="admin">Admin</option>
                    </select>
                </div>
                <input class="bg-custom-red hover:bg-red-700 text-white font-semibold py-2 px-4 rounded cursor-pointer w-full" type="submit" name="submit" value="Register Now">
                <div class="mt-4 text-center">
                    <p class="text-white text-sm">Already have an account? <a href="login.php" class="text-custom-red hover:underline">Login Now</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

