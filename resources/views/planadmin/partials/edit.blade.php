{!! Form::model($model, ['route' => 'plan_edit','method' => 'POST']) !!}
{!! Form::hidden('hidden_id', $model->id, ['id' => 'hidden_id']); !!}
    <div class="form-group">
        <label for="" class="control-label">Name</label>
        {!! Form::text('name', $model->customer->name, ['disabled','class' => 'form-control', 'id' => 'name']) !!}
    </div>

    <div class="form-group">
        <label for="" class="control-label">Alamat</label>
        {!! Form::text('alamat', $model->customer->alamat, ['disabled','class' => 'form-control', 'id' => 'alamat']) !!}
    </div>

    <div class="form-group">
        <label for="ketPlan" class="control-label">Keperluan</label>
        {!! Form::textarea('ketPlan', $model->keterangan, ['rows' => '7','required','class' => 'form-control', 'id' => 'ketPlan']) !!}
    </div>

{!! Form::close() !!}