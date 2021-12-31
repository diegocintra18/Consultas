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
                    <a href="{{route('patients.index')}}"><span class="btn btn-primary"><i class="fas fa-search"></i> Pesquisar paciente</span></a>
                    <a href="{{route('patients.create')}}"><span class="btn btn-success"><i class="fas fa-user-plus"></i> Cadastrar paciente</span></a>
                    <span class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
                        <i class="far fa-question-circle"></i>  Ajuda
                    </span>
                </div>
            </form>
        @elseif(!isset($schedule))
            <form action="{{ route('schedules.store') }}" method="post" class="p-3">
                @csrf
                <div class="form-group">
                    <a href="{{route('patients.index')}}"><span class="btn btn-info"><i class="fas fa-people-arrows"></i> Alterar paciente</span></a>
                    <a href="{{route('patients.create')}}"><span class="btn btn-success"><i class="fas fa-user-plus"></i> Cadastrar paciente</span></a>
                    <span class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
                        <i class="far fa-question-circle"></i>  Ajuda
                    </span>
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
                            <span class="btn btn-primary" id="verifyDate">Verificar horários disponíveis</span>
                        </div>
                    </div>
                    
                </div>
                <div id="form-horario" class="form-group d-none">
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
                <button type="submit" id="salvar" class="btn btn-success">Salvar</button>
            </form>
        @else
            <form action="{{ route('schedules.update') }}" method="post" class="p-3">
                @csrf
                <span class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
                    <i class="far fa-question-circle"></i>  Ajuda
                </span> 
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
                    <div class="mt-1 mb-3">
                        <span class="badge badge-warning">Data original da consulta: 
                            <?php 
                                $x = strtotime($schedule[0]['schedules_date']);
                                echo date("d/m/Y", $x);
                            ?>
                        </span>
                        <br>
                        <span class="badge badge-warning">Horário original da consulta: {{ $time[0]['available_hour'] }}</span>
                    </div>
                    <div class="col row">
                        <div class="col-4">
                            <input type="text" class="form-control" name="schedules_date" value="<?php  $x = strtotime($schedule[0]['schedules_date']);
                                echo date("d/m/Y", $x);
                            ?>" id="datepicker">
                        </div>
                        <div class="col">
                            <span class="btn btn-primary" id="verifyDate">Verificar horários disponíveis para alteração</span>
                        </div>
                    </div>
                    
                </div>
                <div id="form-horario" class="form-group d-none">
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

                <input type="hidden" name="schedule_id" value="{{ $schedule[0]['id'] }}">

                <button type="submit" id="salvar" class="btn btn-success">Salvar</button>
            </form>
        @endif
    </div>

    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajuda</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>O primeiro passo para agendar uma consulta é selecionar um paciente, para isso você possui 3 opções:</p>
          <ul>
              <li>1 - Pesquisar por um paciente já cadastrado;</li>
              <li>2 - Cadastrar um novo paciente;</li>
              <li>3 - Alterar o paciente selecionado</li>
          </ul>
          <p>Após selecionar o paciente você poderá visualizar os dados dele para confirmar se o paciente selecionado está correto.</p>
          <p>Por fim, agora será necessário escolher a data da consulta, clicar no botão de verificar disponibilidade de horários, após isso selecione o horário da consulta, e clique em Salvar para agendar.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
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

    $('#salvar').addClass('d-none');

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

    // Está função é responsável por fazer com que o campo de horários seja exibido, e bloqueia as datas que já possuem agendamento
    $("#verifyDate").click(function(){
        
        var dateInput = $('#datepicker').val();

        $("#form-horario").removeClass("d-none");
        $('#salvar').removeClass('d-none');

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
            var date = year + "-" + day + "-" + month;

            return date;
        };

        var dateRequest = $.date(dateInput);

        var xhr = new XMLHttpRequest();
        xhr.open("GET", "/verificar-disponibilidade/" + dateRequest , true);
        xhr.send();
        xhr.responseType = "json";
       
        xhr.onload = function(){
            var indisponibility = this.response['data'];

            // Este for verifica se já existem consultas agendadas, se existirem ele desabilita o campo de seleção de horário
            // para evitar que 2 consultas sejam agendadas no mesmo horário
            for (var key in indisponibility) {

                var x = indisponibility[key];
                var time = x['time'];
                var seletor = document.getElementById(time);

                if( seletor ){
                    document.getElementById(time).disabled = true;
                    document.getElementById(time).remove();
                }
                
            }
        }
        
    });
</script>
@stop