<div style="text-align : right">
        <a href="member/logout">logout</a>
</div>

<div class="Posts">
<table>
        <thead>
                <colgroup>
                        <col width="20%" />
                        <col width="50%" />
                        <col width="*" />
                </colgroup>
                <tr>
                        <th>PostNum</th>
                        <th>Title</th>
                        <th>Date</th>
                </tr>
        </thead>

        <tbody>
                <? foreach ($posts as $posts_item) : ?>
                        <tr>
                                <td>1</td>
                                <td><a href="posts/<?= $posts_item['TID']?>" ?><?= $posts_item['Title'] ?></a></td>
                                <td><?= $posts_item['CreatedDate'] ?></td>
                        </tr>
                <? endforeach ?>
        </tbody>
</table>
</div>

<div class="Search">
        <?= form_open('posts')?>
                        <select name="opt" id="searchOption">
                                <option value="Title">제목</option>
                                <option value="Paragraph">본문</option>
                                <option value="all">모두</option>
                        </select>
                        <input type="search" name="keyword" style="width:15%" required minlength="2" autocomplete="off">
                        <button>검색</button>
        <?= form_close()?>
</div>
<div class="Search">
        <button onclick="location.href='posts/create'">새글쓰기</button>
</div>