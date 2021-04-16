<?= validation_errors(); ?>

<?= form_open_multipart($mod) ?>
<input type="hidden" name="TID" value="<?= $posts_item->TID ?>" />

<div class="createPost">
    <div>
        <label for="title" class="sr-only">Title</label>
        <input type="input" name="title" value="<?= $posts_item->Title ?>" class="form-control" placeholder="Title" required autofocus />
    </div>

    <div>
        <textarea name="text" class="form-control"><?= $posts_item->Paragraph ?></textarea><br />
    </div>
</div>
<div class="input-group" style="margin-top: 10px;">
    <div class="custom-file">
        <label class="custom-file-label" for="upFile">Choose file</label>
        <input type="file" name="upFile" id="upFile" class="custom-file-input">
    </div>
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" id="fileDel">DeleteFile</button>
    </div>
</div>

<div class="text-right">
    <input type="submit" name="submit" value="Create Posts" class='btn btn-success' style="margin-top: 10px;" />
</div>
<?= form_close() ?>

<script>
    var fileName = '<?= $posts_item->FileID ?>'
    
    $(document).ready(function() {
        if (fileName != null) {
            $('#upFile').siblings("label[for='upFile']").text(fileName);
        }
    });


    $('#fileDel').on('click', function() {
        $('#upFile').val('');
        $('#upFile').siblings("label[for='upFile']").text('');

        if (fileName != null) {
            $.ajax({
                url: "<?= site_url(array('posts', 'clearFile',$posts_item->TID)) ?>",
                async: true,
                timeout: 10000,
                success: function(data) {
                    fileName = null;
                }
            })
        }
    });

    var fileTarget = $('#upFile');

    fileTarget.on('change', function() { 
        console.log('oooooo');
        var cur = $(".custom-file input[type='file']").val();
        $(this).siblings("label[for='upFile']").text(cur);
    });
</script>
