<?php if ($this->getArg('profileMenu.renderWrite')): ?>
<a class="item" href="<?= PUBLICAT_URL . 'write' ?>">
    <div class="icon">
        <img src="<?= $this->icon('write.svg') ?>" alt="<?= $this->t('nav.profile.connected.write') ?>">
    </div>
    <?= $this->t('nav.profile.connected.write') ?>
</a>
<?php endif; ?>

<hr>

<a class="item" href="<?= PUBLICAT_URL . 'user/' . $this->getLoggedUser()['username'] ?>">
    <div class="icon">
        <img src="<?= $this->icon('profile.svg') ?>" alt="<?= $this->t('nav.profile.connected.profile') ?>">
    </div>
    <?= $this->t('nav.profile.connected.profile') ?>
</a>

<a class="item" href="<?= PUBLICAT_URL . 'user/' . $this->getLoggedUser()['username'] ?>">
    <div class="icon">
        <img src="<?= $this->icon('works.svg') ?>" alt="<?= $this->t('nav.profile.connected.works') ?>">
    </div>
    <?= $this->t('nav.profile.connected.works') ?>
</a>

<a class="item" href="<?= PUBLICAT_URL . 'favorites'?>">
    <div class="icon">
        <img src="<?= $this->icon('favorites.svg') ?>" alt="<?= $this->t('nav.profile.connected.favorites') ?>">
    </div>
    <?= $this->t('nav.profile.connected.favorites') ?>
</a>

<hr>

<a class="item" href="<?= PUBLICAT_URL . 'user-settings' ?>">
    <div class="icon">
        <img src="<?= $this->icon('settings.svg') ?>" alt="<?= $this->t('nav.profile.connected.settings') ?>">
    </div>
    <?= $this->t('nav.profile.connected.settings') ?>
</a>

<a class="item logout" onclick="openModal('logout-modal')">
    <div class="icon">
        <img src="<?= $this->icon('logout.svg') ?>" alt="<?= $this->t('nav.profile.connected.logout.name') ?>">
    </div>
    <?= $this->t('nav.profile.connected.logout.name') ?>
</a>