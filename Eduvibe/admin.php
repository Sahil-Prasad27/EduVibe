<?php
session_start();

@include 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $cost = $_POST['cost'];
    $image_url = $_POST['image_url'];

    // Validate input
    if (empty($name) || empty($cost) || empty($image_url)) {
        $message = 'All fields are required.';
    } else {
        // Insert data into the database
        $sql = "INSERT INTO stickers (name, cost, image_url) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sis', $name, $cost, $image_url);

        if ($stmt->execute()) {
            $message = 'Sticker added successfully!';
        } else {
            $message = 'Error adding sticker: ' . $stmt->error;
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
    <title>Admin Interface - Book Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <nav class="p-4 bg-blue-500">
        <h1 class="text-3xl font-semibold text-white">Admin Dashboard</h1>
        <div class="mt-auto flex flex-col items-center ml-auto">
            <button><a href="admin_sticker_form.php" class="hover:text-custom-red text-white">Redeem</a></button>
            <button><a href="logout.php" class="hover:text-custom-red text-white">logout</a></button>
        </div>
    </nav>

    <div class="p-6">
        <h2 class="text-2xl font-semibold mb-4">Upload New Book</h2>
        <form action="upload_book.php" method="post" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="book_name" class="block text-gray-700">Book Name:</label>
                <input type="text" id="book_name" name="book_name" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="file_type" class="block text-gray-700">File Type:</label>
                <select id="file_type" name="file_type" class="w-full p-2 border border-gray-300 rounded-lg" required>
                    <option value="pdf">PDF</option>
                    <option value="word">Word</option>
                    <option value="ppt">PPT</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="book_file" class="block text-gray-700">Upload File:</label>
                <input type="file" id="book_file" name="book_file" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700">Upload Image:</label>
                <input type="file" id="image" name="image" class="w-full p-2 border border-gray-300 rounded-lg">
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Upload Book</button>
        </form>
        <main class="p-6">
            <div class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Add a New Sticker</h2>
                <?php if (isset($message)) : ?>
                    <p class="mb-4 text-green-600"><?php echo htmlspecialchars($message); ?></p>
                <?php endif; ?>
                <form method="POST" action="" class="space-y-4">
                    <div>
                        <label for="name" class="block text-gray-700">Name</label>
                        <input type="text" id="name" name="name" class="mt-1 px-3 py-2 border border-gray-300 rounded-md w-full" required>
                    </div>
                    <div>
                        <label for="cost" class="block text-gray-700">Cost</label>
                        <input type="number" id="cost" name="cost" class="mt-1 px-3 py-2 border border-gray-300 rounded-md w-full" required>
                    </div>
                    <form action="upload.php" method="POST" enctype="multipart/form-data">
                        <div>
                            <div>
                                <label for="image_url" class="block text-gray-700">Upload PNG Image</label>
                                <input type="file" id="image_url" name="image_url" accept="image/png" class="mt-1 px-3 py-2 border border-gray-300 rounded-md w-full" required>
                            </div>

                        </div>
                        <button type="submit" class="mt-4 bg-blue-500 text-white p-2 rounded">Upload</button>
                    </form>
                    <
                        </form>
            </div>
        </main>

        <h2 class="text-2xl font-semibold mt-8 mb-4">Manage Books</h2>
        <table class="w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 border-b">ID</th>
                    <th class="p-4 border-b">Book Name</th>
                    <th class="p-4 border-b">File</th>
                    <th class="p-4 border-b">Type</th>
                    <th class="p-4 border-b">Image</th>
                    <th class="p-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody id="bookTableBody">

            </tbody>
        </table>
    </div>


    <script>
        async function loadBooks() {
            try {
                const response = await fetch('fetch_books.php');
                const books = await response.json();
                const tableBody = document.getElementById('bookTableBody');
                tableBody.innerHTML = '';
                books.forEach(book => {
                    tableBody.innerHTML += `
                        <tr>
                            <td class="p-4 border-b">${book.id}</td>
                            <td class="p-4 border-b">${book.book_name}</td>
                            <td class="p-4 border-b"><a href="uploads/${book.book_file}" target="_blank">View File</a></td>
                            <td class="p-4 border-b">${book.file_type}</td>
                            <td class="p-4 border-b">
                                ${book.image ? `<img src="${book.image}" alt="${book.book_name}" class="w-20 h-20 object-cover">` : 'No Image'}
                            </td>
                            <td class="p-4 border-b">
                                <button class="px-4 py-2 bg-red-500 text-white rounded-lg" onclick="deleteBook(${book.id})">Delete</button>
                            </td>
                        </tr>
                    `;
                });
            } catch (error) {
                console.error('Error loading books:', error);
            }
        }

        async function deleteBook(bookId) {
            try {
                const response = await fetch('delete_book.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: bookId
                    })
                });
                if (response.ok) {
                    loadBooks();
                } else {
                    console.error('Error deleting book');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        document.addEventListener('DOMContentLoaded', loadBooks);
    </script>
</body>

</html>