<?php
namespace App\Controller;

class IndexController extends \App\Controller
{
  public function run() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      return $this->post();
    }
  }

  public function post() {
    // サーバー側でのバリデーション
    $this->_tokenValidate();
    $error = $this->_postValidate();

    if ($error) {
      return ['err' => $error, 'old' => $_POST];
    } else {
      $register = new \App\Model\Register();
      $register->create($_POST);
  
      unset($_SESSION['token']);
  
      header('Location:' . SITE_URL . '/conclude.php');
    }
  }

  private function _tokenValidate() {
    if (!isset($_SESSION['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo '※このフォームは有効でありません';
      exit;
    } else {
      return;
    }
  }

  public function expand($array) {
    $html = '';
    foreach($array as $item) {
      $html .= '<label class="error">' . $item . '</label>';
    }
    echo $html;
  }

  public function old($array, $key) {
    if (isset($array[$key])) {
      return $array[$key];
    } else {
      return '';
    }
  }

  private function _postValidate() {
    $error = [];
    // 姓
    if (empty($_POST['sei'])) {
      $error['sei'][] = '必須項目です (from PHP)';      
    } else {
      if (mb_strlen($_POST['sei'], 'UTF-8') > 16) {
        $error['sei'][] = '16文字以内で入力下さい (from PHP)';      
      }
    }
    // 名
    if (empty($_POST['mei'])) {
      $error['mei'][] = '必須項目です (from PHP)';      
    } else {
      if (mb_strlen($_POST['mei'], 'UTF-8') > 16) {
        $error['mei'][] = '16文字以内で入力下さい (from PHP)';      
      }
    }
    // 性別
    if (!isset($_POST['sex'])) {
      $error['sex'][] = '必須項目です (from PHP)';      
    }
    // 誕生日
    if (empty($_POST['year']) || empty($_POST['month']) || empty($_POST['date'])) {
      $error['birthday'][] = '年月日を全て入力下さい (from PHP)';      
    } else {

      if (!checkdate(intval($_POST['month']),intval($_POST['date']),intval($_POST['year']))) {
        $error['birthday'][] = '有効な日付を入力下さい (from PHP)'; 
      }
      
      $target = new \DateTime($_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['date']);
      $now = new \DateTime('now');
      if ($target > $now) {
        $error['birthday'][] = '過去の日付を選択下さい (from PHP)'; 
      }
    }
    // 運転免許証
    if (!isset($_POST['car_license'])) {
      $error['car_license'][] = '必須項目です (from PHP)';      
    }
    // 電話番号
    if (empty($_POST['tel'])) {
      $error['tel'][] = '必須項目です (from PHP)';      
    } else {
      if (preg_match('/^[0]\d{9,10}$/', $_POST['tel']) !== 1) {
        $error['tel'][] = '0から始まる10桁 (固定電話)または11桁 (携帯電話)を半角数字を入力下さい (from PHP)';      
      }
    }
    // メールアドレス
    if (empty($_POST['mail_address'])) {
      $error['mail_address'][] = '必須項目です (from PHP)';      
    } else {

      if (!filter_var($_POST['mail_address'], FILTER_VALIDATE_EMAIL)) {
        $error['mail_address'][] = '有効なメールアドレスを入力下さい (from PHP)';      
      }
    }
    // 都道府県
    if (empty($_POST['pref'])) {
      $error['pref'][] = '必須項目です (from PHP)';      
    }
    // 都道府県以降
    if (empty($_POST['address'])) {
      $error['address'][] = '必須項目です (from PHP)';      
    } else {

      if (mb_strlen($_POST['address'], 'UTF-8') > 255) {
        $error['address'][] = '255文字以内で入力下さい (from PHP)';      
      }
    }
    // メッセージ
    if (mb_strlen($_POST['message'], 'UTF-8') > 1000) {
      $error['message'][] = '1000文字以内で入力下さい (from PHP)';      
    }
    return $error;
  }
}