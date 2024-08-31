<?php
session_start();

@include 'config.php';


if (!isset($_SESSION['user_name'])) {
    
    header('Location: login.php'); 
    exit();
}

$user_id = $_SESSION['user_name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fetch_data']) && $_POST['fetch_data'] === 'true') {
    header('Content-Type: application/json');

    
    $data = array();
    $labels = array();
    $time_spent = array();

    
    $sql = "SELECT visit_date, SUM(time_spent) as total_time
            FROM user_activity
            WHERE user_id = ?
            GROUP BY visit_date
            ORDER BY visit_date";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

   
    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['visit_date'];
        $time_spent[] = $row['total_time'];
    }

    $data['labels'] = $labels;
    $data['time_spent'] = $time_spent;

    echo json_encode($data);

   
    $stmt->close();
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 p-6">

<header class="flex justify-between items-center mb-8">
    <div class="text-3xl font-bold">Analytics Dashboard</div>
    <a href="logout.php" class="text-blue-500 hover:text-blue-700">Logout</a>
</header>

<main class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">User Activity Analysis</h2>
    <canvas id="activityChart" class="w-full h-64"></canvas>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchData();

        function fetchData() {
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'fetch_data': 'true'
                })
            })
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('activityChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Time Spent (seconds)',
                            data: data.time_spent,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 2,
                            fill: true,
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Time Spent (seconds)'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
        }
    });
</script>

</body>
</html>
