<?php

/**
 * @var EPost[] $posts
 */

use App\EPost;

?>
<div class="table table-hover table-bordered">
    <table style="width: 100%;">
        <colgroup>
            <col width="15%" />
            <col width="50%" />
            <col width="10%" />
            <col width="*" />
        </colgroup>

        <thead class="thead-light">
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
                    <td style="text-align:left"><a href="posts/<?= $posts_item->TID ?>" ?><?= $posts_item->Title ?></a></td>
                    <td><?= $posts_item->ID ?></td>
                    <td><?= $posts_item->CreatedDate ?></td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
</div>

<div class="Search">
    <?= form_open('posts', array('method' => 'get')) ?>
    <select name="opt" id="searchOption" class="form-control">
        <option value="Title">제목</option>
        <option value="Paragraph">본문</option>
        <option value="all">모두</option>
    </select>

    <input type="search" name="keyword" style="width:15%" required minlength="2" autocomplete="off" class="form-control">
    <button class="form-control">검색</button>
    <?= form_close() ?>
</div>

<div class="Search">
    <button onclick="location.href='posts/create'" class="btn btn-success">새글쓰기</button>
</div>

<div class="page">
    <ul class="pagination">
        <li class="page-item">
            <a href="<?= $url . ($page - 1) ?>" class="page-link" aria-level="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <? for ($i = $divStart; $i <= $divEnd; $i++) : ?>
            <li class="page-item" id=<?= $i ?>>
                <a href="<?= $url . $i ?>" class="page-link"><?= $i ?></a>
            </li>
        <? endfor; ?>
        <li class="page-item">
            <a href="<?= $url . ($page + 1) ?>" class="page-link" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</div>

<script>
    // 현재페이지 색상 변경
    $('#<?= $page ?>').addClass("active");
</script>
