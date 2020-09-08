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
    <lable for="thread">Thread:</lable>
    <br>
    <!--<select name="thread">
        <option value="">Add thread model to controller</option>
    </select>
    -->
    <br>
    <input type="hidden" name="current_thread" value="<?= $_GET['thread'] ?>">
    <input type="hidden" name="id" value="<?= $_GET['topic'] ?>">

    <?php if(!$this->isNewTopic()): ?>
        <input type="hidden" name="original_topic" value="<?= $this->getTopicName($data) ?>">
    <?php endif; ?>

    <input type="submit">
</form>

<?php if(!$this->isNewTopic()): ?>
    <a href="delete?thread=<?= $_GET['thread'] ?>&topic=<?= $this->getTopicId($data) ?>&action=delete"><button>Delete topic</button></a>
<?php endif; ?>
