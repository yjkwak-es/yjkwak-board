<?= validation_errors(); ?>

<?= form_open_multipart($mod) ?>
<input type="hidden" name="TID" value="<?= $posts_item->TID ?>" />

<div class="createPost">
    <div>
        <label for="title" class="sr-only">Title</label>
        <input type="input" name="title" value="<?= $posts_item->Title ?>" class="form-control" placeholder="Title" required autofocus/>
    </div>

    <div>
        <textarea name="text" class="form-control"><?= $posts_item->Paragraph ?></textarea><br />
    </div>
</div>
<div>
    <div class="custom-file" style="margin-top: 10px;">
        <input type="file" name="upFile" class="custom-file-input" aria-describedby="inputGroupFileAddon03">
        <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
    </div>
</div>

<div class="text-right">
    <input type="submit" name="submit" value="Create Posts" class='btn btn-success' style="margin-top: 10px;"/>
</div>
<?= form_close() ?>

