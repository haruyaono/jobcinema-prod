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

        <h1 class="txt-h1">次のステップへ進んでください。</h1>
        <p>まだ応募は完了しておりません！</p>
        <p>選考フローに沿って、次のステップに進みましょう。</p>
        <section class="apply-after-job-info">
          <h2>応募先：{{$jobitem->job_office}}</h2>
          <div class="apply-after-sub">
            <p><span style="background:linear-gradient(transparent 50%, #fec1fe 0%);">次のステップは、面接日の確定です。</span></p>
            <p><span style="background:linear-gradient(transparent 50%, #fec1fe 0%);">下記採用窓口へ電話をかけ、企業と面接日の確定を行ってください。</span></p>
            <p><span style="background:linear-gradient(transparent 50%, #fec1fe 0%);">確定後、MYページにある「応募管理」画面から、面接日を入力してください。</span></p>
            <p>MYページは<a href="{{ route('seeker.index.mypage') }}" class="txt-blue-link">こちら</a>です。</p>
            <p><span style="color: #ff4444">※面接日の入力が確認できない場合、お祝い金を申請できません。</span></p>
          </div>
          <table>
            <tr>
              <th>住所</th>
              <td>
                {{$jobitem->job_office_address}}
              </td>
            </tr>
            <tr>
              <th>採用窓口</th>
              <td>
                <a href="tel:{{ $jobitem->company->full_phone }}">{{ $jobitem->company->full_phone }}</a>
              </td>
            </tr>
            <tr>
              <th>お祝い金</th>
              <td>
                @if($jobitem->existsCongratsMoney())
                採用決定で<span class="text-red">{{$jobitem->getCongratsMoney()->custom_amount}}</span>もらえる求人です。
                @else
                お祝い金対象外の求人です。
                @endif

              </td>
            </tr>
            <tr>
              <th>求人ページ</th>
              <td>
                <a href="{{ route('show.front.job_sheet.detail', [$jobitem]) }}" class="txt-blue-link">{{ route('show.front.job_sheet.detail', [$jobitem]) }}</a>
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
