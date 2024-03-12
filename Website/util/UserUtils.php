<?php
namespace Publicat\Util;

/**
 * Some user utilities
 */
trait UserUtils {

    /**
     * @return bool If a user is connected.
     */
    public function isUserConnected(): bool {
        if (array_key_exists('logged_user', $_SESSION)) {
            return !empty($_SESSION['logged_user']);
        } else {
            return false;
        }
    }

    /**
     * Put logged user into the session.
     * Giving NULL will erase the current logged suer from the session
     *
     * @param array|null $user The user array (given by PDO)
     * @return void
     */
    public function setLoggedUser(?array $user): void {
        if ($user == null) {
            $_SESSION['logged_user'] = [];
            return;
        }

        $_SESSION['logged_user'] = $user;
    }

    /**
     * @return array The current logged user in the session (return an empty array if none)
     */
    public function getLoggedUser(): array {
        if (!$this->isUserConnected())
            return [];

        return $_SESSION['logged_user'];
    }

    /**
     * Update the current logged user. So nothing if no user is in the session
     *
     * @param string $field
     * @param mixed $value
     * @return void
     */
    public function updateLoggedUser(string $field, mixed $value): void {
        if (!$this->isUserConnected())
            return;

        $_SESSION['logged_user'][$field] = $value;
    }

    /**
     * Get a user profile picture
     *
     * @param array|null $user The user array (given by PDO)
     * @return string Default profile picture if the given user is null or empty
     */
    public function getUserPicture(?array $user): string {
        $picture = PUBLICAT_URL . 'public/media/default-picture.jpg';

        if (!empty($user)) {
            if (isset($user['profilePicture'])) {
                $picture = PUBLICAT_URL . 'public/user-media/' . $user['profilePicture'];
            }
        }

        return $picture;
    }

    /**
     * @return string Logged user's picture
     */
    public function getLoggedUserPicture(): string {
        return $this->getUserPicture($this->getLoggedUser());
    }

    /**
     * Get a user banner
     *
     * @param array|null $user The user array (given by PDO)
     * @return string Default banner if the given user is null or empty
     */
    public function getUserBanner(?array $user): string {
        $banner = PUBLICAT_URL . 'public/media/default-banner.png';

        if (!empty($user)) {
            if (isset($user['bannerPicture'])) {
                $banner = PUBLICAT_URL . 'public/user-media/' . $user['bannerPicture'];
            }
        }

        return $banner;
    }

    /**
     * @return string Logged user's banner
     */
    public function getLoggedUserBanner(): string {
        return $this->getUserBanner($this->getLoggedUser());
    }

    /**
     * Get a user display name
     *
     * @param array|null $user The user array (given by PDO)
     * @return string The username if there is no displayName
     */
    public function getUserDisplayName(?array $user): string {
        if (empty($user))
            return '';

        if ($user['displayName'] == null) {
            return $user['username'];
        } else {
            return $user['displayName'];
        }
    }

    /**
     * @return string Logged user's display name. Return the username if there is no displayName
     */
    public function getLoggedDisplayName(): string {
        return $this->getUserDisplayName($this->getLoggedUser());
    }

    /**
     * @param array|null $user The user array (given by PDO)
     * @return bool True if the user is either an admin or a moderator
     */
    public function isUserFromPublicatTeam(?array $user): bool {
        if (empty($user))
            return false;

        return $user['role'] == 'admin' || $user['role'] == 'mod';
    }

    /**
     * @return bool True if the logged user is either an admin or a moderator
     */
    public function isLoggedUserFromPublicatTeam(): bool {
        return $this->isUserFromPublicatTeam($this->getLoggedUser());
    }
}