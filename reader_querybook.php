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
    <title>图书查询</title>
    <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        #resbook {
            top: 50%;

        }

        #query {

            text-align: center;
        }

        body {
            width: 100%;


            background-size: cover;
            color: black;
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
                <li class="active"><a href="reader_querybook.php">图书查询</a></li>
                <li><a href="reader_borrow.php">我的借阅</a></li>
                <li><a href="reader_info.php">个人信息</a></li>
                <li><a href="reader_repass.php">密码修改</a></li>
                <li><a href="reader_guashi.php">证件挂失</a></li>
                <li><a href="index.php">退出</a></li>
            </ul>
        </div>
    </div>
</nav>
<h3 style="text-align: center"><?php echo $result['name']; ?>同学，您好</h3><br/>
<h4 style="text-align: center">图书查询：</h4>


<form action="reader_querybook.php" method="POST">
    <div id="query">
        <label><input name="bookquery" type="text" placeholder="请输入图书名或图书号" class="form-control"></label>
        <input type="submit" value="查询" class="btn btn-default">
    </div>
</form>
<table width='100%' class="table table-hover">
    <tr>
        <th>图书号</th>
        <th>图书名</th>
        <th>作者</th>
        <th>出版社</th>
        <th>ISBN</th>
        <th>简介</th>
        <th>语言</th>
        <th>价格</th>
        <th>出版日期</th>
        <th>分类号</th>
        <th>分类名</th>
        <th>书架号</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $gjc = $_POST["bookquery"];

        $sql = "select book_id,name,author,publish,ISBN,introduction,language,price,pubdate,book_info.class_id,class_name,pressmark,state from book_info,class_info where book_info.class_id=class_info.class_id and ( name like '%{$gjc}%' or book_id like '%{$gjc}%')  ;";

    } else {
        $sql = "select book_id,name,author,publish,ISBN,introduction,language,price,pubdate,book_info.class_id,class_name,pressmark,state from book_info,class_info where book_info.class_id=class_info.class_id ;";
    }


    $res = mysqli_query($dbc, $sql);
    foreach ($res as $row) {
        echo "<tr>";
        echo "<td>{$row['book_id']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['author']}</td>";
        echo "<td>{$row['publish']}</td>";
        echo "<td>{$row['ISBN']}</td>";
        echo "<td>{$row['introduction']}</td>";
        echo "<td>{$row['language']}</td>";
        echo "<td>{$row['price']}</td>";
        echo "<td>{$row['pubdate']}</td>";
        echo "<td>{$row['class_id']}</td>";
        echo "<td>{$row['class_name']}</td>";
        echo "<td>{$row['pressmark']}</td>";
        if ($row['state'] == 1) echo "<td>在馆</td>"; else if ($row['state'] == 0) echo "<td>已借出</td>"; else  echo "<td>无状态信息</td>";
        if ($row['state'] == 1) echo "<td><a href='reader_lent.php?id={$row['book_id']}'>我要借阅</a></td>";
        if ($row['state'] == 0) echo "<td>不可借阅</td>";
        echo "</tr>";
    };
    ?>
</table>
</body>
</html>