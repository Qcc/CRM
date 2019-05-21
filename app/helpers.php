<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

/**
 * 格式化手机号码
 *
 * @param [type] $phone
 * @param [type] $separator
 * @return void
 */
function format_phone($phone,$separator)
{
    if(strlen($phone) != 11){
        return $phone;
    }else{
        $arr = str_split($phone);
        $newPhone='';
        foreach ($arr as $i => $n) {
            $newPhone=$newPhone.$n;
            if($i==2 || $i ==6 ){
                $newPhone=$newPhone.$separator;
            }
        }
        return $newPhone;
    }
}

/**
 * 获取下一个客户id
 *
 * @return void
 */
function nextCompany($company,$companys)
{
    if(count($companys) == 1){
        return -1;
    }else{
        foreach ($companys as $item) {
            if($item->id != $company->id){
                return $item->id;
            }
        }
    }
}