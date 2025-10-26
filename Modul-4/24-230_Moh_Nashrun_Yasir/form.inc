<form method="POST" action="formValidation.php">
    <h2>Form Input Handling</h2>
    
    <label for="surname">Surname:</label><br>
    <input type="text" id="surname" name="surname"
        value="<?php echo isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : ''; ?>">
    <?php if (isset($errors['surname'])) echo "<p style='color:red'>{$errors['surname']}</p>"; ?>
    <br><br>

    <label for="email">Email:</label><br>
    <input type="text" id="email" name="email"
        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
    <?php if (isset($errors['email'])) echo "<p style='color:red'>{$errors['email']}</p>"; ?>
    <br><br>

    <input type="submit" value="Submit">
</form>