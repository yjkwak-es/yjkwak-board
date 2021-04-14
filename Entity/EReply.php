<?php

namespace App;

class EReply
{
    public int $RID;
    public int $TID;
    public string $ID;
    public string $Paragraph;
    public string $CreatedDate;

    public function newReply(int $TID, string $ID, string $Paragraph)
    {
        $this->TID = $TID;
        $this->ID = $ID;
        $this->Paragraph = $Paragraph;
        $this->CreatedDate = date('Y-m-d H:i:s');
    }
}
