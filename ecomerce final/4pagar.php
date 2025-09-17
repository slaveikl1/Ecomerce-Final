<?php
session_start();

// Pega o total da compra do carrinho
$carrinho = $_SESSION['carrinho'] ?? [];

$total = 0;
foreach ($carrinho as $item) {
    $total += $item['preco'] * $item['quantidade'];
}

// Simulando um QR Code (coloque sua imagem depois)
$qr_code = "Imagens/qrcode.jpg"; // Caminho relativo da imagem (você pode substituir pelo real)
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Pagamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }

        h2 {
            color: #2831a7ff;
            margin-bottom: 20px;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0 30px;
        }

        img {
            max-width: 300px;
            margin-bottom: 20px;
        }

        .botao-voltar {
            background-color: #2831a7ff;
            color: white;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Finalize seu pagamento</h2>

    <p class="total">Total: R$ <?= number_format($total, 2, ',', '.') ?></p>

    <!-- QR Code para pagamento -->
    <img src="<?= $qr_code ?>" alt="QR Code para pagamento">

    <p>Escaneie o QR Code com seu app de pagamento para concluir a compra.</p>

    <a href="1compras.php"><button class="botao-voltar">Voltar à Loja</button></a>
</body>
</html>
