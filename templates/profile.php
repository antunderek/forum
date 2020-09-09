<h1>Profile page</h1>

<h2>Update profile</h2>

<h3>Change profile picture</h3>
<form action="/profile/image" method="POST" enctype="multipart/form-data">
    <p>Upload profile image:</p>
    <br>
    <input type="file" name="image" id="image">
    <br>
    <input type="submit" value="Upload Image" name="submit">
</form>

<h3>Change username and email</h3>
<form action="/profile/update" method="POST">
    <label for="username">Username:</label>
    <br>
    <input type="text" name="username" value="<?= $this->getUsername($data) ?>">
    <br>
    <label for="email">Email:</label>
    <br>
    <input type="email" name="email" value="<?= $this->getEmail($data) ?>">
    <br>
    <input type="submit">
</form>

<h3>Change password</h3>
<form action="/profile/password" method="POST">
    <label for="current-password">Current password:</label>
    <br>
    <input type="password" name="current-password">
    <br>
    <label for="new-password">New password:</label>
    <br>
    <input type="password" name="new-password">
    <br>
    <label for="check-password">Retype password:</label>
    <br>
    <input type="password" name="check-password">
    <br>
    <input type="submit">
</form>

<?php if(\classes\SessionWrapper::has('administrator')): ?>
    <h2>Revoke your administrator permissions</h2>
    <p>Clicking on the following button you will lose all your administrator privileges and become a basic user.</p>
    <a href="/admin/revoke"><button>Revoke permissions</button></a>
<?php endif; ?>

<h2>Delete account</h2>
<a href="/profile/delete"><button>Delete user</button></a>