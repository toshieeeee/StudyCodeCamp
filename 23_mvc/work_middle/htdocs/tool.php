<?php 

/*************************************************************

▼設定ファイル読み込み

**************************************************************/

require_once '../include/conf/const.php';

/*************************************************************

▼Model読み込み

**************************************************************/

require_once '../include/model/tool_function.php'; 

/*************************************************************

▼変数の定義

**************************************************************/

$error = array();
$list = '';

/*************************************************************

▼関数を実行

**************************************************************/

$link = get_db_connect();
$record = get_goods_table_list($link); // 結果セットを配列で取得

  
/*************************************************************
▼商品のINSERT
**************************************************************/

if(isset($_POST['pro_add']) === TRUE){ //商品を追加する場合の処理

  /*************************************************************
  ▼バリデーション
  **************************************************************/

  $pro_name = str_validation('pro_name'); // 商品名
  $pro_price = num_validation('pro_price'); //価格
  $pro_num = num_validation('pro_num'); // 個数
  $pro_image = upload_image('pro_image'); // 画像
  $pro_status = radio_validation('pro_status'); //ステータス

  if(count($error) === 0) {

    //$link->beginTransaction();

    insert_pro_info_table($link,$pro_name,$pro_price,$pro_image,$pro_status); 
    insert_pro_num_table($link,$pro_num);

    header('Location: http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); 

  }

} //END - $_POST['pro_add']

/*************************************************************
▼商品のUPDATE
**************************************************************/

if(isset($_POST['pro_update']) === TRUE){ // 在庫数変更機能

  $pro_num = num_validation('pro_num'); // 数値のバリデーション

  if(count($error) === 0) {

    $pro_id = $_POST['pro_id']; // ID取得

    update_pro_num_table($link,$pro_id,$pro_num); // UPDATE実行

    header('Location: http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); 

  }

}

/*************************************************************
▼表示ステータスのUPDATE
**************************************************************/

if(isset($_POST['pro_status']) === TRUE){ 

  $pro_id = $_POST['pro_id']; // ID取得
  $pro_status = $_POST['pro_status']; //ステータスの取得

  update_pro_status_table($link,$pro_id,$pro_status);

  header('Location: http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); 

}


/*************************************************************

▼VIEW読み込み

**************************************************************/

include_once '../include/view/tool_view.php';
