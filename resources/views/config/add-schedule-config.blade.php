@extends('adminlte::page')

@section('title', 'Configurações')

@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Configurações de Agendamento</h1>
        </div>
        <div class="col">
            <div class="float-right">
                <a href="{{ route('schedule.create') }}">
                    <button type="button" class="btn btn-success">Adicionar regras de agendamento</button>
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="bg-white">
    @if(session('message'))
        <div class="col-12">
            <div class="alert alert-success">
                <strong>{{session('message')}}</strong>
            </div>
        </div>
    @endif
    @if( isset($schedule_settings))
        <div class="table-responsive mt-5 text-center">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Entrada</th>
                        <th scope="col">Saída do Almoço</th>
                        <th scope="col">Retorno do Almoço</th>
                        <th scope="col">Saída</th>
                        <th scope="col">Duração da consulta</th>
                        <th scope="col">Dias da semana</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $schedule_settings as $schedule )
                        <tr>
                            <td>{{$schedule["schedule_day_start"]}}</td>
                            <td>{{$schedule["schedule_lunch_start"]}}</td>
                            <td>{{$schedule["schedule_lunch_end"]}}</td>
                            <td>{{$schedule["schedule_day_end"]}}</td>
                            <td>{{$schedule["schedule_duration_limit"]}} minutos</td>
                            <td>
                                @if( $schedule["schedule_sunday"] == 1 )
                                    Domingo<br>
                                @endif
                                @if ( $schedule["schedule_monday"] == 1 )
                                    Segunda<br>
                                @endif
                                @if ( $schedule["schedule_tuesday"] == 1 )
                                    Terça<br>
                                @endif
                                @if ( $schedule["schedule_wednesday"] == 1 )
                                    Quarta<br>
                                @endif
                                @if ( $schedule["schedule_thursday"] == 1 )
                                    Quinta<br>
                                @endif
                                @if ( $schedule["schedule_friday"] == 1 )
                                    Sexta<br>
                                @endif
                                @if ( $schedule["schedule_saturday"] == 1 )
                                    Sábado<br>
                                @endif
                            </td>
                            <td>
                                <div class="row">
                                    <a href="{{ route('schedule.show', $schedule['id']) }}"><button type="button" class="btn btn-primary ml-1 mr-1">Editar</button></a>
                                    <button type="button" class="btn btn-danger ml-1 mr-1" data-toggle="modal" data-target="#confirmExclude{{$schedule['id']}}"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="confirmExclude{{$schedule['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-5">
                                        <h4>Você tem certeza de que deseja realizar a exclusão desta regra de agendamento?</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('schedule.destroy', $schedule['id']) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-success">Confirmar exclusão</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
       
    @else

    @endif
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop