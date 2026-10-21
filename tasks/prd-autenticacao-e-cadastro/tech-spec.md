# Tech Spec — MVP 1: Autenticação, sessões e autorização

**Status:** APROVADA PELO RESPONSÁVEL PELO PRODUTO em 2026-10-21 para implementação isolada na branch do MVP; integração PostgreSQL/SMTP e liberação pública exigem homologação adicional.
**Base:** `tasks/prd-autenticacao-e-cadastro/prd.md` e `.agents/POLITICA_DE_TRABALHO.md`.
**Dependência para homologação na Vercel:** PostgreSQL persistente + serviço SMTP transacional.

## 1. Problema e objetivos
O preview do Caducou renderiza, mas Dashboard, Dívidas e Devedores estão públicos; o login visual não autentica e os dados ainda são demonstrativos. O primeiro marco do MVP estabelece acesso real e a barreira de segurança no backend, sem permitir processamento de dívidas reais até que o banco e as policies de domínio estejam operacionais.

Objetivos verificáveis:
- Credor faz login com e-mail/senha, logout e recuperação de acesso.
- Somente usuário autenticado **com e-mail verificado** acessa `/`, `/devedores`, `/dividas` e `/perfil`.
- Contas pendentes acessam exclusivamente a confirmação/reenvio e logout.
- Sessões, rate limit, validação de entrada e auditoria mínima funcionam em produção.
- Cadastro público permanece bloqueado no preview até que DB e SMTP persistentes sejam testados.

## 2. Personas e limites
- Visitante: acessar login, cadastro (quando habilitado), solicitação de redefinição.
- Credor não verificado: iniciar sessão, reenviar confirmação, sair; sem consultar dados financeiros.
- Credor verificado: módulos internos e perfil.
- Devedor: **sem conta** nesta etapa.

## 3. Fluxos de autenticação
### 3.1 Entrar
1. `GET /login` renderiza a tela com `useForm({email,password,remember})`.
2. `POST /login` valida e-mail/senha e aplica `throttle:5,1` (preferir `RateLimiter` por IP+identificador normalizado, com bloqueio temporário).
3. `Auth::attempt()`; erro genérico para credenciais incorretas, sem enumeração.
4. Ao sucesso, `$request->session()->regenerate()`; redirecionar a intended route somente se segura.
5. Credor não verificado vai para `verification.notice`; credor verificado vai para Dashboard.
6. `remember` opcional; cookies `HttpOnly`, `Secure` e `SameSite=Lax` em HTTPS.

### 3.2 Sair
- `POST /logout` somente autenticado e sob proteção CSRF.
- `Auth::logout()`, invalidar sessão e regenerar CSRF token.
- Redirecionar para `/login`.
- Adicionar ação visível e funcional na navegação/perfil.

### 3.3 Verificar e-mail
- Preservar fluxo existente com link assinado e expiração de 60 minutos.
- Usuário pendente acessa somente confirmação/reenvio/logout.
- Se já verificado, redirecionar a Dashboard.
- Reenvio com limite de 3 por minuto; não logar URL assinada ou hash/token.
- Testar link expirado, adulterado, conta inexistente e dupla confirmação.
- Impedir que login sem confirmação exponha tela de perfil, Dashboard ou dados de outros usuários.

### 3.4 Recuperar senha — **alteração proposta ao PRD**
- `GET /esqueci-senha` e `POST /esqueci-senha`: solicitação com resposta neutra quanto à existência da conta.
- `GET /redefinir-senha/{token}` e `POST /redefinir-senha`: Laravel Password Broker, token temporário e uso único.
- E-mail via provedor SMTP; senha nova com a mesma regra forte de cadastro; registrar alteração sem senha/token.
- Invalidar sessões/remember tokens conforme mecanismo implementado e testar token vencido/reutilizado.
- O PRD marca recuperação completa fora de escopo; precisa de aprovação explícita para alterar esse limite.

## 4. Proteção de rotas
- `auth` + `verified` em: Dashboard, Devedores, Dívidas, Perfil e futuras rotas financeiras.
- `guest` para login/cadastro/redefinição (exceto links de recuperação que exigem token).
- `auth` para confirmação/reenvio e `logout`.
- Assinatura de e-mail deve continuar permitida a visitantes, como no fluxo atual.
- Testar que visitante recebe redirect para login e não recebe payload Inertia financeiro; usuário não verificado recebe redirect para confirmação.
- Isolamento por `user_id` será obrigatório quando houver tabelas de dívida/devedor; não confiar em IDs enviados pelo frontend.

