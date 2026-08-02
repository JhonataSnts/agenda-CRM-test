# Agenda de Contatos

CRUD simples de agenda de contatos feito em PHP puro e MySQL.

## Requisitos

- PHP
- MySQL
- Laragon, XAMPP ou ambiente parecido

## Como rodar

1. Coloque o projeto na pasta do servidor local.

Exemplo no Laragon:

```text
C:\laragon\www\agenda-contatos
```

2. Crie o banco e as tabelas executando o arquivo:

```text
database/schema.sql
```

3. Confira a conexão em:

```text
config/database.php
```

Configuração usada no Laragon:

```text
host: localhost
banco: agenda_contatos
usuario: root
senha: vazia
```

4. Acesse no navegador:

```text
http://agenda-contatos.test
```

ou:

```text
http://localhost/agenda-contatos
```

## Funcionalidades

- listar contatos
- cadastrar contato
- editar contato
- excluir contato
- pesquisar por nome
- pesquisar por telefone
- pesquisar por cidade
- pesquisar por estado

