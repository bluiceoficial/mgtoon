# MGTOON

<!-- Badge opcional para deixar claro visualmente -->
![Status](https://img.shields.io/badge/status-arquivado--archived-red.svg)

> **Aviso importante:** Está biblioteca foi **oficialmente arquivada** e não receberá mais atualizações, correções de bugs ou suporte para novas versões.

**MGTOON** é uma biblioteca **leve e minimalista escrita em PHP** para trabalhar com arquivos no formato **TOON** (*Text-Oriented Object Notation*), um formato textual simples e humano para armazenamento estruturado de dados tabulares.

Ela foi projetada para oferecer **CRUD completo**, **validação**, **serialização determinística** e **zero dependências**, sendo ideal para **CLIs**, **ferramentas internas**, **projetos embarcados**, **configurações** e **pequenos bancos de dados em texto puro**.

---

## ✨ Características

* Formato de dados simples, legível e versionável
* CRUD completo (`create`, `read`, `update`, `delete`)
* Definição explícita de **chave primária**
* Validação estrutural e semântica do TOON
* Serialização consistente (`toString`)
* Suporte a carregamento e salvamento em arquivos
* Zero dependências externas
* Compatível com **PHP 8.4 ou superior**
* Ideal para substituir CSV, INI ou JSON simples

---

## 📄 Formato TOON

Exemplo de um arquivo TOON:

```text
user[id|name|email]
1|Pedro|pedro@email.com
2|Ana|ana@email.com
````

### Estrutura

```
tipo[campo1|campo2|campo3]
valor1|valor2|valor3
valor1|valor2|valor3
```

* A **primeira linha** define o tipo e os campos
* As linhas seguintes são os registros
* Um campo é definido como **chave primária**

---

## 📦 Instalação

### Via Composer (recomendado)

```bash
composer require mugomes/mgtoon
```

### Manual

Copie o arquivo `MGTOON.php` para o seu projeto e faça a inclusão manual.

---

## 🚀 Uso básico

### Criar uma estrutura TOON

```php
<?php

use MGTOON\MGTOON;

$toon = new MGTOON();

$toon->create('user', ['id', 'name', 'email'], 'id');

$toon->add([
    'id' => 1,
    'name' => 'Pedro',
    'email' => 'pedro@email.com'
]);

$toon->add([
    'id' => 2,
    'name' => 'Ana',
    'email' => 'ana@email.com'
]);

echo $toon->toString();
```

---

## 📂 Trabalhando com arquivos

### Carregar arquivo

```php
$toon = new MGTOON();
$toon->loadFile('users.toon', 'id');
```

### Salvar em arquivo

```php
$toon->saveFile('users.toon');
```

---

## 📖 Leitura de dados

### Ler todos os registros

```php
$records = $toon->read();
```

### Ler por chave primária

```php
$user = $toon->read('1');
```

---

## ✏️ Atualização

```php
$toon->update('1', [
    'email' => 'novo@email.com'
]);
```

* Apenas campos definidos no cabeçalho são atualizados
* Campos inexistentes são ignorados

---

## ❌ Exclusão

```php
$toon->delete('2');
```

---

## 🧪 Validação

É possível validar um conteúdo TOON sem carregá-lo:

```php
$result = $toon->validate($text);

if ($result['valid']) {
    echo 'TOON válido';
} else {
    echo $result['error'];
}
```

### O que é validado?

* Estrutura do cabeçalho
* Quantidade de colunas
* Existência da chave primária
* Duplicidade de valores da chave primária

---

## 🔐 Chave primária

* Definida no momento da criação ou carregamento
* Obrigatória em novos registros
* Não pode conter valores duplicados

```php
$toon->create('product', ['sku', 'name', 'price'], 'sku');
```

---

## 🧠 Casos de uso ideais

* Pequenos bancos de dados locais
* Ferramentas CLI
* Configurações versionáveis
* Dados temporários ou embarcados
* Alternativa simples a CSV/JSON

---

## 👤 Autor

**Murilo Gomes Julio**

🔗 [https://mugomes.github.io](https://mugomes.github.io)

📺 [https://youtube.com/@mugomesoficial](https://youtube.com/@mugomesoficial)

---

## 🤝 Support

* GitHub Sponsors: [https://github.com/sponsors/mugomes](https://github.com/sponsors/mugomes)
* Apoie o projeto: [https://mugomes.github.io/apoie.html](https://mugomes.github.io/apoie.html)

---

## 📜 License

Copyright (c) 2025-2026 Murilo Gomes Julio

Licensed under the [MIT](https://github.com/mugomes/mgtoon/blob/main/LICENSE).

All contributions to the MiTemplate are subject to this license.
