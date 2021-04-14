<?= form_open('member/setInfo') ?>

<div>
    <label for="name">이름</label> <input type="text" name="name" id="name" autocomplete="off" value=<?= $member['name'] ?>>
</div>

<div>
    <label for="age">나이</label> <input type="text" id="age" name="age" autocomplete="off" value=<?= $member['age'] ?>>
</div>

<div>
    <label for="male">Male</label>
    <input type="radio" name="gender" id="male" value="M">

    <label for="female">Female</label>
    <input type="radio" name="gender" id="female" value="F">
</div>

<input type="submit" value="저장">

<script>
    <? if (isset($member['gender'])) : ?>
        <? if ($member['gender'] === 'M') : ?>
            document.getElementById('male').checked = true;
        <? else : ?>
            document.getElementById('female').checked = true;
        <? endif; ?>
    <? endif; ?>
</script>

<?= form_close() ?>
