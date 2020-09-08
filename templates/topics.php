<h1>Topics for <?= $_GET['thread'] ?></h1>
<a href="/topicedit/index?thread=<?= $_GET['thread'] ?>&topic=newtopic&action=create">Create new topic</a>

<table border="1">
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Poster</th>
        <th>Date</th>
        <th>Latest post</th>
    </tr>
    <?php foreach($data as $topic): ?>
    <tr>
        <td><a href="/topic/view?topic=<?= $topic->getId() ?>"><?= $topic->getName() ?></a></td>
        <td><?= $topic->getDescription() ?></td>
        <td><?= $topic->getTopicCreator() ?></td>
        <td><?= $topic->getDateCreated() ?></td>
        <td>Post</td>
        <?php if($topic->getTopicCreator() === \classes\SessionWrapper::get('id') || \classes\SessionWrapper::has('administrator')): ?>
            <td><a href="/topicedit/index?thread=<?= $_GET['thread'] ?>&topic=<?= $topic->getId() ?>&action=update">Edit</a></td>
        <?php endif; ?>
    </tr>
    <?php endforeach; ?>
</table>