<?php
use Illuminate\Support\Facades\Cache;

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

function howLevel($money)
{
    // 缓存业绩等级设置
	$level = Cache::rememberForever('level', function (){
        $l = \DB::table('settings')->where('name','level')->first();
        return json_decode($l->data); 
    });
    if($money >= $level->level_6->performance){
        return $level->level_6;
    }else if($money >= $level->level_5->performance){
        return $level->level_5;
    }else if($money >= $level->level_4->performance){
        return $level->level_4;
    }else if($money >= $level->level_4->performance){
        return $level->level_3;
    }else if($money >= $level->level_2->performance){
        return $level->level_2;
    }else{
        return $level->level_1;
    }
}

/**
 * 获取商机对应的反馈名称
 *
 * @param [type] $feed
 * @return void
 */
function callResult($feed)
{
    switch ($feed) {
        case 0:
            return '跟进中';
            break;
        
        case 1:
            return '有效商机';
            break;
        
        case 2:
            return '号码错误';            
            break;
        
        case 3:
            return '没有需要';                        
            break;
        
        default:
            return '无反馈';            
            break;
    }
}



