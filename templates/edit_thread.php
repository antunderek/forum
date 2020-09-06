<h1>Edit thread</h1>

<form action="" method="POST">
    <label for="name">Name:</label>
    <br>
    <input typeof="text" name="name" value="<?= $data[0]->getName() ?>">
    <br>
    <lable for="description">Description:</lable>
    <br>
    <textarea maxlength="255" name="description"><?= $data[0]->getDescription() ?></textarea>
    <br>
    <input type="submit">
</form>

<!-- Ako je thread pokazati sljedece -->
<?php if (!isset($_GET['subthread'])): ?>
<h2>Edit subthreads</h2>
<table border="1">
    <tr>
        <th>Subthread</th>
        <th>Description</th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach ($data['subthreads'] as $thread):?>
        <tr>
            <td><?= $thread->getName() ?></td>
            <td><?= $thread->getDescription() ?></td>
            <td><a href="/edit/index?thread=<?= $thread->getParent() ?>&subthread=<?= $thread->getName() ?>">Edit</a></td>
            <td><a href="/edit/delete?thread=<?= $thread->getParent() ?>&subthread=<?= $thread->getName() ?>" onclick="return confirm('Are you sure you want to delete this subthread')">Delete</a></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>