<?php

namespace App;

class EMember
{
    public $PID;
    public $ID;
    public $PW;
    public $name;
    public $age;
    public $gender;
    protected $admin;

    public function setID(string $ID, string $PW)
    {
        $this->ID = $ID;
        $this->PW = $PW;
    }

    public static function setInfo(string $name, int $age = 0, string $gender = '')
    {
        $member = new EMember();
        $member->name = $name;
        $member->age = $age;
        $member->gender = $gender;

        return $member;
    }
}
