<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        

        #flex-container{
    
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        } 
        
        input[placeholder]{
            width: 450px;
            height: 35px;
            font-size: 0.8rem;
            margin-bottom: 5px;
        }

        [type="submit"]{
            width: 100%;
            height: 35px;
            margin-top: 20px;
            margin-bottom: 15px;
        }

        .info{
            font-size: 0.1rem;
            margin-bottom: 20px;

        }
        

        a{
            text-decoration: none;
            font-size: 0.73rem;
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
    <div id="flex-container">
        <h2>회원가입</h2>
        <form action="signupprocess.php" method="POST">
            
                <input type="text" name="id" placeholder="아이디"><br>
                <div class="info"><i>아이디는 6~12자의 영문과 숫자만 사용 가능합니다.</i></div>
                <input type="password" name="password" placeholder="비밀번호"><br> 
                <div class="info"><i>비밀번호는 8~14자의 영문과 숫자만 사용 가능합니다.</i></div>
               <input type="email" name="email" placeholder="이메일"><br>
            
            <input type="submit" value="가입하기">
        </form>
        <a href="./login.php">로그인 페이지로 이동</a>
    </div>
</body>
</html>