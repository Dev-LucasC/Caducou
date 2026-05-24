# Caducou Agent Instructions

Before changing code or generating project artifacts, read:

1. `.agents/POLITICA_DE_TRABALHO.md`
2. Feature specs in `tasks/prd-[feature-slug]/`
3. Project README and architecture notes, when available
4. Existing tests
5. Current code

Caducou follows SDD (Spec Driven Development). Relevant implementation must be based on an approved spec, reviewed against LGPD/privacy impact, security rules, acceptance criteria, and expected tests.

Use the project skills in `.agents/skills/` together with the working policy:

- `cria-prd` for product requirements.
- `cria-techspec` for technical specifications.
- `criar-tasks` for implementation task breakdowns.
- `executar-task` for executing approved tasks.
- `laravel-best-practices`, `inertia-vue-development`, `tailwindcss-development`, and `pest-testing` for implementation standards.

Stop and request human review when a change involves payments, platform commission, sensitive personal data, permanent data deletion, collection automation, third-party integrations, legal rules, authentication/authorization changes, or structural database changes.
