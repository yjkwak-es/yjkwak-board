<div>
        <a href="member/logout">logout</a>
        <span><?=var_dump($_SESSION)?></span>
</div>
<?php foreach ($posts as $posts_item): ?>

        <h3><?php echo $posts_item['Title'] ?></h3>

        <div class="main">
                <?php echo $posts_item['Paragraph'] ?>
        </div>

        <p><a href="posts/<?=$posts_item['TID'] ?>">View article</a></p>

<?php endforeach ?>