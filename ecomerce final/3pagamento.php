<?php
session_start();

// Pega o carrinho da sessão
$carrinho = $_SESSION['carrinho'] ?? [];

// Calcula o total
$total = 0;
foreach ($carrinho as $item) {
    $total += $item['preco'] * $item['quantidade'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pagamento</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin: 20px; }
        h2 { color: #2831a7ff; }
        .total { font-size: 20px; font-weight: bold; margin: 20px 0; }
        form { display: inline-block; text-align: left; margin-top: 20px; width: 300px; }
        label { display: block; margin: 10px 0 5px; }
        input[type="text"], input[type="number"], input[type="email"] { width: 100%; padding: 5px; }
        button { background: #2831a7ff; color: white; border: none; padding: 10px 15px; border-radius: 10px; cursor: pointer; margin-top: 10px; }
        .opcoes { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Pagamento</h2>

    <?php if (empty($carrinho)): ?>
        <p>Seu carrinho está vazio!</p>
        <a href="1compras.php"><button>Voltar para Compras</button></a>
    <?php else: ?>
        <p class="total">Total a pagar: R$ <?= number_format($total, 2, ',', '.') ?></p>

        <!-- Formulário de Pagamento -->
        <form action="4pagar.php" method="post" onsubmit="return validarFormulario()">
            <!-- Dados do Cliente -->
            <label for="nome">Nome Completo:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required>

            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" id="endereco" required>

            <!-- Método de Pagamento -->
            <div class="opcoes">
                <label><input type="radio" name="metodo" value="pix" required> PIX</label>
                <label><input type="radio" name="metodo" value="credito"> Cartão de Crédito</label>
                <label><input type="radio" name="metodo" value="debito"> Cartão de Débito</label>
            </div>

            <!-- Campos para cartão -->
            <div id="cartao" style="display:none;">
                <label>Número do Cartão:</label>
                <input type="text" name="num_cartao" placeholder="0000 0000 0000 0000">

                <label>Nome no Cartão:</label>
                <input type="text" name="nome_cartao">

                <label>Validade (MM/AA):</label>
                <input type="text" name="validade">

                <label>CVV:</label>
                <input type="number" name="cvv">
            </div>

            <button type="submit">Pagar</button>
        </form>

        <!-- Botão de Voltar fora do formulário -->
        <a href="2carrinho.php"><button>Voltar ao Carrinho</button></a>
    <?php endif; ?>

    <script>
        // Mostrar campos do cartão se necessário
        const radios = document.querySelectorAll('input[name="metodo"]');
        const cartaoDiv = document.getElementById('cartao');

        radios.forEach(radio => {
            radio.addEventListener('change', () => {
                if (radio.value === 'credito' || radio.value === 'debito') {
                    cartaoDiv.style.display = 'block';
                } else {
                    cartaoDiv.style.display = 'none';
                }
            });
        });

        // Validação simples do formulário
        function validarFormulario() {
            const nome = document.getElementById('nome').value.trim();
            const email = document.getElementById('email').value.trim();
            const endereco = document.getElementById('endereco').value.trim();
            const metodo = document.querySelector('input[name="metodo"]:checked')?.value;

            if (!nome || !email || !endereco || !metodo) {
                alert("Por favor, preencha todos os campos obrigatórios.");
                return false;
            }

            if ((metodo === 'credito' || metodo === 'debito') && cartaoDiv.style.display === 'block') {
                const num = document.querySelector('input[name="num_cartao"]').value.trim();
                const nomeCartao = document.querySelector('input[name="nome_cartao"]').value.trim();
                const validade = document.querySelector('input[name="validade"]').value.trim();
                const cvv = document.querySelector('input[name="cvv"]').value.trim();

                if (!num || !nomeCartao || !validade || !cvv) {
                    alert("Preencha todos os dados do cartão.");
                    return false;
                }
            }

            return true;
        }
    </script>
</body>
</html>
