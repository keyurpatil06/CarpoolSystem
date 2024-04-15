<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #4d5c71;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        #main {
            max-width: 400px;
            width: 90%;
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #333;
        }

        #passenger-area {
            margin-top: 20px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="text"]:focus {
            border-color: #4CAF50;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            margin: 10px 0;
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "carpool";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Failed to connect: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $passenger_id = $_POST["passenger_id"];

        $login_query = "SELECT * FROM passenger WHERE passenger_id = '$passenger_id'";
        $login_result = mysqli_query($conn, $login_query);

        if (!$login_result) {
            echo "Error: " . mysqli_error($conn);
        } elseif (mysqli_num_rows($login_result) > 0) {
            header("location: passengerDashboard.php");
            exit();
        } else {
            echo '<div class="error-message">Invalid passenger ID</div>';
        }
    }
    ?>

    <div id="main">
        <h1>Passenger Login</h1>

        <div id="passenger-area">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="text" id="passenger_id" name="passenger_id" placeholder="Enter your passenger ID" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>

</html>