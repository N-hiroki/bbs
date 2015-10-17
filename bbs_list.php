<?PHP
    $view = "";
    $num = 20;  //１ページに表示するtitle数
    $dsn = 'mysql:dbname=tennis;host=localhost';
    $user = 'root';
    $password = '';
    //ページ数が指定されているとき
    $page = 0;
    try{
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $db->prepare("SELECT * FROM bbs ORDER BY date DESC LIMIT :page, :num");
        $page *= $num;
        $stmt->bindParam(':page',$page,PDO::PARAM_INT);
        $stmt->bindParam(':num',$num,PDO::PARAM_INT);
        $flag = $stmt->execute();
        if($flag == false){
            $view = "SQLエラー";
        }else{
            while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
        //新規質問
            $view .= '<a href="bbs.php?        bbs_id='.$result['bbs_id'].'"method="get"action="bbs.php">'.$result['bbs_title'].'/作成者:'.$result['user'].'</a><br>';
            }
        }
    }catch(PDOException $e){
        echo "エラー:".$e->getMessage();
    }
?>