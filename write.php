<!--
画像受け取り
画像の名前生成（パス）
画像をalbumに保存
画像の名前（パス）をdbに保存
画像を送ったら他のタイトルなど文字化け
-->
<?php
    $name = $_POST['name'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    $pass = $_POST['pass'];
    $img = $_POST['img'];
    if($name == '' || $body == ''){
        header('Location: index.php');
        exit();
    }
    if(!preg_match("/^[0-9]{4}$/", $pass)){
        header('Location: index.php');
        exit();
    }
    $dsn = 'mysql:dbname=tennis;host=localhost';
    $user = 'root';
    $password = '';
    try{
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $db->prepare("
            INSERT INTO bbs (name,title,body,date,pass,img)
            VALUES (:name, :title, :body, now(), :pass, :img)"
        );
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':body', $body, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->bindParam(':img', $img, PDO::PARAM_STR);
        $stmt->execute();
        header('Location: index.php');
        exit();
    }catch(PDOException $e){
        die('エラー:'.$e->getMessage());
    }
?>