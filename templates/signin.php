<form action="login/signin" method="POST">
    <label for="email">Email</label>
    <br>
    <input type="email" name="email" value="<?= \classes\SessionWrapper::has('temp_data') ? \classes\SessionWrapper::get('temp_data', 'email') : ''?>">
    <br>
    <label for="password">Password</label>
    <br>
    <input type="password" name="password">
    <br>
    <input type="submit">
</form>
