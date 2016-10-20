<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CodeCamp_index</title>
  
  <style type="text/css">

  /* http://meyerweb.com/eric/tools/css/reset/  v2.0 | 20110126 License: none (public domain) */  html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed,  figure, figcaption, footer, header, hgroup,  menu, nav, output, ruby, section, summary, time, mark, audio, video { margin: 0; padding: 0; border: 0; font-size: 100%; font: inherit; vertical-align: baseline; } /* HTML5 display-role reset for older browsers  */ article, aside, details, figcaption, figure,  footer, header, hgroup, menu, nav, section { display: block; } body { line-height: 1; } ol, ul { list-style: none; } blockquote, q { quotes: none; } blockquote:before, blockquote:after, q:before, q:after { content: ''; content: none; } table { border-collapse: collapse; border-spacing: 0; }
    

    .header {
      
      width:100%;
      height : 68px;
      border-bottom :2px solid #0f2950;
      position: fixed;
      margin-top: -120px;
      z-index: 1;
      background: rgba(255,255,255,0.8);
    }
    
    .title {
      color: #0f2950;
      font-weight: bold;
      font-size: 20px;
      line-height: 68px;
      padding-left:20px;
      float: left;

    }

    .main_section  {
      margin-top: 120px;
    }
    
    .parents_contents_wrapper {
        margin: 0 auto;
        width: 1020px;
    }

    .clearfix:after {
      content: "";
      clear: both;
      display: block;
    }

    .contents_wrapper {
      width: 240px;
      height: 260px;
      border:1px solid #ccc;
      margin-bottom: 16px;
      margin-left: 12px;
      float: left;
    }

    .pro_text {
      text-align: center;
      font-size: 12px;
      line-height: 1.5;
      color: #0f2950;
    }

    .pro_text_none {
      color: red;
    }
    
    .image,img {  
      min-width: 160px;
      margin-bottom:24px;
      height: 160px;
      text-align: center;
    }

    img {
      margin: 0 auto;
      margin-top:12px;
    }

    .footer {

      width: 100%;
      height: 60px;
      background: #0f2950;

    }

    .footer_text {
      color: #fff;
      line-height: 60px;

    }

    .parents_submit {
      float: right;
      margin-right: 120px;

    }

    .submit {
      width: 150px;
      height: 46px;
      background-color: #04a9f4;
      color :#0f2950;
      font-weight: bold;
      font-size: 20px;
      border: 1px solid #ccc;
      margin-top: 10px;
    }

    .parents_pro_price_submit {
       float: right;
       margin-right: 40px;
       line-height: 68px;
       color: #0f2950;
       font-weight: bold;
       font-size: 20px;
    }

    .pro_price_submit {
      width: 148px;
      height: 42px;
      border : 1px solid #ccc;
      font-size: 24px;
      text-align: right;
    }


  </style>

</head>
<body>
  
  <form action="result.php" method="post">

  <header>

    <div class= "header">

      <nav>
      <div class="nav clearfix">

        <h1 class="title">自動販売機</h1>

        <div class="parents_submit">

          <input type="submit" value="購入" class="submit">

        </div>

        <p class="parents_pro_price_submit">投入金額 <input type="text" name="pro_price_submit" class="pro_price_submit"></p>

      </div>
      </nav>

    </div>
    </header>
  
    <section>
    <div class="main_section">

      <div class="parents_contents_wrapper clearfix">

        <?php foreach ($data as $data_text) { ?>

          <?php if($data_text['pro_status']){ ?>

          <div class="contents_wrapper">

            <p class="image"><img src="./image/<?php echo $data_text["pro_image"] ?>"/></p>

            <div class="pro_text_wrapper">

              <p class="pro_text pro_name">

                <?php echo sanitize(($data_text["pro_name"])) ?>

              </p>

              <p class="pro_text pro_price">

                <?php echo sanitize(($data_text["pro_price"])) ?>円

              </p>

              <?php if($data_text['pro_num']){ ?>

              <p class="pro_text pro_price">

                <input type="radio" name="pro_id" value="<?php echo sanitize(($data_text["pro_id"])) ?>">

              </p>

              <?php } else {?>

              <p class="pro_text pro_price pro_text_none">売り切れです</p>

              <?php } ?>

            </div>

          </div>

          <?php } ?>

        <?php } ?>

      </div>

    </div>
    </section>

  </form>

  <footer>
  <div class="footer">
    <p class="pro_text footer_text"><span>Copyright ©</span>TK Co., Ltd. All rights reserved.</p>
  </div>
  </footer>

  
</body>
</html>