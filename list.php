<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('Location: ./login.php?notLogin');
        exit;
    }

    // 데이터베이스 연결
    require 'dbconfig.php';
    $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

    try{
        $pdo = new PDO($dsn, $user, $password);
        
    }catch(PDOException $e){
        echo $e -> getMessage();
    }


    $sql = 'SELECT * FROM list';
    
    $statement = $pdo -> prepare($sql);
    $statement -> execute();
    $list = $statement -> fetchAll();
    


    
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table{
            width: 70%;
            border-spacing: 0 10px;
        }

        th, td{
            text-align: center;
        }
        .content{
            cursor: pointer;
        }

        .content:hover{
            text-decoration: underline;
        }

    
        
    </style>
</head>
<body>
    <h1>자유게시판</h1>
    <h2><?php echo $_SESSION['id']?>님 환영합니다.</h2>
    <a href="./write.php">글 쓰기</a>
    <a href="logout.php">로그 아웃</a><br><br>

    <?php 
        echo "<table>
        <tr>
          <th>게시글 번호</th>
          <th>제목</th>
          <th>작성자</th>
          <th>생성 및 수정 날짜</th>
        </tr>";

        foreach($list as $article){            
            echo "<tr class=\"content\" onClick=\"location.href='./content.php?{$article['idx']}'\">
              <td>{$article['idx']}</td>
              <td>{$article['title']}</td>
              <td>{$article['writer']}</td>
              <td>{$article['date']}</td>
            </tr>
            <";
        }
        echo "</table>";
    ?>

</body>
</html>