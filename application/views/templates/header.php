<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CodeIgniter 튜토리얼(Tutorial)</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/board.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
        function popup() {
            var option = "left=100,top=100,width=500,height=300";
            window.open("member/setInfo", "상세정보저장", option);
        }

        $(function() {
            setPop();
        });

        // 팝업 세팅
        function setPop() {
            var popOpenBtn = $('#menuOpen');

            //팝업 열기
            popOpenBtn.on('click', function() {
                $('.MenuPopup').fadeIn(200);
                popOpenBtn.fadeOut(200);
            })

            //팝업 닫기
            $('#menuClose').on('click', function() {
                $('.MenuPopup').fadeOut(200);
                popOpenBtn.fadeIn(200);
            })
        }
    </script>

</head>

<body>
    <h1 style="text-align : center"><?= $title ?></h1>
    <div class="Layer">
        <div class="Menu">
            <button class="btn btn-primary" id="menuOpen"><span class="glyphicon glyphicon-align-justify" aria-hidden="true">&laquo;</span></button>
        </div>

        <div class="MenuPopup">
            <div class="FlexContainer">
                <div><a href="javascript:popup()"><?= $this->session->selectUserData() ?></a></div>
                <div><a href="<?= site_url(array('member', 'logout')) ?>">logout</a></div>
                <div> <button class="close" aria-label="Close" id="menuClose">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <div>
                <a href="<?= site_url('posts') ?>">Posts archive</a>
            </div>

        </div>
    </div>
<div class="MainBody">
