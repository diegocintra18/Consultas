@extends('adminlte::page')

@section('title', 'Excluir data')

@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Bloquear data</h1>
        </div>
        <div class="col">
            <div class="float-right">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#excludeDate">Nova data de bloqueio</button>
            </div>
        </div>
    </div>
@stop

@section('content')
    @if(session('message'))
        <div class="col-12">
            <div class="alert alert-success">
                <strong>{{session('message')}}</strong>
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

    @if ( isset($exclude) )
        <div class="container bg-white">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Ações</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($exclude as $e)
                        <tr>
                            <td>
                                <?php 
                                    $data = strtotime($e['exclude_date']);
                                    echo date("d/m/Y", $data);
                                ?>
                            </td>
                            <td>
                                <button type="button" id="exclude{{$e['id']}}" class="btn btn-danger ml-1 mr-1" data-toggle="modal" data-target="#confirmExclude"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    
    <!-- Modal cadastro de bloqueio -->
    <div class="modal fade" id="excludeDate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-5">
                    <h4>Selecione a data que deseja bloquear agendamentos:</h4>
                    <form action="{{ route('scheduleexclude.store') }}" method="post">
                        @csrf
                        <input type="date" name="schedule_exclude_date" id="">
                </div>
                <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Model de exclusão de data -->
    <div class="modal fade" id="{{$e['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-5">
                    <h4>Você tem certeza de que deseja realizar a exclusão deste bloqueio de agendamento?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('scheduleexclude.destroy', $e['id']) }}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-success">Confirmar exclusão</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

let = `
    <div class="modal fade" id="confirmExclude" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-5">
                    <h4>Você tem certeza de que deseja realizar a exclusão deste bloqueio de agendamento?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('scheduleexclude.destroy') }}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-success">Confirmar exclusão</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
`;

@stop