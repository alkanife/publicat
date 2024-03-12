<?php
namespace Publicat\Model\User;

use PDO;
use Publicat\Model\Model;

/**
 * Manage users
 */
class Users extends Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Create a SELECT request
     *
     * @param bool $includeNumbers If true, will include followers, following, and work counts
     * @param bool $includeFrom
     * @return string
     */
    private function getSelectRequest(bool $includeNumbers = false, bool $includeFrom = true): string {
        $request = <<<SQL
                    SELECT `id`,
                           `username`,
                           `emailAddress`,
                           `birthdate`,
                           `registeredDateTime`,
                           `displayName`,
                           `aboutMe`,
                           `profilePicture`,
                           `bannerPicture`,
                           `isVerified`,
                           (SELECT `name` FROM `$this->userRoles_table` WHERE `$this->userRoles_table`.`id` = `$this->users_table`.`role_id`) AS `role`
                    SQL;

        if ($includeNumbers) {
            $request .= ', ';
            $request .= <<<SQL
                        (SELECT COUNT(*) FROM `$this->works_table` WHERE `owner_id` = `$this->users_table`.`id`) AS `works`,
                        (SELECT COUNT(*) FROM `$this->followers_table` WHERE `follower_id` = `$this->users_table`.`id`) AS `following`,
                        (SELECT COUNT(*) FROM `$this->followers_table` WHERE `following_id` = `$this->users_table`.`id`) AS `followers`
                        SQL;
        }

        if ($includeFrom) {
            $request .= ' FROM `' . $this->users_table . '` ';
        }

        return $request;
    }

    /**
     * Create user
     *
     * @param string $email
     * @param string $username
     * @param string $password
     * @return void
     */
    public function create(string $email, string $username, string $password): void {
        if (empty($email) || empty($username) || empty($password))
            return;

        $request = "INSERT INTO `$this->users_table` (`username`, `emailAddress`, `password`) VALUES (:username, :emailAddress, :password);";

        $statement = $this->pdo->prepare($request);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':emailAddress', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();
    }

    /**
     * Get user by unique id
     *
     * @param int $id
     * @param bool $includeNumbers see getSelectRequest()
     * @return array
     */
    public function getById(int $id, bool $includeNumbers = false): array {
        $statement = $this->pdo->prepare($this->getSelectRequest($includeNumbers) . ' WHERE `id` = :id;');
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get user by username
     *
     * @param string $username
     * @param bool $includeNumbers
     * @return array
     */
    public function getByUsername(string $username, bool $includeNumbers = false): array {
        $statement = $this->pdo->prepare($this->getSelectRequest($includeNumbers) . ' WHERE `username` = :username;');
        $statement->bindValue(':username', $username);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get user by email address
     *
     * @param string $email
     * @param bool $includeNumbers
     * @return array
     */
    public function getByEmail(string $email, bool $includeNumbers = false): array {
        $statement = $this->pdo->prepare($this->getSelectRequest($includeNumbers) . ' WHERE `emailAddress` = :emailAddress;');
        $statement->bindValue(':emailAddress', $email);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get user by username, including profile information like : follower count, following count, work count, and if the connected user is following or being followed by the searched user
     *
     * @param string $username
     * @param int|null $loggedUserId
     * @return array
     */
    public function getProfile(string $username, ?int $loggedUserId = null): array {
        $request = $this->getSelectRequest(true, false);

        if (!empty($loggedUserId)) {
            $request .= ', ' . <<<SQL
                        (SELECT COUNT(*) FROM `$this->followers_table` WHERE `follower_id` = `$this->users_table`.`id` AND `following_id` = :loggedId) AS `isFollowingLoggedUser`,
                        (SELECT COUNT(*) FROM `$this->followers_table` WHERE `follower_id` = :loggedId AND `following_id` = `$this->users_table`.`id`) AS `isFollowedByLoggedUser`
                        SQL;
        }

        $statement = $this->pdo->prepare("$request FROM $this->users_table WHERE `username` = :username;'");
        $statement->bindValue(':username', $username);

        if (!empty($loggedUserId)) {
            $statement->bindValue(':loggedId', $loggedUserId, PDO::PARAM_INT);
        }

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get user password by email address
     *
     * @param string $email
     * @return mixed
     */
    public function getPasswordByEmail(string $email): mixed {
        $request = <<<SQL
                    SELECT `password`
                    FROM `$this->users_table`
                    WHERE `emailAddress` = :emailAddress;
                    SQL;

        $statement = $this->pdo->prepare($request);
        $statement->bindValue(':emailAddress', $email);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Check if the given username exists in the database
     *
     * @param string $username The username
     * @return bool true if the username exists
     */
    public function isUsernameTaken(string $username): bool {
        if (empty($username))
            return false;

        $request = <<<SQL
                    SELECT COUNT(`username`)
                    FROM `$this->users_table`
                    WHERE `username` = :username;
                    SQL;

        $statement = $this->pdo->prepare($request);
        $statement->bindValue(':username', $username);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_COLUMN);
    }

    /**
     * Check if the given email address exists in the database
     *
     * @param string $email
     * @return bool true if the email address exists
     */
    public function isEmailTaken(string $email): bool {
        if (empty($email))
            return false;

        $request = <<<SQL
                    SELECT COUNT(`emailAddress`)
                    FROM `$this->users_table`
                    WHERE `emailAddress` = :email;
                    SQL;

        $statement = $this->pdo->prepare($request);
        $statement->bindValue(':email', $email);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_COLUMN);
    }

    /**
     * Update user's information
     *
     * @param int $id User ID
     * @param array $updateValues See Model:createUpdateRequest()
     * @return void
     */
    public function updateById(int $id, array $updateValues = []): void {
        $request = $this->createUpdateRequest($this->users_table, $updateValues);

        $statement = $this->pdo->prepare($request);

        $this->bindUpdateValues($statement, $updateValues);

        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Delete user
     *
     * @param int $id User ID
     * @return void
     */
    public function deleteById(int $id): void {
        $request = "DELETE FROM `$this->users_table` WHERE `id` = :id;";

        $statement = $this->pdo->prepare($request);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    /**
     * Update user role
     *
     * @param int $id User ID
     * @param string $roleName Role name
     * @return void
     */
    public function updateRole(int $id, string $roleName): void {
        $request = "UPDATE `$this->users_table` SET `role_id` = (SELECT `id` FROM `$this->userRoles_table` WHERE `$this->userRoles_table`.`name` = :roleName) WHERE `$this->users_table`.`id` = :id;";

        $statement = $this->pdo->prepare($request);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':roleName', $roleName);
        $statement->execute();
    }
}