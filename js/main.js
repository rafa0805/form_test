'use strict';
$(function() {
  // エンターキーの無効化処理
  $('#main_form').on('keypress', 'input', function(e) {
    const key = e.keyCode || e.charCode || 0;
    // 13はEnterキーのキーコード
    if (key == 13) {
      e.preventDefault();
    }
  });

  // 日付バリデーションのために年月日を統合
  $('#main_form').on('change', '#year, #month, #date', function() {
    let $birthday = $('#birthday');
    let year = $('#year').val();
    let month = $('#month').val();
    let date = $('#date').val();

    $birthday.val(`${year}/${month}/${date}`);
  });

  // バリデーション関連とsubmitハンドラーの記述
  $('#main_form').validate({
    rules: {
      sei: {
        required: true,
        maxlength: 16,
      },
      mei: {
        required: true,
        maxlength: 16,
      },
      sex: {
        required: true,
      },
      birthday: {
        existDate: true, //カスタムルール
        pastDate: true, //カスタムルール
        fullDate: true, //カスタムルール
      },
      car_license: {
        required: true,
      },
      tel: {
        required: true,
        digits: true,
        telFormat: true, //カスタムルール
      },
      mail_address: {
        required: true,
        email: true,
      },
      pref: {
        required: true,
      },
      address: {
        required: true,
        maxlength: 255,
      },
      message: {
        maxlength: 1000,
      },
    },
    messages: {
      sei: {
        required: '必須項目です',
        maxlength: '16文字以内で入力下さい',
      },
      mei: {
        required: '必須項目です',
        maxlength: '16文字以内で入力下さい',
      },
      sex: {
        required: '必須項目です',
      },
      birthday: {
        date: 'この日付は有効ではありません',
      },
      car_license: {
        required: '必須項目です',
      },
      tel: {
        required: '必須項目です',
        digits: '半角数字を使用下さい',
      },
      mail_address: {
        required: '必須項目です',
        email: '有効なメールアドレスを入力下さい',
      },
      pref: {
        required: '必須項目です',
      },
      address: {
        required: '必須項目です',
        maxlength: '255字以内で入力下さい',
      },
      message: {
        maxlength: '1000文字以内で入力下さい',
      },
    },
    errorPlacement: function(error, element) {
      element.closest('.input').next().append(error);
    },
    submitHandler: function(form) {
      if ($('button[type="submit"]').hasClass('preview')) {
        previewWindow();
      } else {
        form.submit();
      }
    },
  });

  // 再入力画面への切り替え
  $('form').on('click', 'button.return', function() {
    formWindow();
  });

  //確認画面の作りこみ
  function previewWindow() {
    $('.input').children().hide();
    display_input(inputForShow());
    $('button[type="submit"]').removeClass('preview').text('登録');
    $('button.return').removeClass('hidden');
  }

  // 再入力画面の作りこみ
  function formWindow() {
    $('.input').children('span').remove();
    $('.input').children().show();
    $('button[type="submit"]').addClass('preview').text('確認画面へ');
    $('button.return').addClass('hidden');
  }

  //DOMにアクセスし確認のため入力内容を表示する
  function display_input(inputs) 
  {
    Object.entries(inputs).forEach(function(input) {
      let $text;
      if (input[0] !== 'token') {
        $text = $('<span>').text(input[1]).addClass('confirm');
      } else {
        return;
      }
      $('.' + input[0]).append($text);
    });
  }

  //確認画面に表示する形にデータを整形
  function inputForShow() {
    let show = {
      sei : $('#sei').val(),
      mei : $('#mei').val(),
      sex : $('input[name="sex"]:checked').data('label'),
      birthday : $('#year').val() + '年' + $('#month').val().padStart(2, '0') + '月' + $('#date').val().padStart(2, '0')  +  '日',
      car_license : $('input[name="car_license"]:checked').data('label'),
      tel : $('#tel').val(),
      mail_address : $('#mail_address').val(),
      pref : $('option.pref:selected').text(),
      address : $('#address').val(),
      message : $('#message').val(),
    }
    return show;
  }

  // 以降、カスタムルールの記述

  jQuery.validator.addMethod('fullDate', function(value, element) {
    let format = /^\d{4}\/\d{1,2}\/\d{1,2}$/;
    return format.test(value);
  }, '年月日を全て入力下さい');

  jQuery.validator.addMethod('existDate', function(value, element) {
    var y = value.split("/")[0];
    var m = value.split("/")[1] - 1;
    var d = value.split("/")[2];
    var date = new Date(y,m,d);
    if(date.getFullYear() != y || date.getMonth() != m || date.getDate() != d){
      return this.optional(element) || false;
    } else {
      return true;
    }
  }, '有効な日付を入力下さい');

  jQuery.validator.addMethod('pastDate', function(value, element) {
    var y = value.split("/")[0];
    var m = value.split("/")[1] - 1;
    var d = value.split("/")[2];
    var date = new Date(y,m,d);
    if(date >= Date.now()){
      return this.optional(element) || false;
    }else {
      return true;
    }
  }, '過去の日付を選択下さい');

  jQuery.validator.addMethod('telFormat', function(value, element) {
    let format = /^0\d{9,10}$/;
    return format.test(value);
  }, '0から始まる10桁 (固定電話)または11桁 (携帯電話)を半角数字を入力下さい');
});