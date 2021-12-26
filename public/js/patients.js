function checkInputs(inputs) {

    var filled = true;
  
    inputs.forEach(function(input) {
    
        if(input.value === "") {
            filled = false;
        }
  
    });
  
  return filled;
  
}

var inputs = document.querySelectorAll("input");
var button = document.querySelector("button");

inputs.forEach(function(input) {
    
  input.addEventListener("keyup", function() {

    if ( checkInputs(inputs )) {
        button.disabled = false;
    } else {
        button.disabled = true;
    }

  });

});

function isValidCPF(cpf) {
    // Validar se é String
    if (typeof cpf !== 'string') return false
    
    // Tirar formatação
    cpf = cpf.replace(/[^\d]+/g, '')
    
    // Validar se tem tamanho 11 ou se é uma sequência de digitos repetidos
    if (cpf.length !== 11 || !!cpf.match(/(\d)\1{10}/)) return false
    
    // String para Array
    cpf = cpf.split('')
    
    const validator = cpf
        // Pegar os últimos 2 digitos de validação
        .filter((digit, index, array) => index >= array.length - 2 && digit)
        // Transformar digitos em números
        .map( el => +el )
        
    const toValidate = pop => cpf
        // Pegar Array de items para validar
        .filter((digit, index, array) => index < array.length - pop && digit)
        // Transformar digitos em números
        .map(el => +el)
    
    const rest = (count, pop) => (toValidate(pop)
        // Calcular Soma dos digitos e multiplicar por 10
        .reduce((soma, el, i) => soma + el * (count - i), 0) * 10) 
        // Pegar o resto por 11
        % 11 
        // transformar de 10 para 0
        % 10
        
    return !(rest(10,2) !== validator[0] || rest(11,1) !== validator[1])
}

$("#patient_cpf").focusout(function(){
     //alert("abriu a função" + this.value);
    if ( isValidCPF(this.value) == true ) {
        $("#patient_cpf").removeClass("is-invalid");
        $("#cpf_feedback").empty();
        $("#patient_cpf").addClass("is-valid");
    } else {
        $("#patient_cpf").addClass("is-invalid");
        $("#cpf_feedback").empty();
        button.disabled = true;
        $("#cpf_feedback").append("O CPF digitado é inválido, verifique os números e digite novamente!");
    }
});

$('#patient_birth_date').focusout(function(){
    var data = new Date();
    var dia = data.getDate();
    var mes = data.getMonth();
    var ano = data.getFullYear();
    var dataCompleta = ano + '-' + mes + '-' + dia;

    if( this.value.getTime() > dataCompleta.getTime() ){
        alert(data1 + ' - ' + data2);
    }
});

$(document).ready(function(){
    $("#address_zipcode").inputmask("99999-999");
    $("#patient_cpf").inputmask("999.999.999-99");
    $("#patient_phone").inputmask("(99) 99999-9999");
});

$("#address_zipcode").focusout(function(){
    
    if ( this.value != "" ){

        var cep = this.value;

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{5}-[0-9]{3}$/;

        if( cep.length > 0 ){

            if( validacep.test(cep) ) {

                $("#address_zipcode").removeClass("is-invalid");
                $("#address_feedback").empty();
                $("#address_zipcode").addClass("is-valid");

                //Início do Comando AJAX
                $.ajax({
                    //O campo URL diz o caminho de onde virá os dados
                    //É importante concatenar o valor digitado no CEP
                    url: 'https://viacep.com.br/ws/'+$(this).val()+'/json/unicode/',
                    //Aqui você deve preencher o tipo de dados que será lido,
                    //no caso, estamos lendo JSON.
                    dataType: 'json',
                    //SUCESS é referente a função que será executada caso
                    //ele consiga ler a fonte de dados com sucesso.
                    //O parâmetro dentro da função se refere ao nome da variável
                    //que você vai dar para ler esse objeto.
                    success: function(resposta){
                        //Agora basta definir os valores que você deseja preencher
                        //automaticamente nos campos acima.
                        $("#adress_name").val(resposta.logradouro);
                        $("#address_complement").val(resposta.complemento);
                        $("#address_district").val(resposta.bairro);
                        $("#address_city").val(resposta.localidade);
                        $("#address_uf").val(resposta.uf);
                        $("#address_number").focus();
                    }
                });

            } else {
                $("#address_zipcode").addClass("is-invalid");
                $("#address_feedback").empty();
                $("#address_feedback").append("O CEP digitado é inválido, verifique os números e digite novamente!");
            }
                
        }

    }
    
});