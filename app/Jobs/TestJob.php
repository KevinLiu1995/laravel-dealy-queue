<?php

namespace App\Jobs;

use App\ChouJiangRecord;
use App\Notifications\ChouZhongNotify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

// 使用队列执行
class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $choujiangRecord;

    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($delay,$email)
    {
//        $this->choujiangRecord = $chouJiangRecord;
        $this->email = $email;
        // 可以动态设置任务的延迟执行时间$delay，单位秒（可以根据开奖时间与当前时间差值计算出延迟时间）
        $this->delay($delay);
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        //延迟执行的逻辑（开奖逻辑）
        $prizeArr = array(
            '0' => array('id' => 1, 'prize' => '全英雄皮肤', 'v' => 1, 'num' => 1),
            '1' => array('id' => 2, 'prize' => '单英雄皮肤', 'v' => 2, 'num' => 2),
            '2' => array('id' => 3, 'prize' => '钻石1000', 'v' => 3, 'num' => 2),
            '3' => array('id' => 4, 'prize' => '钻石500', 'v' => 15, 'num' => 3),
            '4' => array('id' => 5, 'prize' => '金币100', 'v' => 20, 'num' => 4),
            '5' => array('id' => 6, 'prize' => '金币50', 'v' => 78, 'num' => 10),
        );

        $arr = array();

        foreach ($prizeArr as $key => $val) {
            $arr[$val['id']] = $val['v'];
        }
        $result = '';
        $zj = [];
        //概率数组循环
        for ($i = 0; $i < 3; $i++) {
            //概率数组总精度
            $arrSum = array_sum($arr);

            foreach ($arr as $key => $vv) {
                $randNum = random_int(1, $arrSum);
                if ($randNum <= $vv) {
                    $result = $key;
                    unset($arr[$result]);
                    $zj[] = $result;
                    break;
                } else {
                    $arrSum -= $vv;
                }
            }
        }

        $choujiang = ChouJiangRecord::create([
            'prize' => json_encode($zj),
//            'email' => $this->email
            'email' => '863129201@qq.com'
        ]);

        $choujiang->notify(new ChouZhongNotify($choujiang));

    }
}
