# Mapeamento do Site Atual (Clone João Pessoa) vs Novo (Aracaju)

## Status da Varredura no Banco de Dados do WordPress

### 1. Modelos do Elementor (elementor_library)
- **ID 15**: Lawkit – Header (Cabeçalho do site, menu de navegação, botão CTA)
- **ID 18**: Lawkit – Footer (Rodapé, links institucionais, endereço, direitos autorais)
- **ID 35**: Home (Modelo da Home)
- **ID 101**: cARD
- **ID 114**: Compromisso, estratégia e segurança jurídica
- **ID 129**: 12 areas
- **ID 147**: topo de pagina
- **ID 158**: Contact us
- **ID 209**: cabeçalho de pag

### 2. Páginas Existentes no WordPress (João Pessoa)
| ID | Título Atual | Slug Atual | Equivalente em Aracaju | Ação Necessária |
|---|---|---|---|---|
| 37 | Início | inicio | Home (/ ou /advogado-em-aracaju/) | Atualizar para texto novo da Home Aracaju (5 pilares + FAQ + Missão/Visão) |
| 97 | O Escritório | o-escritorio | Institucional Aracaju | Atualizar textos institucionais |
| 124 | Áreas de Atuação | rea-de-atuacao | Hub de Áreas Aracaju | Ajustar para as 5 áreas prioritárias |
| 145 | Perguntas Frequentes | perguntas-frequentes | FAQ Geral Aracaju | Atualizar com o FAQ novo |
| 160 | CONTATO | contato | Contato Aracaju | Atualizar contatos/links |
| 249 | DIREITO TRABALHISTA | dvogado-trabalhista-em-joao-pessoa | **1. Advogado Trabalhista em Aracaju** | **Mudar slug para dvogado-trabalhista-em-aracaju e atualizar texto/SEO** |
| 277 | Advogado de Família em JP | dvogado-de-familia-em-joao-pessoa | **2. Advogado para Divórcio em Aracaju** | **Mudar slug para dvogado-divorcio-em-aracaju e atualizar texto/SEO** |
| 261 | DIREITO IMOBILIÁRIO | dvogado-imobiliario-em-joao-pessoa | **3. Advogado Imobiliário em Aracaju** | **Mudar slug para dvogado-imobiliario-em-aracaju e atualizar texto/SEO** |
| 212 | Direito Empresarial | dvogado-empresarial-em-joao-pessoa | **4. Advogado Empresarial em Aracaju** | **Mudar slug para dvogado-empresarial-em-aracaju e atualizar texto/SEO** |
| - | *(Nova ou reaproveitada)* | - | **5. Advogado para Inventário em Aracaju** | **Criar ou duplicar página com slug dvogado-inventario-em-aracaju e aplicar layout padrão** |
| 236 | Direito Civil | dvogado-civil-em-joao-pessoa | Manter/Desativar ou Redirecionar | Opcional (não está nos 5 pilares prioritários) |
| 297 | DIREITO CRIMINAL | dvogado-criminal-em-joao-pessoa | Manter/Desativar ou Redirecionar | Opcional (não está nos 5 pilares prioritários) |
| 309 | DIREITO DO CONSUMIDOR | dvogado-do-consumidor-em-joao-pessoa | Manter/Desativar ou Redirecionar | Opcional (não está nos 5 pilares prioritários) |

---

## Estratégia de Atualização Segura do Elementor
1. O Elementor armazena a estrutura da página em formato JSON serializado na meta _elementor_data.
2. Para **não quebrar o design visual, margens, colunas e fontes**:
   - Cada widget de texto (heading, 	ext-editor, ccordion, icon-box, utton) preserva rigorosamente seus IDs, classes e propriedades de estilo.
   - Apenas os valores de texto (	itle, editor, 	ext, etc.) e links (url) são substituídos com precisão cirúrgica via script nativo PHP/WordPress.
3. Para as **novas páginas** (como Inventário):
   - Clonamos a estrutura exata do Elementor de uma das páginas irmãs (ex: Imobiliário ou Divórcio, que já possuem Hero, Seções de Conteúdo, FAQ e Bloco CTA).
   - Injetamos o conteúdo específico de Inventário nos mesmos widgets. Dessa forma, ela ganha exatamente a mesma identidade visual e responsividade, 100% editável pelo Elementor no painel!
