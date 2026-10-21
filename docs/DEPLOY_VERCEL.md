# Caducou — preparo para Vercel (preview técnico)

## Escopo
O projeto é Laravel 12 + Inertia/Vue/Vite, não um Vite SPA. A Vercel precisa de runtime PHP comunitário e do entrypoint `api/index.php`; arquivos frontend saem em `public/build`. Esta branch não muda autenticação, dados financeiros nem a `main`.

## Variáveis requeridas (definir no painel Vercel, nunca no GitHub)
- `APP_NAME=Caducou`, `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://<domínio-do-preview>`
- `APP_KEY`: gerar com `php artisan key:generate --show` em ambiente seguro e manter a mesma chave em todas as instâncias
- Banco Postgres persistente: `DB_CONNECTION=pgsql`, `DB_HOST`, `DB_PORT=5432`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `DB_SSLMODE=require`
- `SESSION_DRIVER=database`, `SESSION_SECURE_COOKIE=true`, `QUEUE_CONNECTION=sync`, `CACHE_STORE=database`
- `LOG_CHANNEL=stderr`, `LOG_LEVEL=warning`, `VIEW_COMPILED_PATH=/tmp`
- Cache Laravel: `APP_CONFIG_CACHE=/tmp/config.php`, `APP_EVENTS_CACHE=/tmp/events.php`, `APP_PACKAGES_CACHE=/tmp/packages.php`, `APP_ROUTES_CACHE=/tmp/routes.php`, `APP_SERVICES_CACHE=/tmp/services.php`
- E-mail de produção: `MAIL_MAILER=smtp`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`

## Antes de publicar
1. Configurar ambiente PHP no provedor e conferir suporte do runtime comunitário `vercel-php@0.7.4`. Não há suporte oficial Vercel para PHP.
2. Configurar serviços gerenciados (Postgres, SMTP) e executar migrations explicitamente fora do deploy.
3. Ajustar na Vercel `Framework Preset: Other`, não Vite. O `vercel.json` usa build `npm run build` e pasta pública `public`.
4. Validar `npm ci && npm run build`, `php artisan test`, páginas com Inertia, assets, rotas, sessão, e-mail e segurança.
5. Bloquear acesso público até login/logout e middleware de autenticação/verificação serem concluídos.

## Limitações atuais do MVP
O botão de login ainda não está ligado ao backend; dashboard, devedores e dívidas apresentam dados demonstrativos; não há migrations para as entidades financeiras; rotas de negócio não estão protegidas. **Não liberar cadastro público nem dados reais nesta etapa.**

O runtime Vercel não garante persistência do filesystem. Anexos, cache persistente, filas, jobs e sessões necessitam arquitetura externa. Há risco de incompatibilidade PHP/serverless; validar no deploy preview antes de aprovar a PR.
