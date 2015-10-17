<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8">
        <title>掲示板</title>
        <link rel="stylesheet" href="main.css">
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <div style="float:left">
            <h1>掲示板</h1>
            <form action="bbs_execute.php" method="post">
                <input type="text" name="title">
                <input type="submit" value="作成">
            </form>
            <?php require("bbs_list.php") ?>
            <h2>掲示板リスト</h2>
            <?=$view?>
        </div>
    </body>
</html>