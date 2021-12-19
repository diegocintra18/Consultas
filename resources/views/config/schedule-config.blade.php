@extends('adminlte::page')

@section('title', 'Configurações')

@section('content_header')
    <h1>Configurações de Agendamento</h1>
@stop

@section('content')
    @if ( $errors->any() )
        <div class="col-12">
            <div class="alert alert-danger">
                <strong>
                    @foreach ($errors->all() as $error)
                        {{$error}}<br>
                    @endforeach
                </strong>
            </div>
        </div>
    @endif 
    @if(session('error'))
        <div class="col-12">
            <div class="alert alert-danger">
                <strong>{{session('error')}}</strong>
            </div>
        </div>
    @endif
    @if(session('success'))
        <div class="col-12">
            <div class="alert alert-success">
                <strong>{{session('success')}}</strong>
            </div>
        </div>
    @endif
    <div class="container-fluid bg-white p-3">
        <div class="col-6 pt-3">
            @if ( isset($schedule_settings) )
                <form method="POST" action="{{ route('schedule.update') }}">
                    @csrf
                    <div class="card">
                        <div class="card-header bg-info">
                            Jornada de Trabalho
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <span style="width: 35%">Horário de entrada</span>
                                <div class="col">
                                    <input type="time" class="form-control" id="schedule_day_start" name="schedule_day_start" value="{{ $schedule_settings['schedule_day_start'] }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <span style="width: 35%">Saída do almoço</span>
                                <div class="col">
                                    <input type="time" class="form-control" id="schedule_lunch_start" name="schedule_lunch_start" value="{{ $schedule_settings['schedule_lunch_start'] }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <span style="width: 35%">Retorno do almoço</span>
                                <div class="col">
                                    <input type="time" class="form-control" id="schedule_lunch_end" name="schedule_lunch_end" value="{{ $schedule_settings['schedule_lunch_end'] }}">
                                </div>
                            </div>    
                            <div class="form-group row">
                                <span style="width: 35%">Horário de saída</span>
                                <div class="col">
                                    <input type="time" class="form-control" id="schedule_day_end" name="schedule_day_end" value="{{ $schedule_settings['schedule_day_end'] }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header bg-info">
                            Regras de agendamento
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <span>Tempo de duração de uma consulta (em minutos)</span>
                                <input type="number" class="form-control" id="schedule_duration_limitschedule_day_end" name="schedule_duration_limit" value="{{ $schedule_settings['schedule_duration_limit'] }}">
                            </div>
                            <div class="form-group">
                                <span>Intervalo antes de uma consulta (em minutos)</span>
                                <input type="number" class="form-control" id="schdule_before_break" name="schedule_before_break" value="{{ $schedule_settings['schedule_before_break'] }}">
                            </div>
                            <div class="form-group">
                                <span>Intervalo após uma consulta (em minutos)</span>
                                <input type="number" class="form-control" id="schdule_after_break" name="schedule_after_break" value="{{ $schedule_settings['schedule_after_break'] }}">
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-info">
                            Disponibilidade de atendimento
                        </div>
                        <div class="card-body">
                            <div class="form-group form-check">
                                @if ($schedule_settings["schedule_sunday"] == 0) 
                                    <input type="checkbox" class="form-check-input" id="schedule_sunday" name="schedule_sunday">
                                    <label class="form-check-label" for="exampleCheck1">Domingo</label>
                                @else
                                    <input type="checkbox" class="form-check-input" id="schedule_sunday" name="schedule_sunday" checked> 
                                    <label class="form-check-label" for="exampleCheck1">Domingo</label>
                                @endif
                            </div>
                            <div class="form-group form-check">
                                @if ($schedule_settings["schedule_monday"] == 0) 
                                    <input type="checkbox" class="form-check-input" id="schedule_monday" name="schedule_monday">
                                    <label class="form-check-label" for="exampleCheck1">Segunda-feira</label>
                                @else
                                    <input type="checkbox" class="form-check-input" id="schedule_monday" name="schedule_monday" checked>
                                    <label class="form-check-label" for="exampleCheck1">Segunda-feira</label>
                                @endif
                            </div>
                            <div class="form-group form-check">
                                @if ($schedule_settings["schedule_tuesday"] == 0)
                                    <input type="checkbox" class="form-check-input" id="schedule_tuesday" name="schedule_tuesday">
                                    <label class="form-check-label" for="exampleCheck1">Terça-feira</label>
                                @else
                                    <input type="checkbox" class="form-check-input" id="schedule_tuesday" name="schedule_tuesday" checked>
                                    <label class="form-check-label" for="exampleCheck1">Terça-feira</label>
                                @endif
                            </div>
                            <div class="form-group form-check">
                                @if ($schedule_settings["schedule_wednesday"] == 0)
                                    <input type="checkbox" class="form-check-input" id="schedule_wednesday" name="schedule_wednesday"> 
                                    <label class="form-check-label" for="exampleCheck1">Quarta-feira</label>
                                @else
                                    <input type="checkbox" class="form-check-input" id="schedule_wednesday" name="schedule_wednesday" checked> 
                                    <label class="form-check-label" for="exampleCheck1">Quarta-feira</label>
                                @endif
                            </div>
                            <div class="form-group form-check">
                                @if ($schedule_settings["schedule_thursday"] == 0)
                                    <input type="checkbox" class="form-check-input" id="schedule_thursday" name="schedule_thursday">
                                    <label class="form-check-label" for="exampleCheck1">Quinta-feira</label>
                                @else
                                    <input type="checkbox" class="form-check-input" id="schedule_thursday" name="schedule_thursday" checked>
                                    <label class="form-check-label" for="exampleCheck1">Quinta-feira</label>
                                @endif
                            </div>
                            <div class="form-group form-check">
                                @if ($schedule_settings["schedule_friday"] == 0)
                                    <input type="checkbox" class="form-check-input" id="schedule_friday" name="schedule_friday">
                                    <label class="form-check-label" for="exampleCheck1">Sexta-feira</label>
                                @else
                                    <input type="checkbox" class="form-check-input" id="schedule_friday" name="schedule_friday" checked>
                                    <label class="form-check-label" for="exampleCheck1">Sexta-feira</label>
                                @endif
                            </div>
                            <div class="form-group form-check">
                                @if ($schedule_settings["schedule_saturday"] == 0)
                                    <input type="checkbox" class="form-check-input" name="schedule_saturday" id="schedule_saturday">
                                    <label class="form-check-label" for="exampleCheck1">Sábado</label>
                                @else
                                    <input type="checkbox" class="form-check-input" name="schedule_saturday" id="schedule_saturday" checked>
                                    <label class="form-check-label" for="exampleCheck1">Sábado</label>
                                @endif
                            </div>
                            <input type="hidden" name="id" value="{{ $schedule_settings['id'] }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </form>
            @else
                <form method="POST" action="{{ route('schedule.store') }}">
                    @csrf
                    <div class="card">
                        <div class="card-header bg-info">
                            Jornada de Trabalho
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <span style="width: 35%">Horário de entrada</span>
                                <div class="col">
                                    <input type="time" class="form-control" id="schedule_day_start" name="schedule_day_start">
                                </div>
                            </div>
                            <div class="form-group row">
                                <span style="width: 35%">Saída do almoço</span>
                                <div class="col">
                                    <input type="time" class="form-control" id="schedule_lunch_start" name="schedule_lunch_start">
                                </div>
                            </div>
                            <div class="form-group row">
                                <span style="width: 35%">Retorno do almoço</span>
                                <div class="col">
                                    <input type="time" class="form-control" id="schedule_lunch_end" name="schedule_lunch_end">
                                </div>
                            </div>    
                            <div class="form-group row">
                                <span style="width: 35%">Horário de saída</span>
                                <div class="col">
                                    <input type="time" class="form-control" id="schedule_day_end" name="schedule_day_end">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header bg-info">
                            Regras de agendamento
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <span>Tempo de duração de uma consulta (em minutos)</span>
                                <input type="number" class="form-control" value="0" id="schedule_duration_limit" name="schedule_duration_limit">
                            </div>
                            <div class="form-group">
                                <span>Intervalo antes de uma consulta (em minutos)</span>
                                <input type="number" class="form-control" value="0" id="schdule_before_break" name="schedule_before_break">
                            </div>
                            <div class="form-group">
                                <span>Intervalo após uma consulta (em minutos)</span>
                                <input type="number" class="form-control"value="0" id="schdule_after_break" name="schedule_after_break">
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-info">
                            Disponibilidade de atendimento
                        </div>
                        <div class="card-body">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="schedule_sunday" name="schedule_sunday">
                                <label class="form-check-label" for="exampleCheck1">Domingo</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="schedule_monday" name="schedule_monday" checked>
                                <label class="form-check-label" for="exampleCheck1">Segunda-feira</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="schedule_tuesday" name="schedule_tuesday" checked>
                                <label class="form-check-label" for="exampleCheck1">Terça-feira</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="schedule_wednesday" name="schedule_wednesday" checked> 
                                <label class="form-check-label" for="exampleCheck1">Quarta-feira</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="schedule_thursday" name="schedule_thursday" checked>
                                <label class="form-check-label" for="exampleCheck1">Quinta-feira</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="schedule_friday" name="schedule_friday" checked>
                                <label class="form-check-label" for="exampleCheck1">Sexta-feira</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" name="schedule_saturday" id="schedule_saturday">
                                <label class="form-check-label" for="exampleCheck1">Sábado</label>
                            </div>
                        </div>
                        <input type="hidden" name="users_id" value="{{Auth::user()->id}}">
                    </div>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </form>
            @endif
        </div>
    </div>
    
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop