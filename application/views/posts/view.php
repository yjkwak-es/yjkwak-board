<?php

/**
 * 
 * @var EPost $posts_item
 * 
 */

use App\EPost;
?>

<? if ($posts_item->ID === $this->session->getUserData()) : ?>
    <div class="text-right">
        <button onclick="document.location='<?= site_url(array('posts', 'create', $posts_item->TID)) ?>'" class="btn btn-light">수정</button>

        <?= form_open('posts/delete', 'style="display:inline"') ?>
        <?= form_hidden('TID', $posts_item->TID) ?>
        <button onclick='submit' class="btn btn-danger">삭제</button>
        <?= form_close() ?>
    </div>
<? endif ?>

<div>
    <div class="PostHead">
        <div class="PostTitle">
            <?= $posts_item->Title ?>
        </div>
        <div style="text-align:right">
            <p>작성자 : <?= $posts_item->ID ?></p>
            <p><?= $posts_item->CreatedDate ?></p>
        </div>
    </div>
</div>

<div class="PostBody">
    <p class="lead"><?= $posts_item->Paragraph ?></p>
    <? if (isset($file)) : ?>
        <div class="Download">
            <a href="<?= site_url(array('posts', 'download', $file['FileID'])) ?>" target="_blank"><?= $file['name_orig'] ?></a>
        </div>
    <? endif; ?>
</div>

<div class='table table-striped table-bordered Replies'>
    <table>
        <colgroup>
            <col width='15%' />
            <col width='70%' />
            <col width='*' />
        </colgroup>
        <tbody>
            <? foreach ($replies as $reply) : ?>
                <tr>
                    <td><?= $reply->ID ?></td>
                    <td><?= nl2br($reply->Paragraph) ?></td>
                    <td><?= $reply->CreatedDate ?>
                        <!-- 수정 및 삭제 버튼 -->
                        <? if ($reply->ID === $this->session->getUserData()) : ?>
                            <button class="btn btn-light btn-sm updateBtn" id=<?= $reply->RID ?>>
                                수정
                            </button>

                            <?= form_open('reply/delete', 'style="display:inline"') ?>
                            <?= form_hidden('RID', $reply->RID) ?>
                            <button onclick="submit" class='btn btn-danger btn-sm'>삭제</button>
                            <?= form_close() ?>
                        <? endif; ?>
                    </td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
</div>

<div>
    <?= form_open('reply/create') ?>
    <input type="hidden" name="TID" value=<?= $posts_item->TID ?>>

    <div class="Write_reply">
        <textarea name="replyText"></textarea>
    </div>

    <div class="text-right">
        <input type="submit" class="btn btn-success" value="답글 달기">
    </div>
    <?= form_close() ?>
</div>

<script>
    $(".updateBtn").click(function() {
        var Btn = $(this);
        var RID = Btn.attr('id');

        var tr = Btn.parent().parent();
        var td = tr.children();

        var Paragraph = td.eq(1).text();
        td.eq(1).html('');

        var newForm = $('<form></form>');

        newForm.attr('method', 'post');
        newForm.attr('action', '<?= site_url(array('reply', 'set')) ?>');

        newForm.append($('<textarea>', {
            css: {
                width: '100%',
                height: '100%'
            },
            name: 'Paragraph',
            id: 'updateP',
        }));
        newForm.append($('<input/>', {
            type: 'hidden',
            name: 'RID',
            value: RID
        }));
        newForm.append($('<input/>', {
            type: 'submit',
            value: '수정완료'
        }));

        newForm.appendTo(td.eq(1));
        $('#updateP').text(Paragraph);
    })
</script>
