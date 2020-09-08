<h1><?= ucfirst($this->getActionName()) ?> topic</h1>

<form action="<?= $this->getActionName() ?>" method="POST">
    <label for="name">Name:</label>
    <br>
    <input typeof="text" name="name" value="<?= $this->getTopicName($data) ?>">
    <br>
    <lable for="description">Description:</lable>
    <br>
    <textarea maxlength="255" name="description"><?= $this->getTopicDescription($data) ?></textarea>
    <br>
    <lable for="Thread">Thread:</lable>
    <br>
    <p>Drop down of available threads only if creating new topic</p>
    <br>

    <?php if(!$this->isNewTopic()): ?>
        <input type="hidden" name="original_topic" value="<?= $this->getTopicName($data) ?>">
    <?php endif; ?>
    <input type="submit">
</form>

<?php if(!$this->isNewTopic()): ?>
    <a href="delete?topic=<?= $this->getThreadName($data) ?>&action=delete"><button>Delete topic</button></a>
<?php endif; ?>
