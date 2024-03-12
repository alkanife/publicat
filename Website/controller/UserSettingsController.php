<?php
namespace Publicat\Controller;

use Publicat\model\user\Users;
use Publicat\Util\FileUploads;
use Publicat\Util\InputUtils;
use Publicat\Util\InputValidation;
use Publicat\Util\Render;
use Throwable;

/**
 * Handle /user-settings
 */
class UserSettingsController extends Controller {
    use Render;
    use InputValidation;
    use FileUploads;
    use InputUtils;

    /**
     * User settings
     * Method: GET|POST - Route: /user-settings
     *
     * @throws Throwable
     */
    public function userSettings(): void {
        if (!$this->isUserConnected()) {
            header('location: /home');
            return;
        }

        $this->renderStartPage();

        $this->addArgument('display-name', $this->getLoggedUser()['displayName']);
        $this->addArgument('about-me', $this->getLoggedUser()['aboutMe']);
        $this->addArgument('birthdate', $this->getLoggedUser()['birthdate']);
        $this->addArgument('username', $this->getLoggedUser()['username']);
        $this->addArgument('email', $this->getLoggedUser()['emailAddress']);

        if (!empty($_POST)) {
            $this->handleProfileUpdate();
            $this->handlePictureUpdate();
            $this->handleBannerUpdate();
            $this->handleAccountUpdate();
            $this->handlePasswordUpdate();
            $this->handleDanger();
        }

        $this->renderCSS('user/user-settings.css');
        $this->renderTitle($this->t('usersettings.title'));
        $this->renderView('user/UserSettings.php');
        $this->renderJavascript('user-settings.js');
        $this->renderEnd();
    }

    /**
     * Handle profile update (POST)
     *
     * @return void
     */
    private function handleProfileUpdate(): void {
        if (!array_key_exists('profileUpdate', $_POST)) {
            return;
        }

        $displayName = $this->getLoggedUser()['displayName'];
        $aboutMe = $this->getLoggedUser()['aboutMe'];
        $birthdate = $this->getLoggedUser()['birthdate'];

        if (isset($_POST['display-name'])) {
            // Placeholder
            $this->addArgument('display-name', $_POST['display-name']);

            // Handle data
            $cleanedDisplayName = $this->cleanUserInput($_POST['display-name']);

            if (empty($cleanedDisplayName)) {
                $displayName = null;
            } else {
                if ($this->isTextInputValid($cleanedDisplayName, MIN_DISPLAY_NAME_SIZE, MAX_DISPLAY_NAME_SIZE)) {
                    $displayName = $cleanedDisplayName;
                } else {
                    $this->getErrorHandler()->addError('display-name', 'usersettings.profile.displayName.invalid');
                }
            }
        }

        if (isset($_POST['about-me'])) {
            // Placeholder
            $this->addArgument('about-me', $_POST['about-me']);

            // Handle data
            $cleanedAboutMe = $this->cleanUserInput($_POST['about-me']);

            if (empty($cleanedAboutMe)) {
                $aboutMe = null;
            } else {
                if ($this->isTextInputValid($cleanedAboutMe, MIN_ABOUT_ME_SIZE, MAX_ABOUT_ME_SIZE)) {
                    $aboutMe = $cleanedAboutMe;
                } else {
                    $this->getErrorHandler()->addError('about-me', 'usersettings.profile.aboutMe.invalid');
                }
            }
        }

        if (isset($_POST['birthdate'])) {
            // Placeholder
            $this->addArgument('birthdate', $_POST['birthdate']);

            // Handle data
            $cleanedDate = $this->cleanUserInput($_POST['birthdate']);

            if (empty($cleanedDate)) {
                $birthdate = null;
            } else {
                if (preg_match(REGEX_DATE, $cleanedDate) && $this->isDateValid($cleanedDate)) {
                    $thisYear = intval(date('Y'));
                    $year = intval(explode('-', $cleanedDate)[0]);

                    if ($year == $thisYear) {
                        $this->getErrorHandler()->addError('birthdate', 'usersettings.profile.birthdate.invalid.thisYear');
                    } else if ($year > $thisYear) {
                        $this->getErrorHandler()->addError('birthdate', 'usersettings.profile.birthdate.invalid.aboveThisYear');
                    } else if ($year < $thisYear-120) {
                        $this->getErrorHandler()->addError('birthdate', 'usersettings.profile.birthdate.invalid.tooOld');
                    } else {
                        $birthdate = $cleanedDate;
                    }
                } else {
                    $this->getErrorHandler()->addError('birthdate', 'usersettings.profile.birthdate.invalid.format');
                }
            }
        }

        $updateValues = [];

        if ($displayName != $this->getLoggedUser()['displayName']) {
            $updateValues['displayName'] = $displayName;
        }

        if ($aboutMe != $this->getLoggedUser()['aboutMe']) {
            $updateValues['aboutMe'] = $aboutMe;
        }

        if ($birthdate != $this->getLoggedUser()['birthdate']) {
            $updateValues['birthdate'] = $birthdate;
        }

        if (!empty($updateValues)) {
            try {
                $userModel = new Users();
                $userModel->updateById($this->getLoggedUser()['id'], $updateValues);

                $this->updateLoggedUser('displayName', $displayName);
                $this->updateLoggedUser('aboutMe', $aboutMe);
                $this->updateLoggedUser('birthdate', $birthdate);

                $this->createNotification($this->t('usersettings.success'), 'success');
            } catch (Throwable $t) {
                $this->createNotification($this->t('usersettings.error'), 'error');
            }
        }
    }

