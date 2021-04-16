<?php

namespace App;

class EReply
{
    public int $RID;
    public int $TID;
    public string $ID;
    public string $Paragraph;
    public string $CreatedDate;

    public static function newReply(int $TID, string $ID, string $Paragraph) : EReply
    {
        $Reply = new EReply();
        $Reply->TID = $TID;
        $Reply->ID = $ID;
        $Reply->Paragraph = $Paragraph;
        $Reply->CreatedDate = date('Y-m-d H:i:s');

        return $Reply;
    }
}
