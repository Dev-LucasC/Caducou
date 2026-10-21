# Caducou — infraestrutura persistente do preview (MVP 2)

**Status:** preparação técnica concluída, provisionamento pendente de conexão/autorização dos provedores. **Não alterar `main` ou promover a produção.**

## Situação inicial verificada (2026-10-21)

- Projeto Vercel: `caducou` (workspace `devlucascs-projects-9b869b66`).
- Nenhuma integração marketplace de PostgreSQL anexada.
- Preview existente da branch `chore/vercel-laravel-preview`: `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`, `SESSION_DRIVER=cookie`, `CACHE_STORE=array`, `MAIL_MAILER=log`.
- Auth implementada na branch `spec/mvp-auth-security` e testada isoladamente, mas ainda **não homologada contra banco persistente**.

## 1. Provedores propostos (necessita conexão/aceite do proprietário)

1. **Neon PostgreSQL** para banco persistente de homologação; projeto de desenvolvimento isolado da futura produção. Conectar a conta/autorizar a criação pelo plugin Neon (ou interface oficial, se preferir).
2. **Resend SMTP** para verificação/reset de senha, com domínio de envio que você controla e verifica via DNS. A chave deve ser específica do ambiente de preview.
3. Confirmar limites do plano e custos antes de aprovar qualquer cobrança. Não provisionar um plano pago automaticamente.

## 2. Variáveis de ambiente Vercel: somente Preview, escopo exato da branch

Os valores abaixo são **nomes/configuração**, não credenciais. As credenciais verdadeiras devem ficar nas variáveis *Encrypted/Sensitive* do painel Vercel. Não colocar URLs com senha em GitHub, PR, logs ou chat.

| Variável | Valor esperado |
|---|---|
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | URL HTTPS **real** do preview usado para receber links de e-mail |
| `APP_KEY` | Chave criptográfica estável do Laravel (manter a atual somente no escopo apropriado; nunca divulgar) |
| `DB_CONNECTION` | `pgsql` |
| `DB_HOST` | Host Neon **pooled** para tráfego da aplicação |
| `DB_PORT` | `5432` |
| `DB_DATABASE` | Nome do banco de homologação |
| `DB_USERNAME` | Usuário dedicado de menor privilégio |
| `DB_PASSWORD` | Segredo do banco |
| `DB_SSLMODE` | `require` |
| `DB_URL` | **Não definir** junto de DB_HOST e demais campos, para evitar sobreposição |
| `SESSION_DRIVER` | `database` |
| `CACHE_STORE` | `database` (inclui rate limit entre instâncias) |
| `QUEUE_CONNECTION` | `sync` temporariamente, até existir worker persistente |
| `SESSION_SECURE_COOKIE` | `true` |
| `SESSION_SAME_SITE` | `lax` |
| `TRUSTED_PROXIES` | `*` apenas neste runtime atrás da borda Vercel |
| `LOG_CHANNEL` | `stderr` |
| `VIEW_COMPILED_PATH` | `/tmp` |
| `APP_CONFIG_CACHE` | `/tmp/caducou-config.php` |
| `APP_EVENTS_CACHE` | `/tmp/caducou-events.php` |
| `APP_PACKAGES_CACHE` | `/tmp/caducou-packages.php` |
| `APP_ROUTES_CACHE` | `/tmp/caducou-routes.php` |
| `APP_SERVICES_CACHE` | `/tmp/caducou-services.php` |
| `MAIL_MAILER` | `smtp` |
| `MAIL_SCHEME` | `smtps` |
| `MAIL_HOST` | `smtp.resend.com` |
| `MAIL_PORT` | `465` |
| `MAIL_USERNAME` | `resend` |
| `MAIL_PASSWORD` | Chave SMTP/API do Resend, armazenada como segredo |
| `MAIL_FROM_ADDRESS` | Endereço em domínio de envio verificado, p.ex. `no-reply@SEU-DOMINIO` |
| `MAIL_FROM_NAME` | `Caducou` |

**Atenção:** a Vercel tem variáveis de preview vinculadas a branches. As da branch `chore/vercel-laravel-preview` não se aplicam automaticamente à branch `chore/mvp-postgres-smtp-preview`. Definir um único ambiente canônico de homologação antes do deploy.

## 3. Migrations, segurança e rollback

- Executar `php artisan migrate --force` **uma única vez** num executor PHP externo/efêmero autorizado, usando o endpoint **direto (sem pooler)** do banco Neon. Não executar no build nem em cada função HTTP.
- Antes da primeira migration: verificar banco destino; em upgrades, tirar snapshot/backup e revisar diff. Não apontar migrations ao banco de produção por engano.
- O schema Laravel atual já inclui `users`, `password_reset_tokens`, `sessions`, `cache` e `cache_locks`. O comando de checagem `php artisan caducou:infra-check` é **somente leitura**.
- Não usar `:memory:` ou filesystem volátil para dados do usuário.
- Para rollback, preferir restore do snapshot do banco de homologação e rollback do deploy, sem excluir registros reais às cegas.
- Não inserir dados de clientes reais antes do teste de autorização por credor, consentimento e LGPD.

## 4. Critérios de aceite

1. `php artisan caducou:infra-check` retorna código 0 e não divulga host/senha/token.
2. Migrations estão aplicadas em PostgreSQL (sem erros), SSL obrigatório.
3. Cadastro + verificação de e-mail com domínio verificado persistem em requisições/instâncias distintas.
4. Login correto autenticado, credenciais inválidas limitadas por cache compartilhado; logout invalida sessão.
5. Link de recuperação válido uma vez, expira; e-mail de solicitação neutro não enumera contas.
6. Rotas internas exigem login + e-mail verificado, sem acesso cruzado.
7. Compilação Vue/Vite e testes Laravel passam.
8. Preview protegido por autenticação da Vercel até revisão final.

## 5. Dependências não concluídas

- Conectar/autorizar Neon na conta de propriedade do projeto e provisionar DB **de preview**.
- Configurar Resend com domínio de envio verificado e chave própria.
- Inserir segredos no ambiente Vercel da branch de homologação; testar conectividade e aplicar migrations.
- Aprovar testes ponta a ponta e revisão de custos/backup antes da ativação.

## Fontes do provedor
- Neon: https://neon.com/docs/get-started-with-neon/workflow-primer
- Resend SMTP: https://resend.com/changelog/smtp-service
