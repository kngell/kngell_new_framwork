<?php

declare(strict_types=1);

interface DatabaseConnexionInterface
{
    //=======================================================================
    //Create a new data base connexion
    //=======================================================================

    /**
     * @return PDO
     */
    public function open():PDO;

    //=======================================================================
    //close database connexion
    //=======================================================================

    /**
    * @return void
    */
    public function close():void;
}