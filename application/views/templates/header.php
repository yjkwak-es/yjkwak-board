<html>

<head>
    <title>CodeIgniter 튜토리얼(Tutorial)</title>
    <link href="/css/board.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
    <h1 style="text-align : center"><?php echo $title ?></h1>
    
    <div class=Search>
        <span>접속자 : <?= $this->session->userdata('UserData') ?></span> <a href="<?=site_url(array('member','logout'))?>">logout</a>
    </div>
