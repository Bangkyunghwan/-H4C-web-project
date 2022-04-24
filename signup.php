<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        input[placeholder]{
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
      if(isset($_GET['sameIdError'])){
    ?>
        <script>
            alert('이미 사용중인 아이디 입니다.')
        </script>
    <?php
      }
    ?>
    <?php  
      if(isset($_GET['invalidInput'])){
    ?>
        <script>
            alert('잘못된 입력입니다. 아이디와 비밀번호의 입력 형식을 확인해주세요.')
        </script>
    <?php
      }
    ?>
    <h2>회원가입 페이지</h2>
    <form action="signupprocess.php" method="POST">
        <label>
            사용할 아이디: <input type="text" name="id" placeholder="아이디는 6~12자의 영문과 숫자만 사용 가능합니다."><br>
        </label>
        <label>
            사용할 비밀번호: <input type="password" name="password" placeholder="비밀번호는 8~14자의 영문과 숫자만 사용 가능합니다."><br> 
        </label>
        <label>
            이메일: <input type="email" name="email" placeholder="example@email.com"><br>
        </label>
        <input type="submit" value="등록">
    </form>
    <a href="./login.php">로그인 페이지로 이동</a>
</body>
</html>