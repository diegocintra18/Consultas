@extends('adminlte::page')

@section('title', 'Agendar Consulta')

@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Agendar Consulta</h1>
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

    @if ( isset($patients) )
    @endif

    <div class="container-fluid bg-white">
        <form action="" method="post" class="p-3">
            <div class="form-group">
                <p>1º passo: pesquise ou cadastre um paciente através dos botões abaixo:</p>
                <p>2º passo: agende um horário de acordo com a disponibilidade de agendamento.</p>
                <button class="btn btn-primary">Pesquisar paciente</button>
                <button class="btn btn-success">Cadastrar paciente</button>
            </div>       
            <div class="form-group">
                <label for="disabledTextInput">Nome</label>
                <input type="text" id="disabledTextInput" class="form-control" disabled>
            </div>
            <div class="form-group row">
                <div class="col">
                    <label for="disabledTextInput">CPF</label>
                    <input type="text" id="disabledTextInput" class="form-control" disabled>
                </div>
                <div class="col">
                    <label for="disabledTextInput">Data de Nascimento</label>
                    <input type="date" id="disabledTextInput" class="form-control" disabled>
                </div>
                <div class="col">
                    <label for="disabledTextInput">Gênero   </label>
                    <input type="text" id="disabledTextInput" class="form-control" disabled>
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <label for="disabledTextInput">E-mail</label>
                    <input type="text" id="disabledTextInput" class="form-control" disabled>
                </div>
                <div class="col">
                    <label for="disabledTextInput">Telefone</label>
                    <input type="text" id="disabledTextInput" class="form-control" disabled>
                </div>
            </div>
            <div class="form-group">
                <h4 class="mt-4 mb-3">Disponibilidade de agendamento</h4>
            </div>
            <div class="form-group row">
                <div class="col">
                    <label for="schedule_date">Data da consulta</label>
                    <input type="text" id="datepicker"></p>
                </div>
                <div class="col">
                    <label for="schedule_hour">Horário da consulta</label>
                    <input type="time" name="schedule_hour" id="schedule_hour">
                </div>
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
        </form>
    </div>
    <pre>
        {{var_dump($disponibility)}}
        <?php
            $day = $disponibility[0]['schedule_disponibility'];
            $days = "";
            if ( $day[0]['schedule_sunday'] == 0) { $days .= '[Domingo],'; }
            if ( $day[0]['schedule_monday'] == 0) { $days .=  '[Segunda],'; }
            if ( $day[0]['schedule_tuesday'] == 0) { $days .=  '[Terça],'; }
            if ( $day[0]['schedule_wednesday'] == 0) { $days .=  '[Quarta],'; }
            if ( $day[0]['schedule_thursday'] == 0) { $days .= '[Quinta],'; }
            if ( $day[0]['schedule_friday'] == 0) { $days .= '[Sexta],'; }
            if ( $day[0]['schedule_saturday'] == 0) { $days .= '[Sábado],'; }
        ?>
    </pre>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script  src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"  integrity="sha256-xH4q8N0pEzrZMaRmd7gQVcTZiFei+HfRTBPJ1OGXC0k="  crossorigin="anonymous"></script>
<script>

    function nonWorkingDates(date){
        var day = date.getDay(), Domingo = 0, Segunda = 1, Terça = 2, Quarta = 3, Quinta = 4, Sexta = 5, Sábado = 6;
        var closedDates = [[12, 31, 2021], [1, 20, 2022]];
        //var closedDays = [[Domingo], [Sábado]];
        var closedDays = [ <?php echo $days; ?> ];
        for (var i = 0; i < closedDays.length; i++) {
            if (day == closedDays[i][0]) {
                return [false];
            }
        }

        for (i = 0; i < closedDates.length; i++) {
            if (date.getMonth() == closedDates[i][0] - 1 &&
            date.getDate() == closedDates[i][1] &&
            date.getFullYear() == closedDates[i][2]) {
                return [false];
            }
        }

        return [true];
    }
    
    $( function() {
        $('#datepicker').datepicker({
            dateFormat: 'dd/mm/yy',
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            nextText: 'Proximo',
            prevText: 'Anterior',
            minDate: new Date(),
            beforeShowDay: nonWorkingDates
        });
    });

</script>
@stop