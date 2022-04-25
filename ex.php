<?php
// 데이터베이스 연결
    require 'dbconfig.php';
    $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

    try{
        $pdo = new PDO($dsn, $user, $password);
        
    }catch(PDOException $e){
        echo $e -> getMessage();
    }


    // 작성자 정보, 글 제목, 내용 가져오기
    $sql = 'SELECT * FROM list WHERE idx = :idx';
    
    
    $statement = $pdo -> prepare($sql);
    $statement -> execute([':idx' => 22]);
    $article = $statement -> fetchAll();

    echo $article[0]['writer'];
?>