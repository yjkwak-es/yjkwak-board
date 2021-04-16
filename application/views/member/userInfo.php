<div class="text-center">
    <?= form_open('member/setInfo',array('class'=>'form-signin')) ?>

    <div>
        <label for="name">이름</label> <input type="text" name="name" id="name" autocomplete="off" value=<?= $member->name ?>>
    </div>

    <div>
        <label for="age">나이</label> <input type="text" name="age" id="age" autocomplete="off" value=<?= $member->age ?>>
    </div>

    <div>
        <label for="male">Male</label>
        <input type="radio" name="gender" id="male" value="M">

        <label for="female">Female</label>
        <input type="radio" name="gender" id="female" value="F">
    </div>

    <input type="submit" value="저장">

    <script>
        <? if (isset($member->gender)) : ?>
            <? if ($member->gender === 'M') : ?>
                document.getElementById('male').checked = true;
            <? else : ?>
                document.getElementById('female').checked = true;
            <? endif; ?>
        <? endif; ?>
    </script>

    <?= form_close() ?>
</div>

<script>
    //이름 : 특수문자 및 완성되지 않은 한글 입력제한
    var replaceChar = /[~!@\#$%^&*\()\-=+_'\;<>0-9\/.\`:\"\\,\[\]?|{}]/gi;
    var replaceNotFullKorean = /[ㄱ-ㅎㅏ-ㅣ]/gi;

    $(document).ready(function() {
        $("#name").on("focusout", function() {
            var x = $(this).val();
            if (x.length > 0) {
                if (x.match(replaceChar) || x.match(replaceNotFullKorean)) {
                    x = x.replace(replaceChar, "").replace(replaceNotFullKorean, "");
                }
                $(this).val(x);
            }
        }).on("keyup", function() {
            $(this).val($(this).val().replace(replaceChar, ""));
        });
    })

    //나이 : 숫자 외 입력제한
    var replaceNotInt = /[^0-9]/gi;

    $(document).ready(function() {
        $("#age").on("focusout", function() {
            var x = $(this).val();
            if (x.length > 0) {
                if (x.match(replaceNotInt)) {
                    x = x.replace(replaceNotInt, "");
                }
                $(this).val(x);
            }
        }).on("keyup", function() {
            $(this).val($(this).val().replace(replaceNotInt, ""));
        });
    });
</script>
