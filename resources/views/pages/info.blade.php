@extends('layouts.master')

@section('title', '代表挨拶')
@section('description', 'JOBCiNEMA代表挨拶')

@section('header')
    @component('components.header')
    @endcomponent
@endsection

@section('contents')
    <!-- パンくず -->
    <div id="breadcrumb" class="bread only-pc">
        <ol class="list-decimal">
            <li>
                <a href="/">
                    <i class="fa fa-home"></i><span>釧路の求人情報TOP</span>
                </a>
            </li>
            <li>
                <a>
                    代表挨拶
                </a>
            </li>
        </ol>
    </div>
    <!-- ここからメインコンテンツ -->
    <div class="main-wrap">
        <section class="main-section static-page">
            <div class="inner">
                <div class="pad">
                    <h1 class="mb-5">代表挨拶</h1>
                    <div class="page-thum-wrap">
                        <figure>
                            <img src="{{ asset('/img/common/profile.jpg') }}" alt="代表の写真">
                        </figure>
                    </div>
                    <div class="page-textarea">
                        <p>22歳の学生2人が立ち上げた釧路密着型求人広告サイト、JOBCiNEMA(ジョブシネマ)。</p>
                        <p>釧路の地方創生を目指し若き世代が動き出さなければ活気が失われていく中、今の自分達には何ができるか。</p>
                        <p>当社は釧路の雇用に焦点を当て、従来のサービスでは難しかった地域の企業と若年層を結びつけることを実現し、釧路の雇用問題を解決することを目指しています。</p>
                        <p>若者が釧路の魅力に触れる機会が少ないのは、魅力的な求人があっても企業と求職者が結びつきにくい環境である事が大きな原因になっていると考えます</p>
                        <p>その問題を解決するため、JOBCiNEMAという求人広告サービスを運営しています</p>
                        <p>若年層の目に多く触れるよう、従来の文字がメインの"読む"媒体ではなく、動画によってよりリアルに職場の雰囲気を感じられる"見る"媒体を提案します。</p>
                        <p>文字では伝えられない『職場の雰囲気を上映』します。</p>
                        <p>釧路に特化することで可能になった他サイトでは見られない、細分化されたエリア検索により、自分の生活様式にあう職場を見つけることができます。</p>
                        <p>釧路に在住しているからこそ分かる生活様式をそのままエリア分けに細かく落とし込みました。</p>
                        <p>釧路をはじめとし、この先道東エリアに進出することでそれぞれの地域の若者離れを解決していきます</p>
                        <p>若者に向けたサービスを発信し動き出すべきは僕たち若者。</p>
                        <p>利用者にとって使いやすく簡略化されたシステムと新しい求人広告サイトとしての信頼を築いて釧路の雇用問題に"革命"を起こします。</p>
                    </div>

                    <p class="mt-5 pl-3 text-right">共同代表　菅原　京介<br/>共同代表　武田　将也</p>
                    <p class="page-section-close-btn">
                        <a href="#" onclick="javascript:window.history.back(-1);return false;">戻る</a>
                    </p>


                </div> <!-- pad -->
            </div>
        </section>
    </div>
@endsection

@section('footer')
    @component('components.footer')
    @endcomponent
@endsection
