<section class="user-settings">
    <div class="content">
        <h1 class="title"><?= $this->t('usersettings.sectionTitle') ?></h1>

        <div class="profile">
            <h3><?= $this->t('usersettings.profile.title') ?></h3>
            <form action="" method="post">
                <div class="input-container <?= $this->getErrorClass('display-name') ?>">
                    <label for="display-name"><?= $this->t('usersettings.profile.displayName.label') ?></label>
                    <input type="text"
                           id="display-name"
                           name="display-name"
                           placeholder="<?= $this->t('usersettings.profile.displayName.placeholder') ?>"
                           maxlength="<?= MAX_DISPLAY_NAME_SIZE ?>"
                           value="<?= $this->getArg('display-name') ?>">
                    <?= $this->getErrorMessage('display-name') ?>
                </div>

                <div class="input-container <?= $this->getErrorClass('about-me') ?>">
                    <label for="about-me"><?= $this->t('usersettings.profile.aboutMe.label') ?></label>
                    <textarea id="about-me"
                              name="about-me"
                              placeholder="<?= $this->t('usersettings.profile.aboutMe.placeholder') ?>"
                              maxlength="<?= MAX_ABOUT_ME_SIZE ?>"><?= $this->getArg('about-me') ?></textarea>
                    <?= $this->getErrorMessage('about-me') ?>
                </div>

                <div class="input-container birthdate <?= $this->getErrorClass('birthdate') ?>">
                    <label for="birthdate"><?= $this->t('usersettings.profile.birthdate.label') ?></label>
                    <p class="warning"><?= $this->t('usersettings.profile.birthdate.warning') ?></p>
                    <input type="date"
                           id="birthdate"
                           name="birthdate"
                           value="<?= $this->getArg('birthdate') ?>">
                    <?= $this->getErrorMessage('birthdate') ?>
                </div>

                <button class="btn black" name="profileUpdate"><?= $this->t('usersettings.profile.submit') ?></button>
            </form>
        </div>

        <hr>

        <div class="pictures">
            <h3><?= $this->t('usersettings.pictures.title') ?></h3>

            <div class="picture-settings">
                <div class="preview">
                    <div class="visuals">
                        <img src="<?= $this->getLoggedUserBanner() ?>"
                             alt="<?= $this->t('usersettings.banner.alt') ?>"
                             class="banner">

                        <div class="pfp-container">
                            <img src="<?= $this->getLoggedUserPicture() ?>"
                                 alt="<?= $this->t('usersettings.picture.alt') ?>">
                        </div>
                    </div>
                    <div class="name">
                        <p class="display-name"><?= $this->getLoggedDisplayName() ?></p>
                        <p class="username">@<?= $this->getLoggedUser()['username'] ?></p>
                    </div>
                </div>

                <div class="inputs">
                    <p class="message"><?= $this->t('usersettings.pictures.message') ?></p>

                    <div>
                        <div class="profile-picture">
                            <form action="" method="post" enctype="multipart/form-data" id="pictureForm" class="<?= $this->getErrorClass('picture') ?>">
                                <label for="picture"><?= $this->t('usersettings.picture.label') ?></label>
                                <div class="input-container">
                                    <input type="file" id="picture" name="picture" accept="image/png, image/jpeg">
                                    <button class="btn black" name="pictureUpdate" id="pictureButton"><?= $this->t('usersettings.picture.submit') ?></button>
                                </div>
                                <?= $this->getErrorMessage('picture') ?>
                            </form>
                        </div>

                        <div class="banner">
                            <form action="" method="post" enctype="multipart/form-data" id="bannerForm" class="<?= $this->getErrorClass('banner') ?>">
                                <label for="banner"><?= $this->t('usersettings.banner.label') ?></label>
                                <div class="input-container">
                                    <input type="file" id="banner" name="banner" accept="image/png, image/jpeg">
                                    <button class="btn black" name="bannerUpdate" id="bannerButton"><?= $this->t('usersettings.banner.submit') ?></button>
                                </div>
                                <?= $this->getErrorMessage('banner') ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="account">
            <h3><?= $this->t('usersettings.account.title') ?></h3>
            <form action="" method="post">
                <div class="input-container <?= $this->getErrorClass('username') ?>">
                    <label for="username"><?= $this->t('usersettings.account.username.label') ?></label>
                    <input type="text"
                           id="username"
                           name="username"
                           placeholder="<?= $this->t('usersettings.account.username.placeholder') ?>"
                           maxlength="<?= MAX_USERNAME_SIZE ?>"
                           value="<?= $this->getArg('username') ?>">
                    <?= $this->getErrorMessage('username') ?>
                    <div class="obligations">
                        <p><?= $this->t('input.username.obligations.title') ?></p>
                        <ul>
                            <?php foreach ($this->t_array('input.username.obligations.values', true) as $obligation): ?>
                                <li><?= $obligation ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="input-container <?= $this->getErrorClass('email') ?>">
                    <label for="email"><?= $this->t('usersettings.account.email.label') ?></label>
                    <input type="email"
                           id="email"
                           name="email"
                           placeholder="<?= $this->t('usersettings.account.email.placeholder') ?>"
                           maxlength="<?= MAX_EMAIL_SIZE ?>"
                           value="<?= $this->getArg('email') ?>">
                    <?= $this->getErrorMessage('email') ?>
                </div>
                <button class="btn black" name="accountUpdate"><?= $this->t('usersettings.account.submit') ?></button>
            </form>
        </div>

        <hr>

        <div class="password">
            <h3><?= $this->t('usersettings.password.title') ?></h3>
            <form action="" method="post">
                <div class="input-container  <?= $this->getErrorClass('password') ?>">
                    <div class="password-label">
                        <label for="password"><?= $this->t('usersettings.password.oldPassword.label') ?></label>
                        <p onclick="togglePasswordLabel(this, 'password')"><?= $this->t('input.password.toggle.show') ?></p>
                    </div>
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="<?= $this->t('usersettings.password.oldPassword.placeholder') ?>"
                           maxlength="<?= MAX_PASSWORD_SIZE ?>"
                           value="<?= $this->getArg('password') ?>">
                    <?= $this->getErrorMessage('password') ?>
                </div>

                <div class="input-container  <?= $this->getErrorClass('newPassword') ?>">
                    <div class="password-label">
                        <label for="newPassword"><?= $this->t('usersettings.password.newPassword.label') ?></label>
                        <p onclick="togglePasswordLabel(this, 'newPassword')"><?= $this->t('input.password.toggle.show') ?></p>
                    </div>
                    <input type="password"
                           id="newPassword"
                           name="newPassword"
                           placeholder="<?= $this->t('usersettings.password.newPassword.placeholder') ?>"
                           maxlength="<?= MAX_PASSWORD_SIZE ?>"
                           value="<?= $this->getArg('newPassword') ?>">
                    <?= $this->getErrorMessage('newPassword') ?>
                    <div class="obligations">
                        <p><?= $this->t('input.password.obligations') ?></p>
                    </div>
                </div>
                <button class="btn black" name="passwordUpdate"><?= $this->t('usersettings.profile.submit') ?></button>
            </form>
        </div>

        <hr>

        <div class="deleteAccount">
            <h3><?= $this->t('usersettings.dangerZone.title') ?></h3>
            <p><?= $this->t('usersettings.dangerZone.description') ?></p>
            <div>
                <button class="btn" onclick="openModal('deleteAccountModal')"><?= $this->t('usersettings.dangerZone.delete.title') ?></button>
                <?php if ($this->isLoggedUserFromPublicatTeam()): ?>
                <button class="btn" onclick="openModal('revokeModal')"><?= $this->t('usersettings.dangerZone.revokePermissions.title') ?></button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<div id="removePictureModal" class="modal dangerous">
    <div class="modal-content">
        <div class="head message-head">
            <button class="modal-close-button">
                <img src="<?= $this->icon('x.svg') ?>" alt="<?= $this->t('usersettings.picture.delete.close') ?>" class="close-icon">
            </button>

            <h3 class="title"><?= $this->t('usersettings.picture.delete.title') ?></h3>
        </div>

        <p><?= $this->t('usersettings.picture.delete.message') ?></p>

        <button class="btn black" id="confirmDeletePicture"><?= $this->t('usersettings.picture.delete.deleteButton') ?></button>
    </div>
