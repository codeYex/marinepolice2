<?php
session_start();
include 'includes/auth.php';
include 'includes/db.php';

if (!isLoggedIn()) {
    header('Location: index.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: manage_users.php');
    exit();
}

$id = $_GET['id'];

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    header('Location: manage_users.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete user
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt->execute([$id])) {
        header('Location: manage_users.php');
        exit();
    } else {
        $error = 'Failed to delete user.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="stylesheet" href="assets/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <h1>Delete User</h1>
            <p>Are you sure you want to delete the Personnel <strong><?php echo htmlspecialchars($user['username']); ?></strong>?</p>
            <form method="POST">
                <button type="submit" class="delete-button">Yes, Delete User</button>
                <a href="manage_users.php" class="button">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>