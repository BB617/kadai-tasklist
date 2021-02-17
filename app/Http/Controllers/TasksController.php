<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $tasks = Task::all();
        
        // return view('tasks.index', [
        //     'tasks' => $tasks,
        //     ]);
        
        $data =[];
        
        if(\Auth::check()){
            $user = \Auth::user();
            
            $tasks = $user->tasks()->paginate(10);
            
            $data = [
                'user' => $user,
                'tasks' => $tasks,
                ];
        }
        
        return view('tasks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;

        // メッセージ作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:255',
            'status' => 'required|max:10',
        ]);
        
        $user = \Auth::user();
        
        // 送られてきたフォームの内容は $request に入っている。
        // メッセージを作成
        $task = new Task;
        $task->content = $request->content;
        $task->status = $request->status;
        $task->user_id = $user->id;
        $task->save();

        // トップページへリダイレクトさせる。
        // （viewを作成する必要はないでしょう。）
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 当該idのレコードをfindOrFailメソッドにて取得し、変数へ代入。
        $task = Task::findOrFail($id);

        // メッセージ詳細ビューでそれを表示
        // message.showのルーティングが走った時、$messageを取得し、viewに渡して表示。
        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // idの値でメッセージを検索して取得
        // 当該idのレコードをfindOrFailメソッドにて取得し、変数へ代入。
        $task = Task::findOrFail($id);

        // メッセージ編集ビューでそれを表示
        // message.editのルーティングが走った時、$messageを取得し、viewに渡して表示。
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:255',
            'status' => 'required|max:10',
        ]);
        
        // idの値でメッセージを検索して取得し、それを変数へ代入。
        $task = Task::findOrFail($id);
        // メッセージを更新
        // リクエストで入力されたデータは、$requestに入っているため、
        // $requestのプロパティ：$request->contentを$message->contentへ代入し差し替え、
        // save()メソッドにて保存。
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();

        // トップページへリダイレクトさせる
        // リダイレクトしているため、viewの作成は不要。
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // idの値でメッセージを検索して取得し、モデルをインスタンスのインスタンスに差し替える。
        $task = Task::findOrFail($id);
        // メッセージを削除
        $task->delete();

        // トップページへリダイレクトさせる
        // リダイレクトりしているため、viewは不要。
        return redirect('/');
    }
}
