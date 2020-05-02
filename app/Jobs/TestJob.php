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
    public function __construct($delay, $email)
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
            '0' => array('id' => 1, 'prize' => 'Apple Watch Series 5 GPS 深空灰色', 'v' => 110, 'num' => 1),
            '1' => array('id' => 2, 'prize' => 'iPhone SE 深空灰色 64GB', 'v' => 25, 'num' => 2),
            '2' => array('id' => 3, 'prize' => 'iPd Air 深空灰色 64GB', 'v' => 300, 'num' => 2),
            '3' => array('id' => 4, 'prize' => 'iPhone 11 基佬紫色 64GB', 'v' => 16, 'num' => 3),
            '4' => array('id' => 5, 'prize' => 'iPhone 11 Pro 暗夜绿色 64GB', 'v' => 8, 'num' => 4),
            '5' => array('id' => 6, 'prize' => 'MacBook Pro 16寸 2.6GHz 6 核处理器 深空灰色 16+512GB', 'v' => 12, 'num' => 10),
        );

        $prize_arr = [
            '1' => [
                'name' => 'Apple Watch Series 5 GPS 深空灰色',
                'value' => '¥3199'
            ],
            '2' => [
                'name' => 'iPhone SE 深空灰色 64GB',
                'value' => '¥3299'
            ],
            '3' => [
                'name' => 'iPad Air 深空灰色 64GB',
                'value' => '¥3896'
            ],
            '4' => [
                'name' => 'iPhone 11 基佬紫色 64GB',
                'value' => '¥5499'
            ],
            '5' => [
                'name' => 'iPhone 11 Pro 暗夜绿色 64GB',
                'value' => '¥6549'
            ],
            '6' => [
                'name' => 'MacBook Pro 16寸 2.6GHz 6 核处理器 深空灰色 16+512GB',
                'value' => '¥18999'
            ]
        ];

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
        $name = [];
        $value = [];
        foreach ($zj as $item) {
            $name[] = $prize_arr[$item]['name'];
            $value[] = $prize_arr[$item]['value'];
        }

        $choujiang = ChouJiangRecord::create([
            'prize' => json_encode($zj),
            'email' => $this->email,
//            'email' => '863129201@qq.com',
            'name' => json_encode($name),
            'value' => json_encode($value),
        ]);

        $choujiang->notify(new ChouZhongNotify($choujiang));

    }
}
