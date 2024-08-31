<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}

include 'config.php'; 

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';


$query = "SELECT * FROM book";
if ($search) {
    $query .= " WHERE book_name LIKE '%$search%'";
}
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-gray-100 text-black">
<header class="flex justify-between items-center p-5 absolute top-0 left-0 right-0 bg-transparent text-black">
    <div class="text-3xl font-bold">Resource</div>
    <nav class="hidden md:flex space-x-8">
        <a href="user.php" class="hover:text-custom-red">Back</a>
        <a href="login.php" class="hover:text-custom-red">Contact Us</a>
    </nav>
    <div class="md:hidden text-3xl cursor-pointer">
        <ion-icon name="menu" onclick="toggleMenu()"></ion-icon>
    </div>
</header>

<main class="p-4 bg-blue-100 mt-16">
    
    <div class="mb-4">
        <form action="" method="GET" class="flex">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by book name..." class="p-2 border border-gray-300 rounded-l-lg w-full">
            <button type="submit" class="bg-blue-500 text-white p-2 rounded-r-lg">Search</button>
        </form>
    </div>

    <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="bg-white border border-gray-300 rounded-lg overflow-hidden text-center p-4 shadow-md">
                <a href="uploads/<?php echo htmlspecialchars($row['book_file']); ?>">
                    <?php $image = !empty($row['image']) ? htmlspecialchars($row['image']) : '/images/default-book-cover.jpg'; ?>
                    <img class="w-full h-[300px] object-cover border-b border-gray-300" src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($row['book_name']); ?>">
                </a>
                <h2 class="text-xl font-semibold mt-2"><?php echo htmlspecialchars($row['book_name']); ?></h2>
            </div>
        <?php endwhile; ?>
    </section>
</main>

</body>
</html>
