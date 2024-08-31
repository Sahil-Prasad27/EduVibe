<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header('location:login.php');
    exit();
}
@include 'config.php';


$query = "SELECT sticker_id, name, cost, image_url FROM stickers";
$result = $conn->query($query);
if (!$result) {
    die("Error fetching stickers: " . $conn->error);
}
$stickers = $result->fetch_all(MYSQLI_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['redeem'])) {
    $sticker_id = $_POST['sticker_id'];
    $user_id = $_SESSION['user_id']; 

    $query = "SELECT cost FROM stickers WHERE sticker_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('i', $sticker_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $sticker = $result->fetch_assoc();

    if ($sticker) {
        $cost = $sticker['cost'];

       
        $query = "SELECT gold_coins FROM user WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && $user['gold_coins'] >= $cost) {
            
            $query = "UPDATE user SET gold_coins = gold_coins - ? WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param('ii', $cost, $user_id);
            $stmt->execute();

            $query = "INSERT INTO user_stickers (user_id, sticker_id) VALUES (?, ?)
                      ON DUPLICATE KEY UPDATE sticker_id = sticker_id";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param('ii', $user_id, $sticker_id);
            $stmt->execute();

            $message = 'Sticker redeemed successfully!';
        } else {
            $message = 'Not enough gold coins.';
        }
    } else {
        $message = 'Sticker not found.';
    }
}


$query = "SELECT s.sticker_id, s.name, s.image_url FROM user_stickers us
          JOIN stickers s ON us.sticker_id = s.sticker_id
          WHERE us.user_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_stickers = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redeem Stickers</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <header class="flex justify-between items-center p-5 bg-blue-800 text-white">
        <h1 class="text-2xl font-bold">Redeem Stickers</h1>
    </header>
    <main class="p-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Available Stickers</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                    <?php foreach ($stickers as $sticker) : ?>
                        <div class="border border-gray-300 p-4 rounded-lg">
                            
                            <img src="<?php echo htmlspecialchars($sticker['image_url'] ?: '/images/default-sticker.jpg'); ?>"
                                 alt="<?php echo htmlspecialchars($sticker['name']); ?>"
                                 class="w-full h-32 object-cover rounded mb-2">
                            <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($sticker['name']); ?></h3>
                            <p class="text-gray-600">Cost: <?php echo htmlspecialchars($sticker['cost']); ?> coins</p>
                            <form method="POST" class="mt-4">
                                <input type="hidden" name="sticker_id" value="<?php echo htmlspecialchars($sticker['sticker_id']); ?>">
                                <button type="submit" name="redeem" class="bg-blue-500 text-white p-2 rounded">Redeem</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php if (isset($message)) : ?>
                <p class="mt-4 text-green-600"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-xl font-semibold text-gray-800">Your Stickers</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                <?php foreach ($user_stickers as $sticker) : ?>
                    <div class="border border-gray-300 p-4 rounded-lg">
                        
                        <img src="<?php echo htmlspecialchars($sticker['image_url'] ?: '/images/default-sticker.jpg'); ?>"
                             alt="<?php echo htmlspecialchars($sticker['name']); ?>"
                             class="w-full h-32 object-cover rounded mb-2">
                        <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($sticker['name']); ?></h3>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($user_stickers)) : ?>
                    <p class="text-gray-600">You have no stickers yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>
