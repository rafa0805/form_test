<?php

header('Content-Type: application/force-download');
header('Content-Disposition: attachment; filename="form_test.csv"');

require(__DIR__ . '/phplib/config/config.php');
$register = new \App\Model\Register();
$arr = $register->extract();

// データ整形
$tag = [  'index','姓', '名', '性別', '誕生日', '運転免許証', '電話番号', 'メールアドレス', '都道府県',  '都道府県以外', 'メッセージ'];
array_unshift($arr, $tag);

$fp = fopen('php://temp', 'w+b');

foreach($arr as $row) {
  fputcsv($fp, $row, ',', '"');
}

rewind($fp);

$csv = stream_get_contents($fp);
$csv = mb_convert_encoding($csv, 'SJIS', 'utf8');
$csv = str_replace('/\n$/', '\r\n', $csv);
$csv = str_replace('/\r$/', '\r\n', $csv);

fclose($fp);

$fp = fopen('php://output', 'w+b');

fwrite($fp, $csv);

fclose($fp);
