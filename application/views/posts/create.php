<h2><?php echo $title ?></h2>

<?php echo validation_errors(); ?>

<?= form_open('posts/create') ?>
<input type="hidden" name="ID" value="<?= $_SESSION['UserData'] ?>" />

<label for="title">Title</label>
<input type="input" name="title" value="<?=$data['posts_item']['Title']?>"/><br />

<label for="text">Text</label>
<textarea name="text"><?=$data['posts_item']['Paragraph']?></textarea><br />

<input type="submit" name="submit" value="Create Posts" />
<?= form_close() ?>