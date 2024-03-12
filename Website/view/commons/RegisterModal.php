<div id="register-modal" class="modal">
    <div class="modal-content">
        <div class="head form-head">
            <button class="modal-close-button">
                <img src="<?= $this->icon('x.svg') ?>" alt="<?= $this->t('mobileMenu.close') ?>" class="close-icon">
            </button>

            <h3 class="title"><?= $this->t('form.signIn.title') ?></h3>
            <p class="description"><?= $this->t('form.signIn.description') ?></p>
        </div>

        <form action="" method="post" name="register-form">
            <div class="input-field username-input-field modification-input">
                <label for="register-username"><?= $this->t('input.username.name') ?><span class="required">*</span></label>

                <div class="input-container">
                    <input type="text" id="register-username" name="register-username" placeholder="<?= $this->t('input.username.placeholder') ?>" maxlength="<?= MAX_USERNAME_SIZE ?>" required>
                    <div class="sub-label">
                        <p class="counter"></p>
                    </div>
                </div>

                <div class="input-information">
                    <div class="info-message">
                        <p><?= $this->t('input.username.obligations.title') ?></p>
                        <ul>
                            <?php foreach ($this->t_array('input.username.obligations.values', true) as $obligation): ?>
                                <li><?= $obligation ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="input-field email-input-field modification-input">
                <label for="register-email"><?= $this->t('input.email.name') ?><span class="required">*</span></label>

                <div class="input-container">
                    <input type="email" id="register-email" name="register-email" placeholder="<?= $this->t('input.email.placeholder') ?>" maxlength="<?= MAX_EMAIL_SIZE ?>" required>
                </div>

                <div class="input-information">
                </div>
            </div>

            <div class="input-field password-input-field modification-input">
                <label for="register-password"><?= $this->t('input.password.name') ?><span class="required">*</span></label>

                <div class="input-container">
                    <input type="password" id="register-password" name="register-password" placeholder="<?= $this->t('input.password.placeholder') ?>" maxlength="<?= MAX_PASSWORD_SIZE ?>" required>
                    <div class="sub-label">
                        <p class="password-toggle"><?= $this->t('input.password.toggle.show') ?></p>
                    </div>
                </div>

                <div class="input-information">
                    <div class="info-message">
                        <div class="password-indicator">
                            <p class="text"><?= $this->t('input.password.strength.tooRisky') ?></p>
                            <div class="bar-wrapper">
                                <div class="bar"></div>
                            </div>
                        </div>
                        <p><?= $this->t('input.password.obligations') ?></p>
                    </div>
                </div>
            </div>

            <div class="input-field password-confirm-input-field modification-input">
                <label for="register-password-confirm"><?= $this->t('input.passwordConfirm.name') ?><span class="required">*</span></label>

                <div class="input-container">
                    <input type="password" id="register-password-confirm" name="register-password-confirm" placeholder="<?= $this->t('input.passwordConfirm.placeholder') ?>" maxlength="<?= MAX_PASSWORD_SIZE ?>" required>
                    <div class="sub-label">
                        <p class="password-toggle"><?= $this->t('input.password.toggle.show') ?></p>
                    </div>
                </div>

                <div class="input-information">
                    <div class="info-message">
                    </div>
                </div>
            </div>

            <div class="input-field tos-input-field modification-input">
                <div class="input-container">
                    <input type="checkbox" id="register-tos" name="register-tos" required>
                </div>

                <label for="register-tos"><?= $this->t('input.tos') ?><span class="required">*</span></label>
            </div>

            <div class="input-field submit-input-field">
                <div class="input-container">
                    <button class="btn black submit-button" disabled><?= $this->t('form.signIn.submit') ?></button>
                </div>
            </div>
        </form>
    </div>
</div>