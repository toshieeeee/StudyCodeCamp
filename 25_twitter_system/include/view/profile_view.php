<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>

  <link rel="stylesheet" type="text/css" href="./css/reset.css">
  <link rel="stylesheet" type="text/css" href="./css/home.css">
  
</head>

<body>

<?php if(count($error) > 0){ ?>

  <?php foreach ($error as $error_text) { ?>

    <?php echo $error_text ?>

  <?php } ?>

<?php } else { ?>

  <header>
  <div class="header">

  <a href="./"><h1 class="h_text">Twitter</h1></a>

  <a href="profile.php">

    <img class="h_profile_btn" src=./image/<?php echo sanitize($user_image) ?>
    
  </a>

  <form action="logout.php" method="post" name="edit_profile">

      <input type="submit" value="ログアウト" class="h-logout_btn">

  </form>

  </div>
  </header>

  <div class="header_profile_image"></div>

  <ul class="header_profile_list_wrapper">

    <div class="header_profile_list_box">

      <li class="header_profile_list">ツイート <p class="header_profile_list_num"><?php echo sanitize($my_tweet_num) ?></p>
      </li>

      <li class="header_profile_list">

        <a href="follow.php">
          フォロー <p class="header_profile_list_num"><?php echo sanitize($follow_user_num) ?></p>
        </a>

      </li>

      <li class="header_profile_list">

        <a href="follower.php">
        フォロワー <p class="header_profile_list_num"><?php echo sanitize($follower_user_num) ?></p>
        </a>

      </li>

    </div>

    <a href="profile_edit.php"><li class="header_profile_edit_btn">プロフィールを編集</li></a>

  </ul>

  

  <section>

  <div class="section_whole_contents_wrapper_profile_page">

    <div class="section_profile_wrapper_profile_page">

      <a href="./profile.php"><div class="section_profile_image_profile_page">
        <img class="section_profile_image_tag" src=./image/<?php echo sanitize($user_image) ?>>
      </div></a>

      <p class="user_name_profile_page"><?php echo $user_name ?></p>

      <p class="user_profile_text_profile_page"><?php echo sanitize($user_profile_text) ?></p>

      <p class="user_place_profile_page"><?php echo sanitize($user_place) ?></p>

    </div>

    <div class="section_tweet_wrapper">


    <?php foreach ($data as $data_text) { ?>

      <div class="tweet_str_parents_wrapper">

    
        <div class="tweet_str_wrapper">

          <?php if($data_text["retweet_id"]){ ?>

          <p class="retweet_user"><img src="./image/retweet_btn.png" class="retweet_str_img"><?php echo $user_name ?>さんがリツイート</p>

          <?php } ?>    
      
          <a href="profile_other.php?user_id=<?php echo sanitize(($data_text["user_id"])) ?>">

            <img class="tweet_user_image" src=./image/<?php echo sanitize(($data_text["user_image"])) ?>>

          </a>

        <div class="tweet_str_inner_wrapper"> 

            <p class="tweet_user"><?php echo sanitize(($data_text["user_name"])) ?></p>
            <p class="tweet_str"><?php echo sanitize(($data_text["user_tweet_str"])) ?></p>

          </div>

        </div>

        <div class="delete_tweet tweet_str_action_wrapper tweet_action_id_<?php echo sanitize(($data_text["tweet_id"])) ?>"> 

          <?php if(!$data_text["retweet_id"]){ ?>

            <img class="garbage_btn delete_id_<?php echo sanitize(($data_text["tweet_id"])) ?>" src="./image/garbage_btn.png">

          <?php } ?>

        </div>


        <!--*****返信機能 [display : none] *****-->

          <div class="delete_tweet_str_wapper delete_tweet_str_wapper_<?php echo sanitize(($data_text["tweet_id"])) ?>">

            <form action="profile.php" method="post" name="delete_tweet">

            <input type ="hidden" name= "delete_id" value="<?php echo sanitize(($data_text["tweet_id"])) ?>">

              <input type="submit" value="削除する" class="tweet_btn delete_btn" name="delete_tweet">

            </form>

          </div>


      </div>

    <?php } ?>

      
    </div>

  </div>
  </section>

<?php } ?>

<script type="text/javascript" src="./js/jquery-3.1.1.min.js"></script>


<script type="text/javascript">

/***********************************
* 削除するフォームを表示
************************************/

$('.delete_tweet').click(function(){

  // クリックしたボタンのユニークなIDを取得

  $delete_id = ($(this).attr('class'));


  // クラス名をスライス
  
  $delete_id = $delete_id.slice(38);

  // 隠れているフォームの要素を取得

  $delete_str_wapper = $('.'+ $delete_id).next().attr('class'); //兄弟要素の兄弟要素を取得
  
  // クラス名をスライス

  $delete_str_wapper = $delete_str_wapper.slice(24);

  $('.' + $delete_str_wapper).fadeIn().css('display','block'); // リツイートブロックを表示

  });





</script>

</body>
</html>