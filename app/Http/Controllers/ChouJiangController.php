<?php

namespace App\Http\Controllers;

use App\ChouJiangRecord;
use App\Http\Requests\ChouJiangRequest;
use App\Jobs\TestJob;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChouJiangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ChouJiangRequest $request)
    {
        // 格式化一个时间日期字符串为 carbon 对象
        $carbon = Carbon::parse($request->time);
        // 计算给定的时间与当前时间的差值，得出延迟执行的时间
        $int = (new Carbon)->diffInSeconds($carbon, false);
        // 分发队列，传入延迟执行时间，等待执行
//        $this->dispatch(new TestJob($int, $request->email));
        $this->dispatch(new TestJob(5, $request->email));

        //格式化时间显示，用于提示
        $delay = $carbon->diffForHumans(Carbon::now());

        return response()->json([
            'success' => '参与成功，奖品将在' . $delay . '抽出，开奖结果会发送到您的邮箱！',
            'time' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
