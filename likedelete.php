<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('Location: ./login.php?notLogin');
        exit;
    }
    
    $articleIdx = $_GET['idx'];
    $userId = $_SESSION['id'];

    // 데이터베이스 연결
    require 'dbconfig.php';
    $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

    try{
        $pdo = new PDO($dsn, $user, $password);
        
        
    }catch(PDOException $e){
        echo $e -> getMessage();
    }


    // 삭제를 위해 이 유저가 그 게시물을 추천한 사람인지 확인
    $sql = 'SELECT * FROM like_manager WHERE article_idx = :articleIdx AND like_user = :userId';

    $statement = $pdo -> prepare($sql);
    $statement -> execute([
        ':articleIdx' => $articleIdx,
        ':userId' => $userId   
    ]);
    $likeData = $statement -> fetchAll();

    if(!$likeData){
        header("Location: ./article.php?idx=$articleIdx&noLike");
        exit;
    }
    

    // 추천 수 1 감소시키기
    $sql = "UPDATE list SET likes = likes - 1 WHERE idx=:idx";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'idx' => $articleIdx,
    ]);

    // 글 추천을 누른 유저의 아이디와 게시글 번호를 글 추천 관리 데이터베이스에 저장
    $sql = 'DELETE FROM like_manager WHERE article_idx = :articleIdx AND like_user = :userId';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':articleIdx' => $articleIdx,
        ':userId' => $userId, 
    ]);

    header("Location: ./article.php?idx=$articleIdx&likeDeleteSuccess");
    exit;


?>





