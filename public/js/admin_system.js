$(function () {
    // メタタグに設定したトークンを使って、全リクエストヘッダにCSRFトークンを追加
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });

    var flag = $('input[name=flag]').val();

    // 登録もしくは編集ボタン押下時
    $('[data-toggle=modal]').on('click', function () {
        var target_id = $(this).attr('data-target_id');
        var target_amount = $(this).attr('data-target_amount');

        // 既存アイテムならフォームに値をセット
        if (target_id) {
            var target_object = $('tr[data-target_id=' + target_id + ']');
            var target_value = {
                target_id: target_id,
                category_name: target_object.find('span.category-name').text(),
                amount: target_amount,
                label: target_object.find('span.label-name').text(),
            };
            $('input[name=target_id]').val(target_value.target_id);
            $('p.target_category_text').text(target_value.category_name);
            $('input[name=amount]').val(target_value.amount);
            $('input[name=label]').val(target_value.label);

        }
    });

    // モーダルが閉じられるとき、アラートを消し、フォームを空にしておく
    $('#adminModal').on('hidden.bs.modal', function () {
        $('#api_result').html('').removeClass().addClass('hidden');
        $('input[name=target_id]').val(null);
        $('p.target_category_text').text(null);
        $('input[name=amount]').val(null);
        $('input[name=label]').val(null);
    });

    // 保存ボタン押下時
    $('#target_submit').on('click', function () {
        var target_id = $('input[name=target_id]').val(),
            target_id = (target_id) ? target_id : null,
            flag = $('input[name=flag]').val();
        var data = {
            target_id: target_id,
            amount: $('input[name=amount]').val(),
            label: $('input[name=label]').val(),
        };

        // APIを呼び出してDBに保存
        $.ajax({
            type: 'POST',
            url: flag + '/edit',
            data: data

        }).done(function (data) {
            // 正常時 結果表示
            console.log(data);
            $('#api_result').html('<span>正常に処理が完了しました</span>')
                .removeClass()
                .addClass('alert alert-success show');

            location.reload();

        }).fail(function (data) {
            // エラー時 エラーメッセージ生成
            console.log(data);
            var error_message = '';
            error_message += data.responseJSON.message + '<br>';
            // エラーメッセージ表示
            $('#api_result').html('<span>' + error_message + '</span>')
                .removeClass()
                .addClass('alert alert-danger show');
        });
    });

});
