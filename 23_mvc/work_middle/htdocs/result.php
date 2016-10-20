<?php

/*************************************************************

▼処理の流れ

**************************************************************/

/*

* バリデーション（DB接続前）
↓
* バリデーション（DB接続後）
↓
* 商品名/ 画像を取得（SELECTクエリの実行）
↓
* 在庫数の更新（UPDATEクエリの実行）


*/

/*************************************************************

▼設定ファイル読み込み

**************************************************************/

require_once '../include/conf/const.php';

/*************************************************************

▼Model読み込み

**************************************************************/

require_once '../include/model/function.php'; 

/*************************************************************

▼関数を実行

**************************************************************/

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

  $pro_id = radio_validation('pro_id'); // 商品選択のバリデーション
  $pro_price_submit = num_validation('pro_price_submit'); //投入金額のバリデーション

  if(count($error) === 0){

    $link = get_db_connect(); // DBに接続

    compare_db_status($link,$pro_id); //表示ステータスを確認

    $pro_num = compare_db_stock($link,$pro_id); // 在庫数を確認
    
    $pro_price_result = compare_db_price($link,$pro_id,$pro_price_submit); //投入金を比較

    if(count($error) === 0){

      $pro_name = get_pro_name($link,$pro_id); //商品名を取得

      $pro_image = get_pro_image($link,$pro_id); //画像名を取得

      update_table($link,$pro_id,$pro_num); // UPDATEを実行

    }

  close_db_connect($link); // DBを切断

  }

}

/*************************************************************

▼VIEW読み込み

**************************************************************/

include_once '../include/view/result_view.php';

