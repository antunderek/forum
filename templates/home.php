<h1>Homepage</h1>
<?php if (\classes\SessionWrapper::has('name')): ?>
    <h2>Logged in as: <?= \classes\SessionWrapper::get('name')?></h2>
    <h2>User id: <?= \classes\SessionWrapper::get('id') ?></h2>
    <br>
    <?php if (\classes\SessionWrapper::has('administrator')): ?>
        <a href="/admin">Administrator panel</a>
    <?php endif; ?>
    <a href="/logout">Logout</a>
<?php else: ?>
    <a href="/login">Login</a>
    <a href="/signup">Signup</a>
<?php endif; ?>

   <?php foreach ($data['threads'] as $thread):?>
<table border="1">
    <tr>
        <th>Thread</th>
        <th>Description</th>
        <th>Subthreads</th>
        <th>Topics</th>
        <th>Posts</th>
    </tr>

    <tr>
        <td><b><?= $thread->getName() ?></b></td>
        <td><?= $thread->getDescription() ?></td>
    </tr>
    <?php foreach($data['subthreads'][$thread->getName()] as $subthread): ?>
        <tr>
            <td><?= $subthread->getName() ?></td>
            <td><?= $subthread->getDescription() ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
<?php endforeach; ?>
