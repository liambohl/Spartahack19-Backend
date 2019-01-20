<?php
/**
 * Created by PhpStorm.
 * User: liamb
 * Date: 1/19/2019
 * Time: 12:21 PM
 */

namespace spartahackV;

require_once __DIR__ . '/Table.php';

class People extends Table
{
    /**
     * Table constructor
     * @param Site, $site The site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, 'person');
    }

    /**
     * Add a person to the database if new, and get their id.
     * @param $name string The person's name as it usually appears, e.g. "Jane Doe"
     * @return integer The id of the person with the given name
     */
    public function getPersonId($name) {
        $pdo = $this->site->getPdo();

        // Get the person's id if they are in the database
        $sql =<<<SQL
SELECT id from $this->tableName
where name=?;
SQL;
        $statement = $pdo->prepare($sql);
        $statement->execute(array($name));

        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $person_array) {
            return $person_array["id"];
        }

        // Otherwise, add the person
        $sql =<<<SQL
INSERT INTO $this->tableName(name)
VALUES(?);
SQL;
        $statement = $pdo->prepare($sql);
        $statement->execute(array($name));
        return $pdo->lastInsertId();
    }
}