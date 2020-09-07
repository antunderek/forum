<h1><?= ucfirst($this->getActionName()) ?> thread</h1>

<form action="<?= $this->getActionName() ?>" method="POST">
    <label for="name">Name:</label>
    <br>
    <input typeof="text" name="name" value="<?= $this->getThreadName($data) ?>">
    <br>
    <lable for="description">Description:</lable>
    <br>
    <textarea maxlength="255" name="description"><?= $this->getThreadDescription($data) ?></textarea>
    <br>
    <input type="hidden" name="original_thread" value="<?= $this->getThreadName($data) ?>">
    <input type="submit">
</form>

<!-- Ako je thread pokazati sljedece -->
<?php if (!isset($_GET['subthread']) && !$this->isNewThread()): ?>
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
    <button>Add  subthread</button>
<?php endif; ?>