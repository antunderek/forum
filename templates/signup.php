<!DOCTYPE html>
<html>
<body>
<?php if ($this->userLoggedIn()): ?>
    <h2>You are already logged in as <?= \classes\SessionWrapper::get('name') ?></h2>
<?php else: ?>
    <form action="signup/register" method="POST">
        <label for="name">Username</label>
        <br>
        <input type="text" name="username" value="<?= $this->rememberedUsername() ?>">
        <br>
        <label for="password">Password</label>
        <br>
        <input type="password" name="password">
        <br>
        <label for="email">Email</label>
        <br>
        <input type="email" name="email" value="<?= $this->rememberedEmail() ?>">
        <br>
        <p><?= $this->checkRegisterError() ?></p>
        <input type="submit">
    </form>
<?php endif; ?>
</body>
</html>
