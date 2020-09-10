<h1>Homepage</h1>
<?php if (\classes\SessionWrapper::has('name')): ?>
    <h2>Logged in as: <?= \classes\SessionWrapper::get('name')?></h2>
    <h2>User id: <?= \classes\SessionWrapper::get('id') ?></h2>
    <br>
    <?php if (\classes\SessionWrapper::has('administrator')): ?>
        <a href="/admin">Administrator panel</a>
    <?php endif; ?>
    <a href="/profile">My profile</a>
    <a href="/logout">Logout</a>
<?php else: ?>
    <a href="/login">Login</a>
    <a href="/signup">Signup</a>
<?php endif; ?>

   <?php foreach ($data as $thread):?>
    <table border="1">
        <tr>
            <th>Thread</th>
            <th>Description</th>
            <th>Subthreads</th>
            <th>Topics</th>
            <th>Posts</th>
        </tr>
            <tr>
                <td><a href="topic/index?thread=<?= $thread->getName() ?>"><b><?= $thread->getName() ?></b></a></td>
                <td><?= $thread->getDescription() ?></td>
            </tr>
        </a>
    </table>
   <?php endforeach; ?>