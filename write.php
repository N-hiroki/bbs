<!--
画像受け取り
画像の名前生成（パス）
画像をalbumに保存
画像の名前（パス）をdbに保存
画像を送ったら他のタイトルなど文字化け
-->
<?php
    $bbs_id = $_POST['bbs_id'];
    $id = $_POST['id'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    $pass = $_POST['pass'];
    $img = $_POST['img'];
    $color = $_POST['color'];
    $date = date("Y-m-d H:i:s");
    if($id == '' || $body == ''){
        header('Location: bbs.php');
        exit();
    }
    if(!preg_match("/^[0-9]{4}$/", $pass)){
        header('Location: bbs.php');
        exit();
    }
    $dsn = 'mysql:dbname=tennis;host=localhost';
    $user = 'root';
    $password = '';
    try{
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $db->prepare("
            INSERT INTO comment (bbs_id,comment_id,id,title,body,img,pass,date,color)
            VALUES (:bbs_id,null, :id, :title, :body, :img, :pass, :date, :color)"
        );
        $stmt->bindParam(':bbs_id', $bbs_id, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':body', $body, PDO::PARAM_STR);
        $stmt->bindParam(':img', $img, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':color', $color, PDO::PARAM_STR);
        $stmt->execute();
        header("Location: bbs.php?bbs_id=$bbs_id");
        exit();
    }catch(PDOException $e){
        die('エラー:'.$e->getMessage());
    }
?>