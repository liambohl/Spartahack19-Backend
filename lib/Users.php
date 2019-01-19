<?php
/**
 * Created by PhpStorm.
 * User: liamb
 * Date: 1/19/2019
 * Time: 12:21 PM
 */

namespace spartahackV;

require_once __DIR__ . '/Table.php';

class Users extends Table
{
    /**
     * Table constructor
     * @param Site, $site The site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, 'user');
    }

    /**
     * @param $username string Username of account to login
     * @return User The account in question, or null if invalid
     */
    public function login($username)
    {
        $pdo = $this->site->getPdo();

        // Find account
        $sql =<<<SQL
SELECT * from $this->tableName
where username=?;
SQL;
        $statement = $pdo->prepare($sql);
        $statement->execute(array($username));

        // Create and return user
        $user = null;
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $user_array) {
            $user = new User($user_array);
        }
        return $user;
    }

    /**
     * @param $username string Username for new account
     * @param $first_name string Account holder's first name
     * @return User The new account, or null if invalid
     */
    public function new_user($username, $first_name)
    {
        $pdo = $this->site->getPdo();

        // Check if account exists; if so, return null
        $sql =<<<SQL
SELECT * from $this->tableName
where username=?;
SQL;
        $statement = $pdo->prepare($sql);
        $statement->execute(array($username));

        if($statement->rowCount() !== 0) {
            return null;
        }

        // Add account
        $sql = <<<SQL
INSERT INTO $this->tableName(username, first_name)
VALUES(?, ?);
SQL;
        $statement = $pdo->prepare($sql);
        $statement->execute(array($username, $first_name));

        // Create and return user
        $sql =<<<SQL
SELECT * from $this->tableName
where username=?;
SQL;
        $statement = $pdo->prepare($sql);
        $statement->execute(array($username));

        $user = null;
        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $user_array) {
            $user = new User($user_array);
        }
        return $user;
    }
}