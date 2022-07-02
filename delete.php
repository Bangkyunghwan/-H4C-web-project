<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('Location: ./login.php?notLogin');
        exit;
    } 

     //csrf 방어를 위한 referer 검사 코드
     $referer = getenv("HTTP_REFERER");
     $host = getenv("HTTP_HOST");
     $parsedReferer = parse_url($referer);
     $refererHost = $parsedReferer['host'];
 
     if($refererHost !== $host){
         echo "외부에서의 요청 차단합니다.";
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


    // 작성자 정보 가져오기
    $sql = 'SELECT writer FROM list WHERE idx = :idx';
    $idx = $_GET['idx'];
    
    $statement = $pdo -> prepare($sql);
    $statement -> execute([':idx' => $idx]);
    $writer = $statement -> fetchAll();

    // 삭제 요청을 한 사람과 글의 작성자가 같은 유저인지 비교 후 삭제 + 그 글의 댓글 까지 모두 삭제
    if($writer[0][0] === $_SESSION['id']){
        $sql = 'DELETE FROM list WHERE idx = :idx';
        $statement = $pdo -> prepare($sql);
        $statement -> execute([':idx' => $idx]);

        $sql = 'DELETE FROM comment WHERE article_idx = :article_idx';
        $statement = $pdo -> prepare($sql);
        $statement -> execute([':article_idx' => $idx]);



        header('Location: ./list.php?deleteSuccess');
        exit;
        
    }else{
        header("Location: ./article.php?idx=$idx&noAuthority");
        exit;
    }
?>


