<form action="login/signin" method="POST">
    <label for="email">Email</label>
    <br>
    <input type="email" name="email" value="<?= $this->rememberedEmail() ?>">
    <br>
    <label for="password">Password</label>
    <br>
    <input type="password" name="password">
    <br>
    <p><?= $this->checkLoginError() ?></p>
    <input type="submit">
</form>
