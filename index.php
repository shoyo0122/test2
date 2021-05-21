<?php
define('FILENAME', './message.txt');

date_default_timezone_set('Asia/Tokyo');

$now_date = null;
$data = null;
$file_handle = null;
$split_data = null;
$comment = array();
$comment_array = array();

if( !empty($_POST['btn_submit']) ) {
    
    if($file_handle = fopen( FILENAME, "a") ) {
        $now_date = date("Y-m-d H:i:s");
        $data = 
        "'".$_POST['view_name']."','".$_POST['comment']."','".$now_date."'\n";
        fwrite( $file_handle, $data);
        fclose( $file_handle);
    }
}

if( $file_handle = fopen( FILENAME,'r') ) {
    while( $data = fgets($file_handle) ){

        $split_data = preg_split( '/\'/', $data);

        $comment = array(
            'view_name' => $split_data[1],
            'comment' => $split_data[3],
            'post_date' => $split_data[5]
        );
        array_unshift( $comment_array, $comment);
    }
    fclose( $file_handle);
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="responsive.css">
    <title>Document</title>
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>読書会</h1>
        </header>

        <div class="container">
            <div class="main">
                <h1>掲示板</h1>
                <form action="index.php" method="POST">
                <label for="view_name">名前</label>
                <br>
                <input id="view_name" type="text" name="view_name">
                <br>
                <label for="comment">コメント</label>
                <br>
                <textarea name="comment" id="comment" ></textarea>
                <br>
                <div class="btn">
                    <input type="submit" name="btn_submit" value="書き込む">
                </div>
                </form>
                <section>
                <?php if( !empty($comment_array) ): ?>
                <?php foreach( $comment_array as $value ): ?>
                <article>
                    <div class="info">
                        <h3><?php echo $value['view_name']; ?></h3>
                        <time><?php echo date('Y年m月d日 H:i',
                        strtotime($value['post_date'])); ?></time>
                    </div>
                    <p><?php echo $value['comment']; ?></p>
                </article>
                <?php endforeach; ?>
                <?php endif; ?>
                </section>
            </div>
            <div class="side">
                <h1>掲示板一覧</h1>
            </div>
        </div>

        <footer>footer</footer>
    </div>
</body>
</html>