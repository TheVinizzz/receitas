<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $receita->nome }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .recipe-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .recipe-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
        }
        .info-item {
            text-align: center;
        }
        .info-label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .ingredients {
            white-space: pre-line;
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #007bff;
        }
        .instructions {
            white-space: pre-line;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        @media print {
            body {
                margin: 0;
            }
            .header {
                page-break-after: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="recipe-title">{{ $receita->nome }}</div>
        <div>Categoria: {{ $receita->categoria->nome }}</div>
        <div>Por: {{ $receita->user->name }}</div>
    </div>

    <div class="recipe-info">
        <div class="info-item">
            <span class="info-label">Tempo de Preparo</span>
            <span>{{ $receita->tempo_preparo_minutos }} minutos</span>
        </div>
        <div class="info-item">
            <span class="info-label">Porções</span>
            <span>{{ $receita->porcoes }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Criado em</span>
            <span>{{ $receita->criado_em->format('d/m/Y') }}</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Ingredientes</div>
        <div class="ingredients">{{ $receita->ingredientes }}</div>
    </div>

    <div class="section">
        <div class="section-title">Modo de Preparo</div>
        <div class="instructions">{{ $receita->modo_preparo }}</div>
    </div>
</body>
</html>