<?php

/**
 * 配列操作共通クラス
 */
class ArrayUtil
{

    /**
     * 指定範囲の取得する
     * @param array $array 配列データ
     * @param int $start 開始位置
     * @param int $limit 範囲
     * @return array 指定範囲配列
     */
    public static function range($array, $start, $limit)
    {
        $count = 0;
        $temp = array();

        if ($array) {
            foreach ($array as $key => $data) {
                if ($count < $start) {
                    $count++;
                    continue;
                } elseif ($count >= $start + $limit) {
                    break;
                }

                $temp[$key] = $data;
                $count++;
            }
        }

        return $temp;
    }

    /**
     * ソート処理
     * @param array $array 配列データ
     * @param string $orderColumn ソートキー
     * @param string $orderBy ASC:昇順, DESC:降順
     * @return array ソート処理後配列
     */
    public static function sort(&$array, $orderColumn, $orderBy = 'ASC')
    {
        if (is_array($array) == false) {
            return $array;
        }
        if (count($array) == 0) {
            return $array;
        }

        // 昇順
        $sort = SORT_ASC;

        // 降順
        if ($orderBy == 'DESC') {
            $sort = SORT_DESC;
        }

        // ソートキー
        $keyList = array();
        foreach ($array as $key => $value) {
            $keyList[$key] = $value[$orderColumn];
        }

        // ソート処理
        array_multisort($keyList, $sort, $array);
        return $array;
    }

    /**
     * 連想配列の最後のkey取得
     * @param array $array 配列データ
     * @return int|string 最後のキー
     */
    public static function key_end($array)
    {
        end($array);
        return key($array);
    }

    /**
     * 連想配列の最初のkey取得
     * @param array $array 配列データ
     * @return int|string 最初のキー
     */
    public static function key_first($array)
    {
        reset($array);
        return key($array);
    }

    /**
     * 配列の値をキーに配列の中身を格納
     * @param array $array 配列
     * @param string $keyName キー
     * @return array($keyName => $array[$keyName])
     */
    public static function convert_key_array($array, $keyName)
    {
        $res = array();
        foreach ($array as $val) {
            if (is_object($val)) {
                $res[$val->$keyName] = $val;
            } else {
                $res[$val[$keyName]] = $val;
            }
        }
        return $res;
    }

    /**
     * 配列の値をキーに配列の中身を格納
     * @param array $array 配列
     * @param string $keyName キー
     * @return array array($keyName=> array($array[$keyName],$array[$keyName]))
     */
    public static function convert_key_list($array, $keyName)
    {
        $res = array();
        foreach ($array as $val) {
            if (is_object($val)) {
                $res[$val->$keyName][] = $val;
            } else {
                $res[$val[$keyName]][] = $val;
            }
        }
        return $res;
    }

    /**
     *  リストに入っている値の合計値を取得
     * @param array $list リスト
     * @param string $sumKey キー
     * @return int 合計値
     */
    public static function sum_num($list, $sumKey)
    {
        $sum = 0;
        foreach ($list as $key => $value) {
            if (is_object($value)) {
                $sum += $value->$sumKey;
            } else {
                $sum += $value[$sumKey];
            }
        }
        return $sum;
    }

    /**
     * 配列情報をマージする。
     * この関数はオブジェクト型でもマージ可能
     * @return array
     */
    public static function merge()
    {
        $argList = func_get_args();
        $result = array();
        foreach ($argList as $argData) {
            foreach ($argData as $value) {
                $result[] = $value;
            }
        }
        return $result;
    }

    /**
     * 配列データを取得
     * @param array|object $ary 配列
     * @param string $key キー
     * @param mixed $default デフォルト値
     * @return mixed
     */
    public static function get_ary_data($ary, $key, $default = null)
    {
        if (is_object($ary)) {
            $ary = (array)$ary;
        }
        return isset($ary[$key]) ? $ary[$key] : $default;
    }

}