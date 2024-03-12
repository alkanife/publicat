<section class="user-settings">
    <div class="profile-header">
        <div class="visuals">
            <img src="<?= $this->getUserBanner([]) ?>"
                 alt="<?= $this->t('userprofile.banner.alt', 'nobody') ?>"
                 class="banner">

            <div class="pfp-container">
                <img src="<?= $this->getUserPicture([]) ?>"
                     alt="<?= $this->t('userprofile.picture.alt', 'nobody') ?>">
            </div>
        </div>
        <div class="contents">
            <div class="text">
                <p class="display-name"><?= $this->getUserDisplayName([]) ?><?= $this->getArg('verified') ?></p>
                <p class="username">@<?= $this->getArg('username') ?></p>
            </div>
            <div class="infos">
                <div class="item">
                    <p class="number">0</p>
                    <p class="name"><?= $this->t('userprofile.infos.followers.singular') ?></p>
                </div>
                <div class="item">
                    <p class="number">0</p>
                    <p class="name"><?= $this->t('userprofile.infos.following.singular') ?></p>
                </div>
                <div class="item">
                    <p class="number">0</p>
                    <p class="name"><?= $this->t('userprofile.infos.works.singular') ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="not-found">
        <p><?= $this->t('userprofile.notFound.message'); ?></p>
    </div>
</section>