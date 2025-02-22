## Mão na Roda

O Mão na Roda oferece funcionalidades para simplificar o fluxo de trabalho dentro de oficinas mecânicas, tanto para gestores quanto para clientes. O sistema resolve problemas comuns de desorganização e falta de controle, permitindo a geração de orçamentos detalhados, acompanhamento de estoque e comunicação direta com os clientes via WhatsApp.

## Dependências

- Docker
- Docker Compose

## Como executar o projeto

### Clonar o repositório
```
$ git clone https://github.com/viniciusciunek/mao-na-roda-backend-utfpr

$ cd mao-na-roda-backend-utfpr
```

### Definir as variáveis de ambiente
```
$ cp .env.example .env
```


### Instalar as Dependências

```
$ ./run composer install
```

### Modifica permissões de pastas para upar imagens.

```
sudo chown www-data:www-data public/assets/uploads
```

### Subir os contêineres

```
$ ./run up -d
```

ou


```
$ docker compose up -d
```

### Criar banco de dados e tabelas

```
$ ./run db:reset
```

### Popular banco de dados

```
$ ./run db:populate
```

### Rodar os testes

```
$ ./run tests
```
ou

```
$ docker compose run --rm php ./vendor/bin/phpunit tests --color
```

### Rodar os linters

[PHPCS](https://github.com/PHPCSStandards/PHP_CodeSniffer/)
```
$ ./run phpcs
```


[PHPStan](https://phpstan.org/)

```
$ ./run phpstan
```


 Acesse em [localhost](http://localhost)


## Testar retorno da API

```
curl -H "Accept: application/json" localhost/pages/products/index.php
```
