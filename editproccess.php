<?php
    session_start();

// 데이터베이스에 저장할 데이터들 
    $content = htmlspecialchars($_POST['content']);
    $date = date('Y-m-d H:i:s');
    $idx = $_GET['idx'];
    //글 제목과 글 내용이 비어있는지 확인
    


    if(empty($content)){
        header('Location: ./edit.php?emptyError');
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
     
    
     // 게시글 데이터베이스에 저장
     $sql = "UPDATE list SET content=:content, date=:date WHERE idx=:idx";
     $statement = $pdo->prepare($sql);
     $statement->execute([
         'content' => $content,
         'date' => $date,
         'idx' => $idx,
     ]);

     
    header("Location: ./article.php?idx=$idx");
?>