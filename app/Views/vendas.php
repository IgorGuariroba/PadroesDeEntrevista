<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Padrão Sliding Window (Janela Deslizante)</title>
    <link href="/tailwind.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 flex flex-col items-center min-h-screen p-6">
<h1 class="text-3xl font-bold mb-6">Calculadora de Maior Volume de Vendas</h1>

<form id="formulario" class="bg-white p-6 rounded shadow-md w-full max-w-lg">
    <label class="block mb-2 font-semibold" for="vendas">Vendas por dia (valores separados por vírgula):</label>
    <input
        type="text"
        id="vendas"
        name="vendas"
        class="w-full p-2 border border-gray-300 rounded mb-4"
        placeholder="Ex: 20,25,22,15,30,10,28,35,40,12"
        required
    />

    <label class="block mb-2 font-semibold" for="dias">Número de dias consecutivos:</label>
    <input
        type="number"
        id="dias"
        name="dias"
        class="w-full p-2 border border-gray-300 rounded mb-4"
        min="1"
        max="30"
        value="7"
        required
    />

    <button
        type="submit"
        class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition"
    >
        Calcular
    </button>
</form>

<div id="resultado" class="mt-6 text-xl font-semibold text-gray-700"></div>

<script>
  document.getElementById('formulario').addEventListener('submit', async function(e) {
    e.preventDefault();

    const vendasInput = document.getElementById('vendas').value.trim();
    const diasInput = document.getElementById('dias').value;

    if (!vendasInput) {
      alert('Por favor, informe os valores de vendas.');
      return;
    }

    const vendasArray = vendasInput.split(',').map(v => parseInt(v.trim())).filter(v => !isNaN(v));

    if (vendasArray.length === 0) {
      alert('Informe ao menos um valor válido de venda.');
      return;
    }

    if (diasInput < 1 || diasInput > vendasArray.length) {
      alert('Número de dias deve ser entre 1 e o total de vendas.');
      return;
    }

    const formData = new FormData();
    formData.append('vendas', JSON.stringify(vendasArray));
    formData.append('dias', diasInput);

    try {
      const response = await fetch('index.php?action=calcular', {
        method: 'POST',
        body: formData,
      });

      const data = await response.json();

      if(data.erro){
        document.getElementById('resultado').textContent = "Erro: " + data.erro;
        return;
      }

      document.getElementById('resultado').textContent =
        `Maior volume de vendas em ${diasInput} dias consecutivos: ${data.resultado}`;
    } catch (error) {
      alert('Erro ao calcular: ' + error.message);
    }
  });
</script>
</body>
</html>
