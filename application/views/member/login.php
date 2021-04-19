<?= validation_errors(); ?>

<div class="login">
    <?= form_open('member/login', array('class' => 'form-signin')) ?>
    <label for="ID" class="sr-only">ID</label>
    <input type="input" name="ID" id="ID" class='form-control' placeholder="ID" required autofocus /> <br>
    <label for="PW" class="sr-only">PW</label>
    <input type="password" name="PW" class='form-control' placeholder="Password" required autofocus /> <br>
    <input type="submit" name="login" value="로그인" class='btn btn-lg btn-primary btn-block' style="margin-top : 10px" />
    <button type="button" data-toggle="modal" data-target="#createMember" name="createMemberBtn" class='btn btn-lg btn-primary btn-block' style="margin-top : 10px">
    회원가입</button>
    <?= form_close() ?>
</div>

<span><? var_dump($_SESSION) ?></span>

<div class="modal fade" id="createMember" tabindex="-1" aria-labelledby="userInfo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Create New Member</h5>
            </div>
            <div class="modal-body">
                <?= form_open() ?>
                <div class="form-group">
                    <label for="newID" class="sr-only">ID</label>
                    <input class="form-control" id="newID" placeholder="ID" required autofocus></input>

                    <label for="PW" class="sr-only">PW</label>
                    <input type="password" class="form-control" id="PW" placeholder="PW" required autofocus></input>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sendCreate">Send It</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#sendCreate').on('click', function() {
        $.ajax({
            url: "<?= site_url(array('member', 'createMember')) ?>",
            type: 'POST',
            async: true,
            data: {
                ID: $('#newID').val(),
                PW: $('#PW').val(),
            },
            timeout: 10000,
            success: function(data) {
                alert(data);
            },
            error: function(request, status, error) {
                alert('err');
            }
        });
    });
</script>
