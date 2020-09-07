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
