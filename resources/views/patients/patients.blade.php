@extends('adminlte::page')

@section('title', 'Pacientes')

@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Pacientes</h1>
        </div>
        <div class="col">
            <div class="float-right">
                <a href="{{ route('patients.create') }}">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#excludeDate">Cadastrar paciente</button>
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
    @if(session('message'))
        <div class="col-12">
            <div class="alert alert-success">
                <strong>{{session('message')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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

    <div class="container-fluid bg-white p-3">
        <center>
            <div id="search-container" class="col-6 text-center">
                <form action="{{ route('patients.index') }}" method="get">
                    @csrf
                    <label for="searchPatients">Pesquise pelo nome do Paciente</label>
                    <div class="form-group row">
                        <input type="text" name="searchPatients" class="col form-control" placeholder="Digite o nome do paciente" id="">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Pesquisar</button>
                    </div>
                </form>
            </div>
        </center>
    </div>

    @if ( isset($search) )
        <div class="container bg-white">
            <center>
                <h3>Resultados para a busca:</h3>
            </center>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($search as $p)
                        <tr>
                            <td>{{ $p['patient_firstname']}} {{ $p['patient_lastname'] }}</td>
                            <td>
                                <?php 
                                    $bloco1 = substr($p['patient_cpf'],0,3);
                                    $bloco2 = substr($p['patient_cpf'],3,3);
                                    $bloco3 = substr($p['patient_cpf'],6,3);
                                    $dig_verificador = substr($p['patient_cpf'],-2);
                                    echo $bloco1 . "." . $bloco2 . "." . $bloco3 . "-" . $dig_verificador;
                                ?>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('patients.show', $p['id']) }}"><button type="button" class="btn btn-primary">Editar</button></a>
                                <a href="{{ route('schedules.create', $p['id']) }}"><button type="button" class="btn btn-warning">Agendar Consulta</button></a>
                                <button type="button" onClick="mudarAction({{$p['id']}})" class="btn btn-danger ml-1 mr-1" data-toggle="modal" data-target="#exampleModal" data-whatever="{{$p['id']}}"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @elseif ( isset($patients) )
        <div class="container bg-white">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $p)
                        <tr>
                            <td>{{ $p['patient_firstname']}} {{ $p['patient_lastname'] }}</td>
                            <td>
                                <?php 
                                    $bloco1 = substr($p['patient_cpf'],0,3);
                                    $bloco2 = substr($p['patient_cpf'],3,3);
                                    $bloco3 = substr($p['patient_cpf'],6,3);
                                    $dig_verificador = substr($p['patient_cpf'],-2);
                                    echo $bloco1 . "." . $bloco2 . "." . $bloco3 . "-" . $dig_verificador;
                                ?>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('patients.show', $p['id']) }}"><button type="button" class="btn btn-primary">Editar</button></a>
                                <a href="{{ route('schedules.create', $p['id']) }}"><button type="button" class="btn btn-warning">Agendar Consulta</button></a>
                                <button type="button" onClick="mudarAction({{$p['id']}})" class="btn btn-danger ml-1 mr-1" data-toggle="modal" data-target="#exampleModal" data-whatever="{{$p['id']}}"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Modal de exclusão de bloqueio -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
                <h3>Deseja realmente excluir este paciente?</h3>
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
        var route = "excluir-paciente/";
        document.getElementById('formulario').action = route + id;
    }
</script>
@stop