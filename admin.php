<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "riti9";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from database
$sql = "SELECT * FROM registrations";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Registration Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            width: 50px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registration Details</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>Semester</th>
                <th>College</th>
                <th>WhatsApp Number</th>
                <th>Contact Number</th>
                <th>Photo ID</th>
                <th>Events</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["course"] . "</td>";
                    echo "<td>" . $row["semester"] . "</td>";
                    echo "<td>" . $row["college"] . "</td>";
                    echo "<td>" . $row["whatsapp"] . "</td>";
                    echo "<td>" . $row["contact"] . "</td>";
                    echo "<td><img src='uploads/" . $row["photo"] . "' alt='Photo'></td>";
                    echo "<td>" . $row["events"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No registrations found</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>