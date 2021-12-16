@extends('adminlte::page')

@section('title', 'Configurações')

@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Configurações de Agendamento</h1>
        </div>
        <div class="col">
            <div class="float-right">
                <a href="/cadastro-configuracoes">
                    <button type="button" class="btn btn-success">Adicionar regras de agendamento</button>
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <pre>
        <?php 
            var_dump($schedule_settings);
        ?>
    </pre>
    @if( isset($schedule_settings))
        @foreach ( $schedule_settings as $schedule )
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
            </tbody>
        </table>
        @endforeach
    @else

    @endif
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop