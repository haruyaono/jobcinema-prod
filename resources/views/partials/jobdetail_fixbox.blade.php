<div id="js-detailFollowingArea" class="comparison-JC-detailFollowingArea">
    <ul class="detail-btn-lst-box-inner">
        <!-- <li>
            <img src="{{ asset('imm/common/') }}" alt="ロゴ">
        </li> -->
        <li>
            <a href="{{ route('seeker.register') }}" class="btn btn-web-entry"><i class="fab fa-telegram-plane mr-2"></i>応募する</a>
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
