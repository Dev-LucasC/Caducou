# Caducou — infraestrutura persistente do preview (MVP 2)

**Status:** preparação técnica concluída, provisionamento pendente de conexão/autorização dos provedores. **Não alterar `main` ou promover a produção.**

## Situação inicial verificada (2026-10-21)

- Projeto Vercel: `caducou` (workspace `devlucascs-projects-9b869b66`).
- Nenhuma integração marketplace de PostgreSQL anexada.
- Preview existente da branch `chore/vercel-laravel-preview`: `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`, `SESSION_DRIVER=cookie`, `CACHE_STORE=array`, `MAIL_MAILER=log`.
- Auth implementada na branch `spec/mvp-auth-security` e testada isoladamente, mas ainda **não homologada contra banco persistente**.

## 0. Neon integrado à Vercel — checagem em 2026-10-21

- A Vercel agora apresenta credenciais do Neon `DATABASE_URL`, `POSTGRES_URL`, `NEON_PROJECT_ID`, etc. para **Preview e Production simultaneamente**.
- As variáveis existem, mas **não comprovam** aplicação de migrations, isolamento do banco ou conexão da aplicação.
- Por segurança, **não usar essa ligação para migrations** antes de confirmar uma branch ou banco Neon dedicado à homologação e credenciais separadas de produção.
- `config/database.php` aceita `DATABASE_URL` somente quando `DB_CONNECTION=pgsql`, mantendo `DB_URL` como prioridade. Nenhuma credencial entra no GitHub.
- No Vercel, criar/ajustar variáveis Laravel apenas em `Preview` com `gitBranch=chore/mvp-postgres-smtp-preview`, após validar o isolamento. Não modificar as variáveis de `Production` e nem as da branch antiga em funcionamento.
- A conexão Neon já injeta um URL completo. Não duplicar `DB_HOST`/`DB_PASSWORD` se `DATABASE_URL` correto estiver disponível.

## Atualização operacional — 21/10/2026, após criação da branch Neon

- Responsável criou branch Neon `caducou-preview` baseada em `main`. A captura de tela forneceu o prefixo do endpoint `ep-tiny-smoke-b7tqkguv`.
- Vercel contém `DATABASE_URL` e `DATABASE_URL_UNPOOLED` tipo **Sensitive**, alocados somente em Preview/`chore/mvp-postgres-smtp-preview`; as variantes personalizadas `DB_URL` e `DB_URL_UNPOOLED` foram excluídas pelo responsável. As variáveis da integração Neon ainda estão disponíveis globalmente a Preview/Production; a conexão específica da branch deve prevalecer em preview.
- O campo secreto de variáveis Sensitive não é retornado pela API Vercel, então **não foi possível provar diretamente** que os endpoints das URLs são os esperados; inspeção visual pelo proprietário no painel ainda é necessária.
- Adicionada verificação `DB_EXPECTED_ENDPOINT`: quando `DB_CONNECTION=pgsql`, Laravel aborta na inicialização caso o host da conexão não comece com o prefixo permitido (`ep-tiny-smoke-b7tqkguv` ou `ep-tiny-smoke-b7tqkguv-pooler`). É uma barreira contra migrations acidentais no banco Neon `main`.
- Vercel, somente na branch do preview, agora tem `DB_EXPECTED_ENDPOINT=ep-tiny-smoke-b7tqkguv`, `DB_SSLMODE=require` e `DB_CONNECTION=pgsql`; `SESSION_DRIVER=cookie`, `CACHE_STORE=array` e `MAIL_MAILER=array` permanecem temporariamente até aplicar migrations e SMTP real.
- Sandbox sem credenciais reais: `npm run build` e `php artisan test` **25 testes, 167 asserts, 0 falhas**; endpoint incorreto falhou como esperado (código 1) e endpoint esperado foi aceito na inicialização do Laravel (código 0), mas **conexão real ao Neon não foi testada**.
- **Não disparar redeploy agora**: PostgreSQL ainda não tem migrations aplicadas e a API Vercel não expõe credenciais Sensitive nem injeta segredos do projeto no Vercel Sandbox. Para migrations seguras é necessário um executor efêmero confiável com segredo acessível no ambiente ou execução local usando credenciais obtidas diretamente dos painéis, sem postá-las em chat.
- A implantação anterior `dpl_DFFaXNRyyGyC8D9nPfaVoAALiKcY` foi READY sob `DB_CONNECTION=sqlite`; mudanças posteriores de variáveis só passam a valer em novo deploy. `main` permanece intocada.

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
| `DATABASE_URL` | **Já criado pela integração Vercel-Neon**, requer confirmação de isolamento; conexão com pooler para tráfego da aplicação |
| `DB_PORT` | Não definir quando o URL completo já contém a porta |
| `DB_DATABASE` | Não definir quando o URL completo já contém o banco |
| `DB_USERNAME` | Não definir quando o URL completo já contém o usuário |
| `DB_PASSWORD` | Não definir quando o URL completo já contém a senha |
| `DB_SSLMODE` | `require` |
| `DB_URL` | Não definir; `config/database.php` resolve `DATABASE_URL` fornecido pela integração, quando `DB_CONNECTION=pgsql` |
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

- Neon/Vercel conectados; **confirmar isolamento de banco/branch exclusivo para preview**, já que as variáveis automáticas também atingem Production.
- Configurar Resend com domínio de envio verificado e chave própria.
- Inserir segredos no ambiente Vercel da branch de homologação; testar conectividade e aplicar migrations.
- Aprovar testes ponta a ponta e revisão de custos/backup antes da ativação.

## Fontes do provedor
- Neon: https://neon.com/docs/get-started-with-neon/workflow-primer
- Resend SMTP: https://resend.com/changelog/smtp-service
