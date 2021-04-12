<?=validation_errors(); ?>

<div class="loginForm">
<?php echo form_open('member/login') ?>
    <label for="ID"> ID </label>
    <input type="input" name="ID" /> <br>
    <label for="PW"> PW </label>
    <input type="password" name="PW" /> <br>
    <input type="submit" name="login" value="로그인" />
</form>  
</div>

<span><? var_dump($_SESSION)?></span>

