<?php
namespace Publicat\Controller\JSON;

use Publicat\model\user\UserFollows;
use Publicat\model\user\Users;
use Publicat\Util\InputUtils;
use Publicat\Util\InputValidation;

/**
 * JSON User Controller
 */
class UserController extends JSONController {
    use InputValidation;
    use InputUtils;

    /**
     * Verify given username.
     * Method: GET - Route: /json/verify_username
     *
     * @param mixed $username
     * @return void
     */
    public function verifyUsername(mixed $username): void {
        echo json_encode($this->isUsernameValid($username));
    }

    /**
     * Verify given email.
     * Method: GET - Route: /json/verify_email
     *
     * @param mixed $email
     * @return void
     */
    public function verifyEmail(mixed $email): void {
        echo json_encode($this->isEmailValid($email));
    }

    /**
     * Handle register
     * Method: POST - Route: /json/register
     *
     * @return void
     */
    public function register(): void {
        if ($this->isUserConnected()) {
            $this->apiError(403);
            return;
        }

        $request = $this->getRequest();

        // Check email
        if (!isset($request['email'])) {
            $this->apiError(400);
            return;
        }

        $isEmailValid = $this->isEmailValid($request['email']);

        if ($isEmailValid['isValid']) {
            if ($isEmailValid['isTaken']) {
                $this->apiError(400);
                return;
            }
        } else {
            $this->apiError(400);
            return;
        }

        // Check username
        if (!isset($request['username'])) {
            $this->apiError(400);
            return;
        }

        $isUsernameValid = $this->isUsernameValid($request['username']);

        if ($isUsernameValid['isValid']) {
            if ($isUsernameValid['isTaken']) {
                $this->apiError(400);
                return;
            }
        } else {
            $this->apiError(400);
            return;
        }

        // Check password
        if (!isset($request['password'])) {
            $this->apiError(400);
            return;
        }

        if (!$this->isTextInputValid($request['password'], MIN_PASSWORD_SIZE, MAX_PASSWORD_SIZE)) {
            $this->apiError(400);
            return;
        }

        // Check TOS
        if (!isset($request['tos'])) {
            $this->apiError(400);
            return;
        }

        if (!$request['tos']) {
            $this->apiError(400);
            return;
        }

        // Make register
        $email = $request['email'];
        $email = $this->cleanUserInput($email);
        $email = strtolower($email);

        $username = $request['username'];
        $username = $this->cleanUserInput($username);

        $password = $request['password'];
        $password = $this->hashUserPassword($password);

        $userModel = new Users();
        $userModel->create($email, $username, $password);

        $user = $userModel->getByUsername($username);

        $this->setLoggedUser($user);
        $this->queueNotification('justSignedin', $this->t('form.signIn.notification', $user['username']), 'success');

        echo json_encode(['success' => true]);
    }

    /**
     * Handle login
     * Method: POST - Route: /json/login
     *
     * @return void
     */
    public function login(): void {
        if ($this->isUserConnected()) {
            $this->apiError(403);
            return;
        }

        $request = $this->getRequest();

        if (!isset($request['email']) || !isset($request['password'])) {
            $this->apiError(400);
            return;
        }

        $email = $this->cleanUserInput($request['email']);

        $userModel = new Users();

        if (!$userModel->isEmailTaken($email)) {
            echo json_encode(['success' => false, 'details' => 'mail']);
            return;
        }

        $userPassword = $userModel->getPasswordByEmail($email);

        $isLoginSuccessful = password_verify($request['password'], $userPassword['password']);

        if (!$isLoginSuccessful) {
            echo json_encode(['success' => false, 'details' => 'password']);
            return;
        }

        $user = $userModel->getByEmail($email);

        $this->setLoggedUser($user);
        $this->queueNotification('justLogged', $this->t('form.login.notification', $this->getLoggedDisplayName()), 'success');

        echo json_encode(['success' => true]);
    }

    /**
     * Handle follow
     * Method: POST - Route: /json/follow
     *
     * @return void
     */
    public function follow(): void {
        if (!$this->isUserConnected()) {
            $this->apiError(403);
            return;
        }

        $request = $this->getRequest();

        if (!isset($request['username'])) {
            $this->apiError(400);
            return;
        }

        $userFollowsModel = new UserFollows();

        if ($userFollowsModel->isFollowing($this->getLoggedUser()['id'], $request['username'])) {
            echo json_encode(['success' => false, 'details' => 'alreadyFollowing']);
            return;
        }

        $userFollowsModel->follow($this->getLoggedUser()['id'], $request['username']);

        echo json_encode(['success' => true]);
    }

    /**
     * Handle unfollow
     *
     * @return void
     */
    public function unfollow(): void {
        if (!$this->isUserConnected()) {
            $this->apiError(403);
            return;
        }

        $request = $this->getRequest();

        if (!isset($request['username'])) {
            $this->apiError(400);
            return;
        }

        $userFollowsModel = new UserFollows();

        if (!$userFollowsModel->isFollowing($this->getLoggedUser()['id'], $request['username'])) {
            echo json_encode(['success' => false, 'details' => 'notFollowing']);
            return;
        }

        $userFollowsModel->unfollow($this->getLoggedUser()['id'], $request['username']);

        echo json_encode(['success' => true]);
    }
}