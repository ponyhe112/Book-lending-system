<?php
session_start();
$username = $_SESSION['username'];
include('mysqli_connect.php');

$sql = "select name from reader_info where reader_id={$username}";
$res = mysqli_query($dbc, $sql);
$result = mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>卡号挂失</title>
    <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        body {
            width: 100%;
            overflow: hidden;
            background: url("图书馆2.jpeg") no-repeat;
            background-size: cover;
            color: antiquewhite;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">图书借阅系统</a>
        </div>
        <div>
            <ul class="nav navbar-nav">
                <li><a href="reader_index.php">主页</a></li>
                <li><a href="reader_querybook.php">图书查询</a></li>
                <li><a href="reader_borrow.php">我的借阅</a></li>
                <li><a href="reader_info.php">个人信息</a></li>
                <li><a href="reader_repass.php">密码修改</a></li>
                <li class="active"><a href="reader_guashi.php">证件挂失</a></li>
                <li><a href="index.php">退出</a></li>
            </ul>
        </div>
    </div>
</nav>
<h3 style="text-align: center"><?php echo $result['name']; ?>同学，您好</h3><br/>
<h4 style="text-align: center">您当前证件状态为：<br/>
    <?php


    $sqla = "select card_state from card_state where card_id={$username} ;";

    $resa = mysqli_query($dbc, $sqla);
    $resulta = mysqli_fetch_array($resa);
    if ($resulta['card_state'] == 0) echo "挂失<br/><br/><a href='reader_guashi_do.php?id=0' style='text-align: center'><button>点此取消挂失</button></a>";
    else echo "正常<br/><br/><a href='reader_guashi_do.php?id=1' style='text-align: center'><button>点此挂失</button></a>";

    ?>
</h4>
</body>
</html>