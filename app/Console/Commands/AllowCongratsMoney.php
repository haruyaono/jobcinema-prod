<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Apply;
use App\Mail\Seeker\CongratsMoney;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;

class AllowCongratsMoney extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobcinema:allowCongratsMoney';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Allows seekers to apply for congratulations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        try {
            // お祝い金申請ステータスが1 且つ 企業側の初出社日から30日経過した応募
            $applies = Apply::where('congrats_application_status', 1)
                ->whereNotNull('user_id')
                ->where('recruit_confirm', '<', (new Carbon())->subDays(31))
                ->get();

            foreach ($applies as $apply) {
                // お祝い金申請ステータスを申請許可に更新
                $apply->update(['congrats_application_status' => 2]);
                Mail::to($apply->user->email)->queue(new CongratsMoney($apply));
            }
        } catch (\Exception $e) {
            \Log::error($e);
            $this->error($e->getMessage());
            return -1;
        }

        return 0;
    }
}
