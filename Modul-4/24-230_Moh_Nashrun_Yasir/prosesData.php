<?php
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

require 'validate.inc';

$errors = [];

if (validateName($_POST, 'surname', $errors)) {
    echo "Data OK!";
} else {
    echo "Data invalid!<br>";
    print_r($errors);
}
?>
