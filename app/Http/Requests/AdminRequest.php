<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Route;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $action = $this->getCurrentAction();

        $rules['editCategory'] = [
            'category_id'   => 'integer|min:1|nullable', 
            'name'          => 'required|string|max:191', 
        ];
        $rules['deleteCategory'] = [
            'category_id' => 'required|integer|min:1'   
        ];

        return array_get($rules, $action, []);
    }

    public function messages()
    {
        // 表示されるバリデートエラーメッセージを個別に編集したい場合は、ここに追加する
        // 項目名.ルール => メッセージという形式で書く
        // プレースホルダーを使うこともできる
        // 下記の例では :max の部分にそれぞれ設定した値（255, 10000）が入る
        return [
            'category_id.required'   => 'カテゴリーIDは必須です',
            'category_id.integer'    => 'カテゴリーIDは整数でなければなりません',
            'category_id.min'        => 'カテゴリーIDは1以上でなければなりません',
            'name.required'          => 'カテゴリ名は必須です',
            'name.string'            => 'カテゴリ名は文字列を入力してください',
            'name.max'               => 'カテゴリ名は:max文字以内で入力してください',
        ];
    }

      /**
     * オーバーライドしてAPIとして実行されているときのレスポンスを json にする
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        $action = $this->getCurrentAction();

        $response['errors'] = $validator->errors()->toArray();
        throw new HttpResponseException(
            response()->json($response, 422)
        );
    }

    /**
     * 現在実行中のアクション名を返す
     *
     * @return mixed
     */
    public function getCurrentAction()
    {
        // 実行中のアクション名を取得
        // App\Http\Controllers\AdminBlogController@post のような返り値が返ってくるので @ で分割
        $route_action = Route::currentRouteAction();
        list(, $action) = explode('@', $route_action);
        return $action;
    }
}
