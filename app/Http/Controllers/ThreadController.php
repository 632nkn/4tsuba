<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;


class ThreadController extends Controller
{
    public function index(Request $request)
    {
        //return Thread::orderBy($request->sort_column, $request->order)->get();

        $sort_list = array("最終更新", "作成日時", "書込数", "いいね数");
        $order_set = array();

        switch ($request->sort) {
            case $sort_list[0]:
                array_push($order_set, 'updated_at');
                break;
            case $sort_list[1]:
                array_push($order_set, 'created_at');
                break;
            case $sort_list[2]:
                array_push($order_set, 'post_count');
                break;
            case $sort_list[3]:
                array_push($order_set, 'like_count');
                break;
            default:
                array_push($order_set, 'updated_at');
        }

        switch ($request->order) {
            case 'desc':
                array_push($order_set, 'desc');
                break;
            case 'asc':
                array_push($order_set, 'asc');
                break;
            default:
                array_push($order_set, 'desc');
        }

        return Thread::orderBy($order_set[0], $order_set[1])->get();
    }
}
