<!DOCTYPE html>
<html>
<body>
<form action="signup/register" method="POST">
    <label for="name">Username</label>
    <br>
    <input type="text" name="username" value="<?= \classes\SessionWrapper::has('temp_data', 'username') ? \classes\SessionWrapper::get('temp_data', 'username') : '';?>">
    <br>
    <label for="password">Password</label>
    <br>
    <input type="password" name="password">
    <br>
    <label for="email">Email</label>
    <br>
    <input type="email" name="email" value="<?= \classes\SessionWrapper::has('temp_data', 'email') ? \classes\SessionWrapper::get('temp_data', 'email') : '';?>">
    <br>
    <input type="submit">
</form>
</body>
</html>
