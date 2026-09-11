# Manual de Desenvolvimento e Deploy Contínuo (CI/CD)

Este manual descreve o fluxo de trabalho e deploy contínuo via **Git + WP Pusher** para o site **Jorge Santos Advocacia Aracaju** (`www.advogadoemaracaju.com.br`).

---

## 1. Arquitetura e Controle de Versão

- **Branch Principal:** `main`
- **Ambiente Local:** LocalWP (`adv-jorge-santos-aracaju-site.local`)
- **Versionamento Seguro (.gitignore):**
  - O arquivo `wp-config.php`, o core do WordPress (`wp-admin`, `wp-includes`) e credenciais de banco de dados **NÃO** são versionados.
  - Temas, plugins customizados, scripts de automação e documentações são rastreados.

---

## 2. Fluxo de Trabalho Git (Deploy Automático)

Para cada nova alteração ou melhoria:

1. **Testar localmente** no LocalWP.
2. **Adicionar os arquivos modificados:**
   ```bash
   git add .
   ```
3. **Criar o commit** seguindo o padrão semântico em Português:
   ```bash
   git commit -m "tipo(escopo): descrição clara da alteração"
   ```
4. **Enviar para a nuvem:**
   ```bash
   git push origin main
   ```
5. O **WP Pusher** em produção recebe o webhook do GitHub e atualiza os arquivos do site em segundos.

---

## 3. Configuração do WP Pusher na Hospedagem (Produção)

1. **Instalação do Plugin:**
   - Acesse [wppusher.com](https://wppusher.com/), baixe o arquivo `.zip` e instale em **Plugins > Adicionar Novo > Enviar Plugin**.
2. **Conexão com GitHub:**
   - Acesse **WP Pusher > GitHub** no painel administrativo e autorize o token de acesso (habilitando repositórios privados).
3. **Instalação do Tema/Plugin com Push-to-Deploy:**
   - Vá em **WP Pusher > Install Theme** (ou **Install Plugin**).
   - **Repository:** `SEU_USUARIO/SEU_REPOSITORIO`
   - **Repository Branch:** `main`
   - **Subdirectory:** Informe o caminho caso instale subpasta (ex: `app/public/wp-content/themes/hello-elementor`).
   - Marque a opção: **[x] Push-to-Deploy**.
   - Conclua a instalação.
