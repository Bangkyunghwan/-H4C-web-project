<?php
    //아이디와 비밀번호가 입력 되었는지 확인
    if($_POST['id'] === '' || $_POST['password'] === ''){
        header('Location: ./login.php?emptyError');
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


    // 로그인 검사
    $sql = 'SELECT id, password FROM members WHERE id = :id';
    $id = $_POST['id'];
    $password = $_POST['password'];

    $statement = $pdo -> prepare($sql);
    $statement -> execute(['id' => $id]);
    $memberData = $statement -> fetchAll();

    if($memberData){
        if(password_verify($password, $memberData[0]['password'])){
            session_start();
            $_SESSION['id'] = $memberData[0]['id'];
            sleep(rand(1,3));     // 브루트 포스 공격 방지
            header('Location: ./list.php');
            exit;
        }else{
            header('Location: ./login.php?wrongPassword');
            sleep(rand(1,3));    // 브루트 포스 공격 방지
            exit;
        }
    }else{
        header('Location: ./login.php?notFoundId');
        exit;
    }

    


?>