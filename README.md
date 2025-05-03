<p align="center"><a href="https://codehub.geanbressan.com.br" target="_blank"><img src="./public/images/codehub-logo.png" width="400" alt="CodeHub Logo"></a></p>

![GitHub repo size](https://img.shields.io/github/repo-size/GeanBressan/codehub)
![GitHub last commit](https://img.shields.io/github/last-commit/GeanBressan/codehub)
![GitHub issues](https://img.shields.io/github/issues/GeanBressan/codehub)
![GitHub contributors](https://img.shields.io/github/contributors/GeanBressan/codehub)

![Made with Laravel](https://img.shields.io/badge/Made%20with-Laravel-red?style=for-the-badge&logo=laravel)
![Made with PHP](https://img.shields.io/badge/Made%20with-PHP-blue?style=for-the-badge&logo=php)

# 📚 CodeHub

Plataforma de blog feita em Laravel, focada em compartilhar posts e artigos de programação de forma simples e moderna.  
Este projeto foi desenvolvido com o objetivo de aprender Laravel e Git na prática, enquanto construía algo funcional e real.

## 🚀 Tecnologias utilizadas

* PHP 8.4
* Laravel 12
* sqlite
* TailwindCSS
* Git

## 📦 Como rodar o projeto

1. Clone o repositório:

```
git clone https://github.com/GeanBressan/codehub.git
```

2. Instale as dependências:

```
composer install
npm install
npm run dev
```

3. Copie o arquivo .env.example para .env e configure as variáveis:

```
cp .env.example .env
```

4. Gere a chave do aplicativo:

```
php artisan key:generate
```

5. Rode as migrations e seeders (opcional):

```
php artisan migrate --seed
```

6. Inicie o servidor:

```
php artisan serve
```

## 🛠 Funcionalidades principais

* Cadastro de posts
* Sistema de categorias e tags
* Upload de imagens
* Tela de login e registro de usuários
* Página inicial com listagem de posts
* Pesquisa por categorias e tags

## 🎯 Melhorias futuras

* Sistema de comentários
* Sistema de curtidas nos posts
* Sistema de Follow entre os usuarios
* Sistema de salvar postagens

## 👨‍💻 Autor

<p align="center">
  <img src="https://avatars.githubusercontent.com/u/53577897" width="100" height="100" style="border-radius: 8px;" alt="Gean Bressan"/>
</p>

<p align="center">
  <b>Gean Bressan</b><br>
  <a href="https://github.com/GeanBressan">GitHub</a>
</p>