# PRD: Autenticacao e Cadastro de Usuario

## Visao Geral

O Caducou precisa permitir que o usuario credor crie uma conta, valide seu e-mail e acesse o sistema de forma segura para gerenciar devedores, dividas, pagamentos e cobrancas.

Esta feature cobre apenas autenticacao e cadastro do usuario credor. Devedores nao terao conta no MVP. Para devedores, a direcao de produto sera acesso por link unico/tokenizado a uma divida especifica, compartilhado pelo credor quando existir divida ativa, sem exigir autenticacao tradicional do devedor.

O cadastro deve ser simples, confiavel e alinhado a LGPD: coletar somente dados essenciais no inicio e adiar documento/CPF/CNPJ para uma etapa futura, obrigatoria apenas quando o usuario quiser cobrar por dentro do site ou usar recursos de pagamento/compliance.

## Objetivos

- Permitir que novos usuarios credores criem conta com dados minimos.
- Exigir verificacao de e-mail antes de liberar acesso funcional ao sistema.
- Permitir login por e-mail e senha.
- Permitir autenticacao social com Google e Apple.
- Reduzir risco de contas falsas usando verificacao de e-mail e protecao contra abuso.
- Evitar coleta prematura de documento pessoal.
- Direcionar usuario validado ao Dashboard apos confirmar e-mail.

Metricas iniciais:

- Taxa de conclusao do cadastro.
- Taxa de verificacao de e-mail.
- Falhas de login por credenciais invalidas.
- Uso de login social versus e-mail/senha.
- Tempo medio entre cadastro e primeira entrada no Dashboard.

## Historias de Usuario

- Como usuario credor, quero criar uma conta com nome, e-mail e senha para acessar o Caducou rapidamente.
- Como usuario credor, quero receber um e-mail de verificacao para confirmar que o e-mail informado e meu.
- Como usuario credor, quero clicar no botao do e-mail e voltar ao Caducou ja autenticado no Dashboard.
- Como usuario credor, quero entrar com Google ou Apple para reduzir friccao de acesso.
- Como usuario credor, quero entender que meu telefone e importante para comunicacao, mas que documento sera solicitado apenas quando necessario.
- Como sistema, quero impedir acesso funcional de contas com e-mail nao verificado.
- Como sistema, quero registrar eventos relevantes de cadastro, login e verificacao para auditoria.
- Como devedor, nao quero precisar criar conta para consultar uma divida especifica compartilhada por link seguro no futuro.

## Funcionalidades Principais

1. Cadastro de usuario credor por e-mail e senha.
   - Campos obrigatorios: nome, e-mail, senha e aceite dos termos/politica.
   - Telefone deve ser opcional no MVP, com aviso de que e importante para comunicacao.
   - Documento/CPF/CNPJ nao deve ser coletado no cadastro inicial.

2. Verificacao obrigatoria de e-mail.
   - Apos cadastro, usuario deve ir para uma tela de confirmacao de e-mail.
   - O sistema deve enviar e-mail com botao de verificacao.
   - Ao clicar no botao, o usuario deve voltar ao Caducou autenticado e ser redirecionado ao Dashboard.
   - Links de verificacao devem expirar e poder ser reenviados.

3. Login por e-mail e senha.
   - O usuario deve conseguir acessar com e-mail e senha.
   - Login deve falhar de forma generica quando credenciais forem invalidas.
   - Contas sem e-mail verificado devem ser direcionadas ao fluxo de confirmacao.

4. Login social com Google e Apple.
   - O usuario deve poder criar conta ou entrar usando Google ou Apple.
   - O e-mail retornado pelo provedor deve ser tratado como identificador principal.
   - Quando o provedor informar e-mail verificado, o Caducou pode considerar o e-mail verificado, desde que a Tech Spec confirme seguranca e privacidade.
   - Contas sociais devem ser vinculadas ao mesmo usuario quando o e-mail ja existir.

5. Controle de acesso inicial.
   - Apenas usuarios credores autenticados e com e-mail verificado devem acessar Dashboard e modulos internos.
   - O front-end nao deve ser a unica barreira de acesso.

6. Preparacao para exigencia futura de documento.
   - O sistema deve comunicar que cobrancas por dentro do site e recursos de pagamento podem exigir verificacao documental futura.
   - Documento nao e necessario para explorar o site e entender a ferramenta.

7. Auditoria e seguranca.
   - Eventos relevantes: cadastro criado, e-mail enviado, e-mail verificado, login bem-sucedido, falha de login, logout, login social vinculado.
   - Logs nao devem expor senha, tokens, documentos ou dados sensiveis.

## Experiencia do Usuario

O fluxo principal deve ser:

1. Usuario acessa "Criar conta".
2. Preenche nome, e-mail, senha, telefone opcional e aceite.
3. Sistema cria conta pendente de verificacao.
4. Usuario ve tela de confirmacao de e-mail com opcao de reenviar.
5. Usuario recebe e-mail e clica no botao de validacao.
6. Sistema valida o link, autentica o usuario e redireciona para o Dashboard.

Fluxo de login:

1. Usuario acessa "Login".
2. Informa e-mail/senha ou escolhe Google/Apple.
3. Se autenticado e verificado, acessa Dashboard.
4. Se autenticado mas nao verificado, vai para confirmacao de e-mail.

UX deve ser mobile-first, clean, premium e objetiva. Mensagens de erro devem ser claras, sem revelar informacoes sensiveis como existencia de conta por e-mail.

## Restricoes Tecnicas de Alto Nivel

- Stack definida: Laravel, Inertia, Vue, Tailwind e Laravel Sail com PHP 8.3.
- Senhas devem usar hash forte.
- O sistema deve ter protecao contra brute force.
- Tokens de verificacao devem ser temporarios, nao previsiveis e armazenados com seguranca.
- Google e Apple exigem avaliacao de seguranca, privacidade, variaveis de ambiente e callbacks seguros.
- Nenhum segredo de provedor social pode ser versionado.
- E-mail local deve usar Mailpit em desenvolvimento.
- Dados pessoais tratados: nome, e-mail, telefone opcional, senha hasheada, identificadores de provedor social, timestamps de verificacao.
- Finalidade LGPD: criacao de conta, autenticacao, seguranca, comunicacao operacional e controle de acesso.
- Base legal provavel: execucao de contrato/procedimentos preliminares e legitimo interesse para seguranca.
- Permissoes: visitante pode criar conta e solicitar login; usuario autenticado/verificado acessa modulos internos; usuario nao verificado acessa apenas confirmacao/reenvio; admin futuro fica fora desta spec.

## Fora de Escopo

- Cadastro/autenticacao tradicional de devedores.
- Link unico do devedor para visualizar/pagar divida, apesar de ser direcao aprovada para feature futura.
- Verificacao de documento/CPF/CNPJ.
- Permissao para cobrar por dentro do site.
- KYC, antifraude avancado ou compliance de pagamento.
- Recuperacao completa de senha, exceto links visuais ja existentes.
- 2FA no MVP.
- Organizacoes, times, convites ou multiusuario.
- Painel administrativo.
- Implementacao tecnica detalhada de Social Login, que pertence a Tech Spec.
