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

$statusMsg = '';

// File upload directory 
$targetDir = "uploads/";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Array to store uploaded file names
    $fileNames = array();

    // Loop through each image file input
    for ($i = 1; $i <= 5; $i++) {
        $fieldName = "image" . $i;
        if (!empty($_FILES[$fieldName]["name"])) {
            $fileName = basename($_FILES[$fieldName]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Allow certain file formats 
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                // Upload file to server 
                if (move_uploaded_file($_FILES[$fieldName]["tmp_name"], $targetFilePath)) {
                    // Add file name to array
                    $fileNames[] = $fileName;
                } else {
                    $statusMsg = "Sorry, there was an error uploading your file.";
                    break;
                }
            } else {
                $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
                break;
            }
        } else {
            $statusMsg = 'Please select all image files to upload.';
            break;
        }
    }

    if (empty($statusMsg)) {
        // Insert image file names into database 
        $insert = $conn->query("INSERT INTO cars (car_name, model, year, mileage, conditions, exterior_color, interior_color, engine, transmission, fuel_type, image1, image2, image3, image4, image5) VALUES ('" . $_POST['car_name'] . "', '" . $_POST['model'] . "', '" . $_POST['year'] . "', '" . $_POST['mileage'] . "', '" . $_POST['conditions'] . "', '" . $_POST['exterior_color'] . "', '" . $_POST['interior_color'] . "', '" . $_POST['engine'] . "', '" . $_POST['transmission'] . "', '" . $_POST['fuel_type'] . "', '" . $fileNames[0] . "', '" . $fileNames[1] . "', '" . $fileNames[2] . "', '" . $fileNames[3] . "', '" . $fileNames[4] . "')");

        if ($insert) {
            $statusMsg = "Car details added successfully.";
        } else {
            $statusMsg = "Failed to add car details, please try again.";
        }
    }
}

// Display status message 
echo $statusMsg;

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        
        h1 {
            text-align: center;
            color: #333;
        }
        
        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        
        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        
        input[type="file"] {
            margin-bottom: 15px;
        }
        
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        .error {
            color: red;
            font-size: 14px;
        }
        
        .success {
            color: green;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h1>Add Car Details</h1>
    <form method="post" enctype="multipart/form-data">
    <label for="car_name">Car Name:</label><br>
        <input type="text" id="car_name" name="car_name" required><br><br>
        
        <label for="model">Model:</label><br>
        <input type="text" id="model" name="model" required><br><br>
        
        <label for="year">Year:</label><br>
        <input type="number" id="year" name="year" min="1900" max="2099" step="1" required><br><br>
        
        <label for="mileage">Mileage:</label><br>
        <input type="number" id="mileage" name="mileage" min="0" required><br><br>
        
        <label for="conditions">Condition:</label><br>
        <select id="conditions" name="conditions" required>
            
            <option value="none"> </option>

            <option value="new">New</option>
            <option value="used">Used</option>
        </select><br><br>
        
        <label for="exterior_color">Exterior Color:</label><br>
        <input type="text" id="exterior_color" name="exterior_color" required><br><br>
        
        <label for="interior_color">Interior Color:</label><br>
        <input type="text" id="interior_color" name="interior_color" required><br><br>
        
        <label for="engine">Engine:</label><br>
        <input type="text" id="engine" name="engine" required><br><br>
        
        <label for="transmission">Transmission:</label><br>
        <input type="text" id="transmission" name="transmission" required><br><br>
        
        <label for="fuel_type">Fuel Type:</label><br>
        <input type="text" id="fuel_type" name="fuel_type" required><br><br>
        
        
        <?php for ($i = 1; $i <= 5; $i++) { ?>
            <label for="image<?php echo $i; ?>">Image <?php echo $i; ?> (Mandatory):</label><br>
            <input type="file" id="image<?php echo $i; ?>" name="image<?php echo $i; ?>" accept="image/*" required><br><br>
        <?php } ?>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>
