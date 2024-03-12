<?php
namespace Publicat\Model\User;

use PDO;
use Publicat\Model\Model;

/**
 * Manage user follows
 */
class UserFollows extends Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @param int $id First user id
     * @param string $username Other username
     * @return bool True if the provided is following the provided username
     */
    public function isFollowing(int $id, string $username): bool {
        $request = "SELECT COUNT(*) FROM `$this->followers_table` WHERE `follower_id` = :id AND `following_id` = (SELECT `id` FROM `$this->users_table` WHERE `username` = :username);";

        $statement = $this->pdo->prepare($request);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':username', $username);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_COLUMN);
    }

    /**
     * Make a user follow another
     *
     * @param int $id First user id
     * @param string $username Other username
     * @return void
     */
    public function follow(int $id, string $username): void {
        $request = "INSERT INTO `$this->followers_table` (`follower_id`, `following_id`) VALUES (:id, (SELECT `id` FROM `$this->users_table` WHERE `username` = :username));";

        $statement = $this->pdo->prepare($request);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':username', $username);
        $statement->execute();
    }

    /**
     * Make a user unfollow another
     *
     * @param int $id First user id
     * @param string $username Other username
     * @return void
     */
    public function unfollow(int $id, string $username): void {
        $request = "DELETE FROM `$this->followers_table` WHERE `follower_id` = :id AND `following_id` = (SELECT `id` FROM `$this->users_table` WHERE `username` = :username);";

        $statement = $this->pdo->prepare($request);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':username', $username);
        $statement->execute();
    }
}