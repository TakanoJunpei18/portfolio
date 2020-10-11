<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\output;
use App\History;
use Carbon\Carbon;

class outputController extends Controller
{
  public function add()
  {
      return view('admin.output.create');
  }
  public function create(Request $request)
  {
      
         // 以下を追記
      // Varidationを行う
      $this->validate($request, output::$rules);

      $output = new output;
      $form = $request->all();

      // フォームから画像が送信されてきたら、保存して、$output->image_path に画像のパスを保存する
      if (isset($form['image'])) {
        $path = $request->file('image')->store('public/image');
        $output->image_path = basename($path);
      } else {
          $output->image_path = null;
      }

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);

      // データベースに保存する
      $output->fill($form);
      $output->save();
      
      // admin/output/createにリダイレクトする
      return redirect('admin/output/create'); 
  }
 
 
  // 以下を追記
  public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = output::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのoutputを取得する
          $posts = output::all();
      }
      return view('admin.output.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }


public function edit(Request $request)
  {
      // News Modelからデータを取得する
      $news = output::find($request->id);
      if (empty($output)) {
        abort(404);    
      }
      return view('admin.output.edit', ['output_form' => $output]);
  }


  public function update(Request $request)
  {
       // Validationをかける
      $this->validate($request, output::$rules);
       // News Modelからデータを取得する
      $output = output::find($request->id);
         // 送信されてきたフォームデータを格納する
      $output_form = $request->all();
      
      if ($request->remove == 'true') {
        $output_form['image_path'] = null;
        
      } elseif ($request->file('image')) {
        $path = $request->file('image')->store('public/image');
        $output_form['image_path'] = basename($path);
        
      } else {
        $output_form['image_path'] = $output->image_path;
        
      }
      unset($output_form['_token']);
      unset($output_form['image']);
      unset($output_form['remove']);
      $output->fill($output_form)->save();
      
      $history = new History;
      $history->output_id = $output->id;
      $history->edited_at = Carbon::now();
      $history->save();
      
      return redirect('admin/output');
    
  }
  public function delete(Request $request)
  {
     // 該当するNews Modelを取得
    $output= output::find($request->id);
     // 削除する
    $output->delete();
    
    return redirect('admin/output/create');
    
  }
  
}

?>
