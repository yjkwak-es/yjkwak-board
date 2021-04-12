<? if($posts_item['ID'] === $this->session->userdata('UserData')) : ?>
<div class="Modify">
    <button>수정</button> <button>삭제</button>
</div>
<? endif ?>

<div class="PostHead">
    <span><?=$posts_item['ID']?></span>
    <span><?=$posts_item['Title']?></span>
    <span><?=$posts_item['CreatedDate']?></span>
</div>

<div class="PostBody">
    <?=$posts_item['Paragraph']?>
</div>