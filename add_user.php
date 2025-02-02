<?php
session_start();
include 'includes/auth.php';
include 'includes/db.php';

if (!isLoggedIn()) {
    header('Location: index.php');
    exit();
}

// Initialize the $error variable
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    // Check if username already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $error = 'Username already exists.';
    } else {
        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO users (username, password, is_active) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $password, $is_active])) {
            header('Location: manage_users.php');
            exit();
        } else {
            $error = 'Failed to add user.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="assets/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <h1>Add User</h1>
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="add-user-form">
                <form method="POST">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                    <div class="checkbox-label">
                        <input type="checkbox" id="is_active" name="is_active" checked>
                        <label for="is_active">Active</label>
                    </div>

                    <button type="submit">Add User</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>