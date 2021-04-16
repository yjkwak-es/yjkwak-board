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

        $('#sendInfo').click(function() {
            $.ajax({
                url: "<?= site_url(array('member', 'infotest')) ?>",
                type: 'POST',
                async: true,
                data: {
                    name: $('#name').val(),
                    age: $('#age').val(),
                    gender: $('input:radio[name="gender"]:checked').val()
                },
                timeout: 10000,
                success: function(data) {
                    alert(data);
                },
                error: function(request, status, error) {
                    $('#name').attr("value", "err");
                }
            });
        });

        $('#userInfo').on('shown.bs.modal', function() {
            $.ajax({
                url: "<?= site_url(array('member', 'getInfo')) ?>",
                async: true,
                timeout: 10000,
                success: function(data) {
                    $('#name').val(data.name);
                    $('#age').val(data.age);
                    $('input:radio[name="gender"][value="' + data.gender + '"]').prop('checked', true);
                }
            });
        })
    });
</script>

<body>
    <h1 style="text-align : center"><?= $title ?></h1>
    <div class="Layer">
        <div class="Menu">
            <button class="btn btn-primary" id="menuOpen"><span class="glyphicon glyphicon-align-justify" aria-hidden="true">&laquo;</span></button>
        </div>

        <div class="MenuPopup">
            <div class="close">
                <button class="close" aria-label="Close" id="menuClose">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div>
                <button id='user' class="btn" data-toggle="modal" data-target="#userInfo"><?= $this->session->selectUserData() ?></button>
            </div>

            <div>
                <a href="<?= site_url('posts') ?>">Posts archive</a>
            </div>

            <div>
                <a href="javascript:popup()"><?= $this->session->selectUserData() ?></a>
            </div>

            <div class="allInfoBtn">
                <a href="javascript:alluser()">유저정보</a>
            </div>

            <div class="logOut">
                <a href="<?= site_url(array('member', 'logout')) ?>">logout</a>
            </div>
        </div>
    </div>

    <!-- userInfo modal -->
    <div class="modal fade" id="userInfo" tabindex="-1" aria-labelledby="userInfo" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Set User Info</h5>
                </div>
                <div class="modal-body">
                    <?= form_open() ?>
                    <div class="form-group">
                        <label for="name" class="sr-only">name</label>
                        <input class="form-control" id="name" placeholder="name" required autofocus></input>

                        <label for="id" class="sr-only">age</label>
                        <input class="form-control" id="age" placeholder="age" required autofocus></input>

                        <div>
                            <label for="male">Male</label>
                            <input type="radio" name="gender" id="male" value="M" style="width : 10%">

                            <label for="female">Female</label>
                            <input type="radio" name="gender" id="female" value="F" style="width : 10%">
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sendInfo">Send message</button>
                </div>
            </div>
        </div>
    </div>

    <div class="MainBody">
