<?php
/**
 * 
 * Migration for crypted password, DO NOT RUN AGAIN
 * 
 */
require_once('connect.php');

$sql = "SELECT * FROM user WHERE id < 4";

$stmt = $pdo->query($sql);

$users = $stmt->fetchAll();

foreach($users as $user){
    $sql = "UPDATE user SET password=:password WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'password' => password_hash($user['password'], PASSWORD_DEFAULT),
        'id' => $user['id']
    ]);
}
var_dump($users);