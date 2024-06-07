<pre>
<?php

session_start();

require_once('connect.php');
if ($_GET['page'] == 'register') {
    $sql = "INSERT INTO user (`email`, `password`) VALUES (:email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'email' => $_POST['email'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
    ]);

} else if ($_GET['page'] == 'disconnect') {
    unset($_SESSION['loggedAs']);

} else if ($_GET['page'] == 'connect') {
    if (canLogin($_POST['email'], $_POST['password'], $pdo)) {
        $_SESSION['loggedAs'] = $_POST['email'];
        // $_SESSION['loggedOn'] = timestamp;
    }
}

var_dump('get', $_GET);
var_dump('post', $_POST);
var_dump('_SESSION', $_SESSION);

function canLogin($username, $password, $pdo)
{
    $sql = 'SELECT * FROM `user` WHERE `email`=:email_placeholder';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email_placeholder' => $username]);
    $res = $stmt->fetch();
    
    if ($res === false)
        return false;

    return password_verify($password, $res['password']);
}

?>
</pre>
<?php
if (isset($_SESSION['loggedAs'])) {
?>
    <h1>Bonjour <?= $_SESSION['loggedAs'] ?></h1>
    <a href="index.php?page=disconnect">bye</a>
<?php
} else {
?>
    <form action="index.php?page=connect" method="POST">
        <input type="text" name="email">
        <input type="text" name="password">
        <input type="submit" value="Connect">
    </form>

    <form action="index.php?page=register" method="POST">
        <input type="text" name="email">
        <input type="text" name="password">
        <input type="submit" value="Register">
    </form>

<?php
}
