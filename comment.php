<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('Location: ./login.php?notLogin');
        exit;
    }
    

    // 댓글이 달린 글 인덱스 번호, 댓글을 쓴 유저 아이디, 댓글 받아오기
    $articleIdx = $_POST['articleIdx'];
    $comment = htmlspecialchars($_POST['comment']);
    $commentWriter =  $_SESSION['id'];
    $date = date('Y-m-d H:i:s');

    if(empty($comment)){
        header("Location: ./article.php?idx=$articleIdx&commentEmptyError");
        exit;
    }

    //데이터베이스 연결
    require 'dbconfig.php';
    $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

    try{
        $pdo = new PDO($dsn, $user, $password);
        
        
    }catch(PDOException $e){
        echo $e -> getMessage();
    }

    // 댓글 데이터베이스에 저장
    $sql = "INSERT INTO comment(article_idx, comment_writer, comment, comment_date) VALUES(:article_idx, :comment_writer, :comment, :comment_date)";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ":article_idx" => $articleIdx,
        ":comment_writer" => $commentWriter,
        ":comment" => $comment,
        ":comment_date" => $date,
    ]);

    header("Location: ./article.php?idx=$articleIdx&commentSuccess");
    exit;
?>