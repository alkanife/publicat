<nav>
    <div class="content">
        <div class="logo">
            <a href="/" id="navigation-logo-anchor">
                <img src="<?= $this->catLogo('cat.svg') ?>" alt="Publicat" class="cat">
                <img src="<?= $this->fullLogo('full.svg') ?>" alt="Publicat" class="full">
            </a>
        </div>

        <form action="" method="post" role="search" id="navigation-search-form" class="search">
            <div class="search-field" id="navigation-search-field">
                <button class="search-button" id="navigation-search-button">
                    <img src="<?= $this->icon('search.svg') ?>" alt="<?= $this->t('nav.search.toggleMobileSearch') ?>">
                </button>
                <div class="search-input">
                    <input type="text" id="nav-search-input" name="search-input" placeholder="<?= $this->t('nav.search.placeholder') ?>">
                    <label for="nav-search-input"><?= $this->t('nav.search.placeholder') ?></label>
                </div>
            </div>
        </form>

        <?php
        $this->addArgument('profileMenu.renderWrite', true);
        if ($this->isUserConnected()):
        ?>
        <div class="profile connected">
            <button class="picture" id="navigation-profile-button">
                <img src="<?= $this->getLoggedUserPicture() ?>" alt="<?= $this->t('nav.profile.connected.icon') ?>">
            </button>
            <div class="desktop-name" id="navigation-profile-dropdown-button">
                <p><?= $this->getLoggedUser()['username'] ?></p>
                <img src="<?= $this->icon('dropdown.svg') ?>" alt="<?= $this->t('nav.profile.connected.dropdown') ?>">
            </div>
            <div id="profile-dropdown">
                <?php $this->renderViewNow('commons/ProfileMenu.php') ?>
            </div>
        </div>
        <?php else: ?>
        <div class="profile not-connected">
            <button class="picture" id="navigation-profile-button">
                <img src="<?= $this->getLoggedUserPicture() ?>" alt="<?= $this->t('nav.profile.notConnected.icon') ?>">
            </button>
            <div class="connect">
                <button class="btn black trigger-login"><?= $this->t('nav.connect.login') ?></button>
                <button class="btn outline-black trigger-register"><?= $this->t('nav.connect.register') ?></button>
            </div>
        </div>
        <?php endif; ?>
    </div>
</nav>

<div id="mobile-menu" class="<?= $this->isUserConnected() ? 'connected' : 'not-connected' ?>">
    <div class="title">
        <h4><?= $this->t('mobileMenu.title') ?></h4>
        <button id="mobile-menu-close-button">
            <img src="<?= $this->icon('x.svg') ?>" alt="<?= $this->t('mobileMenu.close') ?>" class="close-icon">
        </button>
    </div>
    <div class="content">
        <?php if ($this->isUserConnected()): ?>
        <div class="top">
            <div class="profile-card">
                <div class="images">
                    <img src="<?= $this->getLoggedUserBanner() ?>" alt="<?= $this->t('nav.profile.connected.icon') ?>" class="banner">
                    <div class="profile-picture">
                        <img src="<?= $this->getLoggedUserPicture() ?>" alt="<?= $this->t('nav.profile.connected.icon') ?>">
                    </div>
                </div>

                <div class="infos">
                    <p class="display-name"><?= $this->getLoggedDisplayName() ?></p>
                    <p class="username">@<?= $this->getLoggedUser()['username'] ?></p>
                </div>
            </div>
            <div class="menu">
                <?php
                $this->addArgument('profileMenu.renderWrite', false);
                $this->renderViewNow('commons/ProfileMenu.php');
                ?>
            </div>
        </div>
        <div class="bottom">
            <a href="<?= PUBLICAT_URL . 'write' ?>" class="write-button">
                <div class="icon">
                    <img src="<?= $this->icon('write.svg') ?>" alt="<?= $this->t('nav.profile.connected.write') ?>">
                </div>
                <?= $this->t('nav.profile.connected.write') ?>
            </a>
        </div>
        <?php else: ?>
        <img src="<?= $this->icon('books.svg') ?>" alt="<?= $this->t('mobileMenu.notConnected.books') ?>">
        <p><?= $this->t('mobileMenu.notConnected.text') ?></p>
        <hr>
        <div class="connect">
            <button class="btn black trigger-login"><?= $this->t('mobileMenu.notConnected.login') ?></button>
            <button class="btn outline-black trigger-register"><?= $this->t('mobileMenu.notConnected.register') ?></button>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if ($this->isUserConnected()): ?>
<div id="logout-modal" class="modal dangerous">
    <div class="modal-content">
        <div class="head message-head">
            <button class="modal-close-button">
                <img src="<?= $this->icon('x.svg') ?>" alt="<?= $this->t('nav.profile.connected.logout.close') ?>" class="close-icon">
            </button>

            <h3 class="title"><?= $this->t('nav.profile.connected.logout.title') ?></h3>
        </div>

        <p><?= $this->t('nav.profile.connected.logout.message') ?></p>

        <form action="<?= PUBLICAT_URL ?>home" method="post">
            <button class="btn black" name="logMeOut"><?= $this->t('nav.profile.connected.logout.confirm') ?></button>
        </form>
    </div>
</div>
<?php endif; ?>