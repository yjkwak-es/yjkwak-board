<?php

/**
 * @var Post[] $posts
 */

use App\Post;

?>
<div class="Posts">
    <table>
        <colgroup>
            <col width="15%" />
            <col width="50%" />
            <col width="10%" />
            <col width="*" />
        </colgroup>
        
        <thead>
            <tr>
                <th>PostNum</th>
                <th>Title</th>
                <th>Writer</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>
            <? foreach ($posts as $posts_item) : ?>
                <tr>
                    <td><?= $postNum-- ?></td>
                    <td style="text-align:left"><a href="posts/<?= $posts_item['TID'] ?>" ?><?= $posts_item['Title'] ?></a></td>
                    <td><?= $posts_item['ID'] ?></td>
                    <td><?= $posts_item['CreatedDate'] ?></td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
</div>

<div class="Search">
    <?= form_open('posts', array('method' => 'get')) ?>
    <select name="opt" id="searchOption">
        <option value="Title">제목</option>
        <option value="Paragraph">본문</option>
        <option value="all">모두</option>
    </select>
    <input type="search" name="keyword" style="width:15%" required minlength="2" autocomplete="off">
    <button>검색</button>
    <?= form_close() ?>
</div>

<div class="Search">
    <button onclick="location.href='posts/create'">새글쓰기</button>
</div>

<div class="page">
    <a href="<?= $url . ($page - 1) ?>"><-</a>
            <? for ($i = $divStart; $i <= $divEnd; $i++) : ?>
                <a href="<?= $url . $i ?>" id=<?= $i ?>><?= $i ?></a>
            <? endfor; ?>
            <a href="<?= $url . ($page + 1) ?>">-></a>
</div>

<script>
    // 현재페이지 색상 변경
    $('#<?= $page ?>').css("color", "red");
</script>
