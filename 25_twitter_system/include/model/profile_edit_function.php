<?php

/*************************************************************

▼ 関数を定義

**************************************************************/


/*************************************************************
▼ バリデーション関連
**************************************************************/


/***********************************
* 文字列のバリデーション（パスワード含む）
*
* @param str name属性
* @return 成功 : 入力データ 失敗 : $error_textに、入力した文字列を格納したデータ
************************************/

function str_validation($str){

  global $error_text;

  $temp = $str; // 属性名を受け取る
  $str = $_POST[$str]; //属性の値を受け取る
  $attr = $temp;

  if(isset($str) !== TRUE || mb_strlen($str) === 0){

    $error_text[$attr] = $attr.'を入力してください';

  } else if(mb_strlen($str) > 20){

    $error_text[$attr] = $attr.'は20文字以内で入力してください';

  } else if(preg_match ('/^\s*$|^　*$/',$str)){

    $error_text[$attr] = $attr.'は半角、または全角スペースだけでは登録できません';

  } else {

    return $str;

  }

}

function str_long_validation($str){

  global $error_text;

  $temp = $str; // 属性名を受け取る
  $str = $_POST[$str]; //属性の値を受け取る
  $attr = $temp;

  if(isset($str) !== TRUE || mb_strlen($str) === 0){

    $error_text[$attr] = $attr.'を入力してください';

  } else if(mb_strlen($str) > 150){

    $error_text[$attr] = $attr.'は150文字以内で入力してください';

  } else if(preg_match ('/^\s*$|^　*$/',$str)){

    $error_text[$attr] = $attr.'は半角、または全角スペースだけでは登録できません';

  } else {

    return $str;

  }

}


/***********************************
* すべてのユーザー名/ユーザーIDを取得する
* @param DBハンドラ,ユーザーから受け取るID,ユーザーから受け取る整数 
* @return ユーザーID / エラー文章
************************************/

// 取得レコードのリミットを指定
// 自分以外のIDを取得

function get_user_id_name_list($link,$user_id) {

  $sql = 'SELECT user_id,user_name FROM user_table WHERE user_id != '.$user_id.' ORDER BY RAND() LIMIT 3';
  
  return get_as_array($link, $sql); //SQL実行 

}

/***********************************
* ユーザー名を取得する関数

* @param DBハンドラ,ユーザーから受け取るID,ユーザーから受け取る整数 
* @return ユーザー名 / エラー文章
************************************/

function get_user_name($link,$mail,$passwd){ //$link = PDOオブジェクト

  global $error_text;

  $sql = 'SELECT user_name FROM login_table WHERE user_address = "' .$mail. '" AND user_pass = "'.$passwd .'"';

  $data = $link->query($sql);

  $data = $data->fetch(PDO::FETCH_ASSOC); 

  if(!$data){ // ユーザーIDが返ってきたら処理を実行

    $error_text[] = 'メールアドレス、またはパスワードが一致しません';

  } else {

    $user_name = $data['user_name'];

    return $user_name;

  }  

}

/***********************************
* SQLの定義 / get_as_arrayを実行
*
* @param obj $link DBハンドル
* @return つぶやき一覧、連想配列データ
************************************/

function get_user_tweet_list($link) {
  
  $sql = 'SELECT tweet_table.user_id,user_table.user_name,tweet_table.user_tweet_str,tweet_table.user_tweet_time FROM tweet_table JOIN user_table ON tweet_table.user_id = user_table.user_id'; // SQL生成

  return get_as_array($link, $sql); //SQL実行 

}

/***********************************
* UPDATEの実行 
*
* @param0 - DBハンドラ
* @param1 - ユーザーID
*
* @return TRUE / FALSE
***********************************/
/*画像あり
function update_profile_table($link,$user_id,$param1,$param2,$param3,$param4){

  try{


    $sql_info = 'UPDATE user_table SET user_name,user_profile_text,user_image,user_place,user_update_date = (?,?,?,?,?) WHERE user_id = '.$user_id; 

    var_dump($sql_info);

    $stmt = $link->prepare($sql_info); 

    $data[] = $param1; // name
    $data[] = $param2; // profile_text
    $data[] = $param3; // profile_image
    $data[] = $param4; // profile_place
    $data[] = date('Y-m-d H:i:s');
  
    if(!$stmt->execute($data)){ // SQLの判定 / 実行

      throw new QueryException();

    }

  } catch (QueryException $e){

    echo 'Fatal Error : '.$e->getMessage().'<br>';
    echo $e->getFile().'<br>';
    echo $e->getLine().'<br>';

  }
  
}
*/

//画像なし

function update_profile_table($link,$user_id,$param1,$param2,$param3,$param4){

  try{


    //$sql_info = 'UPDATE user_table SET (user_name,user_profile_text,user_place,user_update_date) = (?,?,?,?) WHERE user_id = '.$user_id; 

    //$sql_info = 'UPDATE user_table SET user_name=?,user_profile_text=?,user_place=?,user_update_date=? WHERE user_id = '.$user_id; 

    $sql_info = 'UPDATE user_table SET user_name=?,user_profile_text=?,user_image=?,user_place=?,user_update_date=? WHERE user_id = '.$user_id; 

    $stmt = $link->prepare($sql_info); 

    $data[] = $param1; // name
    $data[] = $param2; // profile_text
    $data[] = $param3; // profile_image
    $data[] = $param4; // profile_place
    $data[] = date('Y-m-d H:i:s');
    
    if(!$stmt->execute($data)){ // SQLの判定 / 実行

      throw new QueryException();

    }

  } catch (QueryException $e){

    echo 'Fatal Error : '.$e->getMessage().'<br>';
    echo $e->getFile().'<br>';
    echo $e->getLine().'<br>';

  }
  
}



/***********************************
* 画像の取得 + バリデーション
*
* @param str name属性
* @return 成功 : 画像名を返す？
************************************/

function upload_image($image){

  global $error_text;

  $img_dir = './image/';

  if (is_uploaded_file($_FILES[$image]['tmp_name']) === TRUE) {

    $pro_image = $_FILES[$image]['name']; 
    
    $extension = pathinfo($pro_image, PATHINFO_EXTENSION); // 拡張子チェック

    if ($extension === 'jpg' || $extension === 'jpeg' || $extension === 'JPG' || $extension === 'png') {  

      $pro_image = md5(uniqid(mt_rand(), true)) . '.' . $extension; 
    
        if (is_file($img_dir . $pro_image) !== TRUE) { 

          if (move_uploaded_file($_FILES[$image]['tmp_name'], $img_dir . $pro_image) !== TRUE) {

              $error_text[] = 'ファイルアップロードに失敗しました';

          } 
          
        } else {  

          $error_text[] = 'ファイルアップロードに失敗しました。再度お試しください。';
        }

      } else { 

        $error_text[] = 'ファイル形式が異なります。画像ファイルはJPEG又はPNGのみ利用可能です。';

      }     

  } else {

    $error_text[] = 'ファイルを選択してください';

  }

  if(isset($pro_image)){

    return $pro_image;

  }

}

