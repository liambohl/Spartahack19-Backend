<?php
/**
 * Created by PhpStorm.
 * User: liamb
 * Date: 1/19/2019
 * Time: 11:40 AM
 */

namespace SpartahackV;

class User
{
    public function __construct($id, $username, $first_name) {
        $this->id = $id;
        $this->username = $username;
        $this->first_name = $first_name;
    }

    private $id;
    private $username;
    private $first_name;
}