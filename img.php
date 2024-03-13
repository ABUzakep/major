<!DOCTYPE html>
<html>
<head>
    <title>Your Page Title</title>
    <style>
        /* Paste your CSS here */
        @import "https://unpkg.com/open-props";
        @import "https://unpkg.com/open-props/normalize.min.css";

        * {
            box-sizing: border-box;
        }

        body {
            display: grid;
            place-items: center;
            min-height: 100vh;
            background: var(--gradient-9);
            font-family: Arial, sans-serif; /* Change font family */
        }

        :root {
            --magnifier: 6;
            --gap: 1vmin;
            --transition: 0.5s;
        }

        .container {
            width: 80vw;
            height: 50vmin;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--gap);
        }

        img {
            --brightness: 0.75;
            --grayscale: 1;
            transition: flex var(--transition), filter var(--transition);
            height: 100%;
            filter: grayscale(var(--grayscale)) brightness(var(--brightness));
            object-fit: cover;
            overflow: hidden;
            flex: 1;
        }

        img:hover {
            --brightness: 1.15;
            --grayscale: 0;
            flex: var(--magnifier);
        }

        /* Styling for car details */
        .car-details {
            font-size: 25px; /* Adjust font size */
            font-weight: bold; /* Make it bold */
            color: black; /* Change text color */
            margin-bottom: 10px; /* Add some margin */
            text-align: left; /* Align to the right */
        }

        .car-label {
            color: #666; /* Change label color */
        }
    </style>
</head>
<body>

<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "major";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to select all details from the cars table
$sql = "SELECT * FROM cars";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Display car details
        echo "<div class='car-details'>";
        echo "<span class='car-label'>Car Name:</span> " . $row["car_name"] . "<br>";
        echo "<span class='car-label'>Model:</span> " . $row["model"] . "<br>";
        echo "<span class='car-label'>Year:</span> " . $row["year"] . "<br>";
        echo "<span class='car-label'>Mileage:</span> " . $row["mileage"] . "<br>";
        echo "<span class='car-label'>Condition:</span> " . $row["conditions"] . "<br>";
        echo "<span class='car-label'>Exterior Color:</span> " . $row["exterior_color"] . "<br>";
        echo "<span class='car-label'>Interior Color:</span> " . $row["interior_color"] . "<br>";
        echo "<span class='car-label'>Engine:</span> " . $row["engine"] . "<br>";
        echo "<span class='car-label'>Transmission:</span> " . $row["transmission"] . "<br>";
        echo "<span class='car-label'>Fuel Type:</span> " . $row["fuel_type"] . "<br>";
        echo "</div>";
        
        // Display images
        echo "<div class='container'>";
        for ($i = 1; $i <= 5; $i++) {
            $imageFieldName = "image" . $i;
            $imagePath = "uploads/" . $row[$imageFieldName];
            echo "<img src='$imagePath' alt='Car Image $i'><br>";
        }
        echo "</div>";
        
        echo "<hr>";
    }
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>

</body>
</html>
