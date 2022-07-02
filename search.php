<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('Location: ./login.php?notLogin');
        exit;
    }
    if(empty($_GET['search'])){
        header('Location: ./list.php?emptyError');
    }


    // 검색 기준 2개와 검색어 가져온 후 쿼리문에 삽입할 수 있는 형태로 변환
    // $type = "'%{$_GET['type']}%'";
    // $standard = $_GET['standard'];
    // $search = "'%{$_GET['search']}%'";

    $type = $_GET['type'];
    $standard = $_GET['standard'];
    $search = $_GET['search'];



    // 데이터베이스 연결
    require 'dbconfig.php';
    $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

    try{
        $pdo = new PDO($dsn, $user, $password);
        
        
    }catch(PDOException $e){
        echo $e -> getMessage();
    }

    // 검색 기준에 따른 쿼리문 작성
    // if($_GET['type'] === "모든"){
    //     $query = "SELECT * FROM list WHERE $standard LIKE $search";
    //     if($_GET['standard'] === "all"){
    //         $query = "SELECT * FROM list WHERE title LIKE $search OR content LIKE $search";
    //     }
    // }else{
    //     $query = "SELECT * FROM list WHERE type LIKE $type AND $standard LIKE $search";
    //     if($_GET['standard'] === "all"){
    //         $query = "SELECT * FROM list WHERE type LIKE $type AND (title LIKE $search OR content LIKE $search)";
    //     }
    // }


    // PDO의 SQL injection 자동 방어를 위해 파라미터를 바인드 해주도록 쿼리문을 수정함
    // 기존의 쿼리문은 바인딩하는 과정 없이 사용자의 입력을 그대로 실행해서 sql injection의 위협이 있음.

    if($_GET['type'] === "모든"){
        if($_GET['standard'] === "title"){
            $query = "SELECT * FROM list WHERE title LIKE ?";
            $params = array("%$search%");
        }
        else if($_GET['standard'] === "all"){
            $query = "SELECT * FROM list WHERE title LIKE ? OR content LIKE ?";
            $params = array("%$search%", "%$search%");       
        }
        else if($_GET['standard'] === "content"){
            $query = "SELECT * FROM list WHERE content LIKE ?";
            $params = array("%$search%");
        }
    }else{
        if($_GET['standard'] === 'title'){
            $query = "SELECT * FROM list WHERE type LIKE ? AND title LIKE ?";
            $params = array("%$type%", "%$search%"); 
        }
        else if($_GET['standard'] === "all"){
            $query = "SELECT * FROM list WHERE type LIKE ? AND (title LIKE ? OR content LIKE ?)";
            $params = array("%$type%", "%$search%", "%$search%" ); 
        }
        else if($_GET['standard'] === "content"){
            $query = "SELECT * FROM list WHERE type LIKE ? AND (title LIKE ? OR content LIKE ?)";
            $params = array("%$type%", "%$search%", "%$search%" ); 
        }
    }
    

    $statement = $pdo -> prepare($query);
    $statement -> execute($params);


    $list = $statement -> fetchAll();

    
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

        h1{
            margin-top: 0;
            margin-bottom: 20px;
        }

        #welcome{
            font-size: 0.7rem;
        }

        table{
            width: 70%;
            border-spacing: 0 20px;

        }
        th{
            border-bottom: 1px solid black;
            border-top: 1px solid black;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        th, td{
            text-align: center;
        }
        .content{
            cursor: pointer;
        }

        .content:hover{
            text-decoration: underline;
        }
        .logout{
            position: fixed;
            top: 1em;
            right: 1em;
        }
        .goList{
            position: fixed;
            top: 1em;
            right: 7em;
        }

        a{
            text-decoration: none;
            font-size: 0.8rem;
        }
        
    </style>
</head>
<body>
    <div id="flex-container">
        <div id="welcome"><?php echo $_SESSION['id']?>님 환영합니다.</div>
        <h1>검색 결과</h1>
        <a class="logout" href="logout.php">로그 아웃</a>
        <a class="goList" href="./list.php">게시판으로 돌아가기</a>
        <?php 
            echo "<table>
            <tr>
            <th>게시글 번호</th>
            <th>제목</th>
            <th>작성자</th>
            <th>게시글 유형</th>
            <th>생성 및 수정 날짜</th>
            </tr>";

            // 글 목록 데이터베이스에 있는 글 정보 하나씩 가져와서 화면에 띄우기
            foreach($list as $article){            
                echo "<tr class=\"content\" onClick=\"location.href='./article.php?idx={$article['idx']}'\">
                <td>{$article['idx']}</td>
                <td>{$article['title']}</td>
                <td>{$article['writer']}</td>
                <td>{$article['type']}</td>
                <td>{$article['date']}</td>
                </tr>";
            }
            echo "</table>";
        ?>
    </div>
</body>