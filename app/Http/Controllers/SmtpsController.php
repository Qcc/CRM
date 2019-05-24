<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Smtp;
use App\Models\Template;
use Auth;

class SmtpsController extends Controller
{
    public function store(Request $request, Smtp $smtp)
    {
        $smtp->fill($request->all());
        $smtp->user_id = Auth::id();
        $smtp->save();
        return back()->with('success', 'SMTP服务器新增成功!');
    }

    public function edit(Request $request, Smtp $smtp)
    {
        $smtp->find($request->id)->update($request->all());
        
        return back()->with('success', 'SMTP服务器修改成功!');
    }

    public function destroy(Request $request, Smtp $smtp)
    {
        $smtp->find($request->id)->delete();
        return back()->with('success', 'SMTP服务器删除成功!');
    }

    // 邮件模版增删改查
    public function TplStore(Request $request, Template $template)
    {
        $template->fill($request->all());
        $template->user_id = Auth::id();
        $template->save();
        return back()->with('success', '邮件模版新增成功!');
    }

    public function TplEdit(Request $request, Template $template)
    {
        $template->find($request->id)->update($request->all());
        
        return back()->with('success', '邮件模版修改成功!');
    }

    public function TplDestroy(Request $request, Template $template)
    {
        $template->find($request->id)->delete();
        return back()->with('success', '邮件模版删除成功!');
    }
}
