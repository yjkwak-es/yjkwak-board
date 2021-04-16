<?php
require_once __DIR__."/EMember.php";

namespace App;

class EAdmin extends EMember 
{
    public function __construct() {
        $this->admin = 1;
    }
}
