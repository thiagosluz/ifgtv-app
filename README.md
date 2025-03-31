# IFG.TV

Sistema de TV Corporativa desenvolvido para o Instituto Federal de Goiás.

## 🚀 Tecnologias

Este projeto foi desenvolvido com as seguintes tecnologias:

- [Laravel](https://laravel.com/)
- [Docker](https://www.docker.com/)
- [Laravel Sail](https://laravel.com/docs/sail)
- JavaScript
- CSS
- Blade Template Engine

## 💻 Pré-requisitos

Antes de começar, verifique se você atende aos seguintes requisitos:
* Docker instalado
* Docker Compose instalado
* Git instalado

## 🎯 Funcionalidades

- Sistema de slides dinâmicos
- Exibição de imagens e textos
- Relógio digital
- Transição automática entre slides
- Suporte a múltiplos templates de apresentação

## 🚀 Instalação

1. Clone o repositório
```bash
git clone [url-do-repositorio]
```

2. Entre no diretório do projeto
```bash
cd ifgtv-app
```

3. Copie o arquivo de ambiente
```bash
cp .env.example .env
```

4. Inicie o Laravel Sail
```bash
./vendor/bin/sail up -d
```

5. Instale as dependências
```bash
./vendor/bin/sail composer install
```

6. Gere a chave da aplicação
```bash
./vendor/bin/sail artisan key:generate
```

7. Execute as migrações
```bash
./vendor/bin/sail artisan migrate
```

## 🔧 Configuração

Para configurar o tempo de transição dos slides, ajuste a variável `slide_time` no arquivo de configuração ou no banco de dados.

## 📝 Uso

Após a instalação, acesse:
```
http://localhost
```

## 🤝 Contribuindo

Contribuições são sempre bem-vindas! Para contribuir:

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📫 Contato

[Thiago Luz/IFG] - [thiago.silva@ifg.edu.br]

## 📝 Licença

Este projeto está sob a licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.
