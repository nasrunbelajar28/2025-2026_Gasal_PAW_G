<?php
require 'validate.inc';
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Jalankan validasi
    $valid_name = validateName($_POST, 'surname', $errors);
    $valid_email = validateEmail($_POST, 'email', $errors);

    // Jika semua valid
    if ($valid_name && $valid_email) {
        echo "<h3 style='color:green'>Form submitted successfully with no errors.</h3>";
        echo "<p><b>Data diterima:</b></p>";
        echo "Surname: " . htmlspecialchars($_POST['surname']) . "<br>";
        echo "Email: " . htmlspecialchars($_POST['email']) . "<br>";
    } else {
        echo "<h3 style='color:red'>Terdapat error dalam form:</h3>";
        include 'form.inc';
    }
} else {
    include 'form.inc';
}
?>
