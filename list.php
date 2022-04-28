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


    // 데이터베이스에서 글 목록 가져오기
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
            border-spacing: 0 20px;

        }
        th{
            border-bottom: 1px solid black;
            border-top: 1px solid black;
            padding-top: 10px;
            padding-bottom: 10px;
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
        .logout{
            position: fixed;
            top: 1em;
            right: 1em;
        }

    
        
    </style>
</head>
<body>
    
    <?php  
      if(isset($_GET['deleteSuccess'])){
    ?>
        <script>
            alert('성공적으로 삭제되었습니다.')
        </script>
    <?php
      }
    ?>
    <?php  
      if(isset($_GET['nonexistArticle'])){
    ?>
        <script>
            alert('존재하지 않는 글입니다.')
        </script>
    <?php
      }
    ?>
    <?php  
      if(isset($_GET['emptyError'])){
    ?>
        <script>
            alert('검색 키워드를 입력해주세요.')
        </script>
    <?php
      }
    ?>

    <h1>모든게시판</h1>
    <a class="logout" href="logout.php">로그 아웃</a>
    <h2><?php echo $_SESSION['id']?>님 환영합니다.</h2>
    <a href="./write.php">글 쓰기</a>
    <form action="search.php">
        <select name="type">
            <option value="모든">모든게시판</option>
            <option value="자유">자유게시판</option>
            <option value="질문">질문게시판</option>
            <option value="홍보">홍보게시판</option>
        </select>
        <select name="standard">
            <option value="all">전체</option>
            <option value="title">제목</option>
            <option value="content">내용</option>
        </select>
        <input type="search" name="search">
         <input type="submit" value="검색">
    </form>
    

    <?php 
        echo "<table>
        <tr>
          <th>게시글 번호</th>
          <th>제목</th>
          <th>작성자</th>
          <th>게시글 유형</th>
          <th>생성 및 수정 날짜</th>
          <th>조회수</th>
          <th>추천 수</th>
        </tr>";

        // 글 목록 데이터베이스에 있는 글 정보 하나씩 가져와서 화면에 띄우기
        foreach($list as $article){            
            echo "<tr class=\"content\" onClick=\"location.href='./article.php?idx={$article['idx']}'\">
              <td>{$article['idx']}</td>
              <td>{$article['title']}</td>
              <td>{$article['writer']}</td>
              <td>{$article['type']}</td>
              <td>{$article['date']}</td>
              <td>{$article['views']}</td>
              <td>{$article['likes']}</td>
            </tr>";
        }
        echo "</table>";
    ?>

</body>
</html>