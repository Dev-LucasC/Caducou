# Política de Trabalho do Projeto - Caducou

**Projeto:** Caducou  
**Tipo:** Site/App SaaS para gestão de dívidas ativas, cobranças e recuperação de valores  
**Metodologia:** SDD - Spec Driven Development  
**Referência visual:** Revolut - clean, financeiro, premium, direto, confiável e mobile-first  
**Documento vivo:** Este documento deve ser atualizado sempre que uma regra de produto, arquitetura, segurança, LGPD ou processo de desenvolvimento mudar.

---

## 1. Objetivo do documento

Este documento define as políticas de trabalho, produto, desenvolvimento, qualidade, segurança, LGPD, experiência do usuário e colaboração para o projeto **Caducou**.

Ele deve servir como referência principal para:

* Codex e agentes de IA envolvidos no desenvolvimento.
* Desenvolvedores humanos.
* Product Owner.
* Agile Master.
* Dev Lead.
* Revisores de código.
* Futuras integrações com pagamentos, e-mail, WhatsApp/chatbot e automações de cobrança.

O objetivo é evitar decisões soltas, reduzir ambiguidade e garantir que o sistema seja desenvolvido com consistência, rastreabilidade, segurança e foco em valor de negócio.

---

## 2. Visão do produto

O **Caducou** é uma plataforma para gestão de dívidas ativas, criada principalmente para pessoas físicas, pequenos empreendedores e prestadores de serviço que emprestam dinheiro, vendem fiado, parcelam valores ou realizam cobranças informais e acabam perdendo o controle de:

* Quem deve.
* Quanto deve.
* Quando pegou emprestado.
* Quando deveria pagar.
* Quanto já foi pago.
* Quanto ainda falta pagar.
* Quais cobranças já foram feitas.
* Qual o histórico de comunicação com o devedor.

A plataforma deve transformar uma relação informal de dívida em um fluxo organizado, rastreável e profissional, sem perder simplicidade.

---

## 3. Posicionamento do produto

O Caducou não deve parecer um sistema pesado, burocrático ou jurídico demais.

A percepção desejada é:

* Simples como um app financeiro moderno.
* Seguro como uma plataforma bancária.
* Direto como uma ferramenta de cobrança.
* Profissional sem ser agressivo.
* Visualmente limpo, inspirado em fintechs como Revolut.

O produto deve transmitir:

* Controle.
* Confiança.
* Clareza.
* Segurança.
* Agilidade.
* Profissionalismo.

---

## 4. Princípios do produto

### 4.1 Clareza antes de complexidade

Toda funcionalidade deve deixar claro:

* O que está sendo registrado.
* Quem é o devedor.
* Qual é o valor original.
* Qual é o valor atualizado.
* O que já foi pago.
* O que ainda falta pagar.
* Qual será a próxima ação.

Se uma tela exigir explicação longa, ela provavelmente está mal desenhada.

### 4.2 Segurança por padrão

Como o sistema lida com dados financeiros, pessoais e histórico de cobrança, toda funcionalidade deve nascer considerando:

* Autenticação.
* Autorização.
* Controle de acesso.
* Registro de auditoria.
* Proteção de dados pessoais.
* Minimização de dados.
* Logs sem exposição indevida.

### 4.3 LGPD desde a concepção

Nenhuma feature deve ser implementada sem avaliar impacto em privacidade.

Toda especificação deve responder:

* Quais dados pessoais serão tratados?
* Por qual finalidade?
* Qual a base legal provável?
* Quem terá acesso?
* Por quanto tempo serão mantidos?
* Como o titular poderá solicitar correção ou exclusão quando aplicável?
* Existe dado sensível? Se sim, por que é indispensável?

### 4.4 SDD obrigatório

Nenhuma implementação relevante deve começar sem uma especificação aprovada.

O fluxo correto é:

1. Especificar.
2. Revisar.
3. Validar regras de negócio.
4. Criar critérios de aceite.
5. Implementar.
6. Testar contra a especificação.
7. Revisar segurança/LGPD.
8. Fazer merge.

### 4.5 Automação com responsabilidade

