@extends('layouts.app')

@section('content')

    <h1>タスク新規作成ページ</h1>

    <div class="row">
        <div class="col-6">
            <!--<form method='POST' action='/message/store'>に相当。-->
            {!! Form::model($task, ['route' => 'tasks.store']) !!}

                <div class="form-group">
                    <!--<label></label>に相当。-->
                    {!! Form::label('content', 'タスク:') !!}
                    <!--<input type="text" value='' class='form-contorl'></input>に相当。-->
                    {!! Form::text('content', null, ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('追加', ['class' => 'btn btn-primary']) !!}

            {!! Form::close() !!}
        </div>
    </div>

@endsection

