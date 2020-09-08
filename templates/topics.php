<h1>Topics for <?= $_GET['thread'] ?></h1>
<a href="/topicedit/index?topic=newtopic&action=create">Create new topic</a>

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
        <td><?= $topic->getName() ?></td>
        <td><?= $topic->getDescription() ?></td>
        <td><?= $topic->getTopicCreator() ?></td>
        <td><?= $topic->getDateCreated() ?></td>
        <td>Post</td>
    </tr>
    <?php endforeach; ?>
</table>