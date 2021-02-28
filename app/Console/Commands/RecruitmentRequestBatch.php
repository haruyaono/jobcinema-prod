<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Apply;

class RecruitmentRequestBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:recruitment_req';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $applies = new Apply();
        $over59nonRec = $applies->where("recruitment_status", 1)->where("updated_at", "<=", date("Y-m-d H:i:s",strtotime("-59 day")))->get();
        foreach ($over59nonRec as $item) {
            $address = $item->company->employer->email;

        }
        return 0;
    }
}
