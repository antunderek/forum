<h1>Administrator panel</h1>

<h2>Edit threads and subthreads</h2>
<table border="1">
    <tr>
        <th>Thread</th>
        <th>Description</th>
        <th>Subthreads</th>
        <th>Topics</th>
        <td>Posts</td>
        <td></td>
        <td></td>
    </tr>
    <?php foreach ($data as $thread):?>
        <tr>
            <td><?= $thread->getName() ?></td>
            <td><?= $thread->getDescription() ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td><a href="/edit/index?thread=<?= $thread->getName() ?>">Edit</a></td>
            <td><a href="/edit/delete?thread=<?= $thread->getName() ?>"onclick="return confirm('Are you sure you want to delete this thread')">Delete</a></td>
        </tr>
    <?php endforeach; ?>
</table>
<button>Add thread</button>

<h2>Search for users</h2>