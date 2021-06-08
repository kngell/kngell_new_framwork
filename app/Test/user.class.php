<?php
declare(strict_types=1);
class User
{
    private $user;

    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }

    public function usermodel()
    {
        return $this->user;
    }
}