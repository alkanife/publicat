<div class="error">
    <img src="<?= $this->catLogo('cat.svg') ?>" alt="Publicat logo">
    <div class="text">
        <h1><?= $this->t($this->getDisplayError()['title']) ?></h1>
        <p><?= $this->t($this->getDisplayError()['message']) ?></p>
    </div>
</div>