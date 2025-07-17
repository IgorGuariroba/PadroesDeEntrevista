<?php
// Código PHP para ser exibido
$codigo = <<<'CODE'
<?php
function calcularMaiorVolumeDeVendasPorPeriodo(array $vendas, int $dias): int {
    $maiorVolume = 0;
    $somaAtual = 0;
    $inicioJanela = 0;

    for ($fimJanela = 0; $fimJanela < count($vendas); $fimJanela++) {
        $somaAtual += $vendas[$fimJanela];

        if ($fimJanela >= $dias - 1) {
            $maiorVolume = max($maiorVolume, $somaAtual);
            $somaAtual -= $vendas[$inicioJanela];
            $inicioJanela++;
        }
    }

    return $maiorVolume;
}
?>
CODE;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padrão Sliding Window - App Moderno</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/php/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/clike/clike.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/edit/matchbrackets.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/edit/closebrackets.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/material-darker.min.css">
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: {
                50: '#f0f9ff',
                500: '#3b82f6',
                600: '#2563eb',
                700: '#1d4ed8',
                900: '#1e3a8a'
              },
              accent: {
                500: '#10b981',
                600: '#059669'
              }
            },
            fontFamily: {
              'mono': ['JetBrains Mono', 'Fira Code', 'Consolas', 'monospace']
            },
            animation: {
              'fade-in': 'fadeIn 0.5s ease-in-out',
              'slide-up': 'slideUp 0.3s ease-out',
              'pulse-slow': 'pulse 3s infinite'
            }
          }
        }
      }
    </script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .CodeMirror {
            height: auto;
            font-family: 'JetBrains Mono', 'Fira Code', 'Consolas', monospace;
            font-size: 14px;
            line-height: 1.6;
            border-radius: 0 0 16px 16px;
            background: #212121 !important;
        }
        .CodeMirror-scroll {
            max-height: 400px;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .code-container {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #10b981;
            background: #1a1a1a;
        }
        .floating-card {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }
        .floating-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .neon-border {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
<!-- Background Pattern -->
<div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>

<!-- Header -->
<header class="relative z-10 pt-8 pb-4">
    <div class="container mx-auto px-6">
        <div class="text-center animate-fade-in">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-accent-500 to-primary-500 rounded-2xl mb-6 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <h1 class="text-5xl font-bold text-white mb-4 bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                Sliding Window
            </h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Algoritmo de Janela Deslizante para análise de dados sequenciais
            </p>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="relative z-10 container mx-auto px-6 pb-12">
    <!-- Explanation Section -->
    <section class="mb-12 animate-slide-up">
        <div class="floating-card bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20">
            <div class="flex items-start space-x-4 mb-6">
                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white mb-3">Como funciona o algoritmo</h2>
                    <p class="text-gray-300 text-lg leading-relaxed">
                        O padrão <span class="text-accent-500 font-semibold">Sliding Window</span> é uma técnica eficiente para encontrar valores máximos ou mínimos em sequências de dados contínuos.
                        No exemplo prático abaixo, calculamos o <span class="text-blue-400 font-semibold">maior volume de vendas em um período de dias consecutivos</span>.
                    </p>
                </div>
            </div>

            <!-- Algorithm Steps -->
            <div class="grid md:grid-cols-3 gap-6 mt-8">
                <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-white font-bold">1</span>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Inicialização</h3>
                    <p class="text-gray-400 text-sm">Define o tamanho da janela e inicializa as variáveis de controle</p>
                </div>
                <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-white font-bold">2</span>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Deslizamento</h3>
                    <p class="text-gray-400 text-sm">Move a janela através dos dados, adicionando novos elementos</p>
                </div>
                <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-white font-bold">3</span>
                    </div>
                    <h3 class="text-white font-semibold mb-2">Otimização</h3>
                    <p class="text-gray-400 text-sm">Remove elementos antigos e mantém o máximo atual</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Code Section -->
    <section class="mb-12 animate-slide-up" style="animation-delay: 0.2s">
        <div class="floating-card bg-white/5 backdrop-blur-lg rounded-3xl p-8 border border-white/20">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-3 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                    Implementação em PHP
                </h2>
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1 bg-accent-500/20 text-accent-400 rounded-full text-sm font-medium">PHP 8.0+</span>
                    <span class="px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-sm font-medium">O(n)</span>
                </div>
            </div>

            <div class="code-container neon-border">
                <div class="bg-gray-800 px-6 py-4 flex items-center justify-between border-b border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="flex space-x-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        </div>
                        <span class="text-gray-300 text-sm font-medium">VendasController.php</span>
                    </div>
                    <button id="copy-btn" class="flex items-center space-x-2 px-3 py-1 bg-gray-700 hover:bg-gray-600 text-gray-300 rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm">Copiar</span>
                    </button>
                </div>
                <textarea id="php-code" style="display: none;"><?= htmlspecialchars($codigo) ?></textarea>
            </div>
        </div>
    </section>

    <!-- Interactive Section -->
    <section class="animate-slide-up" style="animation-delay: 0.4s">
        <div class="floating-card bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-9-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white">Teste Interativo</h2>
            </div>

            <form id="formulario" class="space-y-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="vendas" class="block text-white font-semibold text-lg">
                            📊 Vendas por dia
                        </label>
                        <p class="text-gray-400 text-sm mb-3">Valores separados por vírgula</p>
                        <input
                                type="text"
                                id="vendas"
                                class="w-full p-4 bg-white/10 border border-white/20 rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent transition-all duration-200"
                                placeholder="Ex: 20,25,30,10,50,15,40,60"
                                value="20,25,30,10,50,15,40,60"
                                required
                        >
                    </div>

                    <div class="space-y-2">
                        <label for="dias" class="block text-white font-semibold text-lg">
                            📅 Período (dias consecutivos)
                        </label>
                        <p class="text-gray-400 text-sm mb-3">Tamanho da janela deslizante</p>
                        <input
                                type="number"
                                id="dias"
                                class="w-full p-4 bg-white/10 border border-white/20 rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent transition-all duration-200"
                                min="1"
                                required
                                value="3"
                        >
                    </div>
                </div>

                <button
                        type="submit"
                        class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-accent-500 to-accent-600 hover:from-accent-600 hover:to-accent-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Executar Algoritmo</span>
                </button>
            </form>

            <!-- Result Display -->
            <div id="resultado" class="mt-8 opacity-0 transition-all duration-500"></div>
        </div>
    </section>
</main>

<!-- Footer -->
<footer class="relative z-10 text-center py-8">
    <div class="container mx-auto px-6">
        <p class="text-gray-400">
            Demonstração interativa do algoritmo Sliding Window
        </p>
    </div>
</footer>

<script>
  let editor;

  document.addEventListener('DOMContentLoaded', function() {
    // Inicializar CodeMirror
    editor = CodeMirror.fromTextArea(document.getElementById('php-code'), {
      mode: 'application/x-httpd-php',
      theme: 'material-darker',
      readOnly: true,
      lineNumbers: true,
      lineWrapping: true,
      indentUnit: 4,
      tabSize: 4,
      matchBrackets: true,
      autoCloseBrackets: true,
      extraKeys: {
        "Ctrl-Space": "autocomplete"
      }
    });

    // Ajustar altura automaticamente
    editor.setSize(null, 'auto');

    // Refresh para garantir que renderize corretamente
    setTimeout(() => {
      editor.refresh();
    }, 100);
  });

  // Função para copiar código
  document.getElementById('copy-btn').addEventListener('click', function() {
    const code = editor.getValue();

    navigator.clipboard.writeText(code).then(function() {
      const btn = document.getElementById('copy-btn');
      const originalHTML = btn.innerHTML;
      btn.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-sm">Copiado!</span>
                `;
      btn.classList.add('bg-green-600');

      setTimeout(() => {
        btn.innerHTML = originalHTML;
        btn.classList.remove('bg-green-600');
      }, 2000);
    });
  });

  // Lógica do formulário
  document.getElementById('formulario').addEventListener('submit', function (e) {
    e.preventDefault();

    const vendasStr = document.getElementById('vendas').value.trim();
    const dias = parseInt(document.getElementById('dias').value);
    const vendas = vendasStr.split(',').map(v => parseInt(v.trim())).filter(v => !isNaN(v));

    const resultadoDiv = document.getElementById('resultado');

    if (dias > vendas.length || dias <= 0) {
      resultadoDiv.innerHTML = `
                    <div class="bg-red-500/20 border border-red-500/30 rounded-2xl p-6">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-red-400 font-semibold">Número de dias inválido!</p>
                        </div>
                    </div>
                `;
      resultadoDiv.classList.remove('opacity-0');
      return;
    }

    // Implementação do algoritmo
    let maiorVolume = 0;
    let somaAtual = 0;
    let inicioJanela = 0;
    let melhorPeriodo = [];

    for (let fimJanela = 0; fimJanela < vendas.length; fimJanela++) {
      somaAtual += vendas[fimJanela];

      if (fimJanela >= dias - 1) {
        if (somaAtual > maiorVolume) {
          maiorVolume = somaAtual;
          melhorPeriodo = vendas.slice(inicioJanela, fimJanela + 1);
        }
        somaAtual -= vendas[inicioJanela];
        inicioJanela++;
      }
    }

    // Exibir resultado com animação
    resultadoDiv.innerHTML = `
                <div class="bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-500/30 rounded-2xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-white font-bold text-xl mb-2">Resultado Calculado</h3>
                            <p class="text-green-400 text-2xl font-bold mb-3">
                                💰 Maior volume: ${maiorVolume.toLocaleString('pt-BR')}
                            </p>
                            <p class="text-gray-300 mb-2">
                                📊 Melhor período: [${melhorPeriodo.join(', ')}]
                            </p>
                            <p class="text-gray-400 text-sm">
                                🔍 Analisados ${vendas.length} dias com janela de ${dias} dias consecutivos
                            </p>
                        </div>
                    </div>
                </div>
            `;

    resultadoDiv.classList.remove('opacity-0');
  });

  // Adicionar efeitos de hover aos cards
  document.querySelectorAll('.floating-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-5px)';
    });

    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
    });
  });
</script>
</body>
</html>
