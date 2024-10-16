## Descrição do Sistema

O **Mão na Roda** oferece funcionalidades para simplificar o fluxo de trabalho dentro de oficinas mecânicas, tanto para gestores quanto para clientes. O sistema resolve problemas comuns de desorganização e falta de controle, permitindo a geração de orçamentos detalhados, acompanhamento de estoque e comunicação direta com os clientes via WhatsApp.

### Funcionalidades Principais

#### Visão Gestor/Funcionário:

- Cadastro de peças, fornecedores, clientes e serviços.
- Geração de orçamentos detalhados com peças e fotos anexadas.
- Envio de orçamentos em formato PDF via WhatsApp para clientes cadastrados.
- Controle de estoque com atualizações automáticas após a utilização de peças.
- Histórico de orçamentos e serviços prestados para consultas futuras.

#### Visão do Cliente:

- Acompanhamento em tempo real do status do conserto do veículo.
- Recebimento de orçamentos detalhados via WhatsApp.
- Consulta de histórico de serviços e orçamentos anteriores.
- Notificações automáticas sobre prazos e conclusão do serviço.
- Visualização de fotos e detalhes dos reparos realizados.

## Como Executar o Projeto

### Pré-requisitos

- Docker
- Docker Compose

### Passos para execução:

1. Clone o repositório:

   ```
   git clone https://github.com/viniciusciunek/mao-na-roda-backend-utfpr.git
   ```

2. Navegue até o diretório do projeto:

   ```
   cd mao-na-roda-backend-utfpr
   ```

3. Execute o Docker Compose para configurar o ambiente:

   ```
   docker-compose up --build
   ```

4. Acesse o sistema pelo navegador:

   ```
   http://localhost:8000
   ```

5. Para executar os testes automatizados, utilize o PHPUnit com Docker:
   ```
   docker-compose exec app vendor/bin/phpunit
   ```

## Como Contribuir

Contribuições são bem-vindas! Siga os passos abaixo para contribuir com o projeto:

1. Faça um fork deste repositório.
2. Crie uma nova branch com a sua feature:
   ```
   git checkout -b feat/nova-feature
   ```
3. Commit suas alterações:
   ```
   git commit -m 'Adiciona nova feature'
   ```
4. Faça o push para a sua branch:
   ```
   git push origin feat/nova-feature
   ```
5. Abra um Pull Request para revisão.

## Licença

Este projeto está licenciado sob a [MIT License](LICENSE).
