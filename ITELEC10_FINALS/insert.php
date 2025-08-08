<?php
require 'config.php';

//POST METHOD
// Checks if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Access form data
    $full_name = trim($_POST['full_name']);
    $dob      = $_POST['dob'];
    $gender   = $_POST['gender'];
    $course  = trim($_POST['course']);
    $year_level    = filter_var($_POST['year_level'], FILTER_VALIDATE_INT);
    $contact_number  = trim($_POST['contact_number']);
    $email    = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    //VALIDATE AND SANITIZE INPUT
    // Validate year level and email
    if (!$year_level || !$email) {
        die("Invalid year level or email address.");
    }

    //INSERT THE DATA INTO MySQL database
    //Prepare and execute the SQL statement
    $stmt = $conn->prepare(
        "INSERT INTO students
        (full_name, dob, gender, course, year_level, contact_number, email)
        VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sssssis",
        $full_name, $dob, $gender, $course, $year_level, $contact_number, $email
    );
    $stmt->execute();
    $stmt->close();

    // Redirect to display page
    header("Location: display.php");
    exit;
} else {
    // If the form is not submitted, you can redirect or show an error
    die("Form not submitted.");
}
?>
