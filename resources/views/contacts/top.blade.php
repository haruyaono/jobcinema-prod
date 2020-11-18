@extends('layouts.master')

@section('title', 'お問い合わせ')
@section('description', 'JOBCiNEMAに関するお問い合わせ')

@section('header')
@component('components.header')
@endcomponent
@endsection

@section('contents')
<div id="breadcrumb" class="bread only-pc">
  <ol class="list-decimal">
    <li>
      <a href="/">
        <i class="fa fa-home"></i><span>釧路の求人情報TOP</span>
      </a>
    </li>
    <li>
      <a>
        お問い合わせ
      </a>
    </li>
  </ol>
</div>

<div class="main-wrap">
  <section class="main-section contact-section">
    <div class="inner">
      <div class="pad">
        　 <h1><span class="ib-only-pc">求人サイト</span>JOBCiNEMAに関するお問い合わせ</h1>
        <p>お問い合わせいただいた内容に関するご返答は、3営業日以内に行わせていただきます。<br>下記フォームに必要事項をご記入ください。</p>
        @if($c_flag == 'seeker')
        <p class="c-complete-textbox">企業担当者専用のお問い合わせは<br class="c-568-only"><a class="txt-blue-link" href="/contact_e">こちら</a>になります。</p>
        @elseif($c_flag == 'employer')
        <p class="c-complete-textbox">求職者専用のお問い合わせは<br class="c-568-only"><a class="txt-blue-link" href="/contact_s">こちら</a>になります。</p>
        @endif

        @if(count($errors) > 0)
        <div class="alert alert-danger mb-3">
          <strong><i class="fas fa-exclamation-circle"></i>エラー</strong><br>
          <ul class="list-unstyled">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        @if($c_flag == 'seeker')

        <form method="POST" action="{{route('contact.seeker.post')}}">
          @csrf
          <input type="hidden" name="c_flag" value="seeker">
          <table class="contact-form-table">
            <tbody>
              <tr id="c-tr1">
                <th>
                  <label class="contact-form-heading-text">問い合わせ区分</label>
                </th>
                <td>求職者の方</td>
              </tr>
              <tr id="c-tr2">
                <th>
                  <label class="contact-form-heading-text">問い合わせカテゴリ</label>
                  <span class="contact-form-heading-label required">必須</span>
                </th>
                <td>
                  <div class="contact-form-select-wrap">
                    <select name="category" class="contact-form-select" id="c-category-for-seeker" required="required">
                      <option value>選択</option>
                      <option value="応募確認メールが届かない" @if(old('category')=='応募確認メールが届かない' ) selected @endif>応募確認メールが届かない</option>
                      <option value="電話番号の変更" @if(old('category')=='電話番号の変更' ) selected @endif>電話番号の変更</option>
                      <option value="メールアドレスの変更" @if(old('category')=='メールアドレスの変更' ) selected @endif>メールアドレスの変更</option>
                      <option value="システムエラーの報告" @if(old('category')=='システムエラーの報告' ) selected @endif>システムエラーの報告</option>
                      <option value="お祝い金について" @if(old('category')=='お祝い金について' ) selected @endif>お祝い金について</option>
                      <option value="その他のお問い合わせ" @if(old('category')=='その他のお問い合わせ' ) selected @endif>その他のお問い合わせ</option>
                    </select>
                  </div>
                </td>
              </tr>
              <tr id="c-tr3">
                <th>
                  <label class="contact-form-heading-text">氏名</label>
                  <span class="contact-form-heading-label required">必須</span>
                </th>
                <td>
                  <input class="contact-form-textfield form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" size="20" maxlength="100" required="required" value="{{old('name')}}" style="ime-mode:active;" placeholder="例：佐藤　一郎" type="text" name="name">
                </td>
              </tr>
              <tr id="c-tr4">
                <th>
                  <label class="contact-form-heading-text">氏名<br class="only-pc">(フリガナ)</label>
                </th>
                <td>
                  @if( Auth::check() == true )
                  <input class="contact-form-textfield form-control {{ $errors->has('name_ruby') ? ' is-invalid' : '' }}" size="20" maxlength="100" value="@if(old('name_ruby')){{old('name_ruby')}}@elseif(!old('name_ruby') && $user->last_name && $user->first_name){{$user->last_name}} {{$user->first_name}} @endif" style="ime-mode:active;" placeholder="例：サトウ　イチロウ" type="text" name="name_ruby">
                  @else
                  <input class="contact-form-textfield form-control {{ $errors->has('name_ruby') ? ' is-invalid' : '' }}" size="20" maxlength="100" value="{{old('name_ruby')}}" style="ime-mode:active;" placeholder="例：サトウ　イチロウ" type="text" name="name_ruby">
                  @endif
                </td>
              </tr>
              <tr id="c-tr9">
                <th>
                  <label class="contact-form-heading-text">返信先<br class="only-pc">メールアドレス</label>
                  <span class="contact-form-heading-label required">必須</span>
                </th>
                <td>
                  @if( Auth::check() )
                  <input class="contact-form-textfield form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" size="25" maxlength="100" pattern=".+@.+..+" required="required" value="@if(old('email')){{old('email')}}@elseif(!old('email') && $user->email){{$user->email}}@endif" style="ime-mode:active;" placeholder="例：onamae@example.jp" type="email" name="email">
                  @else
                  <input class="contact-form-textfield form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" size="25" maxlength="100" pattern=".+@.+..+" required="required" value="{{old('email')}}" style="ime-mode:active;" placeholder="例：onamae@example.jp" type="email" name="email">
                  @endif
                </td>
              </tr>
              <tr id="c-tr11">
                <th>
                  <label class="contact-form-heading-text">連絡先電話番号</label>
                </th>
                <td>
                  <input class="contact-form-textfield form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" size="15" pattern="0[0-9]{1,4}-[0-9]{1,4}-[0-9]{3,4}" style="ime-mode:off;" value="@if(old('phone')){{old('phone')}}@elseif(!old('phone') && $user_phone != ""){{$user_phone}}@endif" placeholder="例：03-3333-3333" type="tel" name="phone">
                </td>
              </tr>
              <tr>
                <th>
                  <label class="contact-form-heading-text">お問い合わせ内容</label>
                  <span class="contact-form-heading-label required">必須</span>
                </th>
                <td>
                  <textarea rows="6" class="contact-form-textarea form-control {{ $errors->has('content') ? ' is-invalid' : '' }}" style="ime-mode:active;" required="required" name="content">{{ old('content') }}</textarea>

                </td>
              </tr>
            </tbody>
          </table>
          <div class="contact-button-wrap">
            <button type="submit" class="btn btn-yellow mt-4">送信する<i class="icon-chevron-right"></i></button>
          </div>

        </form>

        @elseif($c_flag == 'employer')
        <form method="POST" action="{{route('contact.employer.post')}}">
          @csrf
          <input type="hidden" name="c_flag" value="employer">
          <table class="contact-form-table">
            <tbody>
              <tr id="c-tr1">
                <th>
                  <label class="contact-form-heading-text">問い合わせ区分</label>
                  <span class="contact-form-heading-label required">必須</span>
                </th>
                <td>企業の方
      </div>
      </td>
      </tr>
      <tr id="c-tr2">
        <th>
          <label class="contact-form-heading-text">問い合わせカテゴリ</label>
          <span class="contact-form-heading-label required">必須</span>
        </th>
        <td>
          <div class="contact-form-select-wrap">
            <select name="category" class="contact-form-select" id="c-category-for-employer" required="required">
              <option value>選択</option>
              <option value="掲載希望" @if(old('category')=='掲載希望' ) selected @endif>掲載希望</option>
              <option value="料金プラン相談" @if(old('category')=='料金プラン相談' ) selected @endif>料金プラン相談</option>
              <option value="システムエラーの報告" @if(old('category')=='システムエラーの報告' ) selected @endif>システムエラーの報告</option>
              <option value="その他のお問い合わせ" @if(old('category')=='その他のお問い合わせ' ) selected @endif>その他のお問い合わせ</option>
            </select>
          </div>
        </td>
      </tr>
      <tr id="c-tr5">
        <th>
          <label class="contact-form-heading-text">企業名</label>
          <span class="contact-form-heading-label required">必須</span>
        </th>
        <td>
          @if( Auth::guard('employer')->check() == true )
          <input class="contact-form-textfield form-control {{ $errors->has('c_name') ? ' is-invalid' : '' }}" size="20" maxlength="100" required="required" value="@if(old('c_name')){{old('c_name')}}@elseif(!old('c_name') && Auth::guard('employer')->user()->company->cname){{Auth::guard('employer')->user()->company->cname}}@endif" style="ime-mode:active;" placeholder="例：株式会社ジョブシネマ" type="text" name="c_name">
          @else
          <input class="contact-form-textfield form-control {{ $errors->has('c_name') ? ' is-invalid' : '' }}" size="20" maxlength="100" required="required" value="{{old('c_name')}}" style="ime-mode:active;" placeholder="例：株式会社ジョブシネマ" type="text" name="c_name">
          @endif
        </td>
      </tr>

      <tr id="c-tr6">
        <th>
          <label class="contact-form-heading-text">企業名<br class="only-pc">(フリガナ)</label>
        </th>
        <td>
          @if( Auth::guard('employer')->check() == true )
          <input class="contact-form-textfield form-control {{ $errors->has('c_name_ruby') ? ' is-invalid' : '' }}" size="20" maxlength="100" value="@if(old('c_name_ruby')){{old('c_name_ruby')}}@elseif(!old('c_name_ruby') && $employer->company->cname_katakana){{$employer->company->cname_katakana}}@endif" style="ime-mode:active;" placeholder="例：ジョブシネマ" type="text" name="c_name_ruby">
          @else
          <input class="contact-form-textfield form-control {{ $errors->has('c_name_ruby') ? ' is-invalid' : '' }}" size="20" maxlength="100" value="{{old('c_name_ruby')}}" style="ime-mode:active;" placeholder="例：ジョブシネマ" type="text" name="c_name_ruby">
          @endif
        </td>
      </tr>
      <tr id="c-tr7">
        <th>
          <label class="contact-form-heading-text">担当者名</label>
          <span class="contact-form-heading-label required">必須</span>
        </th>
        <td>
          @if( Auth::guard('employer')->check() == true )
          <input class="contact-form-textfield form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" size="20" maxlength="100" required="required" value="@if(old('name')){{old('name')}}@elseif(!old('name') && $employer->last_name && $employer->first_name){{$employer->last_name}} {{$employer->first_name}} @endif" style="ime-mode:active;" placeholder="例：佐藤　一郎" type="text" name="name">
          @else
          <input class="contact-form-textfield form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" size="20" maxlength="100" value="{{old('name')}}" style="ime-mode:active;" placeholder="例：佐藤　一郎" type="text" name="name">
          @endif
        </td>
      </tr>
      <tr id="c-tr8">
        <th>
          <label class="contact-form-heading-text">担当者名<br class="only-pc">(フリガナ)</label>
        </th>
        <td>
          @if( Auth::guard('employer')->check() == true )
          <input class="contact-form-textfield form-control {{ $errors->has('name_ruby') ? ' is-invalid' : '' }}" size="20" maxlength="100" value="@if(old('name_ruby')){{old('name_ruby')}}@elseif(!old('name_ruby') && $employer->last_name_katakana && $employer->first_name_katakana  ){{$employer->last_name_katakana}} {{$employer->first_name_katakana}} @endif" style="ime-mode:active;" placeholder="例：サトウ　イチロウ" type="text" name="name_ruby">
          @else
          <input class="contact-form-textfield form-control {{ $errors->has('name_ruby') ? ' is-invalid' : '' }}" size="20" maxlength="100" value="{{old('name_ruby')}}" style="ime-mode:active;" placeholder="例：サトウ　イチロウ" type="text" name="name_ruby">
          @endif
        </td>
      </tr>
      <tr id="c-tr10">
        <th>
          <label class="contact-form-heading-text">返信先<br class="only-pc">メールアドレス</label>
          <span class="contact-form-heading-label required">必須</span>
        </th>
        <td>
          @if( Auth::guard('employer')->check() == true )
          <input class="contact-form-textfield form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" size="25" maxlength="100" pattern=".+@.+..+" required="required" value="@if(old('email')){{old('email')}}@elseif(!old('email') && $employer->email){{$employer->email}}@endif" style="ime-mode:active;" placeholder="例：onamae@example.jp" type="email" name="email">
          @else
          <input class="contact-form-textfield form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" size="25" maxlength="100" pattern=".+@.+..+" required="required" value="{{old('email')}}" style="ime-mode:active;" placeholder="例：onamae@example.jp" type="email" name="email">
          @endif
        </td>
      </tr>
      <tr id="c-tr12">
        <th>
          <label class="contact-form-heading-text">連絡先電話番号</label>
        </th>
        <td>
          <input class="contact-form-textfield form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" size="15" pattern="0[0-9]{1,4}-[0-9]{1,4}-[0-9]{3,4}" style="ime-mode:off;" value="@if(old('phone')){{old('phone')}}@elseif(!old('phone') && $employer_phone != ""){{$employer_phone}}@endif" placeholder="例：03-3333-3333" type="tel" name="phone">
        </td>
      </tr>
      <tr>
        <th>
          <label class="contact-form-heading-text">お問い合わせ内容</label>
          <span class="contact-form-heading-label required">必須</span>
        </th>
        <td>
          <textarea rows="6" class="contact-form-textarea form-control {{ $errors->has('content') ? ' is-invalid' : '' }}" style="ime-mode:active;" required="required" name="content">{{ old('content') }}</textarea>

        </td>
      </tr>
      </tbody>
      </table>
      <div class="contact-button-wrap">
        <button type="submit" class="btn btn-yellow mt-4">送信する<i class="icon-chevron-right"></i></button>
      </div>

      </form>
      @endif
    </div> <!-- pad -->
</div>
</section>
</div>
@endsection

@section('footer')
@component('components.footer')
@endcomponent
@endsection
