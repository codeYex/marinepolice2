<?php
session_start();
include 'includes/auth.php';
include 'includes/db.php';

if (!isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$error = '';
$user = null;

if (!isset($_GET['id'])) {
    header('Location: manage_users.php');
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    header('Location: manage_users.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    // Check if username already exists (excluding the current user)
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND id != ?");
    $stmt->execute([$username, $id]);
    if ($stmt->fetch()) {
        $error = 'Username already exists.';
    } else {
        // Update user
        $stmt = $pdo->prepare("UPDATE users SET username = ?, is_active = ? WHERE id = ?");
        if ($stmt->execute([$username, $is_active, $id])) {
            header('Location: manage_users.php');
            exit();
        } else {
            $error = 'Failed to update user.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="assets/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <h1>Edit User</h1>
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

                <label for="is_active">
                    <input type="checkbox" id="is_active" name="is_active" <?php echo $user['is_active'] ? 'checked' : ''; ?>> Active
                </label>

                <button type="submit">Update User</button>
            </form>
        </div>
    </div>
</body>
</html>