E-mails, chatbot, mensagens automáticas e cobranças devem ser controláveis pelo usuário e rastreáveis.

O sistema não deve disparar cobranças automaticamente sem consentimento operacional explícito do usuário credor.

---

## 5. Escopo inicial do produto

### 5.1 Módulos principais

O MVP do Caducou deve priorizar:

1. Cadastro e autenticação de usuários.
2. Cadastro de devedores.
3. Cadastro de dívidas.
4. Histórico de pagamentos.
5. Status da dívida.
6. Dashboard financeiro.
7. Envio de cobrança por e-mail.
8. Geração de link de pagamento.
9. Controle de comissionamento sobre cobranças pagas.
10. Registro de histórico de cobrança.
11. Políticas básicas de privacidade e consentimento.

### 5.2 Módulos futuros

Funcionalidades que podem entrar após validação do MVP:

* Chatbot de cobrança.
* Cobrança por WhatsApp, se tecnicamente e juridicamente viável.
* Régua automática de cobrança.
* Score interno de risco.
* Templates inteligentes de mensagem.
* OCR de comprovantes.
* Integração com Pix automático.
* Contratos simples de confissão de dívida.
* Assinatura digital.
* Importação de planilhas.
* Relatórios avançados.
* API pública.

---

## 6. Entidades principais do domínio

### 6.1 Usuário credor

Pessoa que usa o Caducou para registrar, controlar e cobrar valores devidos.

Dados possíveis:

* Nome.
* E-mail.
* Telefone.
* Documento, se necessário para pagamentos ou compliance.
* Dados de conta para recebimento.
* Preferências de notificação.
* Plano/assinatura.

### 6.2 Devedor

Pessoa cadastrada pelo usuário credor como responsável por uma ou mais dívidas.

Dados possíveis:

* Nome.
* E-mail.
* Telefone.
* CPF, somente se indispensável para cobrança, pagamento ou formalização.
* Observações.
* Endereço, somente se houver necessidade real.

Regra importante: o sistema deve evitar coletar mais dados do devedor do que o necessário.

### 6.3 Dívida

Registro financeiro que representa um valor devido.

Campos essenciais:

* Credor.
* Devedor.
* Valor original.
* Valor atual.
* Data do empréstimo ou origem da dívida.
* Data de vencimento.
* Descrição.
* Status.
* Histórico de pagamentos.
* Histórico de cobranças.
* Link de pagamento, quando aplicável.

### 6.4 Pagamento

Registro de pagamento total ou parcial.

Campos essenciais:

* Dívida relacionada.
* Valor pago.
* Data de pagamento.
* Meio de pagamento.
* Comprovante, se houver.
* Status da confirmação.

### 6.5 Cobrança

Ação realizada para lembrar ou solicitar pagamento.

Campos essenciais:

* Dívida relacionada.
* Canal de cobrança.
* Mensagem enviada.
* Data/hora.
* Status de envio.
* Status de leitura, se disponível.
* Link de pagamento associado.
* Usuário que disparou ou aprovou o envio.

---

## 7. Status padrão de dívida

Toda dívida deve possuir um status claro.

Status recomendados:

* **Rascunho:** dívida criada mas ainda incompleta.
* **Ativa:** dívida válida e pendente.
* **Vencida:** dívida passou da data de vencimento.
* **Parcialmente paga:** houve pagamento parcial.
* **Paga:** dívida quitada.
* **Renegociada:** dívida alterada por novo acordo.
* **Cancelada:** dívida removida operacionalmente, mas mantida em histórico quando necessário.
* **Em disputa:** existe contestação ou divergência.

Status não devem ser usados apenas como texto livre. Devem ser valores controlados por enum ou tabela de domínio.

---

## 8. Regras de negócio essenciais

### 8.1 Criação de dívida

Uma dívida só pode ser considerada ativa quando possuir, no mínimo:

* Devedor.
* Valor original.
* Data de origem.
* Credor proprietário.

A data de vencimento deve ser recomendada, mas pode ser opcional no MVP, desde que o sistema deixe claro que dívidas sem vencimento não entram em alertas de atraso.

