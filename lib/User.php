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
    /**
     * User constructor.
     * @param $user_array array All fields from the user's database entry
     */
    public function __construct($user_array) {
        $this->id = $user_array["id"];
        $this->username = $user_array["username"];
        $this->first_name = $user_array["first_name"];

        // Fill in weights
    }

    /**
     * Represent the user as XML.
     * @return string XML representation
     */
    public function as_xml() {
        return "<user id=\"$this->id\" username=$this->username first_name=$this->first_name></user>";
    }

    private $id;
    private $username;
    private $first_name;

    // A bunch of private weight values
}