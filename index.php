<?php
require(__DIR__ . '/phplib/config/config.php');
//インスタンスえお生成することでCSRF対策のトークンを生成する
$app = new App\Controller\IndexController(); 
$values = $app->run();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel='stylesheet' href='css/styles_index.css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src='js/jquery-validation-1.19.2/dist/jquery.validate.js'></script>
  <title>Form Sample by Rafael</title>
</head>
<body>
  <header>
    <p>Form Sample by Rafael.</p>
  </header>

  <div id='container'>
    <form id='main_form' action='' method='POST'>
      <p>お問い合わせフォーム<img src='image/mail.png' alt="an icon"></p>
      <input type='hidden' name='token' id='token' value='<?= h($_SESSION['token']); ?>'>
      
      <div class='field_wrapper'>
        <div>
          <p class='label req'><label for='sei'>1. 姓 (最大16文字)</label></p>
          <p class='input sei'><input name='sei' id='sei' type='text' maxlength='16' value='<?= h($app->old($values['old'], 'sei')); ?>'></p>
          <p class='error_box'><?php if (isset($values['err']['sei'])) {$app->expand($values['err']['sei']); } ?></p>
        </div>
        <div>
          <p class='label req'><label for='mei'>2. 名 (最大16文字)</label></p>
          <p class='input mei'><input name='mei' id='mei' type='text' maxlength='16' value='<?= h($app->old($values['old'], 'mei')); ?>'></p>
          <p class='error_box'><?php if (isset($values['err']['mei'])) {$app->expand($values['err']['mei']); } ?></p>
        </div>
      </div>
      
      <p class='label req'>3. 性別</p>
      <ul class='input sex'>
        <li><input type='radio' name='sex' value='1' id='male' data-label='男性'  <?= $app->old($values['old'], 'sex') == '1' ? 'checked' : ''; ?>><label for='male'>男性</label></li>
        <li><input type='radio' name='sex' value='2' id='female' data-label='女性'  <?= $app->old($values['old'], 'sex') == '2' ? 'checked' : ''; ?>><label for='female'>女性</label></li>
      </ul>
      <p class='error_box'><?php if (isset($values['err']['sex'])) {$app->expand($values['err']['sex']); } ?></p>
      
      <p class='label req'><label for='year'>4. 誕生日</label></p>
      <p class='input birthday'>
        <input type='text' name='birthday' id='birthday' value='<?= h($app->old($values['old'], 'birthday')); ?>'>
        <select name='year' id='year'>
          <option value=''>----</option>
          <?php for ($i = date('Y'); $i >= 1900; $i--): ?>
            <option value='<?= h($i);?>' <?= $i == $app->old($values['old'], 'year') ? 'selected' : ''; ?>><?= h($i);?></option>
          <?php endfor; ?>
        </select>
        <label for='year'>年</label>
        <select name='month' id='month'>
          <option value=''>--</option>
          <?php for ($i = 1; $i < 13; $i ++): ?>
            <option value='<?= h($i);?>' <?= $i == $app->old($values['old'], 'month') ? 'selected' : ''; ?>><?= h($i);?></option>
          <?php endfor; ?>
        </select>
        <label for='month'>月</label>
        <select name='date' id='date'>
          <option value=''>--</option>
          <?php for ($i = 1; $i < 32; $i ++): ?>
            <option value='<?= h($i);?>' <?= $i == $app->old($values['old'], 'date') ? 'selected' : ''; ?>><?= h($i);?></option>
          <?php endfor; ?>
        </select>
        <label for='date'>日</label>
      </p>
      <p class='error_box'><?php if (isset($values['err']['birthday'])) {$app->expand($values['err']['birthday']); } ?></p>
      
      <p class='label req'>5. 運転免許証</p>
      <ul class='input car_license'>
        <li><input type='radio' name='car_license' value='1' id='have_lice' data-label='有' <?= $app->old($values['old'], 'car_license') == '1' ? 'checked' : ''; ?>><label for='have_lice'>有</label></li>
        <li><input type='radio' name='car_license' value='0' id='no_lice' data-label='無'  <?= $app->old($values['old'], 'car_license') == '0' ? 'checked' : ''; ?>><label for='no_lice'>無</label></li>  
      </ul>
      <p class='error_box'><?php if (isset($values['err']['car_license'])) {$app->expand($values['err']['car_license']); } ?></p>
      
      <p class='label req'><label for='tel'>6. 電話番号 (ハイフン' - '不要)</label></p>
      <p class='input tel'><input name='tel' id='tel' type='text' value='<?= h($app->old($values['old'], 'tel')); ?>'></p>
      <p class='error_box'><?php if (isset($values['err']['tel'])) {$app->expand($values['err']['tel']); } ?></p>
      
      <p class='label req'><label for='mail_address'>7. メールアドレス (半角)</label></p>
      <p class='input mail_address'><input name='mail_address' id='mail_address' type='text' placeholder='Max 255文字' value='<?= h($app->old($values['old'], 'mail_address')); ?>'></p>
      <p class='error_box'><?php if (isset($values['err']['mail_address'])) {$app->expand($values['err']['mail_address']); } ?></p>
      
      <p class='label req'><label for='pref'>8. 住所 (都道府県)</label></p>
      <p class='input pref'>
        <select name='pref' id='pref'>
          <option value=''>---</option>
          <?php foreach ($pref_codes as $code => $pref): ?>
            <option class='pref' value='<?= h($code); ?>' <?= $code == $app->old($values['old'], 'pref') ? 'selected' : ''; ?>><?= h($pref); ?></option>
          <?php endforeach; ?>
        </select>
      </p>
      <p class='error_box'><?php if (isset($values['err']['pref'])) {$app->expand($values['err']['pref']); } ?></p>
      
      <p class='label req'><label for='address'>9. 住所 / 都道府県以降 (最大255文字)</label></p>
      <p class='input address'><input name='address' id='address' type='text' maxlength='255' value='<?= h($app->old($values['old'], 'address')); ?>'></p>
      <p class='error_box'><?php if (isset($values['err']['address'])) {$app->expand($values['err']['address']); } ?></p>
      
      <p class='label'><label for='message'>10. メッセージ (最大1000文字)</label></p>
      <p class='input message'><textarea name='message' id='message' maxlength='1000'><?= $app->old($values['old'], 'message'); ?></textarea></p>
      <p class='error_box'><?php if (isset($values['err']['message'])) {$app->expand($values['err']['message']); } ?></p>
      
      <p>
      <!-- ボタンの種類をsubmitにしないとバリデーションのプラグインが有効にならない -->
      <!-- enter押下時のsubmit無効化はJSで、enter入力の無効化にて行う -->
        <button type='submit' class='preview btn'>確認画面へ</button>
        <button type='button' class='return hidden btn'>入力画面へ</button>
      </p>
    </form>
  </div>
  <footer>
    <p>Form Sample by Rafael.</p>
  </footer>
  <script src='js/main.js'></script>
</body>
</html>