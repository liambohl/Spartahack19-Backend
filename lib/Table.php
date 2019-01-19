<?php
/**
 * @file
 * Base class for all table classes
 */

namespace SpartahackV;

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
    }

    public function getTableName() {
        return $this->tableName;
    }

    protected $site;        ///< The site object
    protected $tableName;   ///< The table name to use
}