<?php
    $num = 10;  //１ページに表示するコメント数
    $id = "";
    $img = "";
    if(isset($_GET["bbs_id"])){
        $bbs_id = htmlspecialchars($_GET["bbs_id"]);
    }
    $dsn = 'mysql:dbname=tennis;host=localhost';
    $user = 'root';
    $password = '';
    //ページ数が指定されているとき
    $page = 0;
    if(isset($_GET['img'])){
        $img = $_GET['img'];
    }
    if(isset($_GET['page']) && $_GET['page'] > 0){
        $page = intval($_GET['page']) - 1;
    }
    try{
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $db->prepare("SELECT * FROM comment WHERE bbs_id = :bbs_id ORDER BY date DESC LIMIT :page, :num");
        $stmt_title = $db->prepare("SELECT * FROM bbs WHERE bbs_id = :bbs_id");
        $stmt_title->bindParam(':bbs_id',$bbs_id,PDO::PARAM_INT);
        $stmt_title->execute();
        $row_title = $stmt_title->fetch();
        $bbs_title = '<h1>'.$row_title["bbs_title"].'</h1>';
        $page *= $num;
        $stmt->bindParam(':bbs_id',$bbs_id,PDO::PARAM_INT);
        $stmt->bindParam(':page',$page,PDO::PARAM_INT);
        $stmt->bindParam(':num',$num,PDO::PARAM_INT);
        $stmt->execute();
        
    }catch(PDOException $e){
        echo "エラー:".$e->getMessage();
    }
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8">
        <title>掲示板</title>
        <link rel="stylesheet" href="main.css">
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <script src="jscolor/jscolor.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <h1><?=$bbs_title?></h1>
        <form action="write.php" method="post">
            <p>名前:<input type="text" name="id" value="<?=$id?>"></p>
            <p>タイトル:<input type="text" name="title"></p>
            <textarea name="body"></textarea>
            <p>削除パスワード（数字４桁）:<input type="text" name="pass"></p>
            <!--        jsカラー-->
            <input class="color" name="color" value="#000000">
            <p><input type="submit" value="書き込む"></p>
            <p>画像アップロード<br><img src="<?=$img?>" width=150px height=100px></p>
            <input type="hidden" name="img" value="<?=$img?>">
            <input type="hidden" name="bbs_id" value="<?=$bbs_id?>">
        </form>
<!--        アップロード-->
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="img">
            <input type="submit" value="アップロード">
            <input type="hidden" name="bbs_id" value="<?=$bbs_id?>">
        </form>
        <a href="index.php">トップ</a>
        <?php
//            掲示板の内容書き出し
//            画像の名前を持ってきてimgタグで表示
            while($row = $stmt->fetch()):
                $title = $row['title'] ? $row['title'] : '（無題）';
        ?>
        <div style="background-color:<?php echo $row['color']; ?>;width:300px;">
            <p>名前:<?php echo $row['id']?></p>
            <p>タイトル:<?php echo $title ?></p>
            <p><?php echo nl2br($row['body'], false) ?></p>
            <img src="<?php echo $row['img']?>" width=150px height=100px>
            <p><?php echo $row['date']?></p>
            <form action="delete.php" method="post">
                <input type="hidden" name="comment_id" value="<?php echo $row['comment_id']; ?>">
                削除パスワード:<input type="password" name="pass">
                <input type="hidden" name="bbs_id" value="<?=$bbs_id?>">
                <input type="submit" value="削除">
            </form>
        </div>
        <div class="inner"></div>
        <?php endwhile;
            //ページ数表示
            try{
                $stmt = $db->prepare("SELECT COUNT(*) FROM comment WHERE bbs_id = :bbs_id");
                $stmt->bindParam(':bbs_id',$bbs_id,PDO::PARAM_INT);
                $stmt->execute();
            }catch(PDOException $e){
                echo "エラー:".$e->getMessage();
            }
            //コメントの件数を取得
            $comments = $stmt->fetchColumn();
            //ページ数を計算
            $max_page = ceil($comments / $num);
            echo '<p>';
            for($i = 1;$i <= $max_page; $i++){
                echo '<a href="bbs.php?page='.$i.'">'.$i.'</a>&nbsp;';
            }
            echo '</p>';
        ?>
    </body>
</html>