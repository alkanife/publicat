<?php
namespace Publicat\Controller;

use Publicat\model\user\Users;
use Publicat\Util\Render;
use Throwable;

/**
 * Handle /user routes
 */
class UserController extends Controller {
    use Render;

    /**
     * Redirect to homepage
     * Method: GET - Route: /user
     *
     * @return void
     */
    public function empty(): void {
        header('location: /home');
    }

    /**
     * Display user profile
     * Method: GET - Route: /user/{username}
     *
     * @param mixed $username
     * @return void
     * @throws Throwable
     */
    public function userProfile(mixed $username): void {
        $userModel = new Users();
        $profileExists = $userModel->isUsernameTaken($username);

        $this->renderStartPage();
        $this->renderCSS('user/profile.css');

        if ($profileExists) {
            if ($this->isUserConnected()) {
                $profileUser = $userModel->getProfile($username, $this->getLoggedUser()['id']);

                $this->addArgument('isLoggedUserProfile', $this->getLoggedUser()['id'] == $profileUser['id']);
            } else {
                $profileUser = $userModel->getProfile($username);
            }

            $this->addArgument('user', $profileUser);
            $this->addArgument('registeredDateTime', $this->formatUserDateTime($profileUser['registeredDateTime']));

            if ($this->isUserFromPublicatTeam($profileUser) || $profileUser['isVerified']) {
                $this->addArgument('verified', '<span class="verified"><img src="' . $this->icon('verified.svg') . '" alt="' . $this->t('userprofile.verified') . '"></span>');
            } else {
                $this->addArgument('verified', null);
            }

            $this->addRawJavascript('const userProfileName = "' . $profileUser['username'] . '";');
            $this->addRawJavascript('const followError = "' . $this->t('userprofile.follow.error', $this->getUserDisplayName($profileUser)) . '";');
            $this->addRawJavascript('const followSuccess = "' . $this->t('userprofile.follow.success', $this->getUserDisplayName($profileUser)) . '";');
            $this->addRawJavascript('const unfollowError = "' . $this->t('userprofile.unfollow.error', $this->getUserDisplayName($profileUser)) . '";');
            $this->addRawJavascript('const unfollowSuccess = "' . $this->t('userprofile.unfollow.success', $this->getUserDisplayName($profileUser)) . '";');

            $this->renderTitle($this->t('userprofile.title', $profileUser['username']));
            $this->renderView('user/Profile.php');
            $this->renderJavascript('user-profile.js');
        } else {
            $this->addArgument('username', $username);
            $this->renderTitle($this->t('userprofile.notFound.title'));
            $this->renderView('user/ProfileNotFound.php');
        }

        $this->renderEnd();
    }
}