<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckBody extends Model
{
    //use HasFactory;
    public function returnDestinationDisplayedPostIdList($body)
    {
        $regular_expression = "/>>[1-9][0-9]{0,3}( |　|\n|\r|\r\n|\t)+/";
        $regular_expression_for_sentence = "/^>>[1-9][0-9]{0,3}$/";
        $goal_id_list = array();

        if (preg_match($regular_expression, $body)) {
            //全角スペースを半角スペースに変換(preg_splitが全角スペース対応してない)
            $hankaku_body = mb_convert_kana($body, 's');
            //改行を半角スペースに
            $plane_body = str_replace(["\r\n", "\r", "\n"], ' ', $hankaku_body);
            //センテンスごとに区切り配列へ
            $sentences = preg_split("/[\s\n]/", $plane_body);

            foreach ($sentences as $sentence) {
                if (preg_match($regular_expression_for_sentence, $sentence)) {
                    array_push($goal_id_list, substr($sentence, 2));
                } else {
                }
            }
            //(悪意のある)重複した>>番号を削除
            $unique_list = array_unique($goal_id_list);
            //配列を詰める
            $aligned_list = array_values($unique_list);

            return $aligned_list;
        }
        //「>>1」のような1語の場合
        else if (preg_match($regular_expression_for_sentence, $body)) {
            array_push($goal_id_list, substr($body, 2));
            return $goal_id_list;
        } else {
            return null;
        }
    }
}
