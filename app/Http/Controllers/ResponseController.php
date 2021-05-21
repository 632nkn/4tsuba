<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckBody;
use App\Models\Response;


class ResponseController extends Controller
{
    public function store(Request $request)
    {
        $check_body = new CheckBody();
        $dest_displayed_post_id_list = $check_body->returnDestinationDisplayedPostIdList($request->body);

        if ($dest_displayed_post_id_list) {
            for ($i = 0; $i < count($dest_displayed_post_id_list); $i++) {
                Response::create([
                    'thread_id' => $request->thread_id,
                    'origin_d_post_id' => $request->displayed_post_id,
                    'dest_d_post_id' => $dest_displayed_post_id_list[$i]
                ]);
            }
        }
    }

    public function destroy(Request $request)
    {
        Response::where('thread_id', $request->thread_id)
            ->where('origin_d_post_id', $request->displayed_post_id)->delete();
    }
}
