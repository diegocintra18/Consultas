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

    <div class="container-fluid bg-white">
        @if(!isset($patient))
            <form action="" method="post" class="p-3">
                <div class="form-group">
                    <p>1º passo: pesquise ou cadastre um paciente através dos botões abaixo:</p>
                    <p>2º passo: agende um horário de acordo com a disponibilidade de agendamento.</p>
                    <a href="{{route('patients.index')}}"><span class="btn btn-primary">Pesquisar paciente</span></a>
                    <a href="{{route('patients.create')}}"><span class="btn btn-success">Cadastrar paciente</span></a>
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
                        <label for="disabledTextInput">Gênero</label>
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
                <div class="form-group">
                    <label for="schedule_date">Data da consulta</label><br>
                    <div class="col-4">
                        <input type="text" class="form-control" id="datepicker">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col col-form-label" for="schedule_hour">Horário da consulta</label>
                    <div class="col-4">
                        <select class="form-control" id="schedule_hour" name="schedule_hour">
                            <?php
                                foreach ($available as $a){
                                    echo "<option>" . $a['available_hour'] . "</option>";
                                }
                            ?>
                        </select>
                        
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Salvar</button>
            </form>
        @else
            <form action="{{ route('schedules.store') }}" method="post" class="p-3">
                @csrf
                <div class="form-group">
                    <p>1º passo: pesquise ou cadastre um paciente através dos botões abaixo:</p>
                    <p>2º passo: agende um horário de acordo com a disponibilidade de agendamento.</p>
                    <a href="{{route('patients.index')}}"><span class="btn btn-info">Alterar paciente</span></a>
                    <a href="{{route('patients.create')}}"><span class="btn btn-success">Cadastrar paciente</span></a>
                </div>       
                <div class="form-group">
                    <label for="disabledTextInput">Nome</label>
                    <input type="hidden" name="idPatient" value="{{ $patient[0]['id'] }}">
                    <input type="text" id="disabledTextInput" class="form-control" value="{{ $patient[0]['patient_firstname'] }} {{ $patient[0]['patient_lastname'] }}" disabled>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="disabledTextInput">CPF</label>
                        <input type="text" id="disabledTextInput" class="form-control" id="patient_cpf" 
                        <?php 
                            $bloco1 = substr($patient[0]['patient_cpf'],0,3);
                            $bloco2 = substr($patient[0]['patient_cpf'],3,3);
                            $bloco3 = substr($patient[0]['patient_cpf'],6,3);
                            $dig_verificador = substr($patient[0]['patient_cpf'],-2);
                            echo 'value="' . $bloco1 . "." . $bloco2 . "." . $bloco3 . "-" . $dig_verificador . '"';
                        ?> disabled>
                    </div>
                    <div class="col">
                        <label for="disabledTextInput">Data de Nascimento</label>
                        <input type="date" id="disabledTextInput" class="form-control" value="{{ $patient[0]['patient_birth_date']}}" disabled>
                    </div>
                    <div class="col">
                        <label for="disabledTextInput">Gênero</label>
                        <input type="text" id="disabledTextInput" class="form-control" <?php if($patient[0]['patient_gender'] == 0){ echo 'value="Masculino"'; } elseif($patient[0]['patient_gender'] == 1){ echo 'value="Feminino"';} else{ echo 'value="Não binário"'; }?> disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col">
                        <label for="disabledTextInput">E-mail</label>
                        <input type="text" id="disabledTextInput" class="form-control" value="{{ $patient[0]['patient_email'] }}" disabled>
                    </div>
                    <div class="col">
                        <label for="disabledTextInput">Telefone</label>
                        <input type="text" id="disabledTextInput" class="form-control" value="{{ $patient[0]['patient_phone'] }}" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <h4 class="mt-4 mb-3">Disponibilidade de agendamento</h4>
                </div>
                <div class="form-group">
                    <label for="schedule_date">Data da consulta</label><br>
                    <div class="col row">
                        <div class="col-4">
                            <input type="text" class="form-control" name="schedules_date" id="datepicker">
                        </div>
                        <div class="col">
                            <span class="btn btn-info" id="verifyDate">Verificar horários disponíveis</span>
                        </div>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="col col-form-label" for="schedule_hour">Horário da consulta</label>
                    <div class="col-4">
                        <select class="form-control" id="schedule_hour" name="schedule_hour">
                            <?php
                                foreach ($available as $b => $a){
                                    echo '<option id="' . $a['available_hour'] . '" value="' . $a['available_hour'] .'" >';
                                    echo $a['available_hour'] . "</option>";
                                }
                            ?>
                        </select>
                        
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Salvar</button>
            </form>
        @endif
    </div>

    <?php

        $day = $disponibility[0]['schedule_disponibility'];
        $excludeDays = "";
        $days = "";

        if ( $day[0]['schedule_sunday'] == 0) { $days .= '[Domingo],'; }
        if ( $day[0]['schedule_monday'] == 0) { $days .=  '[Segunda],'; }
        if ( $day[0]['schedule_tuesday'] == 0) { $days .=  '[Terça],'; }
        if ( $day[0]['schedule_wednesday'] == 0) { $days .=  '[Quarta],'; }
        if ( $day[0]['schedule_thursday'] == 0) { $days .= '[Quinta],'; }
        if ( $day[0]['schedule_friday'] == 0) { $days .= '[Sexta],'; }
        if ( $day[0]['schedule_saturday'] == 0) { $days .= '[Sábado],'; }

        foreach ($exclude as $e) {
            $date = $e['exclude_date'];
            $timestamp = strtotime($date);
            $newDate = date("m,d,Y", $timestamp);
            $excludeDays .= '['.$newDate.'],';
        }

    ?>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script  src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script>
    //Função responsável por fazer a exclusão de datas que não possuem agendamento disponível
    function nonWorkingDates(date){
        var day = date.getDay(), Domingo = 0, Segunda = 1, Terça = 2, Quarta = 3, Quinta = 4, Sexta = 5, Sábado = 6;
        var closedDates = [ {{$excludeDays }} ];
        var closedDays = [ {{$days}} ];
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
    
    //Tradução e criação do datepicker usando a função de exclusão de datas
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

    $("#verifyDate").click(function(){
        
        var dateInput = $('#datepicker').val();

        $.date = function(dateObject) {
            var d = new Date(dateObject);
            var day = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            if (day < 10) {
                day = "0" + day;
            }
            if (month < 10) {
                month = "0" + month;
            }
            var date = year + "-" + month + "-" + day;

            return date;
        };

        var dateRequest = $.date(dateInput);


        var xhr = new XMLHttpRequest();
        xhr.open("GET", "/teste/" + dateRequest , true);
        xhr.send();
        xhr.responseType = "json";
       
        xhr.onload = function(){
            var indisponibility = this.response['data'];
            console.log(indisponibility);

            for (var key in indisponibility) {
                //console.log(indisponibility[key]);
                
                //$select = document.getElementById('schedule_hour');

                var x = indisponibility[key];
                var time = x['time'];

                //console.log("valor: " + time['time']);

                var seletor = '#' + time;

                console.log(seletor);

                if( $(seletor) ){
                    $(seletor).prop('disabled', 'disabled');
                }
                
            }
        }

        // $.ajax({
        //     url: "/teste/",
        //     type: "get",
        //     success: function(response){
        //         console.log(response);
        //     }
        // });
        
    });

</script>
@stop