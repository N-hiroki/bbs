<?php
    //アップロード処理
    $bbs_id = $_POST['bbs_id'];
    if(isset($_FILES['img']) && is_uploaded_file($_FILES['img']['tmp_name'])){
        $old_name = $_FILES['img']['tmp_name'];
        $new_name = date("YmdHis");
        $new_name .= mt_rand();
        switch(exif_imagetype($_FILES['img']['tmp_name'])){
            case IMAGETYPE_JPEG:
                $new_name .= '.jpg';
                break;
            case IMAGETYPE_GIF:
                $new_name .= '.gif';
                break;
            case IMAGETYPE_PNG:
                $new_name .= 'png';
                break;
            default:
                header('Location: index.php');
                exit();
        }
        if(move_uploaded_file($old_name, 'album/'.$new_name)){
            $new_name = 'album/'.$new_name;
            header("Location: bbs.php?img=$new_name&bbs_id=$bbs_id");
            exit();
        }else{
            header('Location: bbs.php');
            exit();
        }
    }
?>
