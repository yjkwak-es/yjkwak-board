<?= validation_errors(); ?>

<?= form_open('posts/create') ?>
<input type="hidden" name="ID" value="<?= $_SESSION['UserData'] ?>" />

<div class="createPost">
    <div style="width:100%">
        <label for="title">Title</label>
        <input type="input" name="title" value="<?= $posts_item['Title'] ?>" />
    </div>

    <div style="width:100%">
        <textarea name="text"><?= $posts_item['Paragraph'] ?></textarea><br />
    </div>
</div>

<div class="Modify">
    <input type="submit" name="submit" value="Create Posts" />
</div>
<?= form_close() ?>