### 8.2 Valor atual da dívida

O valor atual deve considerar:

* Valor original.
* Pagamentos parciais.
* Descontos.
* Acréscimos, se habilitados.
* Juros/multa, somente se a funcionalidade for explicitamente especificada.

No MVP, recomenda-se evitar cálculo automático de juros até que a regra jurídica e comercial esteja clara.

### 8.3 Pagamento parcial

Pagamentos parciais devem reduzir o saldo devedor.

O sistema deve manter histórico completo e nunca sobrescrever pagamentos antigos.

### 8.4 Quitação

Uma dívida deve ser marcada como paga quando o saldo restante for igual a zero.

A quitação pode ocorrer por:

* Pagamento completo.
* Pagamentos parciais somados.
* Baixa manual feita pelo usuário.
* Desconto integral autorizado.

Toda baixa manual deve ser auditável.

### 8.5 Cobrança manual

No MVP, cobranças devem ser preferencialmente manuais ou semi-automáticas.

O usuário deve revisar ou confirmar antes do envio.

### 8.6 Cobrança automática

Cobrança automática só pode existir após implementação de:

* Preferências claras do usuário.
* Opt-in para automação.
* Templates revisáveis.
* Limites de frequência.
* Registro de envio.
* Possibilidade de pausar.
* Política contra abuso.

### 8.7 Comissão do Caducou

Quando o Caducou gerar receita por percentual sobre cobrança paga, a regra deve ser transparente.

Toda especificação de pagamento deve definir:

* Percentual da comissão.
* Momento em que a comissão é cobrada.
* Base de cálculo.
* Se há taxa fixa adicional.
* Quem paga a taxa: credor ou devedor.
* Como será exibido no recibo.
* Como será tratado reembolso, chargeback ou estorno.

---

## 9. Política de LGPD e privacidade

### 9.1 Dados pessoais tratados

O Caducou poderá tratar dados pessoais de usuários credores e devedores.

Dados comuns:

* Nome.
* E-mail.
* Telefone.
* Identificadores de conta.
* Dados financeiros relacionados a dívida.
* Histórico de cobrança.
* Histórico de pagamento.

Dados que devem ser evitados salvo necessidade real:

* CPF.
* Endereço completo.
* Documentos anexados.
* Informações familiares.
* Informações profissionais irrelevantes.
* Dados sensíveis.

### 9.2 Dados sensíveis

O sistema não deve solicitar dados sensíveis.

São exemplos de dados que devem ser evitados:

* Saúde.
* Religião.
* Opinião política.
* Origem racial ou étnica.
* Dados biométricos.
* Filiação sindical.
* Vida sexual.

Se algum dado sensível aparecer em observações livres, comprovantes ou anexos, o sistema deve tratar isso como risco e considerar mecanismos de bloqueio, alerta ou minimização.

### 9.3 Finalidades de tratamento

Dados pessoais devem ser tratados apenas para finalidades legítimas e específicas, como:

* Criar conta de usuário.
* Autenticar acesso.
* Registrar devedores.
* Registrar dívidas.
* Controlar pagamentos.
* Enviar cobranças autorizadas.
* Gerar links de pagamento.
* Prevenir fraude.
* Cumprir obrigações legais/regulatórias.
* Atender solicitações de titulares.

### 9.4 Minimização de dados

Toda nova feature deve seguir a regra:

> Se o dado não é necessário para entregar valor, cumprir obrigação legal, reduzir fraude ou executar cobrança autorizada, ele não deve ser coletado.

### 9.5 Transparência

O usuário deve entender:

* Quais dados são coletados.
* Por que são coletados.
* Como serão usados.
* Com quem podem ser compartilhados.
* Como solicitar exclusão, correção ou acesso.

### 9.6 Compartilhamento com terceiros

Dados só podem ser compartilhados com terceiros quando houver finalidade clara, por exemplo:

* Provedor de pagamento.
* Provedor de e-mail.
* Provedor de hospedagem.
* Serviço de chatbot.
* Ferramenta antifraude.
* Serviço de analytics, com cautela.

