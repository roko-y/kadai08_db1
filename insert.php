<?php
// セッションを開始する
session_start();

//1. POSTデータ取得
$bookname   = $_POST["bookname"];
$bookurl    = $_POST["bookurl"];
$bookcommet = $_POST["bookcomment"];



//2. DB接続します  以下はデータベースのデータを取ってくる関数
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=kadai08_db;charset=utf8;host=localhost','root',''); //rootはxamppのID名、パスワードはなし。　サクラサーバーなら自分のID名、パスワードとなる
 
} catch (PDOException $e) {
  exit('DB_CONECT:'.$e->getMessage()); //exitは処理を止める
}


//３．データ登録SQL作成
$sql = "INSERT INTO gs_bm_table(bookname,bookurl,bookcomment,indate)VALUES(:bookname,:bookurl,:bookcomment,sysdate());";
$stmt = $pdo->prepare($sql);   //SQLをセットする関数
$stmt->bindValue(':bookname',   $bookname,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT) 「->』は中のという意味 bindValuはクリーニングするという意味　STR：文字の形
$stmt->bindValue(':bookurl',  $bookurl , PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':bookcomment', $bookcommet, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();   //SQLの実行　ture or false

//$success_message = 'メッセージを書き込みました。';

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();   //stmtのエラーを感知したら、エラーの配列をみる
  exit("SQL_ERROR:".$error[2]);   //errorの二番名の配列を表記する
}else{
  // 成功メッセージをセッションに保存する
  $_SESSION['success_message'] = 'メッセージを書き込みました。';
  //５．index.phpへリダイレクト
  header("Location: index.php"); //Location: のあとは半角スペースをいれる
  exit();

}
?>
