<p>Posts</p>

<table border="1">
    <tr>
        <th><?= $data['topic']->getName() ?></th>
        <th><?= $data['topic']->getDateCreated() ?></th>
    </tr>
    <tr>
        <td><?= $data['topic']->getDescription() ?></td>
    </tr>
    <tr>
        <td><?= $data['topic']->getTopicCreator() ?></td>
        <?php if(\classes\SessionWrapper::has('administrator') || $data['topic']->getTopicCreator() === \classes\SessionWrapper::get('name')): ?>
            <td><a href="/topic/edit?thread=<?= $data['topic']->getParent() ?>&topic=<?= $data['topic']->getId() ?>&action=update">Edit</a></td>
        <?php endif; ?>
    </tr>
</table>

<?php foreach($data['posts'] as $post): ?>
<table border="1">
    <tr>
        <th></th>
        <th><?= $post->getDatePosted() ?></th>
    </tr>
    <tr>
        <td><?= $post->getUser() ?></td>
        <td><?= $post->getContent() ?></td>
        <?php if(\classes\SessionWrapper::has('administrator') || $post->getUser() === \classes\SessionWrapper::get('name')): ?>
            <td><a href="/post/edit?id=<?= $post->getId() ?>">Edit</a></td>
            <td><a href="/post/delete?id=<?= $post->getId() ?>&user=<?= $post->getUser() ?>&topic=<?= $data['topic']->getId() ?>">Delete</a></td>
        <?php endif; ?>
    </tr>
</table>
<?php endforeach; ?>

<div>
    <p>Write post:</p>
    <form action="/post/create" method="POST">
        <textarea maxlength="255" name="content"></textarea>
        <input type="hidden" name="topic_id" value="<?= $data['topic']->getId() ?>">
        <input type="hidden" name="user_id" value="<?= \classes\SessionWrapper::get('id') ?>">
        <br>
        <input type="submit">
    </form>
</div>