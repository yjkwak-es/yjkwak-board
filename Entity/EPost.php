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

    public static function createEmpty(): EPost
    {
        $post = new EPost;
        $post->TID = 0;
        $post->Title = '';
        $post->Paragraph = '';
        $post->CreatedDate = '';
        $post->FileID = null;

        return $post;
    }

    public static function newPost(string $ID, string $Title, string $Paragraph, $FileID = null)
    {
        $post = new EPost;
        $post->ID = $ID;
        $post->Title = $Title;
        $post->Paragraph = $Paragraph;
        $post->CreatedDate = date('Y-m-d H:i:s');
        $post->FileID = $FileID;
        
        return $post;
    }
}
