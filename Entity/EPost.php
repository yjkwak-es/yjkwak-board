<?php

namespace App;

class EPost
{
    public int $TID;
    public string $ID;
    public string $Title;
    public string $Paragraph;
    public string $CreatedDate;
    public $FileID;

    // public function __construct()
    // {
    //     $this->TID = 1;
    //     $this->Title = '';
    //     $this->Paragraph = '';
    //     $this->CreatedDate = '';
    //     $this->FileID = null;
    // }

    public function newPost(string $ID, string $Title, string $Paragraph, $FileID = null)
    {
        $this->ID = $ID;
        $this->Title = $Title;
        $this->Paragraph = $Paragraph;
        $this->CreatedDate = date('Y-m-d H:i:s');
        $this->FileID = $FileID;
    }
}
