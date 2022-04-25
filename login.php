<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        input[name]{
            width: 250px;
            height: 20px;
            font-size: 0.6rem;
        }
    </style>
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
    <?php  
      if(isset($_GET['notFoundId'])){
    ?>
        <script>
            alert('존재하지 않는 아이디 입니다.')
        </script>
    <?php
      }
    ?>
    <?php  
      if(isset($_GET['wrongPassword'])){
    ?>
        <script>
            alert('잘못된 비밀번호 입니다.')
        </script>
    <?php
      }
    ?>
    <?php  
      if(isset($_GET['notLogin'])){
    ?>
        <script>
            alert('로그인 후 게시판을 이용할 수 있습니다.')
        </script>
    <?php
      }
    ?>
    <?php  
      if(isset($_GET['logout'])){
    ?>
        <script>
            alert('로그아웃 되었습니다.')
        </script>
    <?php
      }
    ?>
    <h1>로그인 페이지</h1>
    <form action="./loginprocess.php" method="POST">
        <label>
            아이디 : <input type="text" name="id"><br>
        </label>
        <label>
            비밀번호 : <input type="password" name="password"><br>
        </label>
        <input type="submit" value="로그인">
    </form>
    <a href='signup.php'>회원가입 하러가기</a>
</body>
</html>