Todo terceiro deve ser avaliado antes da integração.

### 9.7 Retenção e exclusão

O sistema deve prever política de retenção.

Regras recomendadas:

* Usuário pode solicitar exclusão de conta.
* Dados necessários para obrigações legais ou antifraude podem ser retidos pelo prazo necessário.
* Dívidas canceladas não devem desaparecer sem histórico, se houver necessidade de auditoria.
* Dados de devedores devem poder ser removidos ou anonimizados quando não houver dívida ativa, pendência legal ou necessidade legítima.

### 9.8 Logs e auditoria

Logs nunca devem expor indevidamente:

* CPF.
* Dados bancários.
* Tokens.
* Senhas.
* Links privados de pagamento.
* Conteúdo completo de mensagens sensíveis.

Eventos críticos devem ser auditados:

* Criação de dívida.
* Alteração de valor.
* Exclusão/cancelamento.
* Baixa manual.
* Envio de cobrança.
* Alteração de dados do devedor.
* Geração de link de pagamento.
* Acesso administrativo.

---

## 10. Segurança da informação

### 10.1 Autenticação

O sistema deve ter autenticação segura.

Requisitos mínimos:

* Senhas com hash forte.
* Proteção contra brute force.
* Sessões seguras.
* Recuperação de senha com token temporário.
* E-mail verificado para ações críticas.

Recomendado:

* Autenticação em dois fatores.
* Login social somente após avaliação de segurança e privacidade.

### 10.2 Autorização

Usuários só podem acessar dados próprios.

Toda consulta deve ser filtrada pelo usuário proprietário, organização ou tenant.

É proibido confiar apenas no front-end para controle de acesso.

### 10.3 Multi-tenant

Se o sistema for SaaS, deve ser projetado para isolamento entre contas.

Toda entidade sensível deve possuir vínculo claro com:

* user_id; ou
* organization_id; ou
* tenant_id.

### 10.4 Proteção de dados

Requisitos:

* HTTPS obrigatório.
* Dados sensíveis criptografados quando necessário.
* Tokens armazenados com segurança.
* Backups protegidos.
* Segredos fora do repositório.
* Variáveis de ambiente para credenciais.
* Rotação de chaves quando necessário.

### 10.5 Uploads

Comprovantes e anexos devem seguir regras rígidas:

* Validar tipo de arquivo.
* Validar tamanho.
* Impedir execução de arquivos enviados.
* Armazenar em local seguro.
* Controlar acesso por autorização.
* Registrar metadados.

---

## 11. Política de desenvolvimento SDD

### 11.1 Regra central

Nenhuma feature deve ser implementada diretamente a partir de uma ideia solta.

Toda feature deve nascer de uma especificação.

### 11.2 Estrutura mínima de uma spec

Toda spec deve conter:

1. Título.
2. Contexto.
3. Problema que resolve.
4. Objetivo de negócio.
5. Usuários impactados.
6. Fluxo esperado.
7. Regras de negócio.
8. Dados envolvidos.
9. Impacto LGPD.
10. Critérios de aceite.
11. Estados de erro.
12. Permissões.
13. Eventos de auditoria.
14. Testes esperados.
15. Fora de escopo.

### 11.3 Template de spec

```md
# Spec: [Nome da Feature]

## Contexto
Explique o cenário atual e por que esta feature existe.

## Problema
Qual dor do usuário ou do negócio será resolvida?

## Objetivo
Qual resultado esperado após implementação?

## Personas impactadas
- Usuário credor
- Devedor
- Administrador
- Sistema

## Fluxo principal
1. ...
2. ...
3. ...

## Regras de negócio
- REGRA-001: ...
- REGRA-002: ...

## Dados tratados
- Campo
- Tipo
- Obrigatório?
- Finalidade
- Observações LGPD

## Permissões
Quem pode criar, visualizar, editar, excluir ou executar esta ação?

## Critérios de aceite
- Dado que...
- Quando...
- Então...

## Estados de erro
- Erro de validação
- Erro de permissão
- Erro de integração
- Erro de pagamento

## Auditoria
Quais eventos devem ser registrados?

## Testes esperados
- Unitários
- Integração
- Feature/e2e
- Segurança

## Fora de escopo
O que esta spec não cobre?
```

