<?php


namespace DocBoard\Domain;

use DocBoard\Domain\Author;


class Author 

{

    /**

     * Author id.

     *

     * @var integer

     */

    private $id;


    /**

     * First Name author.

     *

     * @var string

     */

    private $firstName;


    /**

     * Last Name author.

     *

     * @var integer

     */

    private $lastName;


    public function getId() {

        return $this->id;

    }


    public function setId($id) {

        $this->id = $id;

    }


    public function getFirstName() {

        return $this->firstName;

    }


    public function setFirstName($firstName) {

        $this->firstName = $firstName;

    }


    public function getLastName() {

        return $this->lastName;

    }


    public function setLastName($lastName) {

        $this->lastName = $lastName;

    }


}