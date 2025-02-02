<?php
session_start();
include 'includes/auth.php';

if (!isLoggedIn()) {
    header('Location: index.php');
    exit();
}

include 'includes/dash_header.php';
?>
<div class="dashboard-container">
<?php include 'includes/sidebar.php'; ?>
    <div class="main-content">
    <div class="user-management">

<h1>Manage Users</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include 'includes/db.php';
        $stmt = $pdo->query("SELECT * FROM users");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['username']}</td>
                    <td>" . ($row['is_active'] ? 'Active' : 'Inactive') . "</td>
                    <td>
                        <a href='edit_user.php?id={$row['id']}'>Edit</a>
                        <a href='delete_user.php?id={$row['id']}'>Delete</a>
                    </td>
                  </tr>";
        }
        ?>
    </tbody>
</table>
<a href="add_user.php" class="button">Add User</a>
</div>


    </div>
</div>
