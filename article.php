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

    //해당 게시글의 조회수 증가시키기
    if(!isset($_COOKIE["article_$idx"])){
        setcookie("article_$idx", $idx, time() + 60*60);
        $sql = "UPDATE list SET views = views + 1 WHERE idx=:idx";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            'idx' => $idx,
        ]);
    }


    

    
    // 없는 글을 불러오려하는 경우 차단 (뒤로가기 막기 기능이 안돼서 추가한 기능임.)
    if(empty($article)){
        header('Location: ./list.php?nonexistArticle');
        exit;
    }

    // 댓글 불러오기
    $sql = 'SELECT * FROM comment WHERE article_idx = :idx';
    $statement = $pdo -> prepare($sql);
    $statement -> execute([':idx' => $idx]);
    $comments = $statement -> fetchAll();
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
        .goList{
            position: fixed;
            top: 1em;
            right: 6em;
        }
        .comment-box {
            background-color: whitesmoke;
            font-size: 0.8rem;
            margin-bottom: 15px;
            padding: 5px;    
        }
        .comment-info{
            padding-bottom: 10px;
        }

        .comment-box pre{
            margin : 0;
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
    <?php  
      if(isset($_GET['commentEmptyError'])){
    ?>
        <script>
            alert('댓글을 입력해주세요.');
        </script>
    <?php
      }
    ?>
    <?php  
      if(isset($_GET['commentSuccess'])){
    ?>
        <script>
            alert('댓글이 등록되었습니다.');
        </script>
    <?php
      }
    ?>
    <?php  
      if(isset($_GET['commentNoAuthority'])){
    ?>
        <script>
            alert('이 댓글에 대한 권한이 없습니다.');
        </script>
    <?php
      }
    ?>
    <?php  
      if(isset($_GET['commentdeletesuccess'])){
    ?>
        <script>
            alert('댓글이 성공적으로 삭제되었습니다.');
        </script>
    <?php
      }
    ?>
    <?php  
      if(isset($_GET['likeAlready'])){
    ?>
        <script>
            alert('이미 추천한 게시글 입니다.');
        </script>
    <?php
      }
    ?>
    <?php  
      if(isset($_GET['likeSuccess'])){
    ?>
        <script>
            alert('이 게시글을 추천 하였습니다.');
        </script>
    <?php
      }
    ?>
    <?php  
      if(isset($_GET['likeDeleteSuccess'])){
    ?>
        <script>
            alert('추천을 취소했습니다.');
        </script>
    <?php
      }
    ?><?php  
    if(isset($_GET['noLike'])){
  ?>
      <script>
          alert('추천 하지 않은 게시글 입니다.');
      </script>
  <?php
    }
  ?>
    <h2><?php echo $article[0]['title']?></h2>
    <a class="logout" href="logout.php">로그 아웃</a>
    <a class="goList" href="./list.php">게시판으로 돌아가기</a>
    <span><?php echo $article[0]['writer']?></span>
    <span><?php echo $article[0]['date']?></span><hr>
    <?php  
      if(!empty($article[0]['image'])){
        $imagePathArray = explode('\\', $article[0]['image']);
        $image = end($imagePathArray);
        echo "<img src=./upload/$image>";
      }
    ?>
    <p><?php echo "<pre>{$article[0]['content']}</pre>"?></p>
    <?php echo "<button onclick=\"location.href='delete.php?idx=$idx'\">삭제</button>"?>
    <?php echo "<button onclick=\"location.href='edit.php?idx=$idx'\">수정</button>"?><br><br>

    <?php echo "<button onclick=\"location.href='like.php?idx=$idx'\">글 추천</button>"?>
    <?php echo "<button onclick=\"location.href='likedelete.php?idx=$idx'\">추천 취소</button>"?>





    
    <h4>댓글목록</h4>
    <form action="./comment.php" method="POST">
        <input type="hidden" name="articleIdx" value=<?php echo $idx?>>
        <textarea name="comment" rows="5" cols="50" placeholder="댓글 작성"></textarea>
        <input type="submit" value="등록">
    </form>
    <br>





    <?php
        if(!empty($comments)){
            foreach($comments as $comment){
                echo "<div class=\"comment-box\">";
                echo "<div class=\"comment-info\">";
                echo "<span><b>{$comment['comment_writer']}</b>  </span>";
                echo "<span>{$comment['comment_date']}  </span>";
                echo "<span><button onclick=\"location.href='./commentdelete.php?comment_idx={$comment['comment_idx']}'\">삭제</button></span>";
                echo "</div>";   
                echo "<pre>{$comment['comment']}</pre>";
                echo "</div>";
                
            }
        }       
    ?>
</body>
</html>