    /**
     * Handle profile picture update (POST)
     *
     * @return void
     */
    private function handlePictureUpdate(): void {
        if (!array_key_exists('pictureUpdate', $_POST)) {
            return;
        }

        $profilePicture = null;
        $response = $this->handlePictureUpload('picture');

        switch ($response) {
            case 'error_internal':
                $this->createNotification($this->t('usersettings.picture.error.internal'), 'error');
                return;

            case 'error_size':
                $this->getErrorHandler()->addError('picture', 'usersettings.picture.error.size');
                return;

            case 'error_extension':
                $this->getErrorHandler()->addError('picture', 'usersettings.picture.error.extension');
                return;

            case 'empty':
                if ($this->getLoggedUser()['profilePicture'] == null)
                    return;

                break;

            default:
                $profilePicture = $response;
                break;
        }

        try {
            $userModel = new Users();
            $userModel->updateById($this->getLoggedUser()['id'], ['profilePicture' => $profilePicture]);

            if ($profilePicture == null) {
                $this->createNotification($this->t('usersettings.picture.success.remove'), 'success');
                $this->deleteFile('user-media', $this->getLoggedUser()['profilePicture']);
            } else {
                $this->createNotification($this->t('usersettings.picture.success.upload'), 'success');
            }

            $this->updateLoggedUser('profilePicture', $profilePicture);
        } catch (Throwable $t) {
            $this->createNotification($this->t('usersettings.picture.error.internal'), 'error');
        }
    }

    /**
     * Handle profile banner update (POST)
     *
     * @return void
     */
    private function handleBannerUpdate(): void {
        if (!array_key_exists('bannerUpdate', $_POST)) {
            return;
        }

        $bannerPicture = null;
        $response = $this->handlePictureUpload('banner');

        switch ($response) {
            case 'error_internal':
                $this->createNotification($this->t('usersettings.banner.error.internal'), 'error');
                return;

            case 'error_size':
                $this->getErrorHandler()->addError('banner', 'usersettings.banner.error.size');
                return;

            case 'error_extension':
                $this->getErrorHandler()->addError('banner', 'usersettings.banner.error.extension');
                return;

            case 'empty':
                if ($this->getLoggedUser()['bannerPicture'] == null)
                    return;

                break;

            default:
                $bannerPicture = $response;
                break;
        }

        try {
            $userModel = new Users();
            $userModel->updateById($this->getLoggedUser()['id'], ['bannerPicture' => $bannerPicture]);

            if ($bannerPicture == null) {
                $this->createNotification($this->t('usersettings.banner.success.remove'), 'success');
                $this->deleteFile('user-media', $this->getLoggedUser()['bannerPicture']);
            } else {
                $this->createNotification($this->t('usersettings.banner.success.upload'), 'success');
            }

            $this->updateLoggedUser('bannerPicture', $bannerPicture);
        } catch (Throwable $t) {
            $this->createNotification($this->t('usersettings.banner.error.internal'), 'error');
        }
    }

    /**
     * Handle account update (POST)
     *
     * @return void
     */
    private function handleAccountUpdate(): void {
        if (!array_key_exists('accountUpdate', $_POST)) {
            return;
        }

        $username = $this->getLoggedUser()['username'];
        $emailAddress = $this->getLoggedUser()['emailAddress'];

        if (isset($_POST['username'])) {
            // Placeholder
            $this->addArgument('username', $_POST['username']);

            // Handle data
            $cleanedUsername = $this->cleanUserInput($_POST['username']);

            if (empty($cleanedUsername)) {
                $this->getErrorHandler()->addError('username', 'error.input.username.empty');
            } else {
                if ($username != $cleanedUsername) {
                    $validity = $this->isUsernameValid($cleanedUsername);

                    if ($validity['isValid']) {
                        if ($validity['isTaken']) {
                            $this->getErrorHandler()->addError('username', 'error.input.username.taken');
                        } else {
                            $username = $cleanedUsername;
                        }
                    } else {
                        $this->getErrorHandler()->addError('username', 'error.input.username.invalid');
                    }
                }
            }
        }

        if (isset($_POST['email'])) {
            // Placeholder
            $this->addArgument('email', $_POST['email']);

            // Handle data
            $cleanedEmail = $this->cleanUserInput($_POST['email']);

            if (empty($cleanedEmail)) {
                $this->getErrorHandler()->addError('email', 'error.input.email.empty');
            } else {
                if ($emailAddress != $cleanedEmail) {
                    $validity = $this->isEmailValid($cleanedEmail);

                    if ($validity['isValid']) {
                        if ($validity['isTaken']) {
                            $this->getErrorHandler()->addError('email', 'error.input.email.taken');
                        } else {
                            $emailAddress = $cleanedEmail;
                        }
                    } else {
                        $this->getErrorHandler()->addError('email', 'error.input.email.invalid');
                    }
                }
            }
        }

        $updateValues = [];

        if ($username != $this->getLoggedUser()['username']) {
            $updateValues['username'] = $username;
        }

        if ($emailAddress != $this->getLoggedUser()['emailAddress']) {
            $updateValues['emailAddress'] = $emailAddress;
        }

        if (!empty($updateValues)) {
            try {
                $userModel = new Users();
                $userModel->updateById($this->getLoggedUser()['id'], $updateValues);

                $this->updateLoggedUser('username', $username);
                $this->updateLoggedUser('emailAddress', $emailAddress);

                $this->createNotification($this->t('usersettings.success'), 'success');
            } catch (Throwable $t) {
                $this->createNotification($this->t('usersettings.error'), 'error');
            }
        }
    }

