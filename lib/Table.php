<?php
/**
 * @file
 * Base class for all table classes
 */

namespace SpartahackV;

require_once __DIR__ . '/Site.php';

/**
 * Base class for all table classes
 */
class Table {
    /**
     * Table constructor
     * @param Site, $site The site object
     * @param $name string Name of this table, not including prefix
     */
    public function __construct(Site $site, $name) {
        $this->site = $site;
        $this->tableName = $site->getTablePrefix() . $name;
        $this->smallTables = array(
            "director" => $site->getTablePrefix() . "director",
            "writer" => $site->getTablePrefix() . "writer",
            "actor" => $site->getTablePrefix() . "actor",
            "director_preferences" => $site->getTablePrefix() . "director_preferences",
            "writer_preferences" => $site->getTablePrefix() . "writer_preferences",
            "actor_preferences" => $site->getTablePrefix() . "actor_preferences",
            "genre" => $site->getTablePrefix() . "genre",
            "movie_genre" => $site->getTablePrefix() . "movie_genre",
            "genre_preferences" => $site->getTablePrefix() . "genre_preferences"
        );
    }

    public function getTableName() {
        return $this->tableName;
    }

    protected $site;        ///< The site object
    protected $tableName;   ///< The table name to use
    protected $smallTables;
}