@extends('adminlte::page')

@section('title', 'Pacientes')

@section('content_header')
    <h2 class="m-3">Cadastro de Pacientes</h2>
@stop

@section('content')
    @if(session('error'))
        <div class="col-12">
            <div class="alert alert-danger">
                <strong>{{session('error')}}</strong>
            </div>
        </div>
    @endif
    
    <div class="p-3">
        <form method="POST" action="{{ route('patients.store') }}">
            @csrf
            <div class="row">
                <div class="col-5 p-3 bg-white border border-secondary">
                    <h2 class="mb-3">Dados Pessoais</h2>
                    <div class="form-group">
                        <label class="form-check-label">Primeiro Nome</label>
                        <input type="textt" class="form-control" id="exampleInputEmail1" name="patient_firstname" placeholder="Ned" size="20" minlength="3" maxlength="20">
                    </div>
                    <div class="form-group">
                        <label class="form-check-label">Sobrenome</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="patient_lastname" placeholder="Stark" size="100" minlength="3" maxlength="100">
                    </div>
                    <div class="form-group">
                        <label class="form-check-label">CPF</label>
                        <input type="text" class="form-control" id="patient_cpf" placeholder="740.718.800-90" name="patient_cpf">
                        <div id="cpf_feedback" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-check-label">Celular</label>
                        <input type="text" class="form-control" id="patient_phone" placeholder="(16)99123-4567" name="patient_phone">
                    </div>
                    <div class="form-group">
                        <label class="form-check-label">E-mail</label>
                        <input type="email" class="form-control" id="exampleInputPassword1" name="patient_email" placeholder="seuemail@email.com" size="120" maxlength="120">
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
                <div class="col-5 ml-5 p-3 bg-white border border-secondary">
                    <h2 class="mb-3">Endereço</h2>
                    <div class="form-group">
                        <label class="form-check-label" >CEP</label>
                        <input type="text" class="form-control" id="address_zipcode" name="address_zipcode" placeholder="14500-123" size="10" maxlength="9">
                        <div id="address_feedback" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-check-label" >Logradouro</label>
                        <input type="text" class="form-control" id="adress_name" name="adress_name" placeholder="Av Brasil" size="200" maxlength="200">
                    </div>
                    <div class="form-group">
                        <label class="form-check-label" >Bairro</label>
                        <input type="text" class="form-control" id="adress_district" placeholder="Jardim das Oliveiras" name="adress_district">
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label class="form-check-label" >Número</label>
                            <input type="text" class="form-control" id="address_number" name="address_number" placeholder="1234" size="5" maxlength="5">
                        </div>
                        <div class="col">
                            <label class="form-check-label" >Complemento</label>
                            <input type="text" placeholder="Casa, apartamento, fundos e etc" class="form-control" id="address_complement" name="address_complement">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-check-label" >Cidade</label>
                        <input type="text" class="form-control" id="address_city" name="address_city" placeholder="Franca" size="30" maxlength="30">
                    </div>
                    <div class="form-group row" style="align-items: center;">
                        <label class="col-2 col-form-label form-check-label">UF</label>
                        <div class="col-10">
                            <select class="form-control" id="address_uf" name="address_uf">
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
                    <button type="submit" class="btn btn-success btn-block" disabled>Salvar</button>
                </div>
            </div>
        </form>
    </div>
    
@stop

@section('css')
@stop

@section('js')
    <script src="/js/jquery.inputmask.js"></script>
    <script src="{{ URL::asset('/js/patients.js') }}"></script>
@stop