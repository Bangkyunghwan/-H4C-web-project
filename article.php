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

    // 글 내용 가져오기
    $sql = 'SELECT * FROM list WHERE idx = :idx';
    $idx = $_GET['idx'];
    
    $statement = $pdo -> prepare($sql);
    $statement -> execute([':idx' => $idx]);
    $article = $statement -> fetchAll();
    if(empty($article)){
        header('Location: ./list.php?nonexistArticle');
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .logout{
            position: fixed;
            top: 1em;
            right: 1em;
        }
    </style>
</head>
<body>
<?php  
      if(isset($_GET['noAuthority'])){
    ?>
        <script>
            alert('이 글에 대한 권한이 없습니다.')
        </script>
    <?php
      }
    ?>
    <h2><?php echo $article[0]['title']?></h2>
    <a class="logout" href="logout.php">로그 아웃</a>
    <span><?php echo $article[0]['writer']?></span>
    <span><?php echo $article[0]['date']?></span><hr>
    <p><?php echo $article[0]['content']?></p>
    <?php echo "<button onclick=\"location.href='delete.php?idx=$idx'\">삭제</button>"?>
    <a href="./list.php">게시판으로 돌아가기</a>

</body>
</html>