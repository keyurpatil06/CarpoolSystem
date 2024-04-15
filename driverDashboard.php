<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>

    <style>
        * {
            padding: 0;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #4d5c71;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin: 1rem;
            padding: 0.75rem;
            border-radius: 10px;
            color: white;
            background-color: #45a049;
        }

        form {
            max-width: 500px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"] {
            width: 96%;
            margin: auto;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            margin-top: 5px;
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
        $driver_id = $_POST["driver_id"];
        $start_point = $_POST["start_point"];
        $destination = $_POST["destination"];
        $date = $_POST["date"];
        $time = $_POST["time"];

        $insert_trip_query = "INSERT INTO trips (driver_id, start_point, destination, date, time) VALUES ('$driver_id', '$start_point', '$destination', '$date', '$time')";
        if (mysqli_query($conn, $insert_trip_query)) {
            echo "Trip created successfully!";
            header("location: role.html");
        } else {
            echo "Error creating trip: " . mysqli_error($conn);
        }
    }
    ?>

    <h1>Create Trip</h1>

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <label for="driver_id">Driver ID:</label>
        <input type="text" id="driver_id" name="driver_id" required>
        <br>

        <label for="start_point">Start Point:</label>
        <input type="text" id="start_point" name="start_point" required>
        <br>

        <label for="destination">Destination:</label>
        <input type="text" id="destination" name="destination" required>
        <br>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        <br>

        <label for="time">Time:</label>
        <input type="time" id="time" name="time" required>
        <br>

        <button type="submit">Create Trip</button>
    </form>
</body>

</html>