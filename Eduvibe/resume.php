<?php
session_start();


// Handle form submission
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Generator</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .myimg {
            border-radius: 50%;
            width: 200px;
        }
        .background {
            background-color: rgb(4, 4, 44);
            color: white;
        }
        .resume-format {
            display: none;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            .resume-format,
            .resume-format * {
                visibility: visible;
            }
            .resume-format {
                position: absolute;
                left: 0;
                top: 0;
            }
            #cv-form {
                display: none;
            }
        }
    </style>
</head>
<body class="font-sans m-0 p-0">
<header class="flex justify-between items-center p-5 absolute top-0 left-0 right-0 bg-transparent text-black">
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
    <div class="container mx-auto p-4" id="cv-form">
        <h1 class="text-3xl font-bold text-center my-4">Resume Generator</h1>
        
        <div class="mb-4">
            <label for="formatSelection" class="block text-sm font-medium">Select Resume Format</label>
            <select id="formatSelection" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="format1">Format 1</option>
                <option value="format2">Format 2</option>
            </select>
        </div>
        
        <div class="flex flex-wrap -mx-2">
            <div class="w-full md:w-1/2 px-2 mb-4">
                <h3 class="text-xl font-semibold mb-2">Personal Information</h3>
                <div class="mb-4">
                    <label for="nameField" class="block text-sm font-medium">Your Name</label>
                    <input type="text" id="nameField" placeholder="Enter here" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="contactField" class="block text-sm font-medium">Your Contact</label>
                    <input type="text" id="contactField" placeholder="Enter here" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="addressField" class="block text-sm font-medium">Your Address</label>
                    <textarea id="addressField" placeholder="Enter here" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                </div>
                <div class="mb-4">
                    <label for="imgfield" class="block text-sm font-medium">Select Your Photo</label>
                    <input id="imgfield" type="file" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <p class="text-gray-600 text-sm mb-2">Important Links</p>
                <div class="mb-4">
                    <label for="LiField" class="block text-sm font-medium">LinkedIn</label>
                    <input type="text" id="LiField" placeholder="Enter here" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
            </div>
            <div class="w-full md:w-1/2 px-2 mb-4">
                <h3 class="text-xl font-semibold mb-2">Professional Information</h3>
                <div class="mb-4">
                    <label for="objectiveField" class="block text-sm font-medium">Profile</label>
                    <textarea id="objectiveField" placeholder="Enter here" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                </div>
                <div class="mb-4" id="we">
                    <label for="workExperienceField" class="block text-sm font-medium">Work Experience</label>
                    <textarea placeholder="Enter here" class="w-full px-3 py-2 border border-gray-300 rounded-md wefield mt-2"></textarea>
                    <div class="text-center mt-2" id="weAddButton">
                        <button onclick="addNewWEField()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add</button>
                    </div>
                </div>
                <div class="mb-4" id="aq">
                    <label for="educationField" class="block text-sm font-medium">Education</label>
                    <textarea placeholder="Enter here" class="w-full px-3 py-2 border border-gray-300 rounded-md eqfield mt-2"></textarea>
                    <div class="text-center mt-2" id="aqAddButton">
                        <button onclick="addNewAQField()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add</button>
                    </div>
                </div>
                <div class="mb-4" id="sk">
                    <label for="skillsField" class="block text-sm font-medium">Skills</label>
                    <textarea placeholder="Enter here" class="w-full px-3 py-2 border border-gray-300 rounded-md skfield mt-2"></textarea>
                    <div class="text-center mt-2" id="skAddButton">
                        <button onclick="addNewSKField()" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <button onclick="generateCV()" class="bg-blue-500 text-white px-6 py-3 rounded-md text-lg">Generate CV</button>
        </div>
    </div>

    <!-- Resume Format 1 -->
    <div class="container mx-auto p-4 resume-format" id="format1">
        <div class="flex flex-wrap">
            <div class="w-full md:w-1/3 text-center py-5 background">
                <img src="piku.jfif" alt="Profile Picture" class="myimg" id="imgTemplate">
                <p id="nameT1" class="text-xl font-bold">Name</p>
                <p id="contactT" class="text-lg">Contact</p>
                <p id="addressT" class="text-lg">Address</p>
                <hr class="my-4">
                <p><a id="liT" href="#" class="text-blue-400">LinkedIn</a></p>
                <div class="card mt-4 text-start border-0">
                    <div class="card-header background">
                        <h3>Skills</h3>
                    </div>
                    <div class="card-body background">
                        <ul id="skT"></ul>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-2/3 py-5">
                <h1 id="nameT2" class="text-4xl font-bold text-center">Name</h1>
                <div class="card mt-4">
                    <div class="card-header background">
                        <h3>Profile</h3>
                    </div>
                    <div class="card-body">
                        <p id="objectiveT">Profile Description</p>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header background">
                        <h3>Work Experience</h3>
                    </div>
                    <div class="card-body">
                        <ul id="weT"></ul>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header background">
                        <h3>Education</h3>
                    </div>
                    <div class="card-body">
                        <ul id="aqT"></ul>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button onclick="printCV('format1')" class="bg-blue-500 text-white px-6 py-3 rounded-md">Print CV</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Resume Format 2 -->
    <div class="container mx-auto p-4 resume-format" id="format2">
        <div class="flex flex-wrap">
            <div class="w-full md:w-2/3 py-5">
                <h1 id="nameT3" class="text-4xl font-bold text-center">Name</h1>
                <div class="card mt-4">
                    <div class="card-header background">
                        <h3>Profile</h3>
                    </div>
                    <div class="card-body">
                        <p id="objectiveT2">Profile Description</p>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header background">
                        <h3>Work Experience</h3>
                    </div>
                    <div class="card-body">
                        <ul id="weT2"></ul>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header background">
                        <h3>Education</h3>
                    </div>
                    <div class="card-body">
                        <ul id="aqT2"></ul>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header background">
                        <h3>Skills</h3>
                    </div>
                    <div class="card-body">
                        <ul id="skT2"></ul>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button onclick="printCV('format2')" class="bg-blue-500 text-white px-6 py-3 rounded-md">Print CV</button>
                </div>
            </div>
            <div class="w-full md:w-1/3 text-center py-5 background">
                <img src="piku.jfif" alt="Profile Picture" class="myimg" id="imgTemplate2">
                <p id="nameT4" class="text-xl font-bold">Name</p>
                <p id="contactT2" class="text-lg">Contact</p>
                <p id="addressT2" class="text-lg">Address</p>
                <hr class="my-4">
                <p><a id="liT2" href="#" class="text-blue-400">LinkedIn</a></p>
            </div>
        </div>
    </div>

    <script>
        function addNewWEField() {
            let newNode = document.createElement('textarea');
            newNode.classList.add('w-full', 'px-3', 'py-2', 'border', 'border-gray-300', 'rounded-md', 'mt-2', 'wefield');
            newNode.setAttribute('placeholder', "Enter here");

            let weOb = document.getElementById("we");
            let weAddButtonOb = document.getElementById("weAddButton");

            weOb.insertBefore(newNode, weAddButtonOb);
        }

        function addNewAQField() {
            let newNode = document.createElement('textarea');
            newNode.classList.add('w-full', 'px-3', 'py-2', 'border', 'border-gray-300', 'rounded-md', 'mt-2', 'eqfield');
            newNode.setAttribute('placeholder', "Enter here");

            let aqOb = document.getElementById("aq");
            let aqAddButtonOb = document.getElementById("aqAddButton");

            aqOb.insertBefore(newNode, aqAddButtonOb);
        }

        function addNewSKField() {
            let newNode = document.createElement('textarea');
            newNode.classList.add('w-full', 'px-3', 'py-2', 'border', 'border-gray-300', 'rounded-md', 'mt-2', 'skfield');
            newNode.setAttribute('placeholder', "Enter here");

            let skOb = document.getElementById("sk");
            let skAddButtonOb = document.getElementById("skAddButton");

            skOb.insertBefore(newNode, skAddButtonOb);
        }

        function generateCV() {
            let format = document.getElementById("formatSelection").value;
            let nameField = document.getElementById("nameField").value;
            let contactField = document.getElementById("contactField").value;
            let addressField = document.getElementById("addressField").value;
            let liField = document.getElementById("LiField").value;
            let objectiveField = document.getElementById("objectiveField").value;

            document.getElementById('nameT1').innerHTML = nameField;
            document.getElementById('nameT2').innerHTML = nameField;
            document.getElementById('nameT3').innerHTML = nameField;
            document.getElementById('nameT4').innerHTML = nameField;
            document.getElementById('contactT').innerHTML = contactField;
            document.getElementById('addressT').innerHTML = addressField;
            document.getElementById('liT').innerHTML = liField;
            document.getElementById('liT').href = liField;

            document.getElementById('objectiveT').innerHTML = objectiveField;
            document.getElementById('objectiveT2').innerHTML = objectiveField;

            let wes = document.getElementsByClassName('wefield');
            let str = '';
            for (let e of wes) {
                str += `<li>${e.value}</li>`;
            }
            document.getElementById('weT').innerHTML = str;
            document.getElementById('weT2').innerHTML = str;

            let ads = document.getElementsByClassName('eqfield');
            let str1 = '';
            for (let e of ads) {
                str1 += `<li>${e.value}</li>`;
            }
            document.getElementById('aqT').innerHTML = str1;
            document.getElementById('aqT2').innerHTML = str1;

            let sks = document.getElementsByClassName('skfield');
            let str2 = '';
            for (let e of sks) {
                str2 += `<li>${e.value}</li>`;
            }
            document.getElementById('skT').innerHTML = str2;
            document.getElementById('skT2').innerHTML = str2;

            let file = document.getElementById('imgfield').files[0];
            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = function () {
                document.getElementById('imgTemplate').src = reader.result;
                document.getElementById('imgTemplate2').src = reader.result;
            };

            document.querySelectorAll('.resume-format').forEach(el => el.style.display = 'none');
            document.getElementById(format).style.display = 'block';
        }

        function printCV(format) {
            window.print();
        }
    </script>
</body>
</html>
