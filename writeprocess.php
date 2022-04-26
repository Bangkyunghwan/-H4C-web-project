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

    // 업로드된 파일이 있는 지 확인후 파일 처리 과정
    if(!empty($_FILES['image']['name'])){
        $name = basename($_FILES['image']['name']);

        $fileArray = explode('.', $name);
        $ext = end($fileArray);
        $newFileName = date(time()).'.'.$ext;

        $imageExt = ['png', 'jpg', 'jpeg', 'gif', 'PNG', "JPG", 'JPEG', 'GIF'];

        $uploadDir = "C:\Bitnami\wampstack-8.1.4-0\apache2\htdocs\board\upload\\";
        $uploadFile = $uploadDir . $newFileName;
        

        if(!in_array($ext, $imageExt)){
            header("Location: ./write.php?fileError");
            exit;
        }
    

        if(!move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)){
            header("Location: ./write.php?fileError");
            exit;
        }
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
    $sql = "INSERT INTO list(writer, title, content, image ,date) VALUES(:writer, :title, :content, :image, :date)";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        ':writer' => $writer,
        ':title' => $title,
        ':content' => $content,
        ':image' => $uploadFile,
        ':date' => $date
    ]);

    header('Location: ./list.php');
    exit;
    


?>