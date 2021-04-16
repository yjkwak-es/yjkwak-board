<script>
    function popup() {
        var option = "left=100,top=100,width=500,height=300";
        window.open("member/setInfo", "상세정보저장", option);
    }

    $(function() {
        setPop();
    });

    // 메뉴 세팅
    function setPop() {
        var popOpenBtn = $('#menuOpen');

        //메뉴 열기
        popOpenBtn.on('click', function() {
            $('.MenuPopup').fadeIn(200);
            popOpenBtn.fadeOut(200);
        })

        //메뉴 닫기
        $('#menuClose').on('click', function() {
            $('.MenuPopup').fadeOut(200);
            popOpenBtn.fadeIn(200);
        })
    }


    function alluser() {
        var option = "left=100,top=100,width=800,height=600";
        window.open("<?= site_url(array('admin', 'members')) ?>", "유저정보", option);
    }

    $(document).ready(function() {
        if ('<?= $this->session->isAdmin() ?>' == '1') {
            $('.allInfoBtn').css('display', 'block');
        } else {
            $('.allInfoBtn').css('display', 'none');
        }
    });
</script>

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

            <div class="allInfoBtn">
                <a href="javascript:alluser()">유저정보</a>
            </div>

        </div>
    </div>
    <div class="MainBody">
