$(function () {
    // メタタグに設定したトークンを使って、全リクエストヘッダにCSRFトークンを追加
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        
    });

    var flag = $('input[name=flag]').val();
    console.log(flag);

    // 登録もしくは編集ボタン押下時
    $('[data-toggle=modal]').on('click', function() {
        var target_category_id = $(this).attr('data-category_id');

        // 既存カテゴリーならフォームに値をセット
        if (target_category_id) {
            var target_object = $('tr[data-category_id=' + target_category_id + ']');
            if(flag == 'salary') {
                var pIdVal = target_object.parent().find('.parent_id').val();
            } else {
                var pIdVal = target_object.parent().next().val();
            }
            var target_value = {
                category_id   : target_category_id,
                pId           : pIdVal,
                name          : target_object.find('span.name').text()
            };
            $('input[name=category_id]').val(target_value.category_id);
            $('select.pId option[value=' + target_value.pId + ']').prop('selected', true);
            $('input[name=name]').val(target_value.name);
        }
    });

    // モーダルが閉じられるとき、アラートを消し、フォームを空にしておく
    $('#categoryModal').on('hidden.bs.modal', function() {
        $('#api_result').html('').removeClass().addClass('hidden');
        $('input[name=category_id]').val(null);
        $('input[name=name]').val(null);
    });

    // 保存ボタン押下時
    $('#category_submit').on('click', function() {
        var category_id = $('input[name=category_id]').val(),
        category_id = (category_id) ? category_id : null;
        flag = (flag) ? flag : null;
        pIdVal = flag == 'status' ? $('input.parent_id').val() : $('input[name=name]').val();
        var data = {
            category_id   : category_id,
            pId          : pIdVal,
            name          : $('input[name=name]').val(),
            flag          : flag
        };

        console.log(data);

        // APIを呼び出してDBに保存
        $.ajax({
            type : 'POST',
            url : data['flag'] + '/edit',
            data : data

        }).done(function(data) {
            // 正常時 結果表示
           
            $('#api_result').html('<span>正常に処理が完了しました</span>')
                .removeClass()
                .addClass('alert alert-success show');

            // 少しせこいが、リロードして変更が反映された画面を表示する
            location.reload();
            
        }).fail(function(data, error) {
            // エラー時 エラーメッセージ生成
            var error_message = '';
            $.each(data.responseJSON.errors, function(element, message_array) {
                $.each(message_array, function(index, message) {
                    error_message += message + '<br>';
                })
            });
            // エラーメッセージ表示
            $('#api_result').html('<span>' + error_message + '</span>')
                .removeClass()
                .addClass('alert alert-danger show');
        });
    });

    // 削除ボタン押下時
    $('#category_delete').on('click', function() {
        var data = {
            category_id : $('input[name=category_id]').val(),
            flag          : flag
        };

        // APIを呼び出して削除
        $.ajax({
            type : 'POST',
            url : flag + '/delete',
            data : data

        }).done(function(data) {
            // 正常時 結果表示
            $('#api_result').html('<span>削除しました</span>')
                .removeClass()
                .addClass('alert alert-success show');
            // リロード
            location.reload();

        }).fail(function(data) {
            // エラー時 エラーメッセージ表示
            $('#api_result').html('<span>削除に失敗しました</span>')
                .removeClass()
                .addClass('alert alert-danger show');
        });
    });
});