<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Folder Buttons</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .folder-button {
            background-color: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
            text-decoration: none;
            color: #374151;
            width: 200px;
            height: 200px;
        }

        .folder-button:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .folder-icon {
            font-size: 4rem;
            color: #4b5563;
        }

        .folder-button p {
            margin-top: 1rem;
            font-size: 1.25rem;
        }
    </style>
</head>

<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">

    <h1 class="text-4xl font-bold mb-12">Select Your Course</h1>

    <div class="grid grid-cols-2 gap-8 md:grid-cols-3 lg:grid-cols-5">
        <a href="FULL.php" class="folder-button">
            <span class="folder-icon">📁</span>
            <p>Full Stack Web Development</p>
        </a>

        <a href="DSA.php" class="folder-button">
            <span class="folder-icon">📁</span>
            <p>Data Structures & Algorithms</p>
        </a>

        <a href="AI.php" class="folder-button">
            <span class="folder-icon">📁</span>
            <p>ML & AI</p>
        </a>

        <a href="Mobileappdev.php" class="folder-button">
            <span class="folder-icon">📁</span>
            <p>Mobile App Development</p>
        </a>

        <a href="DBMS.php" class="folder-button">
            <span class="folder-icon">📁</span>
            <p>Database Management</p>
        </a>

        <a href="VLSI.php" class="folder-button">
            <span class="folder-icon">📁</span>
            <p>VLSI Design</p>
        </a>

        <a href="Controlsystem.php" class="folder-button">
            <span class="folder-icon">📁</span>
            <p>Control Systems</p>
        </a>

        <a href="page8.html" class="folder-button">
            <span class="folder-icon">📁</span>
            <p>PCB Design</p>
        </a>

        <a href="page9.html" class="folder-button">
            <span class="folder-icon">📁</span>
            <p>Signal Processing</p>
        </a>

        <a href="page10.html" class="folder-button">
            <span class="folder-icon">📁</span>
            <p>Embedded Systems</p>
        </a>
    </div>

    <script>
       
    </script>
</body>

</html>
