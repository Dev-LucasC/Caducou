# Plano de execução — MVP Caducou

**Status:** Planejado, ainda não aprovado para implementar. Proposta baseada no PRD vigente, Tech Spec de autenticação e política SDD.

## Marco 1 — Autenticação e acesso
- [ ] M1.0 Revisar e aprovar `tech-spec.md`; decidir recuperação de senha e prioridade de Google/Apple.
- [ ] M1.1 Criar testes red para autenticação/CSRF/throttling/sessões/logout.
- [ ] M1.2 Implementar `POST /login`, formulário Inertia e mensagens neutras; limpar/sanitizar redirecionamentos.
- [ ] M1.3 Implementar `POST /logout` e botão de sair, invalidando sessão/CSRF.
- [ ] M1.4 Agrupar rotas internas sob `auth,verified`, tratar usuário ainda não verificado.
- [ ] M1.5 Estender os testes atuais que esperam páginas públicas para exigir login/verificação.
- [ ] M1.6 (se aprovado) Implementar password broker, solicitações genéricas e links de reset.
- [ ] M1.7 Revisar captura de erros, campos sensíveis em logs, cookies e fluxos mobile.
- [ ] M1.8 Validar build, testes e browser HTTP/HTTPS local.
- [ ] M1.9 Deploy em preview protegido somente depois do Marco 2 estar conectado.

## Marco 2 — PostgreSQL persistente
- [ ] M2.0 Especificar e aprovar infraestrutura, schema, backups, migrations e plano de rollback.
- [ ] M2.1 Provisionar PostgreSQL gerenciado com SSL, credenciais por ambiente, separando preview e produção.
- [ ] M2.2 Configurar `DB_*`, sessões/cache persistentes, SMTP, `APP_URL` e `APP_KEY` estável.
- [ ] M2.3 Executar migrations de forma explícita, fora do processo de build serverless.
- [ ] M2.4 Homologar cadastro, verificação, login, logout e reset em múltiplas invocações.
- [ ] M2.5 Validar backup/restauração e acesso mínimo ao banco.

## Marco 3 — Domínio financeiro
- [ ] M3.0 PRD/Tech Spec/schema de Devedor, Dívida, Pagamento e auditoria aprovados; tratar privacidade e autorização.
- [ ] M3.1 Migrations com `user_id` e FKs; valores monetários em centavos (inteiros).
- [ ] M3.2 CRUD de devedores com isolamento por proprietário; testes cross-account.
- [ ] M3.3 CRUD de dívidas e estados controlados (ativa, vencida, paga etc.).
- [ ] M3.4 Histórico de pagamentos imutável, transação atômica, saldo calculado, validação de excedentes/estornos.
- [ ] M3.5 Dashboard com agregações reais por credor; retirar dados demonstrativos.
- [ ] M3.6 Autorização + auditoria de alterações financeiras e testes de regressão.

## Marco 4 — Homologação e produção
- [ ] M4.1 E2E login -> cadastro de devedor -> dívida -> pagamento parcial -> quitação.
- [ ] M4.2 Segurança: acesso não autorizado, IDOR, CSRF, rate limit, cookies, HTTPS, dados sensíveis e logs.
- [ ] M4.3 Performance, observabilidade, backup, migrations rollback, retenção LGPD.
- [ ] M4.4 Aprovação humana de todos os requisitos, revisão PR e preparação de `main`.
- [ ] M4.5 Deploy de produção controlado, smoke tests e plano de reversão.

**Restrição atual:** o preview Vercel usa SQLite `:memory:` (sem persistência); não abrir cadastro público nem armazenar dados reais até completar M2.
