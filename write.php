<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('Location: ./login.php?notLogin');
        exit;
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
        #flex-container{
            height: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
           
        }  

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
        a{
            text-decoration: none;
            font-size: 0.8rem;
        }
        #title-type{
            display: flex;
            justify-content: space-between;
        }

        [type="submit"]{
            width: 100%;
            height: 40px;
            justify-self: center;
        }
    </style>
</head>
<body>
    <?php  
      if(isset($_GET['emptyError'])){
    ?>
        <script>
            alert('제목이나 본 내용이 입력되지 않았습니다.')
        </script>
    <?php
      }
    ?>
    <?php  
      if(isset($_GET['fileError'])){
    ?>
        <script>
            alert('파일 업로드에 실패하였습니다.')
        </script>
    <?php
      }
    ?>
    <div id="flex-container">
    <h2>글 작성 페이지</h2>
    <a class="logout" href="logout.php">로그 아웃</a>
    <form action="./writeprocess.php" method="POST" enctype="multipart/form-data">
        <div id="title-type">
            <label>
                글 제목: <input type="text" name="title" style="width: 300px; "><br>
            </label>
            <label>
                게시글 유형 : 
                <select name="type">
                    <option value="자유">자유(기타)</option>
                    <option value="질문">질문</option>
                    <option value="홍보">홍보</option>
                </select>
            </label> 
        </div>
        <p>
            본 내용<br>
            <textarea name="content" rows="30" cols="100"></textarea>
        </p>
        <p>
            이미지 업로드 : <input type="file" name="image"></input>
        </p>     
        <input type="submit" value="글 게시하기">
    </form>
    <a class="goList" href="./list.php">게시판으로 돌아가기</a>
    </div>
</body>
</html>