@extends('adminlte::page')

@section('title', 'Pacientes')

@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Pacientes</h1>
        </div>
        <div class="col">
            <div class="float-right">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#excludeDate">Cadastrar paciente</button>
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
                                <button type="button" onClick="mudarAction({{$e['id']}})" class="btn btn-danger ml-1 mr-1" data-toggle="modal" data-target="#exampleModal" data-whatever="{{$e['id']}}"><i class="fas fa-trash-alt"></i></button>
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

    <!-- Modal de exclusão de bloqueio -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
                <h3>Deseja realmente excluir esta data de bloqueio?</h3>
            </div>
            <div class="modal-footer">
                <form class="form-teste" id="formulario" action="" method="post">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-success">Sim</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
          </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    function mudarAction(id){
        var route = "excluir-exclusaoagenda/";
        document.getElementById('formulario').action = route + id;
    }
</script>
@stop