@extends('adminlte::page')

@section('title', 'Pacientes')

@section('content_header')
@stop

@section('content')
    @if(session('error'))
        <div class="col-12">
            <div class="alert alert-danger">
                <strong>{{session('error')}}</strong>
            </div>
        </div>
    @endif
    
    <div class="p-3 bg-white">
        <form method="POST" action="{{ route('patients.store') }}">
            @csrf
            <div class="row">
                <div class="col-5 p-3 border border-secondary">
                    <h2 class="mb-3">Dados Pessoais</h2>
                    <div class="form-group">
                        <label class="form-check-label">Primeiro Nome</label>
                        <input type="textt" class="form-control" id="exampleInputEmail1" name="patient_firstname">
                    </div>
                    <div class="form-group">
                        <label class="form-check-label">Sobrenome</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="patient_lastname">
                    </div>
                    <div class="form-group">
                        <label class="form-check-label">CPF</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="patient_cpf">
                    </div>
                    <div class="form-group">
                        <label class="form-check-label">Celular</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="patient_phone">
                    </div>
                    <div class="form-group">
                        <label class="form-check-label">E-mail</label>
                        <input type="email" class="form-control" id="exampleInputPassword1" name="patient_email">
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label form-check-label">Gênero</label>
                        <div class="col-10">
                            <select class="form-control" id="exampleFormControlSelect1" name="patient_birth_date">
                                <option>Masculino</option>
                                <option>Feminino</option>
                                <option>Não binário</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-5 col-form-label form-check-label">Data de nascimento</label>
                        <div class="col-7">
                            <input type="date" class="form-control" id="exampleInputPassword1" name="patient_birthdate">
                        </div>
                    </div>
                </div>
                <div class="col-5 ml-5 p-3 border border-secondary">
                    <h2 class="mb-3">Endereço</h2>
                    <div class="form-group">
                        <label class="form-check-label" >CEP</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="address_zipcode">
                    </div>
                    <div class="form-group">
                        <label class="form-check-label" >Logradouro</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="adress_name">
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label class="form-check-label" >Número</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" name="address_number">
                        </div>
                        <div class="col">
                            <label class="form-check-label" >Complemento</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" name="address_complement">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-check-label" >Cidade</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="address_city">
                    </div>
                    <div class="form-group row" style="align-items: center;">
                        <label class="col-2 col-form-label form-check-label">UF</label>
                        <div class="col-10">
                            <select class="form-control" id="exampleFormControlSelect1" name="address_uf">
                                <option>AC</option>
                                <option>AL</option>
                                <option>AP</option>
                                <option>AM</option>
                                <option>BA</option>
                                <option>CE</option>
                                <option>DF</option>
                                <option>ES</option>
                                <option>GO</option>
                                <option>MA</option>
                                <option>MT</option>
                                <option>MS</option>
                                <option>MG</option>
                                <option>PA</option>
                                <option>PB</option>
                                <option>PR</option>
                                <option>PE</option>
                                <option>PI</option>
                                <option>RJ</option>
                                <option>RN</option>
                                <option>RS</option>
                                <option>RO</option>
                                <option>RR</option>
                                <option>SC</option>
                                <option>SP</option>
                                <option>SE</option>
                                <option>TO</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Salvar</button>
                </div>
            </div>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <link rel="text/javascript" href="/js/patients.js">
@stop