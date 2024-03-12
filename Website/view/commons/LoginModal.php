<div id="login-modal" class="modal">
    <div class="modal-content">
        <div class="head form-head">
            <button class="modal-close-button">
                <img src="<?= $this->icon('x.svg') ?>" alt="<?= $this->t('mobileMenu.close') ?>" class="close-icon">
            </button>

            <h3 class="title"><?= $this->t('form.login.title') ?></h3>
        </div>

        <form action="" method="post" name="login-form">
            <div class="input-field email-input-field">
                <label for="login-email"><?= $this->t('input.email.name') ?><span class="required">*</span></label>

                <div class="input-container">
                    <input type="text" id="login-email" name="login-email" placeholder="<?= $this->t('input.email.placeholder') ?>" required>
                </div>

                <div class="input-information">
                </div>
            </div>

            <div class="input-field password-input-field">
                <label for="login-password"><?= $this->t('input.password.name') ?><span class="required">*</span></label>

                <div class="input-container">
                    <input type="password" id="login-password" name="login-password" placeholder="<?= $this->t('input.password.placeholder') ?>" required>
                    <div class="sub-label">
                        <p class="password-toggle"><?= $this->t('input.password.toggle.show') ?></p>
                    </div>
                </div>

                <div class="input-information">
                </div>
            </div>

            <p class="general-error"></p>

            <div class="input-field submit-input-field">
                <div class="input-container">
                    <button class="btn black submit-button" disabled><?= $this->t('form.login.submit') ?></button>
                </div>
            </div>
        </form>
    </div>
</div>