Documentação

O projeto não implementado em docker.
usando o 
Laravel 8.83.17
Mysql 5.7.33
PHP 8^

foi utilizado apenas uma biblioteca para download de arquivos em csv.

maatwebsite/excel, já inserida no composer.json

projeto já conta com migrates e seeders

Endpoint's
Todos os metodos retornam um array
caso ocorra um erro retornara um array da seguinte forma
[
    'status'=>'error',
    'message'=>'mensagem referente ao erro'
]

em caso de busca caso não ocorra erro será retornado os dados da busca direto,
em caso de ações será retornadop um array com o status success, e message;

>>Endpoint's Clientes

>Cadastro 
Rota metódo POST, url_base/users/create
enviar no body json com as seguintes informações
[
    'name': 'Marcos exemplo', type=string
    'email': 'exemplo@exemplo.com.br', type=string
    'birthday': '1999-02-01', type=string
]

>Buscar Todos
Rota metódo GET url_base/users/get_all

retornara todos os clientes cadastrados

>Buscar Cliente por id
Rota metódo GET url_base/users/get?id={{ id_cliente }}

Retorna o cliente escolhido.

>Deletar

Rota metódo PUT url_base/users/delete?id={{ id_cliente }}

caso o cliente tenha transações não será possivel deleta-lo.

>Transações do Cliente
Rota metódo GET url_base/users/transactions?id_client={{ id_cliente }}

retorno por order decrescente as transações do cliente escolhido

>Alterar Saldo Inicial
Rota metódo GET url_base/users/alter_balance?id_cliente={{ id_cliente }}&value={{ novo valor }}


>> Transações

>Criar nova Transação 
Rota metódo POST url_base/transactions/create
enviar json no body da requisição com os seguinteas dados
[
    'id_client': 2, type=int
    'type': 'tipo' type=enum
    'amount': '123.3' type=double
]

tipo: deve seguir os três modelos disponiveis.
credito,
debito,
estorno

>Recuperar pelo id
Rota metódo GET url_base/transactions/get?id={{ id_transacao }}

>Cancelar
Rota metódo PUT url/transactions/cancel?id={{ id_transacao }}

>Extrato
gera um arquivo do tipo csv com as transações do cliente,
pode ser utilizado 3 tipos de filtros 
>todas as movimentações enviando somente o id do cliente
>dos ultimos 30 dias enviando &period_days=30 na url após o id do cliente
>mês de referencia enviando &period=22-06 na url após o id do cliente

Rota metódo GET url_base/transactions/extract?id_cliente&period_days=30&period=22-06

**obs: caso o filtro period for enviado junto com o period_days, period_days será desconsiderado na busca,
e só efetuará o filtro do period.

>Balanço
nesta rota você tem acesso a somatória de transações realizadas pelo cliente.
Rota metódo GET url_base/transactions/balance?id={{ id_cliente }}
