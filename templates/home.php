<h1>Homepage</h1>
<a href="/login">Login</a>
<a href="/signup">Signup</a>

<table style="border: solid 1px; width: 50%">
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