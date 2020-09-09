<h1>Administrator panel</h1>

<h2>Edit threads</h2>
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
    <?php foreach ($data['threads'] as $thread):?>
        <tr>
            <td><?= $thread->getName() ?></td>
            <td><?= $thread->getDescription() ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td><a href="/thread/index?thread=<?= $thread->getName() ?>">Edit</a></td>
            <td><a href="/thread/delete?thread=<?= $thread->getName() ?>" onclick="return confirm('Are you sure you want to delete this thread')">Delete</a></td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="/thread/index?thread=newthread&action=create"><button>Add thread</button></a>

<h2>Users</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
    </tr>
    <?php foreach ($data['users'] as $user):?>
        <tr>
            <td><?= $user->getId() ?></td>
            <td><?= $user->getUsername() ?></td>
            <td><?= $user->getEmail() ?></td>
            <td><a href="">Edit</a></td>
            <td>Delete</td>
        </tr>
    <?php endforeach; ?>
</table>