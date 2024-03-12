<?php
namespace Publicat\Model;

use PDO;
use PDOStatement;

/**
 * Common class for models
 */
class Model {

    protected PDO $pdo;

    protected string $users_table            = DB_TABLE_PREFIX . 'users';
    protected string $userRoles_table        = DB_TABLE_PREFIX . 'userRoles';
    protected string $followers_table        = DB_TABLE_PREFIX . 'followers';
    protected string $usersLikesWorks_table  = DB_TABLE_PREFIX . 'usersLikesWorks';

    protected string $works_table            = DB_TABLE_PREFIX . 'works';
    protected string $worksHaveTags_table    = DB_TABLE_PREFIX . 'worksHaveTags';
    protected string $workTags_table         = DB_TABLE_PREFIX . 'workTags';
    protected string $workVisibilities_table = DB_TABLE_PREFIX . 'workVisibilities';
    protected string $contentRatings_table   = DB_TABLE_PREFIX . 'contentRatings';

    protected string $documents_table        = DB_TABLE_PREFIX . 'documents';

    public function __construct() {
        $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    }

    /**
     * Will create an update request with the given updateValues
     *
     * @param string $table Table name (complete)
     * @param array $updateValues An array of column names with their desired value (ex.: ['username' => 'alkanife']
     * @param string $uniqueValue The WHERE statement (id/username/email)
     * @return string The SQL request
     */
    protected function createUpdateRequest(string $table, array $updateValues, string $uniqueValue = 'id'): string {
        $request = 'UPDATE `' . $table . '` SET ';

        $first = true;

        foreach ($updateValues as $key => $updateValue) {
            if ($first) {
                $first = false;
            } else {
                $request .= ', ';
            }

            $request .= "`$key` = :$key";
        }

        $request .= " WHERE `$uniqueValue` = :$uniqueValue;";

        return $request;
    }

    /**
     * Will bind update values to a PDOStatement
     *
     * @param PDOStatement $statement The statement
     * @param array $updateValues Update values, see createUpdateRequest()
     * @return PDOStatement
     */
    protected function bindUpdateValues(PDOStatement $statement, array $updateValues): PDOStatement {
        foreach ($updateValues as $key => $updateValue) {
            $pdoType = PDO::PARAM_STR;

            switch (gettype($updateValue)) {
                case 'integer':
                    $pdoType = PDO::PARAM_INT;
                    break;

                case 'boolean':
                    $pdoType = PDO::PARAM_BOOL;
                    break;

                case 'NULL':
                    $pdoType = PDO::PARAM_NULL;
                    break;

                default:
                    break;
            }

            $statement->bindValue(':' . $key, $updateValue, $pdoType);
        }

        return $statement;
    }
}