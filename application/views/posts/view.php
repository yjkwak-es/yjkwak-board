<? if ($posts_item['ID'] === $this->session->userdata('UserData')) : ?>
    <div class="Modify">
        <button onclick="">수정</button>
        <?= form_open('posts/delete') ?>
        <?= form_hidden('TID', $posts_item['TID']) ?>
        <button onclick='submit'>삭제</button>
        <?= form_close() ?>
    </div>
<? endif ?>

<div class="PostHead">
    <span>작성자 : <?= $posts_item['ID'] ?></span>
    <span><?= $posts_item['Title'] ?></span>
    <span><?= $posts_item['CreatedDate'] ?></span>
</div>

<div class="PostBody">
    <?= $posts_item['Paragraph'] ?>
</div>

<div>
    <? foreach ($replys as $reply) : ?>
        <div class="Replies">
            <span><?= $reply['ID'] ?></span>
            <span><?= $reply['Paragraph'] ?> </span>
            <span><?= $reply['CreatedDate'] ?> </span>
        </div>
    <? endforeach; ?>
</div>

<div>
    <?= form_open('reply/create') ?>
    <input type="hidden" name="TID" value=<?= $posts_item['TID'] ?>>

    <div class="Write_reply">
        <textarea name="replyText"></textarea>
    </div>

    <div class="Modify">
        <input type="submit" value="답글 달기">
    </div>
    <?= form_close() ?>
</div>
