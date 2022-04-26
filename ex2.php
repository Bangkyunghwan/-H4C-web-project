<?php
    if(empty($_FILES['image']['name'])){
        echo '업로드된 파일이 없습니다.';
        exit;
    }

    var_dump($_FILES);

    $name = basename($_FILES['image']['name']);

    $fileArray = explode('.', $name);
    $ext = end($fileArray);
    $newFileName = date(time()). '.'.$ext;


    $imageExt = ['png', 'jpg', 'jpeg', 'gif', 'PNG', "JPG", 'JPEG', 'GIF'];

    $uploadDir = "C:\Bitnami\wampstack-8.1.4-0\apache2\htdocs\board\upload\\";
    $uploadFile = $uploadDir . $newFileName;
     
    if(!in_array($ext, $imageExt)){
        echo '허용되지 않는 확장자입니다.';
        exit;
    }


    if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)){
        echo '파일이 유효하고, 성공적으로 업로드 되었습니다.';
    } else {
        echo '파일 업로드 공격의 가능성이 있습니다!';
    }

    // var_dump($_FILES['image']['name']);
    // var_dump($uploadFile);
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
    <img src="./upload/<?php echo $newFileName?>" />

</body>
</html>