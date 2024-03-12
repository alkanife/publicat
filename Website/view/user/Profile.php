<?php $user = $this->getArg('user') ?>

<section class="user-settings">
    <div class="profile-header">
        <div class="visuals">
            <img src="<?= $this->getUserBanner($user) ?>"
                 alt="<?= $this->t('userprofile.banner.alt', $user['username']) ?>"
                 class="banner">

            <div class="pfp-container">
                <img src="<?= $this->getUserPicture($user) ?>"
                     alt="<?= $this->t('userprofile.picture.alt', $user['username']) ?>">
            </div>

            <?php if (!$this->isUserConnected()): ?>
                <div class="button follow" onclick="openModal('login-modal')">
                    <img src="<?= $this->icon('follow.svg') ?>" alt="<?= $this->t('userprofile.follow') ?>">
                    <p><?= $this->t('userprofile.follow') ?></p>
                </div>
            <?php else: ?>
                <?php if ($this->getArg('isLoggedUserProfile')): ?>
                    <div class="button settings">
                        <a href="<?= PUBLICAT_URL . 'user-settings' ?>">
                            <img src="<?= $this->icon('settings.svg') ?>" alt="<?= $this->t('userprofile.settings') ?>">
                            <p><?= $this->t('userprofile.settings') ?></p>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="button following"
                         id="following-button"
                         style="display: <?= $user['isFollowedByLoggedUser'] ? '' : 'none' ?>">
                        <img src="<?= $this->icon('following.svg') ?>" alt="<?= $this->t('userprofile.following.name') ?>">
                        <p><?= $this->t('userprofile.following.name') ?></p>
                    </div>
                    <div class="button follow"
                         id="follow-button"
                         style="display: <?= $user['isFollowedByLoggedUser'] ? 'none' : '' ?>">
                        <img src="<?= $this->icon('follow.svg') ?>" alt="<?= $this->t('userprofile.follow') ?>">
                        <p><?= $this->t('userprofile.follow.name') ?></p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="contents">
            <div class="text">
                <p class="display-name"><?= $this->getUserDisplayName($user) ?><?= $this->getArg('verified') ?></p>
                <p class="username">@<?= $user['username'] ?></p>
            </div>
            <div class="infos">
                <div class="item">
                    <p class="number"><?= $user['followers'] ?></p>
                    <?php if ($user['followers'] > 1): ?>
                        <p class="name"><?= $this->t('userprofile.infos.followers.plural') ?></p>
                    <?php else: ?>
                        <p class="name"><?= $this->t('userprofile.infos.followers.singular') ?></p>
                    <?php endif; ?>
                </div>
                <div class="item">
                    <p class="number"><?= $user['following'] ?></p>
                    <?php if ($user['following'] > 1): ?>
                        <p class="name"><?= $this->t('userprofile.infos.following.plural') ?></p>
                    <?php else: ?>
                        <p class="name"><?= $this->t('userprofile.infos.following.singular') ?></p>
                    <?php endif; ?>
                </div>
                <div class="item">
                    <p class="number"><?= $user['works'] ?></p>
                    <?php if ($user['works'] > 1): ?>
                        <p class="name"><?= $this->t('userprofile.infos.works.plural') ?></p>
                    <?php else: ?>
                        <p class="name"><?= $this->t('userprofile.infos.works.singular') ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="profile-body">
        <div class="additional">
            <?php if ($user['aboutMe']): ?>
                <div class="about-me">
                    <p><?= $user['aboutMe'] ?></p>
                </div>
                <hr>
            <?php endif; ?>
            <p><?= $this->t('userprofile.infos.joined', $this->getArg('registeredDateTime')) ?></p>
        </div>
        <div class="body">
            <h1 class="title"><?= $this->t('userprofile.works.title') ?></h1>

            <div class="no-publications">
                <img src="<?= $this->icon('no-publications.svg') ?>" alt="<?= $this->t('userprofile.works.none.alt') ?>">
                <p><?= $this->t('userprofile.works.none.message', $this->getUserDisplayName($user)) ?></p>
            </div>
        </div>
    </div>
</section>