    /**
     * Handle password update (POST)
     *
     * @return void
     */
    private function handlePasswordUpdate(): void {
        if (!array_key_exists('passwordUpdate', $_POST)) {
            return;
        }

        $passwordValid = false;
        $newPassword = null;
        $userModel = new Users();

        if (isset($_POST['password'])) {
            // Placeholder
            $this->addArgument('password', $_POST['password']);

            // Handle data
            if (empty($_POST['password'])) {
                $this->getErrorHandler()->addError('password', 'usersettings.password.oldPassword.empty');
            } else {
                $userPassword = $userModel->getPasswordByEmail($this->getLoggedUser()['emailAddress']);

                if (password_verify($_POST['password'], $userPassword['password'])) {
                    $passwordValid = true;
                } else {
                    $this->getErrorHandler()->addError('password', 'usersettings.password.oldPassword.incorrect');
                }
            }
        }

        if (isset($_POST['newPassword'])) {
            // Placeholder
            $this->addArgument('newPassword', $_POST['newPassword']);

            // Handle data
            if (empty($_POST['newPassword'])) {
                $this->getErrorHandler()->addError('newPassword', 'usersettings.password.newPassword.empty');
                return;
            } else {
                if (!$this->isTextInputValid($_POST['newPassword'], MIN_PASSWORD_SIZE, MAX_PASSWORD_SIZE)) {
                    $this->getErrorHandler()->addError('newPassword', 'usersettings.password.newPassword.format');
                    return;
                }

                $newPassword = $this->hashUserPassword($_POST['newPassword']);
            }
        }

        if (!$passwordValid)
            return;

        try {
            $userModel->updateById($this->getLoggedUser()['id'], ['password' => $newPassword]);

            $this->addArgument('password', null);
            $this->addArgument('newPassword', null);

            $this->createNotification($this->t('usersettings.password.success'), 'success');
        } catch (Throwable $t) {
            $this->createNotification($this->t('usersettings.error'), 'error');
        }
    }

    /**
     * Handle danger updates (delete account + revoke)
     *
     * @return void
     */
    private function handleDanger(): void {
        if (isset($_POST['deleteMe'])) {
            try {
                $userModel = new Users();
                $userModel->deleteById($this->getLoggedUser()['id']);
            } catch (Throwable $t) {
                $this->createNotification($this->t('usersettings.dangerZone.delete.error'), 'error');
                return;
            }

            $this->deleteFile('user-media', $this->getLoggedUser()['profilePicture']);
            $this->deleteFile('user-media', $this->getLoggedUser()['bannerPicture']);
            $this->setLoggedUser(null);
            $this->queueNotification('delete', $this->t('usersettings.dangerZone.delete.confirmMessage'), 'success');

            header('location: /home');
            die();
        }

        if (isset($_POST['revokeMe'])) {
            try {
                $userModel = new Users();
                $userModel->updateRole($this->getLoggedUser()['id'], 'USER');
            } catch (Throwable $t) {
                $this->createNotification($this->t('usersettings.dangerZone.revokePermissions.error'), 'error');
                return;
            }

            $this->updateLoggedUser('role', 'USER');
            $this->createNotification($this->t('usersettings.dangerZone.revokePermissions.confirmMessage'), 'success');
        }
    }

    /**
     * @param string $inputName The input name
     * @return string|null Return the 'error' class if the given input has any errors
     */
    private function getErrorClass(string $inputName): ?string {
        if ($this->getErrorHandler()->hasErrors($inputName)) {
            return 'error';
        }

        return null;
    }

    /**
     * @param string $inputName The input name
     * @return string|null Return an error-message <p> if the given input has any errors
     */
    private function getErrorMessage(string $inputName): ?string {
        if ($this->getErrorHandler()->hasErrors($inputName)) {
            return '<p class="error-message">' . $this->t($this->getErrorHandler()->getErrorsFor($inputName)[0]) . '</p>';
        }
        return null;
    }
}