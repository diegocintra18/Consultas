#Requisitos do Ambiente

- Instale o Docker na versão mais recente através do link: https://www.docker.com/get-started
- Instale uma ferramenta de testes de requisições REST para realizar consultas na API, como o Postman por exemplo.


#Execução da aplicação
Para startar o docker e rodar a aplicação execute o comando de terminal use o comando: ./vendor/bin/sail up

Após o primeiro build da aplicação você poderá criar um alias para que não seja mais necessário executar este comando toda vez que desejar iniciar o servidor, para isso execute no terminal este comando: alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
Quando o alias é criado, para iniciar o servidor basta executar o comando de terminal: sail up.


Após criar este alias você poderá executar comandos Artisan conforme o exemplo à seguir:
sail artisan queue:work


#Banco de Dados
Na primeira execução do projeto será necessário executar um comando de terminal no container ativo do Laravel para as migrations criarem as tabelas do banco de dados, este comando é: sail artisan migrate