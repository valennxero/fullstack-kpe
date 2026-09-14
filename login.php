<?php
$error      = $_GET["error"] ?? "";
$old_iduser = $_GET["iduser"] ?? "";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlentities($error) ?></p>
    <?php endif; ?>

    <form method="post" action="login_proses.php">
        <label>ID User:</label><br>
        <input type="text" name="iduser" value="<?= htmlentities($old_iduser) ?>" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="registration.php">Daftar di sini</a></p>
</body>
</html>