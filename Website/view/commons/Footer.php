<?php if ($this->isPage()): ?>
    <script>
        const apiEndpoint = "<?= PUBLICAT_URL . 'json/' ?>";
        const internalError = "<?= $this->t('error.internal') ?>";
        const inputSettings = {
            username: {
                minSize: <?= MIN_USERNAME_SIZE ?>,
                maxSize: <?= MAX_USERNAME_SIZE ?>,
                errorMessages: <?= json_encode($this->t_array('error.input.username')) ?>
            },
            email: {
                minSize: <?= MIN_EMAIL_SIZE ?>,
                maxSize: <?= MAX_EMAIL_SIZE ?>,
                errorMessages: <?= json_encode($this->t_array('error.input.email')) ?>
            },
            password: {
                minSize: <?= MIN_PASSWORD_SIZE ?>,
                maxSize: <?= MAX_PASSWORD_SIZE ?>,
                errorMessages: <?= json_encode($this->t_array('error.input.password')) ?>,
                strengthMessages: <?= json_encode($this->t_array('input.password.strength')) ?>,
                toggle: <?= json_encode($this->t_array('input.password.toggle')) ?>
            },
        }
        const loginErrorMessages = {
            mail: "<?= $this->t('form.login.error.mail') ?>",
            password: "<?= $this->t('form.login.error.password') ?>",
        }
        const notificationCloseButtonHTML = "<img src=\"<?= $this->icon('x.svg') ?>\" alt=\"<?= $this->t('notification.close') ?>\" class=\"close-icon\">";
    </script>
    <script src="<?= $this->js('page.js') ?>"></script>
<?php endif; ?>

<?php
if (!empty($this->rawJavascript)) {
    foreach ($this->rawJavascript as $js) {
        echo '<script>' . $js . '</script>';
    }
}

if (!empty($this->javascript)) {
    foreach ($this->javascript as $js) {
        echo '<script src="' . $this->js($js) . '"></script>';
    }
}
?>
</body>
</html>