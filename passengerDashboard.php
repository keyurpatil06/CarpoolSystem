<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "carpool";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Failed to connect: " . mysqli_connect_error());
}

$passenger_id = isset($_POST["passenger_id"]) ? $_POST["passenger_id"] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["trip_id"]) && !empty($passenger_id)) {
    $trip_id = $_POST["trip_id"];

    // Update the trip with the passenger ID to mark it as booked
    $book_trip_query = "UPDATE trips SET passenger_id = '$passenger_id' WHERE trip_id = '$trip_id'";
    if (mysqli_query($conn, $book_trip_query)) {
        echo '<p class="tripBook" id="successMsg">Trip booked successfully!</p>';
    } else {
        echo "Error booking trip: " . mysqli_error($conn);
    }
}

// Query to fetch all available trips
$fetch_available_trips_query = "SELECT * FROM trips WHERE passenger_id IS NULL";
$fetch_available_trips_result = mysqli_query($conn, $fetch_available_trips_query);

// Query to fetch booked trips by the current passenger
$fetch_booked_trips_query = "SELECT * FROM trips WHERE passenger_id = '$passenger_id'";
$fetch_booked_trips_result = mysqli_query($conn, $fetch_booked_trips_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Dashboard</title>

    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #4d5c71;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #f1f1f1;
            font-weight: bold;
        }

        td {
            background-color: #fff;
        }

        input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
            margin-right: 5px;
        }

        button[type="submit"] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .booked-trips {
            margin-top: 40px;
        }

        .tripBook {
            margin: 1rem auto;
            background-color: #45a049;
            color: white;
            font-size: 1.5rem;
            padding: 0.5rem;
            text-align: center;
        }

        button {
            background-color: #45a049;
            padding: 0.75rem 1rem;
            margin: 10px auto;
            text-align: center;
            border: none;
            outline: none;
            cursor: pointer;
            border-radius: 10px;
        }

        button a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Available Trips</h1>
        <table>
            <tr>
                <th>Trip ID</th>
                <th>Driver ID</th>
                <th>Start Point</th>
                <th>Destination</th>
                <th>Date</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($fetch_available_trips_result)) {
                echo "<tr>";
                echo "<td>" . $row["trip_id"] . "</td>";
                echo "<td>" . $row["driver_id"] . "</td>";
                echo "<td>" . $row["start_point"] . "</td>";
                echo "<td>" . $row["destination"] . "</td>";
                echo "<td>" . $row["date"] . "</td>";
                echo "<td>" . $row["time"] . "</td>";
                echo "<td>";
                echo "<form action='" . $_SERVER["PHP_SELF"] . "' method='post'>";
                echo "<input type='hidden' name='trip_id' value='" . $row["trip_id"] . "'>";
                echo "<input type='text' name='passenger_id' placeholder='Enter Passenger ID' value='$passenger_id' required>";
                echo "<button type='submit'>Book</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <?php if (!empty($passenger_id)) : ?>
            <div class="booked-trips">
                <h1>Booked Trips</h1>
                <table>
                    <tr>
                        <th>Trip ID</th>
                        <th>Driver ID</th>
                        <th>Start Point</th>
                        <th>Destination</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                    <?php
                    while ($booked_row = mysqli_fetch_assoc($fetch_booked_trips_result)) {
                        echo "<tr>";
                        echo "<td>" . $booked_row["trip_id"] . "</td>";
                        echo "<td>" . $booked_row["driver_id"] . "</td>";
                        echo "<td>" . $booked_row["start_point"] . "</td>";
                        echo "<td>" . $booked_row["destination"] . "</td>";
                        echo "<td>" . $booked_row["date"] . "</td>";
                        echo "<td>" . $booked_row["time"] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        <?php endif; ?>
        <button><a href="./index.html">Home</a></button>
    </div>


    <script>
        setTimeout(() => {
            let successMsg = document.getElementById("successMsg");
            if (successMsg) {
                successMsg.style.display = "none";
            }
        }, 5000);
    </script>
</body>

</html>