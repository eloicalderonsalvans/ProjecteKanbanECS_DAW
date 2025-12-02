<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tasca</title>
    <!-- Font de Google: Poppins per un aspecte modern i coherent -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --color-primary: #007bff; /* Blau primari */
            --color-bg: #f7f9fc; /* Fons clar */
            --color-card-bg: #ffffff; /* Fons del formulari */
            --color-shadow: rgba(0, 0, 0, 0.1);
            --color-text: #333;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 30px;
            background-color: var(--color-bg);
            color: var(--color-text);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 600px;
        }

        h1 {
            font-weight: 700;
            color: #212529;
            margin-top: 0;
            margin-bottom: 25px;
            text-align: center;
        }

        /* Estil de la targeta/formulari principal */
        form {
            background-color: var(--color-card-bg);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px var(--color-shadow);
        }

        form div { 
            margin-bottom: 20px; 
        }

        label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 600; 
            color: #555;
            font-size: 0.95em;
        }

        input[type="text"], textarea, select {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1em;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        input[type="text"]:focus, textarea:focus, select:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
            outline: none;
        }

        textarea { 
            resize: vertical; 
            height: 120px; 
        }
        
        /* Botó d'acció primària (Actualitzar Tasca) */
        .primary-btn {
            width: 100%;
            background-color: var(--color-primary);
            color: white;
            padding: 12px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: 600;
            transition: background-color 0.2s, transform 0.1s;
            box-shadow: 0 4px 6px rgba(0, 123, 255, 0.2);
        }
        .primary-btn:hover {
            background-color: #0056b3;
            transform: translateY(-1px);
        }

        /* Enllaç de retorn */
        .link-return {
            margin-top: 25px;
            display: inline-block;
            text-decoration: none;
            color: var(--color-primary);
            font-weight: 500;
            font-size: 0.95em;
            transition: opacity 0.2s;
        }
        .link-return:hover {
            opacity: 0.8;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Tasca: {{ $tasca->titol }}</h1>

        <!-- El formulari apunta a la ruta 'tasca.update' que fa servir el mètode update del controlador -->
        <form action="{{ route('tasca.update', $tasca->id_tasca) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div>
                <label for="titol">Títol:</label>
                <input type="text" id="titol" name="titol" value="{{ $tasca->titol }}" required>
            </div>
            
            <div>
                <label for="descripcio">Descripció:</label>
                <textarea id="descripcio" name="descripcio">{{ $tasca->descripcio }}</textarea>
            </div>
            
            <div>
                <label for="prioritat">Prioritat:</label>
                <select id="prioritat" name="prioritat">
                    <option value="Baixa" {{ $tasca->prioritat === 'Baixa' ? 'selected' : '' }}>Baixa</option>
                    <option value="Mitjana" {{ $tasca->prioritat === 'Mitjana' ? 'selected' : '' }}>Mitjana</option>
                    <option value="Alta" {{ $tasca->prioritat === 'Alta' ? 'selected' : '' }}>Alta</option>
                </select>
            </div>
            
            <div>
                <label for="responsable">Responsable:</label>
                <input type="text" id="responsable" name="responsable" value="{{ $tasca->responsable }}">
            </div>
            
            <div>
                <label for="estat">Estat:</label>
                <select id="estat" name="estat">
                    <option value="pendents" {{ $tasca->estat === 'pendents' ? 'selected' : '' }}>Pendents</option>
                    <option value="en_proces" {{ $tasca->estat === 'en_proces' ? 'selected' : '' }}>En procés</option>
                    <option value="completades" {{ $tasca->estat === 'completades' ? 'selected' : '' }}>Completades</option>
                </select>
            </div>
            
            <button type="submit" class="primary-btn">Actualitzar Tasca</button>
        </form>

        <div style="text-align: center;">
            <a href="{{ route('tasca.index') }}" class="link-return">← Tornar al Kanban</a>
        </div>
    </div>
</body>
</html>
