# GameZone — tema WordPress 1.0.0

Tema clássico WordPress para portal de notícias, reviews e jogos. PHP, CSS e JavaScript separados. Não exige plugins.

## Instalação
1. No WordPress, vá a **Aparência → Temas → Adicionar novo → Enviar tema**.
2. Selecione `gamezone.zip`, instale e ative.
3. Vá a **Configurações → Geral** e ajuste o nome e a descrição do site.
4. Em **Aparência → Menus** (ou **Aparência → Personalizar → Menus**), crie o menu e atribua à posição **Menu principal**. Sem menu configurado, o tema exibe links padrão.
5. Em **Posts → Categorias**, crie as categorias com slugs `noticias`, `reviews`, `jogos`, `guias`.
6. Crie publicações, defina uma **imagem destacada** para cada uma e selecione a categoria correspondente.
7. Para reviews, edite um post e use a caixa **Nota do review (0 a 10)**. Se não estiver visível, ative-a em Preferências/Opções de tela do editor.
8. Em **Aparência → Personalizar → GameZone: página inicial**, altere a cor e os textos da capa sem publicações.

## Como funciona
- Página inicial: post mais recente como capa, seis posts em cartões e barra lateral com destaques e categorias.
- Se desejar uma página estática como início, configure em **Configurações → Leitura**. A página inicial continuará usando `front-page.php`.
- Arquivos de categorias, pesquisa, artigo, página, comentários, paginação e página 404 incluídos.
- Sem conteúdo fictício importado. As imagens de jogos devem ser adicionadas pelo administrador com direitos de uso.
- A tipografia usa Inter do Google Fonts quando há conexão; usa fontes do sistema caso contrário.

## Estrutura
- `style.css`: metadados do tema
- `assets/css/main.css`: estilos
- `assets/js/main.js`: menu mobile
- `functions.php`: recursos WordPress, personalizador, nota de reviews
- `front-page.php`, `single.php`, `archive.php`, `search.php`, `page.php`, `404.php`: templates

Licença GPL-2.0-or-later.
