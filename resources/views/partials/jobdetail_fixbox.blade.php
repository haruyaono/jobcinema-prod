<div id="js-detailFollowingArea" class="comparison-JC-detailFollowingArea">
    <ul class="detail-btn-lst-box-inner">
        <!-- <li>
            <img src="{{ asset('imm/common/') }}" alt="ロゴ">
        </li> -->
        <li>
            @if(!$exists)
            <a href="{{ route('show.front.entry.step1', $jobitem) }}" class="btn btn-web-entry"><i class="fab fa-telegram-plane mr-2"></i>応募する</a>
            @else
            <a class="btn btn-web-entry non-link" href="javascript:void(0)">応募済み</a>
            @endif

        </li>
        @if(Auth::guard('seeker')->check())
        <li>
            <favourite-follow-fixed-component :jobid={{$jobitem->id}} :favourited={{ $jobitem->checkSaved()?'true':'false' }}></favourite-follow-fixed-component>
        </li>
        @else
        <li>
            <a href="{{ route('seeker.register') }}" class="btn btn-web-register">
                <i class="fas fa-user-circle mr-2"></i>会員登録
            </a>
        </li>
        @endif
    </ul>
</div>
