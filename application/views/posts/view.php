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

<div class='Replies'>
    <table>
        <colgroup>
            <col width='15%' />
            <col width='70%' />
            <col width='*' />
        </colgroup>
        <tbody>
            <? foreach ($replies as $reply) : ?>
                <tr>
                    <td><?= $reply['ID'] ?></td>
                    <td><?= nl2br($reply['Paragraph']) ?></td>
                    <td><?= $reply['CreatedDate'] ?>
                        <!-- 수정 및 삭제 버튼 -->
                        <? if ($reply['ID'] === $this->session->userdata('UserData')) : ?>
                            <button class="updateBtn" id=<?=$reply['RID']?>>
                            수정
                            </button>

                            <?= form_open('reply/delete', 'style="display:inline"') ?>
                            <?= form_hidden('RID', $reply['RID']) ?>
                            <button onclick="submit">삭제</button>
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
    <input type="hidden" name="TID" value=<?= $posts_item['TID'] ?>>

    <div class="Write_reply">
        <textarea name="replyText"></textarea>
    </div>

    <div class="Modify">
        <input type="submit" value="답글 달기">
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
        newForm.attr('action', '<?=site_url(array('reply','set'))?>');

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
