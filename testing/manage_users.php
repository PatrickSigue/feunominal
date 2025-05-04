<?php
session_start();
require 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$users = $pdo->query("SELECT * FROM users")->fetchAll();
?>

<h2>Manage Users</h2>

<table border="1">
    <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Role</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user['user_id'] ?></td>
        <td><?= $user['username'] ?></td>
        <td><?= $user['role'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="admin.php">Back to Dashboard</a>