---

## 12. Política para Codex e agentes de IA

### 12.1 Prioridade de leitura

Antes de alterar código, o Codex deve consultar, nesta ordem:

1. Documento de política de trabalho.
2. Specs da feature.
3. README do projeto.
4. Arquitetura do projeto.
5. Testes existentes.
6. Código atual.

### 12.2 Regras para geração de código

O Codex deve:

* Respeitar a stack definida no projeto.
* Não criar arquitetura paralela sem justificativa.
* Não duplicar regra de negócio em locais diferentes.
* Não remover testes sem autorização.
* Não alterar contrato de API sem atualizar spec.
* Não criar campos sensíveis sem justificativa LGPD.
* Não adicionar dependências sem necessidade clara.
* Não expor dados pessoais em logs.
* Não implementar cobrança automática sem spec explícita.

### 12.3 Quando o Codex deve parar e pedir revisão humana

O Codex deve sinalizar necessidade de revisão quando a mudança envolver:

* Pagamentos.
* Comissão da plataforma.
* Dados pessoais sensíveis.
* Exclusão definitiva de dados.
* Automação de cobrança.
* Integração com terceiros.
* Regras jurídicas.
* Alteração de autenticação/autorização.
* Mudança estrutural de banco de dados.

### 12.4 Saída esperada do Codex em cada tarefa

Ao finalizar uma implementação, o Codex deve informar:

* Arquivos alterados.
* Regras implementadas.
* Testes criados/alterados.
* Riscos conhecidos.
* Pontos pendentes.
* Como validar manualmente.

---

## 13. Política de arquitetura

### 13.1 Arquitetura recomendada

O sistema deve ser organizado por domínio, não apenas por tipo técnico.

Domínios iniciais:

* Auth.
* Users.
* Debtors.
* Debts.
* Payments.
* Collections.
* Notifications.
* Billing/Commissions.
* Audit.
* Privacy/LGPD.

### 13.2 Separação de responsabilidades

Evitar controllers gordos.

Recomendado:

* Controllers apenas orquestram entrada e saída.
* Services executam casos de uso.
* Models representam entidades.
* Policies/Gates controlam autorização.
* Jobs processam tarefas assíncronas.
* Events registram acontecimentos relevantes.
* Notifications cuidam de comunicação.

### 13.3 APIs

APIs devem seguir padrões consistentes:

* Respostas previsíveis.
* Erros padronizados.
* Validação clara.
* Status HTTP adequado.
* Paginação em listagens.
* Filtros documentados.
* Sem exposição de campos internos desnecessários.

### 13.4 Banco de dados

Regras:

* Usar migrations versionadas.
* Toda tabela crítica deve ter timestamps.
* Soft delete deve ser considerado para entidades sensíveis.
* Alterações financeiras devem preservar histórico.
* Evitar atualizar valores financeiros sem trilha de auditoria.

---

## 14. Política de UX/UI

### 14.1 Referência visual

A referência visual principal é o estilo de fintechs modernas como Revolut.

Direção visual:

* Interface limpa.
* Alto contraste.
* Tipografia moderna.
* Cards financeiros claros.
* Poucas cores por tela.
* Uso inteligente de branco, preto, cinza e cores de destaque.
* Mobile-first.
* Microinterações úteis.
* Aparência premium.

### 14.2 Princípios de UX

Cada tela deve responder rapidamente:

* Onde estou?
* O que tenho que fazer?
* Qual o valor em aberto?
* Qual a próxima ação recomendada?
* Existe risco ou atraso?

### 14.3 Dashboard

O dashboard deve priorizar:

* Total em aberto.
* Total vencido.
* Total recebido no período.
* Dívidas próximas do vencimento.
* Dívidas com maior valor.
* Últimas cobranças.
* Ações rápidas.

### 14.4 Linguagem de cobrança

O tom das mensagens deve ser:

* Profissional.
* Claro.
* Respeitoso.
* Não abusivo.
* Não ameaçador.
* Não constrangedor.

