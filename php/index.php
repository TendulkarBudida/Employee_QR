<?php
session_start();

// Initialize variables
$login_error = "";
$username = "";

require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to retrieve user credentials
    $sql = "SELECT * FROM adm_access WHERE adm_uid = ? AND adm_pass = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);

    // Execute the prepared statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if a row exists with matching credentials
    if ($result->num_rows == 1) {
        // Authentication successful, start session and redirect to qr.php
        $_SESSION['username'] = $username;
        header("Location: qr.php");
        exit();
    } else {
        // Authentication failed, set error message
        $login_error = "Invalid username or password";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technip Energies Login</title>
    <link rel="stylesheet" href="../css/style_login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="row container-fluid h-100 w-100 m-0 p-0">
        <div class="login-section">
            <div class="login-box">
                <div class="logo">
                    <img src="https://www.technipenergies.com/sites/energies/files/2021-03/TECHNIP_ENERGIES_LOGO_HORIZONTAL_CMJN.png" alt="Technip Energies Logo" class="logo-img">
                </div>
                <h2>Log in to your Account</h2>
                <p>Welcome back!</p>
                <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="input-group">
                        <span class="input-icon google-icon">
                            <img src="https://images.vexels.com/media/users/3/130187/isolated/preview/5e8d2205ecc8cde3235581fc5ecfa430-email-outline-icon-by-vexels.png" alt="Email Icon">
                        </span>
                        <input type="text" name="username" id="username" placeholder="Username" required>
                    </div>
                    <div class="input-group">
                        <span class="input-icon password-icon">
                            <img src="https://cdn4.iconfinder.com/data/icons/universal-icons-9/384/web-29-512.png" alt="Password Icon">
                        </span>
                        <input type="password" name="password" id="password" placeholder="Password" required>
                    </div>
                    <div class="options">
                        <label><input type="checkbox" name="remember"> Remember me</label>
                    </div>
                    <button type="submit" class="login-btn">Log in</button>
                </form>
                <?php if (!empty($login_error)) echo "<p style='color:red;'>$login_error</p>"; ?>
                <p>Contact Support: +1 (800) 123-4567</p>
            </div>
        </div>
        <div class="info-section">
            <div class="info-box">
                <h2>Rapid Employee Profile Retrieval</h2>
                <p>Everything you need in a neatly customizable dashboard.</p>
                <div class="icons">
                    <img src="https://getcoursefunnels.in/images/landing/s25-img09.png" alt="App Icon">
                </div>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="d.js"></script>
</body>
</html>
