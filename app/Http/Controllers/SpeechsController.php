<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SpeechRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Speech;
use Auth;

class SpeechsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request, Speech $speech)
    {
        if($request->ask){
            $speechs = Speech::where('ask','like','%'.$request->ask.'%')
                ->orWhere('answer','like','%'.$request->ask.'%')
                ->with('user')
                ->orderBy('answer')->paginate(10);
        }else{
            $speechs = Speech::with('user')->orderBy('answer')->paginate(10);
        }
        return view('pages.speech.show',compact('speechs'));
    }

    public function store(SpeechRequest $request)
    {
        $speech = new Speech;
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $speech->fill($data);
		$speech->save();
        return back()->with('success', '标准回答添加完成完成!');
    }
    
    public function update(SpeechRequest $request)
    {
        // 清除销售话术缓存
        Cache::forget('speechs');
        $speech = Speech::find($request->id);
        $speech->fill($request->all());
        $speech->save();
        return back()->with('success', '标准回答修改完成完成!');
    }

    public function destroy(Request $request)
    {
        $speech = Speech::find($request->id);
        $speech->delete();
        return back()->with('success', '标准回答已经删除!');
    }
}