</div>

<div id="removeBannerModal" class="modal dangerous">
    <div class="modal-content">
        <div class="head message-head">
            <button class="modal-close-button">
                <img src="<?= $this->icon('x.svg') ?>" alt="<?= $this->t('usersettings.banner.delete.close') ?>" class="close-icon">
            </button>

            <h3 class="title"><?= $this->t('usersettings.banner.delete.title') ?></h3>
        </div>

        <p><?= $this->t('usersettings.banner.delete.message') ?></p>

        <button class="btn black" id="confirmDeleteBanner"><?= $this->t('usersettings.banner.delete.deleteButton') ?></button>
    </div>
</div>

<div id="deleteAccountModal" class="modal dangerous">
    <div class="modal-content">
        <div class="head message-head">
            <button class="modal-close-button">
                <img src="<?= $this->icon('x.svg') ?>" alt="<?= $this->t('usersettings.dangerZone.delete.close') ?>" class="close-icon">
            </button>

            <h3 class="title"><?= $this->t('usersettings.dangerZone.delete.title') ?></h3>
        </div>

        <p><?= $this->t('usersettings.dangerZone.delete.message') ?></p>

        <form action="" method="post">
            <button class="btn black" name="deleteMe"><?= $this->t('usersettings.dangerZone.delete.deleteButton') ?></button>
        </form>
    </div>
</div>

<?php if ($this->isLoggedUserFromPublicatTeam()): ?>
<div id="revokeModal" class="modal dangerous">
    <div class="modal-content">
        <div class="head message-head">
            <button class="modal-close-button">
                <img src="<?= $this->icon('x.svg') ?>" alt="<?= $this->t('usersettings.dangerZone.revokePermissions.close') ?>" class="close-icon">
            </button>

            <h3 class="title"><?= $this->t('usersettings.dangerZone.revokePermissions.title') ?></h3>
        </div>

        <p><?= $this->t('usersettings.dangerZone.revokePermissions.message') ?></p>

        <form action="" method="post">
            <button class="btn black" name="revokeMe"><?= $this->t('usersettings.dangerZone.revokePermissions.revokeButton') ?></button>
        </form>
    </div>
</div>
<?php endif; ?>