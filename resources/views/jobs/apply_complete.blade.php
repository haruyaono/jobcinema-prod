@extends('layouts.apply_form_master')

@section('title', '応募完了')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
  @component('components.apply_header')
  @endcomponent
@endsection

@section('contents')
<div class="main-wrap">
  <section class="main-section">
    <div class="inner">
      <div class="pad">
        <h1 class="txt-h1">応募完了</h1>
        <p>応募が完了しました。</p>
        <p>選考フローに沿って、次のステップに進みましょう。</p>
        <section class="apply-after-job-info">
          <h2>応募先：{{$job->job_office}}</h2>
          <div class="apply-after-sub">
            <p>MYページは<a href="{{route('mypages.index')}}" class="txt-blue-link">こちら</a>です。</p>
            <p>「応募後の流れ」は応募管理からも確認できます。</p>
          </div>
          <table>
            <tr>
              <th>住所</th>
              <td>
                {{$job->job_office_address}}
              </td>
            </tr>
            <tr>
              <th>採用窓口</th>
              <td>
              {{$job->company->phone1}}-{{$job->company->phone2}}-{{$job->company->phone3}}
              </td>
            </tr>
            <tr>
              <th>お祝い金</th>
              <td>
                @if($job->festive_money)
                  採用決定で<span class="text-red">5,000円</span>もらえる求人です。
                @else
                  お祝い金対象外の求人です。
                @endif
                
              </td>
            </tr>
            <tr>
              <th>求人ページ</th>
              <td>
                <a href="{{route('jobs.show', ['id' => $job->id])}}" class="txt-blue-link">{{route('jobs.show', ['id' => $job->id])}}</a>
              </td>
            </tr>
          </table>
        </section>

        <section class="apply-after-job-warming">
          <h2 class="font-yellow"><i class="fas fa-exclamation-triangle mr-2"></i>ご注意ください</h2>
          <p class="mb-3">下記の場合でもお祝い金の対象となります。</p>
          <div class="apply-after-sub">
            <p>・応募した企業から応募後１年以内に採用が決まった場合</p>
            <p>・辞退・不採用の連絡後改めて採用された場合</p>
            <p>・応募した企業から別のお仕事（会社）を紹介された場合</p>
            <p class="mb-2">・応募した職種・勤務地以外に採用された場合</p>
            <p>※初出社には研修期間（試用期間）も含みます。</p>
            <p>※採用お祝い金は、JOBCiNEMAよりプレゼントします。</p>
            <p>採用企業様より直接お渡しすることはありません。</p>
            <p>※退会した場合はお祝い金はもらえません</p>
          </div>
        </section>
        <div class="btn-wrap">
          <a href="/" class="btn btn-yellow">トップに戻る</a>
        </div>

      </div>
    </div>
  </section>
</div> <!-- main-wrap-->
@endsection

@section('js')
  <script src="{{ asset('js/main.js') }}"></script>
@endsection
