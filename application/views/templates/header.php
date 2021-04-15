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
    </script>
    
</head>

<body>
    <h1 style="text-align : center"><?php echo $title ?></h1>
    
    <div class=Search>
        <span>접속자 : <a href="javascript:popup()"><?=$this->session->selectUserData()?></a></span> 
        <a href="<?=site_url(array('member','logout'))?>">logout</a>
    </div>