Evitar:

* Linguagem agressiva.
* Exposição pública.
* Ameaças jurídicas automáticas.
* Pressão excessiva.
* Frequência abusiva de mensagens.

---

## 15. Política de cobrança e comunicação

### 15.1 Canais possíveis

Canais previstos:

* E-mail.
* Chatbot.
* Link de pagamento.
* Futuramente WhatsApp ou SMS, se aprovado.

### 15.2 Template de cobrança

Todo template deve conter:

* Nome do devedor, se disponível.
* Nome do credor ou identificação clara.
* Valor devido.
* Descrição curta da dívida.
* Data de vencimento, se houver.
* Link de pagamento, se houver.
* Canal de contato.
* Informação de que a mensagem é uma cobrança privada.

### 15.3 Limite de frequência

O sistema deve impedir abuso.

Recomendação inicial:

* Não enviar múltiplas cobranças automáticas no mesmo dia para a mesma dívida.
* Permitir histórico visível ao usuário.
* Alertar quando a frequência parecer excessiva.

### 15.4 Registro de envio

Toda cobrança enviada deve gerar registro com:

* Canal.
* Data/hora.
* Conteúdo ou referência do template.
* Usuário responsável.
* Status.

---

## 16. Política de pagamentos

### 16.1 Link de pagamento

Links de pagamento devem ser gerados de forma segura.

Requisitos:

* Token não previsível.
* Expiração configurável.
* Vinculação com dívida correta.
* Exibição clara do valor.
* Identificação do credor.
* Registro de criação.
* Registro de pagamento.

### 16.2 Provedor de pagamento

Antes de integrar um provedor, avaliar:

* Taxas.
* Suporte a Pix.
* Split de pagamento.
* Webhooks.
* Estorno.
* Chargeback.
* Compliance.
* Segurança.
* Documentação.

### 16.3 Webhooks

Webhooks devem ser tratados com segurança:

* Validar assinatura.
* Evitar processamento duplicado.
* Registrar payload mínimo necessário.
* Tratar idempotência.
* Não confiar cegamente em dados recebidos.

---

## 17. Política de testes

### 17.1 Testes obrigatórios

Toda feature crítica deve ter testes.

Prioridades:

* Regras financeiras.
* Cálculo de saldo.
* Pagamentos parciais.
* Status da dívida.
* Permissões.
* Criação de cobrança.
* Geração de link de pagamento.
* Webhooks.
* Exclusão/anonimização de dados.

### 17.2 Tipos de teste

Recomendados:

* Unitários para regras puras.
* Feature/integration para fluxos principais.
* E2E para jornadas críticas.
* Testes de autorização.
* Testes de validação.
* Testes de idempotência em webhooks.

### 17.3 Critério mínimo para merge

Uma alteração só pode ser aprovada se:

* Atende a spec.
* Não quebra testes existentes.
* Possui testes para nova regra crítica.
* Não expõe dados pessoais indevidamente.
* Respeita autorização.
* Mantém consistência visual.

---

## 18. Definition of Ready

Uma tarefa está pronta para desenvolvimento quando possui:

* Spec aprovada.
* Critérios de aceite claros.
* Regras de negócio definidas.
* Dados necessários mapeados.
* Impacto LGPD avaliado.
* Dependências identificadas.
* Design ou wireframe quando necessário.
* Prioridade definida.

---

## 19. Definition of Done

Uma tarefa está concluída quando:

* Código implementado.
* Testes relevantes criados ou atualizados.
* Critérios de aceite atendidos.
* Revisão de código realizada.
* Migrações testadas.
* Erros tratados.
* Permissões validadas.
* Logs seguros.
* Documentação atualizada quando necessário.
* Nenhuma regra da spec foi ignorada sem justificativa.

---

## 20. Gestão ágil do projeto

### 20.1 Cadência recomendada

Para o início do projeto:

* Ciclos curtos de 1 semana.
* Planejamento semanal.
* Revisão semanal do progresso.
* Refinamento contínuo de specs.
* Backlog enxuto e priorizado.

