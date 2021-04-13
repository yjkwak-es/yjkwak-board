<? if ($posts_item['ID'] === $this->session->userdata('UserData')) : ?>
    <div class="Modify">
        <button onclick="document.location='<?= site_url(array('posts', 'create', $posts_item['TID'])) ?>'">수정</button>
        <?= form_open('posts/delete', 'style="display:inline"') ?>
        <?= form_hidden('TID', $posts_item['TID']) ?>
        <button onclick='submit'>삭제</button>
        <?= form_close() ?>
    </div>
<? endif ?>

<div class="PostHead">
    <span style="width : 20%">작성자 : <?= $posts_item['ID'] ?></span>
    <span style="width : 58%"><?= $posts_item['Title'] ?></span>
    <span style="width : 20%"><?= $posts_item['CreatedDate'] ?></span>
</div>

<div class="PostBody">
    <?= $posts_item['Paragraph'] ?>
</div>

<div style="width : 60%">
    <? foreach ($replies as $reply) : ?>
        <div class="Replies">
            <span style="width : 15%"><?= $reply['ID'] ?></span>
            <span style="width : 68%"><?= $reply['Paragraph'] ?> </span>
            <span style="width : 15%"><?= $reply['CreatedDate'] ?>

                <? if ($reply['ID'] === $this->session->userdata('UserData')) : ?>
                    <button class="updateBtn">수정</button>

                    <?= form_open('reply/delete', 'style="display:inline"') ?>
                    <?= form_hidden('RID', $reply['RID']) ?>
                    <button onclick="submit">삭제</button>
                    <?= form_close() ?>
                <? endif; ?>

            </span>
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
