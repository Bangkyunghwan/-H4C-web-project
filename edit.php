<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('Location: ./login.php?notLogin');
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


    // 작성자 정보, 글 제목, 내용 가져오기
    $sql = 'SELECT * FROM list WHERE idx = :idx';
    $idx = $_GET['idx'];
    
    $statement = $pdo -> prepare($sql);
    $statement -> execute([':idx' => $idx]);
    $article = $statement -> fetchAll();

    // 수정요청을 한 유저와 글을 작성한 유저가 일치하는지 검사
    if(!($article[0]['writer'] === $_SESSION['id'])){
        header("Location: ./article.php?idx=$idx&noAuthority");
        exit;       
    }

    $content = $article[0]['content'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php  
      if(isset($_GET['emptyError'])){
    ?>
        <script>
            alert('입력되지 않은 정보가 있습니다. 모든 정보를 입력해주세요.')
        </script>
    <?php
      }
    ?>
    <form action=<?php echo "./editproccess.php?idx=$idx"?> method="POST" enctype="multipart/form-data">
        <h2><?php echo $article[0]['title']?></h2>
        
        <span><?php echo $article[0]['writer']?></span>
        <span><?php echo $article[0]['date']?></span><hr>
        <p>
            본 내용<br>
            <textarea name="content" rows="30" cols="50"><?php echo $content?></textarea>
        </p>
        <p>
            새 이미지 업로드 : <input type="file" name="image"></input>
        </p> 
        <input type="submit" value="수정 완료">
    </form>
      <a href=<?php echo "./article.php?idx=$idx"?>>수정 취소</a>
</body>
</html>




