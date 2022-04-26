<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('Location: ./login.php?notLogin');
        exit;
    }
    if(empty($_GET['search'])){
        header('Location: ./list.php?emptyError');
    }


    $type = "'%{$_GET['type']}%'";
    $standard = $_GET['standard'];
    $search = "'%{$_GET['search']}%'";

    // echo $type;
    // echo $standard;
    // echo $search;

    // 데이터베이스 연결
    require 'dbconfig.php';
    $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

    try{
        $pdo = new PDO($dsn, $user, $password);
        
        
    }catch(PDOException $e){
        echo $e -> getMessage();
    }


    if($_GET['type'] === "모든"){
        $query = "SELECT * FROM list WHERE $standard LIKE $search";
        if($_GET['standard'] === "all"){
            $query = "SELECT * FROM list WHERE title LIKE $search OR content LIKE $search";
        }
    }else{
        $query = "SELECT * FROM list WHERE type LIKE $type AND $standard LIKE $search";
        if($_GET['standard'] === "all"){
            $query = "SELECT * FROM list WHERE type LIKE $type AND (title LIKE $search OR content LIKE $search)";
        }
    }
    

    $statement = $pdo -> prepare($query);
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
        .goList{
            position: fixed;
            top: 1em;
            right: 6em;
        }

    
        
    </style>
</head>
<body>
    
    <h1>검색 결과</h1>
    <a class="logout" href="logout.php">로그 아웃</a>
    <a class="goList" href="./list.php">게시판으로 돌아가기</a>
    <?php 
        echo "<table>
        <tr>
          <th>게시글 번호</th>
          <th>제목</th>
          <th>작성자</th>
          <th>게시글 유형</th>
          <th>생성 및 수정 날짜</th>
        </tr>";

        // 글 목록 데이터베이스에 있는 글 정보 하나씩 가져와서 화면에 띄우기
        foreach($list as $article){            
            echo "<tr class=\"content\" onClick=\"location.href='./article.php?idx={$article['idx']}'\">
              <td>{$article['idx']}</td>
              <td>{$article['title']}</td>
              <td>{$article['writer']}</td>
              <td>{$article['type']}</td>
              <td>{$article['date']}</td>
            </tr>";
        }
        echo "</table>";
    ?>