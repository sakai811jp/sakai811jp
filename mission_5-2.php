<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-2</title>
</head>
<body>
<?php 
// DB接続設定
	$dsn ="mysql:dbname=database;host=localhost";
	$user ="user";
	$password ="password";
	$pdo = new PDO($dsn, $user, $password, 
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

// テーブルの作成
    $sql_table = "CREATE TABLE IF NOT EXISTS tbtoukou1(
	id INT AUTO_INCREMENT PRIMARY KEY,
	name char(32),
	comment TEXT,
	date DATETIME,
	pass TEXT
	)";
// SQL実行
	$stmt_table = $pdo->query($sql_table);
//データレコードの挿入
    if($_POST["submit"]&&empty($_POST["bangou"])==true){
    $sql_in = $pdo -> prepare("INSERT INTO tbtoukou1 (name, comment,date,pass) 
	                        VALUES (:name,:comment,:date,:pass)");
	$sql_in-> bindParam(':name', $name, PDO::PARAM_STR);
	$sql_in-> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql_in-> bindParam(':date', $date, PDO::PARAM_STR);
    $sql_in-> bindParam(':pass', $pass1, PDO::PARAM_STR);
    $name=$_POST["name"];
    $comment=$_POST["comment"];
    $date = new DateTime();
    $date = $date->format('Y-m-d H:i:s');
    $pass1=$_POST["pass1"];
//prepareを実行
    $sql_in -> execute();}
//データレコードの内容を削除	
	$id =$_POST["del"]; //削除する投稿番号
    $pass2=$_POST["pass2"];
if($_POST["del"]&&$_POST["submit_del"]&&$_POST["pass2"]){	
	$sql_delete = "DELETE FROM tbtoukou1 WHERE id=$id AND pass='$pass2'";
	$stmt_delete = $pdo->query($sql_delete);
//パスワードが違うとき
    $sql_not="SELECT * FROM tbtoukou1 WHERE id=$id";
    $stmt_not = $pdo->query($sql_not);
    $results_not= $stmt_not->fetchAll();
    foreach ($results_not as $row_not){
    $pass_not=$row_not[4];
    if($pass2!=$pass_not){echo "パスワードが違います";}}}
//データレコードの内容を変更
    $reid =$_POST["num_edit"]; //変更する投稿番号
    $pass3=$_POST["pass3"];
if($_POST["num_edit"]&&$_POST["submit_edit"]&&$_POST["pass3"]){
    $sql_edit = "SELECT * FROM tbtoukou1 WHERE id=$reid AND pass='$pass3'";
	$stmt_edit = $pdo->query($sql_edit);
	$results_edit = $stmt_edit->fetchAll();
	foreach ($results_edit as $row_edit){
	$rename = $row_edit["name"];
	$recom = $row_edit["comment"]; //フォームに表示
	}
//パスワードが違うとき
    $sql_not="SELECT * FROM tbtoukou1 WHERE id=$reid";
    $stmt_not = $pdo->query($sql_not);
    $results_not= $stmt_not->fetchAll();
    foreach ($results_not as $row_not){
    $pass_not=$row_not[4];
    if($pass3!=$pass_not){echo "パスワードが違います";}}}
    $reid2=$_POST["bangou"];
if($_POST["submit"]&&empty($_POST["bangou"])==false){
	$sql_edit2= "UPDATE tbtoukou1 SET name=:name,comment=:comment,id=:id,date=:date 
	                                 WHERE id=$reid2";
	$stmt_edit2 = $pdo->prepare($sql_edit2);
	$stmt_edit2->bindParam(":name", $name1, PDO::PARAM_STR);
	$stmt_edit2->bindParam(":comment", $comment1, PDO::PARAM_STR);
	$stmt_edit2->bindParam(":id", $reid2, PDO::PARAM_INT);
	$stmt_edit2-> bindParam(':date', $date1, PDO::PARAM_STR);
	$name1=$_POST["name"];
    $comment1=$_POST["comment"];
	$date1 = new DateTime();
    $date1 = $date1->format('Y-m-d H:i:s');//変更するやつ
	$stmt_edit2->execute();	}
?>
<form action=""method="post">
<input type="text" name="name"value=
"<?php echo $rename ?>"placeholder="名前"><br>
<input type="text" name="comment"value=
"<?php echo $recom ?>"placeholder="コメント"><br>
<input type="text" name="pass1"placeholder="パスワード">
<input type="submit" name="submit"><br>
<input type="hidden" name="bangou"value=
"<?php echo $reid ?>"><br>
<input type="number" name="del"placeholder="削除対象番号">  <br>
<input type="text" name="pass2"placeholder="パスワード">
<input type="submit" name="submit_del" value="削除"><br>
<input type="number" name="num_edit"placeholder="編集対象番号"><br>
<input type="text" name="pass3"placeholder="パスワード">
<input type="submit" name="submit_edit" value="編集"><br>
<?php
// DB接続設定
	$dsn ="mysql:dbname=database;host=localhost";
	$user ="user";
	$password ="password";
	$pdo = new PDO($dsn, $user, $password, 
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
//入力したデータレコードを抽出し、表示  
    $sql_select = "SELECT * FROM tbtoukou1";
	$stmt_select = $pdo->query($sql_select);
	$results = $stmt_select->fetchAll();
	foreach ($results as $row){
//$rowの中にはテーブルのカラム名が入る
		echo $row["id"].",";
		echo $row['name'].",";
		echo $row['comment'].",";
	    echo $row['date']."<br>";
    echo "<hr>";
	}
?>
</body>
</html>