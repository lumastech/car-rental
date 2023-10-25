<?php
// user seeder
$name = 'admin';
$email = 'admin@mail.com';
$password = 'admin';
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$sql = "SELECT * FROM users WHERE username = 'admin'";
$result = $db->query($sql);

if ($result->num_rows === 0) {
    $sql = "INSERT INTO users (name, email, password) VALUES ($name, $email, $passwordHash)";
    $db->query($sql);
}

// $query = "INSERT INTO users (username, password) VALUES (?, ?)";
// $stmt = $db->prepare($query);
// $stmt->bind_param("ss", $username, $passwordHash);
// $stmt->execute();
// $stmt->close();