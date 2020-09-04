<h1>Homepage</h1>
<?php if (\classes\SessionWrapper::has('name')): ?>
    <h2>Logged in as: <?= \classes\SessionWrapper::get('name')?></h2>
    <br>
    <a href="/logout">Logout</a>
<?php else: ?>
    <a href="/login">Login</a>
    <a href="/signup">Signup</a>
<?php endif;?>

<table border="1">
    <tr>
        <th>Thread</th>
        <th>Description</th>
    </tr>
    <?php foreach ($this->getData() as $thread):?>
        <tr>
            <td><?= $thread->getName() ?></td>
            <td><?= $thread->getDescription() ?></td>
        </tr>
    <?php endforeach; ?>
</table>