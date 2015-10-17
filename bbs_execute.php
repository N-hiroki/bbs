<!--
index.phpからデータを受け取る
bbsテーブルに保存
bbs_list.phpに移動
session　使ってid取得
-->
<?php
    $title = htmlspecialchars($_POST["title"]);
    $date = $date = date("Y-m-d H:i:s");
    $id = "ZEROFROM";
    $dsn = 'mysql:dbname=tennis;host=localhost';
    $user = 'root';
    $password = '';
    try{
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $db->prepare("
            INSERT INTO bbs (bbs_id,bbs_title,date,user)
            VALUES (null, :title, :date,:id)"
        );
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        header('Location: bbs_list.php');
        exit();
    }catch(PDOException $e){
        die('エラー:'.$e->getMessage());
    }
?>