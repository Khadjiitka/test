<?php

$email = $_POST['email'] ?? '';
$name = $_POST['character_name'] ?? 'Unknown Hero';
$gender = $_POST['gender'] ?? '';
$race = $_POST['race'] ?? '';
$stone = $_POST['standing_stone'] ?? '';
$city = $_POST['city'] ?? '';
$weapon_class = $_POST['weapon_class'] ?? '';
$weapon_type = $_POST['weapon_type'] ?? '';
$weapon_material = $_POST['weapon_material'] ?? '';
$backstory = $_POST['backstory'] ?? '';

$guilds = $_POST['guilds'] ?? [];

$avatar = "/pic/ava.png";

if (isset($_FILES['avatar']) && $_FILES['avatar']['name'] != "") {
    $target = "../../pic/" . basename($_FILES["avatar"]["name"]);
    move_uploaded_file($_FILES["avatar"]["tmp_name"], $target);
    $avatar = $target;
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Character Profile</title>

    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=IM+Fell+English+SC&display=swap"
        rel="stylesheet">

    <style>
        body {
            background: url("/pic/BgGener.jpg") no-repeat center center/cover;
            font-family: 'Cinzel', serif;
            color: white;
            margin: 0;
            padding: 40px;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            z-index: -1;
        }

        .container {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .card {
            width: 500px;
            background: rgba(20, 20, 20, 0.85);
            border: 1px solid #777;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
        }

        .js-panel {
            width: 500px;
            background: rgba(20, 20, 20, 0.85);
            border: 1px solid #777;
            border-radius: 10px;
            padding: 30px;

            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .js-content {
            text-align: center;
        }

        .avatar {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            border: 3px solid #aaa;
            object-fit: cover;
            margin-bottom: 20px;
        }

        h1 {
            font-family: "IM Fell English SC", serif;
            letter-spacing: 3px;
        }

        .section {
            margin-top: 20px;
            text-align: left;
        }

        .section-title {
            font-family: "IM Fell English SC", serif;
            font-size: 22px;
            margin-bottom: 8px;
            border-bottom: 1px solid #777;
        }

        .backstory {
            font-style: italic;
            line-height: 1.6;
        }

        /* BUTTON STYLE */

        .btn-generator-nav {
            display: block;
            margin: 12px auto;
            padding: 12px;
            background: #2d2d2d;
            border: 1px solid #aaa;
            border-radius: 6px;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 18px;
            transition: 0.3s;
            cursor: pointer;

            width: 260px;
        }

        .btn-generator-nav:hover {
            background: #444;
            transform: scale(1.05);
        }

        .output {
            margin-top: 20px;
            font-size: 18px;
            color: white;
            min-height: 60px;
        }

        /* bottom buttons */

        .bottom-buttons {
            margin-top: 20px;
        }
    </style>

</head>

<body>

    <div class="container">

        <!-- LEFT PANEL -->

        <div class="card">

            <img src="<?php echo $avatar; ?>" class="avatar">

            <h1><?php echo htmlspecialchars($name); ?></h1>

            <div class="section">

                <div class="section-title">Basic Info</div>

                <p><b>Email:</b> <?php echo htmlspecialchars($email); ?></p>
                <p><b>Race:</b> <?php echo $race; ?></p>
                <p><b>Gender:</b> <?php echo $gender; ?></p>
                <p><b>City:</b> <?php echo $city; ?></p>
                <p><b>Standing Stone:</b> <?php echo $stone; ?></p>

            </div>

            <div class="section">

                <div class="section-title">Weapon</div>

                <p><b>Class:</b> <?php echo $weapon_class; ?></p>
                <p><b>Type:</b> <?php echo $weapon_type; ?></p>
                <p><b>Material:</b> <?php echo $weapon_material; ?></p>

            </div>

            <?php if (!empty(array_filter($guilds))): ?>

                <div class="section">

                    <div class="section-title">Guilds</div>

                    <?php
                    foreach ($guilds as $g) {
                        if ($g != "") {
                            echo "<p>$g</p>";
                        }
                    }
                    ?>

                </div>

            <?php endif; ?>

            <div class="section">

                <div class="section-title">Backstory</div>

                <div class="backstory">
                    <?php echo nl2br(htmlspecialchars($backstory)); ?>
                </div>

            </div>

        </div>


        <!-- RIGHT PANEL -->
        <div class="js-panel">
            <div class="js-content">

                <h1>Adventurer's Board</h1>

                <div id="welcome"></div>

                <p>Choose your activity:</p>

                <button class="btn-generator-nav" onclick="viewUsers()">
                    View other heroes
                </button>

                <button class="btn-generator-nav" onclick="generateShout()">
                    Generate Dragon Shout
                </button>

                <button class="btn-generator-nav" onclick="showTamrielDate()">
                    Tamriel Calendar
                </button>
                <div id="output" class="output"></div>
            </div>


            <!-- bottom buttons -->
            <div class="bottom-buttons">
                <a href="/index.html" class="btn-generator-nav"> Main Page </a>
                <button class="btn-generator-nav" onclick="deleteCharacter()">Delete Character</button>
            </div>
        </div>
    </div>


    <script>

        /* welcome message */

        let heroName = "<?php echo htmlspecialchars($name); ?>";

        window.onload = function () {

            document.getElementById("welcome").innerHTML =
                "<h2>Welcome back, " + heroName + "!</h2>" +
                "<p>Skyrim awaits your next adventure.</p>";

        }


        /* view users */

        function viewUsers() {

            alert("Soon you will be able to explore profiles of other heroes.");

        }


        /* shout generator */

        function generateShout() {

            let words = ["FUS", "RO", "DAH", "YOL", "TOOR", "SHUL", "LOK", "VAH", "KOOR"];

            let shout =
                words[Math.floor(Math.random() * words.length)] + " " +
                words[Math.floor(Math.random() * words.length)] + " " +
                words[Math.floor(Math.random() * words.length)];

            document.getElementById("output").innerHTML =
                "Dragon Shout: <b>" + shout + "</b>";

        }


        /* tamriel calendar */

        function showTamrielDate() {

            let today = new Date();

            let months = [
                "Morning Star",
                "Sun's Dawn",
                "First Seed",
                "Rain's Hand",
                "Second Seed",
                "Midyear",
                "Sun's Height",
                "Last Seed",
                "Hearthfire",
                "Frostfall",
                "Sun's Dusk",
                "Evening Star"
            ];

            let days = [
                "Sundas",
                "Morndas",
                "Tirdas",
                "Middas",
                "Turdas",
                "Fredas",
                "Loredas"
            ];

            let day = today.getDate();
            let month = months[today.getMonth()];
            let weekday = days[today.getDay()];
            let year = today.getFullYear();

            document.getElementById("output").innerHTML =
                "Today in Tamriel:<br>" +
                weekday + ", " + day + " of " + month + ", " + year;

        }


        /* delete confirmation */

        function deleteCharacter() {

            let confirmDelete = confirm("Are you sure you want to delete this character?");

            if (confirmDelete) {
                alert("Character deleted (functionality will be added later).");
            }

        }

    </script>

</body>

</html>