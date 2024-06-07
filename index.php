<pre>
<?php

session_start();


if ($_GET['page'] == 'disconnect') {
    unset($_SESSION['loggedAs']);
}
else if ($_GET['page'] == 'connect') {
    if ($_POST['email'] == 'sam' && $_POST['password'] == '123') {
        $_SESSION['loggedAs'] = $_POST['email'];
    }
}

var_dump('get', $_GET);
var_dump('post', $_POST);
var_dump('_SESSION', $_SESSION);


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
        <input type="submit">
    </form>
<?php
}
