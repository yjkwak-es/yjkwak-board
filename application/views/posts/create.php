<?= validation_errors(); ?>

<?= form_open_multipart($mod) ?>
<input type="hidden" name="TID" value="<?= $posts_item->TID ?>" />

<div class="createPost">
    <div>
        <label for="title">Title</label>
        <input type="input" name="title" value="<?= $posts_item->Title ?>" class="form-control"/>
    </div>

    <div>
        <textarea name="text" class="form-control"><?= $posts_item->Paragraph ?></textarea><br />
    </div>
</div>
<div>
    <div class="custom-file">
        <input type="file" name="upFile" class="custom-file-input" aria-describedby="inputGroupFileAddon03">
        <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
    </div>
</div>

<div class="text-right">
    <input type="submit" name="submit" value="Create Posts" class='btn btn-success'/>
</div>
<?= form_close() ?>

