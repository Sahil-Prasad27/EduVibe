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
    <title>Learn and Play</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <style>
        
        .chat-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            max-height: 400px;
            overflow-y: auto;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .chat-input {
            display: flex;
            margin-top: 10px;
        }

        .chat-input textarea {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            resize: none;
        }

        .chat-input button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px;
            cursor: pointer;
        }

        .chat-input button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body class="bg-gray-100">
    <header class="flex justify-between items-center p-5 absolute top-0 left-0 right-0 bg-transparent text-black">
        <div class="text-3xl font-bold">EduVibe</div>
        <nav class="hidden md:flex space-x-8">
            <a href="logout.php" class="hover:text-custom-red">Logout</a>
        </nav>
        <div class="md:hidden text-3xl cursor-pointer">
            <ion-icon name="menu" onclick="toggleMenu()"></ion-icon>
        </div>
    </header>

    <div class="flex mt-14">
        <div class="bg-white w-64 p-5 h-screen shadow-lg">
            <div class="text-center mb-8">
                <img src="" alt="" class="w-24 mx-auto">
            </div>
            <ul class="space-y-4">
                <li class="flex items-center p-3 mb-3 rounded-lg cursor-pointer bg-blue-500 text-white shadow">
                    <i class="fas fa-tachometer-alt text-lg mr-3"></i>
                    <span class="font-medium">Dashboard</span>
                </li>
                <li class="flex items-center p-3 mb-3 rounded-lg cursor-pointer hover:bg-blue-100 hover:text-blue-500">
                    <i class="fas fa-chart-bar text-lg mr-3"></i>
                    <span class="font-medium"><a href="resource.php">Resource</a></span>
                </li>
                <li class="flex items-center p-3 mb-3 rounded-lg cursor-pointer hover:bg-blue-100 hover:text-blue-500">
                    <i class="fas fa-credit-card text-lg mr-3"></i>
                    <span class="font-medium"><a href="resume.php">Resume</a></span>
                </li>
                <li class="flex items-center p-3 mb-3 rounded-lg cursor-pointer hover:bg-blue-100 hover:text-blue-500">
                    <i class="fas fa-users text-lg mr-3"></i>
                    <span class="font-medium"><a href="graph.php">Study Stats</a></span>
                </li>
                <li class="flex items-center p-3 mb-3 rounded-lg cursor-pointer hover:bg-blue-100 hover:text-blue-500">
                    <i class="fas fa-chart-line text-lg mr-3"></i>
                    <span class="font-medium"><a href="video.php">Goal Based Course</a></span>
                </li>
                <li class="flex items-center p-3 mb-3 rounded-lg cursor-pointer hover:bg-blue-100 hover:text-blue-500">
                    <i class="fas fa-chart-line text-lg mr-3"></i>
                    <span class="font-medium"><a href="redeem.php">Redeem</a></span>
                </li>
                <li class="flex items-center p-3 mb-3 rounded-lg cursor-pointer hover:bg-blue-100 hover:text-blue-500">
                    <i class="fas fa-cog text-lg mr-3"></i>
                    <span class="font-medium"><a href="contactus.php">Contact Us</a></span>
                </li>
            </ul>
        </div>
        <div class="flex-1 p-6 bg-gray-100">
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">AI Recommendations</h3>
                <div id="chatbox" class="chat-box">
                    <iframe width="100%" height="300" allow="microphone;" src="https://console.dialogflow.com/api-client/demo/embedded/a8455fa1-2822-4c39-8478-893be4740b6c"></iframe>
                </div>
            </div>
            <div class="flex justify-between items-center mb-8">
                
            </div>
            <div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex justify-between items-center mb-3">
                            <i class="fas fa-clock text-3xl text-blue-500"></i>
                        </div>
                        <div class="text-center">
                            <h3 id="liveTime" class="text-3xl font-semibold text-gray-800">00:00:00</h3>
                            <p class="text-xs text-gray-600">Live Time</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex justify-between items-center mb-3">
                            <i class="fas fa-video text-3xl text-blue-500"></i>
                        </div>
                        <div class="text-center">
                            <h3 class="text-3xl font-semibold text-gray-800">6 hours</h3>
                            <p class="text-xs text-gray-600">Video Watched</p>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex justify-between items-center mb-3">
                            <i class="fas fa-coins text-3xl text-blue-500"></i>
                        </div>
                        <div class="text-center">
                            <h3 class="text-3xl font-semibold text-gray-800">22k</h3>
                            <p class="text-sm text-gray-600">Earned Coins</p>
                            <p class="text-xs text-gray-500">Total Daily Coins</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 rounded-lg text-white shadow-md max-w-sm mx-auto">
                        <div class="flex flex-col items-center">
                            <input id="sessionInput" type="number" placeholder="Session Time (mins)" class="px-2 py-1 text-gray-800 rounded-lg mb-2 w-2/3 text-center">
                            <input id="breakInput" type="number" placeholder="Break Time (mins)" class="px-2 py-1 text-gray-800 rounded-lg mb-2 w-2/3 text-center">

                            <h2 id="sessionTime" class="text-4xl font-bold mb-2">00:00</h2>
                            <h6 class="text-1xl font-semibold mb-4">Current Session</h6>

                            <h4 id="breakTime" class="text-xl font-bold mb-2">00:00</h4>
                            <h6 class="text-1xl font-semibold">Break Time</h6>

                            <div class="m-4 space-x-2">
                                <button id="startBtn" class="px-4 py-2 my-1 bg-white text-blue-500 font-semibold rounded-lg">Start</button>
                                <button id="stopBtn" class="px-4 py-2 my-1 bg-white text-blue-500 font-semibold rounded-lg">Stop</button>
                                <button id="restartBtn" class="px-4 py-2 my-1 bg-white text-blue-500 font-semibold rounded-lg">Restart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-2xl font-semibold text-gray-800">Sticker</h3>
                        </div>
                        
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-2xl font-semibold text-gray-800">Daily Streak</h3>
                        <div class="overflow-x-auto mt-4">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border-b text-left">Date</th>
                                        <th class="px-4 py-2 border-b text-left">Time</th>
                                        <th class="px-4 py-2 border-b text-left">Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-4 py-2 border-b">2023-07-14</td>
                                        <td class="px-4 py-2 border-b">10:00 AM</td>
                                        <td class="px-4 py-2 border-b">60 mins</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 border-b">2023-07-14</td>
                                        <td class="px-4 py-2 border-b">11:00 AM</td>
                                        <td class="px-4 py-2 border-b">30 mins</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-2xl font-semibold text-gray-800">Performance Graph</h3>
                    
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.querySelector('nav');
            menu.classList.toggle('hidden');
        }

        
        let sessionTimer;
        let breakTimer;
        let sessionTime = 0;
        let breakTime = 0;

        function startSessionTimer() {
            sessionTimer = setInterval(() => {
                if (sessionTime > 0) {
                    sessionTime--;
                    document.getElementById('sessionTime').innerText = formatTime(sessionTime);
                } else {
                    clearInterval(sessionTimer);
                    alert('Session Time Completed! Starting Break Time...');
                    startBreakTimer();  
                }
            }, 1000);
        }

        function startBreakTimer() {
            breakTimer = setInterval(() => {
                if (breakTime > 0) {
                    breakTime--;
                    document.getElementById('breakTime').innerText = formatTime(breakTime);
                } else {
                    clearInterval(breakTimer);
                    alert('Break Time Completed!');
                }
            }, 1000);
        }

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        }

        function startTimer() {
            const sessionInput = document.getElementById('sessionInput').value;
            const breakInput = document.getElementById('breakInput').value;

            if (sessionInput) {
                sessionTime = parseInt(sessionInput) * 60;
                document.getElementById('sessionTime').innerText = formatTime(sessionTime);
                startSessionTimer();
            }
            if (breakInput) {
                breakTime = parseInt(breakInput) * 60;
                document.getElementById('breakTime').innerText = formatTime(breakTime);
            }
        }

        function stopTimer() {
            clearInterval(sessionTimer);
            clearInterval(breakTimer);
        }

        function restartTimer() {
            stopTimer();
            document.getElementById('sessionInput').value = '';
            document.getElementById('breakInput').value = '';
            document.getElementById('sessionTime').innerText = '00:00';
            document.getElementById('breakTime').innerText = '00:00';
        }

        document.getElementById('startBtn').addEventListener('click', startTimer);
        document.getElementById('stopBtn').addEventListener('click', stopTimer);
        document.getElementById('restartBtn').addEventListener('click', restartTimer);
    </script>

    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