## 5. Dados e infraestrutura
- Tabelas já existentes: `users`, `password_reset_tokens`, `sessions`. **Não criar novas tabelas nesta etapa sem revisar schema.**
- Ambiente local/testes: SQLite isolado e Mail fake/Mailpit.
- Preview remoto: não persistir usuários em SQLite `:memory:`; configurar PostgreSQL antes de testes reais de login/cadastro.
- Em servidor serverless, preferir `SESSION_DRIVER=database` com DB persistente, `APP_KEY` estável, APP_URL correto, TLS/headers confiáveis e `APP_DEBUG=false`.
- SMTP de produção com remetente verificado; e-mail de autenticação **não** deve usar `MAIL_MAILER=log` em produção.
- Nenhum segredo em repositório, output de CI, logs ou screenshots.

## 6. Interfaces
- Ligar formulário Login.vue ao Inertia `useForm`, mostrar erro genérico, estado de carregamento e acessibilidade.
- Atualizar links `Esqueci minha senha`, `Voltar`, e ação Logout.
- Reutilizar design existente; responsividade mobile-first.
- Evitar feedback de autenticado na interface quando back-end ainda não autorizou a sessão.

## 7. Auditoria, privacidade e segurança
Dados usados: nome, e-mail, telefone opcional, hash de senha, carimbos de verificação, IP minimizado para rate limit e eventos de segurança; não coletar CPF.
Finalidades: acesso ao serviço, segurança, comunicação operacional; base legal a validar na política de privacidade.
Eventos mínimos (sem dados sensíveis): cadastro, login ok/falha genérica, logout, confirmação e solicitação de reset. Retenção e meio de armazenamento precisam ser aprovados antes de persistir auditoria em produção.
Cookies seguros, CSRF, rate limit, mensagens neutras de login/reset e logs sem segredo.
Não disponibilizar cadastro público nem inserir dados financeiros reais durante a implementação.

## 8. Testes e critérios de aceite
- Visitante tem `302 /login` para `/`, `/dividas`, `/devedores` e `/perfil` com payload protegido.
- Conta não verificada é bloqueada dessas quatro rotas e pode reenviar confirmação.
- Credor verificado consegue login, renovar sessão, consultar áreas internas e fazer logout que invalida sessão.
- Credenciais inválidas não autenticam; throttling impede ataque repetido.
- Link assinado válido confirma e-mail; token adulterado/expirado falha.
- Reset com token válido funciona; expirado/reutilizado falha; feedback não revela e-mails cadastrados.
- `php artisan test` verde, `npm run build` verde, verificação HTTP/Browser HTTPS com console limpo.
- Registro/recuperação por e-mail homologado contra banco **persistente**, antes de merge/deploy produção.

## 9. Estados de falha
Credenciais erradas, excesso de tentativas, sessão expirada, CSRF inválido, e-mail não verificado, token de verificação/reset vencido, falha de SMTP e indisponibilidade do PostgreSQL. Exibir resposta segura ao usuário e registrar telemetria operacional sem dados pessoais completos.

## 10. Fora de escopo desta entrega
- Social login Google/Apple: requisito do PRD a tratar em Tech Spec própria após avaliar OAuth, vinculação de contas e callbacks.
- CRUD de dívidas/devedores/pagamentos, cobranças, comissões, Pix, KYC, 2FA.
- Abertura pública do MVP, dados financeiros reais e merge direto para `main`.

## 11. Decisões pendentes de aprovação
1. **APROVADO:** incluir recuperação de senha no MVP 1, apesar do PRD atual excluir esse fluxo.
2. **APROVADO:** login social Google/Apple **após** MVP email/senha (sujeito a Tech Spec própria).
3. Aprovar o uso de PostgreSQL gerenciado + SMTP externo no marco 2 (fornecedor ainda não escolhido).
4. **APROVADO:** bloquear Dashboard e módulos de demonstração a visitantes na futura versão autenticada.
5. Definir janela mínima de retenção de registros de auditoria.
