<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = $conn->real_escape_string(trim($_POST['name']));
    $course = $conn->real_escape_string(trim($_POST['course']));
    $semester = $conn->real_escape_string(trim($_POST['semester']));
    $college = $conn->real_escape_string(trim($_POST['college']));
    $whatsapp = $conn->real_escape_string(trim($_POST['whatsapp']));
    $contact = $conn->real_escape_string(trim($_POST['contact']));

    // Handle events
    $events = isset($_POST['events']) && is_array($_POST['events']) ? implode(', ', $_POST['events']) : '';

    // Initialize photo variable
    $photo = '';

    // Check if file was uploaded
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo = basename($_FILES["photo"]["name"]);
        $target_dir = "uploads/";

        // Ensure uploads directory exists
        if (!is_dir($target_dir)) {
            if (!mkdir($target_dir, 0777, true)) {
                die("Failed to create directory: $target_dir");
            }
        }

        $target_file = $target_dir . $photo;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $extensions_arr = array("jpg", "jpeg", "png", "gif");

        // Check if file is an image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            // Check file extension
            if (in_array($imageFileType, $extensions_arr)) {
                // Check file size (e.g., max 5MB)
                if ($_FILES['photo']['size'] <= 10000000) {
                    // Upload file
                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
                        // Prepare and execute SQL statement
                        $stmt = $conn->prepare("INSERT INTO registrations (name, course, semester, college, whatsapp, contact, photo, events) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param("ssssssss", $name, $course, $semester, $college, $whatsapp, $contact, $photo, $events);

                        if ($stmt->execute()) {
                            echo "New record created successfully";
                        } else {
                            echo "Error: " . $stmt->error;
                        }

                        $stmt->close();
                    } else {
                        echo "Sorry, there was an error uploading your file. Please check the directory permissions.";
                    }
                } else {
                    echo "Sorry, your file is too large. Max file size is 10MB.";
                }
            } else {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }
        } else {
            echo "File is not an image.";
        }
    } else {
        if ($_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
            echo "Error uploading file: " . $_FILES['photo']['error'];
        } else {
            echo "No file was uploaded.";
        }
    }
}

$conn->close();
?>