### 20.2 Ordem recomendada de construção do MVP

1. Base do projeto e autenticação.
2. Cadastro de usuário.
3. Cadastro de devedor.
4. Cadastro de dívida.
5. Listagem e filtros.
6. Registro de pagamento parcial.
7. Dashboard inicial.
8. Envio de cobrança por e-mail.
9. Link de pagamento.
10. Comissão da plataforma.
11. Histórico/auditoria.
12. Política de privacidade e telas LGPD.

### 20.3 Priorização

Priorizar funcionalidades que:

* Reduzem perda de controle financeiro.
* Aumentam chance de recuperação da dívida.
* Geram receita para o Caducou.
* Reduzem risco jurídico/LGPD.
* Melhoram confiança do usuário.

---

## 21. Riscos principais

### 21.1 Risco jurídico

Cobranças podem gerar conflitos se forem abusivas, excessivas ou mal comunicadas.

Mitigação:

* Templates respeitosos.
* Registro de envio.
* Controle de frequência.
* Opt-in para automações.
* Revisão humana em fluxos sensíveis.

### 21.2 Risco LGPD

O produto trata dados pessoais de pessoas que talvez não tenham criado conta diretamente.

Mitigação:

* Minimizar dados.
* Informar finalidade.
* Criar canal de solicitação de titular.
* Evitar dados sensíveis.
* Controlar acesso.
* Ter política de privacidade clara.

### 21.3 Risco financeiro

Erros em saldo, comissão ou pagamento podem causar prejuízo.

Mitigação:

* Testes fortes.
* Auditoria.
* Idempotência.
* Revisão de regras financeiras.
* Histórico imutável de eventos críticos.

### 21.4 Risco reputacional

O produto pode ser percebido como ferramenta de cobrança agressiva.

Mitigação:

* Posicionamento profissional.
* Linguagem ética.
* Limites de automação.
* Design confiável.
* Política antiabuso.

---

## 22. Anti-padrões proibidos

Não fazer:

* Criar campos pessoais sem finalidade.
* Salvar senha em texto puro.
* Expor CPF, telefone ou e-mail em logs.
* Permitir que um usuário acesse dívida de outro.
* Deletar histórico financeiro sem auditoria.
* Enviar cobrança automática sem opt-in.
* Usar linguagem ameaçadora em mensagens.
* Calcular comissão sem transparência.
* Implementar regra financeira sem teste.
* Criar feature sem spec.
* Alterar banco de dados sem migration.
* Criar dependência externa sem justificativa.

---

## 23. Checklist para cada nova feature

Antes de implementar, responder:

* Existe spec?
* A regra de negócio está clara?
* Quais dados pessoais serão usados?
* Existe impacto LGPD?
* O usuário tem permissão para essa ação?
* Precisa de auditoria?
* Precisa de teste?
* Pode afetar saldo financeiro?
* Pode afetar pagamento ou comissão?
* Pode enviar mensagem para devedor?
* Pode gerar risco de abuso?
* Precisa atualizar documentação?

---

## 24. Primeiras specs recomendadas

Criar, nesta ordem:

1. Spec de autenticação e cadastro de usuário.
2. Spec de cadastro de devedores.
3. Spec de criação de dívida.
4. Spec de registro de pagamento parcial.
5. Spec de dashboard financeiro.
6. Spec de envio de cobrança por e-mail.
7. Spec de geração de link de pagamento.
8. Spec de comissão sobre cobrança paga.
9. Spec de auditoria.
10. Spec de privacidade/LGPD.

---

## 25. Conclusão

O Caducou deve ser construído como uma plataforma financeira simples, confiável e segura.

A força do produto estará em transformar dívidas informais em registros claros, acionáveis e cobrados com profissionalismo.

O desenvolvimento deve seguir SDD de forma rigorosa para evitar ambiguidades, proteger dados pessoais, reduzir risco financeiro e permitir que humanos e agentes de IA trabalhem com precisão.

A prioridade é entregar um MVP enxuto, seguro e validável, com foco em controle de dívidas, cobrança estruturada e geração de receita por pagamentos recuperados.
