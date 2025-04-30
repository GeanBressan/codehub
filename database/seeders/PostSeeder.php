<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'title' => '5 Dicas Simples para Melhorar Seu Código em Qualquer Linguagem',
            'slug' => Str::slug('5 Dicas Simples para Melhorar Seu Código em Qualquer Linguagem'),
            'description' => 'Quer escrever códigos mais limpos, legíveis e fáceis de manter? Veja 5 dicas práticas que você pode aplicar hoje, independente da linguagem que usa.',
            'content' => <<<EOT
Se você está começando na programação ou mesmo se já tem uma boa experiência, sempre há espaço para melhorar a forma como escreve seu código. Aqui vão 5 dicas simples que fazem toda a diferença:

### 1. Nomeie suas variáveis de forma clara
Evite nomes como `x`, `temp`, `data1`. Prefira `userName`, `totalPrice`, `createdAt`. O nome certo evita comentários desnecessários.

### 2. Comente o porquê, não o que
Não escreva comentários óbvios como `// soma dois números`. Prefira explicar decisões: `// adiciona taxa de serviço ao total final`.

### 3. Evite códigos duplicados
Se você copiar e colar um bloco de código, talvez seja hora de transformá-lo em uma função reutilizável.

### 4. Separe a lógica em partes
Organize o código em funções pequenas com responsabilidade única. Isso melhora a leitura e facilita testes.

### 5. Revise e refatore sempre que possível
Antes de considerar o código "pronto", releia e tente deixá-lo mais simples e claro.

---

Melhorar a qualidade do código não exige grandes mudanças. Pequenas práticas como essas fazem você evoluir como programador e tornam seu trabalho mais profissional.
EOT,
            'status' => 'published',
            'post_at' => '2025-04-25 10:00:00',
            'category_id' => 14,
        ]);

        Post::create([
            'title' => 'Como Funciona o Algoritmo de Busca Binária',
            'slug' => Str::slug('Como Funciona o Algoritmo de Busca Binária'),
            'description' => 'Entenda como o algoritmo de busca binária funciona e como ele pode otimizar suas buscas em listas ordenadas.',
            'content' => <<<EOT
A busca binária é um algoritmo eficiente para encontrar um item em uma lista ordenada. Ao invés de verificar cada item sequencialmente, ele divide a lista ao meio e descarta metade dela a cada iteração.
### Como Funciona?
1. **Lista Ordenada**: A lista deve estar ordenada.
2. **Divisão**: Compare o item do meio com o item que você está procurando.
3. **Descartar Metade**: Se o item do meio for maior, busque na metade inferior. Se for menor, busque na metade superior.
4. **Repetir**: Continue dividindo até encontrar o item ou até que a lista não tenha mais elementos.
### Complexidade
A complexidade de tempo da busca binária é O(log n), o que a torna muito mais rápida que a busca linear (O(n)) em listas grandes.
### Exemplo em Python
```python
def binary_search(arr, target):
    left, right = 0, len(arr) - 1
    while left <= right:
        mid = (left + right) // 2
        if arr[mid] == target:
            return mid
        elif arr[mid] < target:
            left = mid + 1
        else:
            right = mid - 1
    return -1
```
### Conclusão
A busca binária é uma técnica poderosa que pode economizar tempo e recursos, especialmente em listas grandes. Aprender a implementá-la é um passo importante para qualquer programador.
EOT,
            'status' => 'published',
            'post_at' => '2025-04-24 10:00:00',
            'category_id' => 7,
        ]);

        Post::create([
            'title' => 'Introdução ao Machine Learning',
            'slug' => Str::slug('Introdução ao Machine Learning'),
            'description' => 'Aprenda os conceitos básicos de Machine Learning e como ele pode ser aplicado em diferentes áreas.',
            'content' => <<<EOT
Machine Learning é um campo da inteligência artificial que permite que sistemas aprendam e melhorem com a experiência. Ao invés de serem programados explicitamente, eles usam dados para identificar padrões e fazer previsões.
### Tipos de Aprendizado
1. **Supervisionado**: O modelo é treinado com dados rotulados. Exemplo: prever preços de casas com base em características como tamanho e localização.
2. **Não Supervisionado**: O modelo encontra padrões em dados não rotulados. Exemplo: segmentação de clientes.
3. **Reforço**: O modelo aprende através de tentativas e erros, recebendo recompensas ou punições. Exemplo: jogos.
### Aplicações
- **Saúde**: Diagnóstico de doenças.
- **Finanças**: Previsão de fraudes.
- **Marketing**: Segmentação de clientes.
- **Transporte**: Otimização de rotas.
### Conclusão
Machine Learning está transformando diversas indústrias. Compreender seus princípios básicos é essencial para qualquer profissional que deseje se destacar no mercado atual.
EOT,
            'status' => 'published',
            'post_at' => '2025-04-23 10:00:00',
            'category_id' => 6,
        ]);

        Post::create([
            'title' => 'O Futuro da Inteligência Artificial',
            'slug' => Str::slug('O Futuro da Inteligência Artificial'),
            'description' => 'Uma visão sobre as tendências e inovações que moldarão o futuro da inteligência artificial.',
            'content' => <<<EOT
A inteligência artificial (IA) está evoluindo rapidamente e promete transformar a forma como vivemos e trabalhamos. Aqui estão algumas tendências que moldarão o futuro da IA:
### 1. Aprendizado de Máquina Explicável
A transparência nos modelos de IA será crucial. As empresas precisarão entender como os algoritmos tomam decisões, especialmente em setores regulados como saúde e finanças.
### 2. IA Ética
A ética na IA será um tema central. As empresas precisarão garantir que seus sistemas sejam justos, transparentes e livres de preconceitos.
### 3. Integração com IoT
A combinação de IA com a Internet das Coisas (IoT) permitirá a criação de sistemas mais inteligentes e autônomos, desde casas conectadas até cidades inteligentes.
### 4. IA Conversacional
A evolução dos assistentes virtuais e chatbots tornará a interação com máquinas mais natural e intuitiva.
### 5. IA em Tempo Real
A capacidade de processar dados em tempo real permitirá decisões mais rápidas e precisas, impactando setores como transporte, saúde e finanças.
### Conclusão
O futuro da IA é promissor e cheio de oportunidades. À medida que a tecnologia avança, será essencial que profissionais e empresas se adaptem e aproveitem essas inovações para se manterem competitivos.
EOT,
            'status' => 'published',
            'post_at' => '2025-04-28 10:00:00',
            'category_id' => 5,
        ]);
    }
}
