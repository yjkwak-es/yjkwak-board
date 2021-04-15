<html>

<head>
    <title>CodeIgniter 튜토리얼(Tutorial)</title>
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
            <button id="menuOpen">메뉴</button>
        </div>

        <div class="MenuPopup">
            <div class="FlexContainer">
                <div><span>접속자 : <a href="javascript:popup()"><?= $this->session->selectUserData() ?></a></span></div>
                <div><a href="<?= site_url(array('member', 'logout')) ?>">logout</a></div>
                <div> <button id="menuClose"> X </button> </div>
            </div>
            
            <div>
            <a href="<?=site_url('posts')?>">Posts archive</a>
            </div>
            
        </div>
    </div>
