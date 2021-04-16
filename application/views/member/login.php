<?=validation_errors(); ?>

<div class="login">
<?= form_open('member/login',array('class'=>'form-signin')) ?>
    <label for="ID" class="sr-only">ID</label>
    <input type="input" name="ID" id="ID" class='form-control' placeholder="ID" required autofocus/> <br>
    <label for="PW" class="sr-only">PW</label>
    <input type="password" name="PW" class='form-control' placeholder="Password" required autofocus/> <br>
    <input type="submit" name="login" value="로그인" class='btn btn-lg btn-primary btn-block' style="margin-top : 10px"/>
</form>  
</div>

<span><? var_dump($_SESSION)?></span>

