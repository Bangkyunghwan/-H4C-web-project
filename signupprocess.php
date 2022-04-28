<?php
    // 아이디 비밀번호 이메일 중 입력되지 않은 정보가 있으면 다시
    // 회원가입 페이지로 경고창을 띄우며 리다이렉트.
    if($_POST['id'] === '' || $_POST['password'] === ''|| $_POST['email'] === ''){
        header('Location: ./signup.php?emptyError');
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
    // 아이디, 비밀번호, 이메일 정보 받아오기
    $id = $_POST['id'];
    $password = $_POST['password'];
    $email = $_POST['email'];


    // 아이디와 비밀번호 유효성 검사
    if(!preg_match('/^[a-z0-9]{6,14}+$/', $id) || !preg_match('/^[a-z0-9]{8,16}+$/', $password)){
        header('Location: ./signup.php?invalidInput');
        exit; 
    }

    // 아이디 중복 검사
    $sql = 'SELECT id FROM members WHERE id = :id';

    $statement = $pdo -> prepare($sql);
    $statement -> execute(['id' => $id]);
    $sameId = $statement -> fetchAll();

    if($sameId){
        header('Location: ./signup.php?sameIdError');
        exit;
    }

    // 데이터베이스에 신규 회원 데이터 저장
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 데이터베이스에 저장 전 비밀번호 암호화
    
    $sql = "INSERT INTO members(id, password, email) VALUES(:id, :password, :email)";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':id' => $id,
        ':password' => $password,
        ':email' => $email, 
    ]);

    header('Location: ./signupsuccess.html');

?>

