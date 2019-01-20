<?php
/**
 * Created by PhpStorm.
 * User: liamb
 * Date: 1/19/2019
 * Time: 12:21 PM
 */

namespace spartahackV;

require_once __DIR__ . '/Table.php';

class Genres extends Table
{
    /**
     * Table constructor
     * @param Site, $site The site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, 'genre');
    }

    /**
     * Add a genre to the database if new, and get its id.
     * @param $name string The name of the genre
     * @return integer The id of the given genre
     */
    public function getGenreId($name) {
        $pdo = $this->site->getPdo();

        // Get the genre's id if it is in the database
        $sql =<<<SQL
SELECT id from $this->tableName
where name=?;
SQL;
        $statement = $pdo->prepare($sql);
        $statement->execute(array($name));

        foreach ($statement->fetchAll(\PDO::FETCH_ASSOC) as $genre_array) {
            return $genre_array["id"];
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