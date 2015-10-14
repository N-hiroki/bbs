<?php
    //データ受け取り
    $id = intval($_POST['id']);
    $pass = $_POST['pass'];
    //チェック
    if($id == '' || $pass == ''){
        header('Location: index.php');
        exit();
    }
    $dsn = 'mysql:dbname=tennis;host=localhost';
    $user = 'root';   //ユーザー設定してないからエラーになるかも  rootにすれば大丈夫かも
    $password = ''; //tennissuserに設定したpass
    try{
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $db->prepare("DELETE FROM bbs WHERE id=:id AND pass=:pass");
        //パラメータの割り当て
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        //実行
        $stmt->execute();
    }catch(PDOException $e){
        echo "エラー:".$e->getMessage();
    }
    header("Location: index.php");
    exit();
?>