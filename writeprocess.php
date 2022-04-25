<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('Location: ./login.php?notLogin');
        exit;
    }

    // 데이터베이스에 저장할 데이터들 
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $writer = htmlspecialchars($_SESSION['id']);
    $date = date('Y-m-d H:i:s');


    // 글 제목과 글 내용이 비어있는지 확인
    if(empty($title) || empty($content)){
        header('Location: ./write.php?emptyError');
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
     
    
 
     // 게시글 데이터베이스에 저장
     $sql = "INSERT INTO list(writer, title, content,  date) VALUES(:writer, :title, :content, :date)";
     $statement = $pdo->prepare($sql);
     $statement->execute([
         ':writer' => $writer,
         ':title' => $title,
         ':content' => $content,
         ':date' => $date
     ]);

    header('Location: ./list.php');


?>