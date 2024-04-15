<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "carpool";

$conn  = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Failed to connect " . mysqli_connect_error());
}

// $sql = "CREATE DATABASE carpool";
// $result = mysqli_query($conn, $sql);

// if ($result) {
//     echo "Created DB";
// } else {
//     echo mysqli_error($conn);
// }

$sql_create_person = "CREATE TABLE IF NOT EXISTS person (
    person_id INT(11) PRIMARY KEY,
    email VARCHAR(50),
    phone_no VARCHAR(10)
)";
mysqli_query($conn, $sql_create_person);

$sql_create_driver = "CREATE TABLE IF NOT EXISTS driver (
    person_id INT(11),
    driver_id INT(11) UNIQUE,
    PRIMARY KEY(person_id, driver_id),
    FOREIGN KEY(person_id) REFERENCES person(person_id)
)";
mysqli_query($conn, $sql_create_driver);

$sql_create_passenger = "CREATE TABLE IF NOT EXISTS passenger (
    person_id INT(11),
    passenger_id INT(11) UNIQUE,
    PRIMARY KEY(person_id, passenger_id),
    FOREIGN KEY(person_id) REFERENCES person(person_id)
)";
mysqli_query($conn, $sql_create_passenger);

$create_create_trips = "CREATE TABLE IF NOT EXISTS trips (
    trip_id INT AUTO_INCREMENT PRIMARY KEY,
    driver_id INT NOT NULL,
    start_point VARCHAR(100) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    passenger_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (driver_id) REFERENCES driver(driver_id),
    FOREIGN KEY (passenger_id) REFERENCES passenger(passenger_id)
)";
mysqli_query($conn, $create_create_trips);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $person_id = $_POST["person_id"];
    $driver_id = $_POST["driver_id"];
    $passenger_id = $_POST["passenger_id"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    $check_person_query = "SELECT * FROM person WHERE email = '$email' AND phone_no = '$phone'";
    $check_person_result = mysqli_query($conn, $check_person_query);

    if (!$check_person_result) {
        echo "Error: " . mysqli_error($conn);
    } elseif (mysqli_num_rows($check_person_result) > 0) {
        echo "Account already exists. Please log in.";
        header("location: role.html");
    } else {
        // Person doesn't exist, then create a new entry in the person table
        $insert_person_query = "INSERT INTO person (person_id, email, phone_no) VALUES ('$person_id', '$email', '$phone')";
        if (mysqli_query($conn, $insert_person_query)) {
            // Insert driver entry if driver ID is provided
            if (!empty($driver_id)) {
                $insert_driver_query = "INSERT INTO driver (person_id, driver_id) VALUES ('$person_id', '$driver_id')";
                mysqli_query($conn, $insert_driver_query);
            }

            // Insert passenger entry if passenger ID is provided
            if (!empty($passenger_id)) {
                $insert_passenger_query = "INSERT INTO passenger (person_id, passenger_id) VALUES ('$person_id', '$passenger_id')";
                mysqli_query($conn, $insert_passenger_query);
            }

            echo "Account created successfully!";
            header("location: role.html");
        } else {
            echo "Error creating account: " . mysqli_error($conn);
        }
    }
}