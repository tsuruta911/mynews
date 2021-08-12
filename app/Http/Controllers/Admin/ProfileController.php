<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでProfile Modelが扱えるようになる
use App\Profile;

class ProfileController extends Controller
{
    //メンタリングテスト
    public function add ()
    {
        return view('admin.profile.create');
    }
    
    public function edit()
    {
        return view('admin.profile.edit');
    }
    
    public function update()
    {
        return redirect('admin/profile/edit');
    }
    
    public function create(Request $request)
    {
             // 以下を追記
      // Varidationを行う
      $this->validate($request, Profile::$rules);
      
      $profiles = new Profile;
      $form = $request->all();
      
       // フォームから送信されてきた_tokenを削除する
       unset($form['_token']);
       
       // データベースに保存する
       $profiles->fill($form);
       $profiles->save();
       
        return redirect('admin/profile/create');
    }
    
    public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = Profile::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのニュースを取得する
          $posts = Profile::all();
      }
      return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }
}
