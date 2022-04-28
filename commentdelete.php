<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('Location: ./login.php?notLogin');
        exit;
    }
    $comment_idx = $_GET['comment_idx'];

    //데이터베이스 연결
    require 'dbconfig.php';
     $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
 
     try{
         $pdo = new PDO($dsn, $user, $password);
         
         
     }catch(PDOException $e){
         echo $e -> getMessage();
     }

    
    $sql = 'SELECT comment_writer, article_idx FROM comment WHERE comment_idx = :comment_idx';
    
    $statement = $pdo -> prepare($sql);
    $statement -> execute([':comment_idx' => $comment_idx]);
    $comment = $statement -> fetchAll();
    $articleIdx = $comment[0]['article_idx'];

    // 삭제 요청한 유저와 댓글 작성자가 같은지 비교
    if($comment[0]['comment_writer'] !== $_SESSION['id']){
        header("Location: ./article.php?idx=$articleIdx&commentNoAuthority");
        exit;
    }

    $sql = 'DELETE FROM comment WHERE comment_idx = :comment_idx';
    $statement = $pdo -> prepare($sql);
    $statement -> execute([':comment_idx' => $comment_idx]);

    header("Location: ./article.php?idx=$articleIdx&commentdeletesuccess");

    



?>