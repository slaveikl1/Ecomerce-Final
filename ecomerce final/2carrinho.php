<?php
session_start();

// Inicializa carrinho se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Limpar carrinho se clicar em "Cancelar"
if (isset($_GET['acao']) && $_GET['acao'] === 'clear') {
    unset($_SESSION['carrinho']);
    header("Location: 1compras.php");
    exit;
}

// Pega carrinho
$carrinho = $_SESSION['carrinho'] ?? [];

// Calcula total
$total = 0;
foreach ($carrinho as $item) {
    $total += $item['preco'] * $item['quantidade'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Seu Carrinho</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { margin: 20px auto; border-collapse: collapse; width: 70%; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background: #f2f2f2; }
        .total { font-weight: bold; background: #e0ffe0; }
        .botoes { margin-top: 20px; }
        button { background: #2831a7ff; color: white; border: none; padding: 8px 12px; border-radius: 10px; cursor: pointer; margin: 0 5px; }
    </style>
</head>
<body>
    <h2>Seu Carrinho</h2>

    <?php if (!empty($carrinho)): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Tamanho</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Subtotal</th>
            </tr>
            <?php foreach ($carrinho as $item): 
                $subtotal = $item['preco'] * $item['quantidade'];
            ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= $item['nome'] ?></td>
                    <td><?= $item['tamanho'] ?></td>
                    <td><?= $item['quantidade'] ?></td>
                    <td>R$ <?= number_format($item['preco'],2,",",".") ?></td>
                    <td>R$ <?= number_format($subtotal,2,",",".") ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="total">
                <td colspan="5">Total</td>
                <td>R$ <?= number_format($total,2,",",".") ?></td>
            </tr>
        </table>

        <div class="botoes">
            <a href="1compras.php"><button>Voltar</button></a>
            <a href="2carrinho.php?acao=clear"><button>Cancelar</button></a>
            <a href="3pagamento.php"><button>Finalizar Compra</button></a>
        </div>
    <?php else: ?>
        <p>Seu carrinho está vazio!</p>
        <a href="1compras.php"><button>Voltar para Compras</button></a>
    <?php endif; ?>
</body>
</html>
