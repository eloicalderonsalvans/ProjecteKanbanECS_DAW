<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Responsable</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary: #28a745; /* Verd per a crear/guardar */
            --color-bg: #f7f9fc;
            --color-card-bg: #ffffff;
            --color-shadow: rgba(0, 0, 0, 0.1);
            --color-text: #333;
            --color-link: #007bff;
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
            max-width: 500px;
        }

        h1 {
            font-weight: 700;
            color: #212529;
            margin-top: 0;
            margin-bottom: 25px;
            text-align: center;
        }

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

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1em;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        input[type="text"]:focus, input[type="number"]:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
            outline: none;
        }
        
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
            box-shadow: 0 4px 6px rgba(40, 167, 69, 0.2);
        }
        .primary-btn:hover {
            background-color: #1e7e34;
            transform: translateY(-1px);
        }

        .link-return {
            margin-top: 25px;
            display: inline-block;
            text-decoration: none;
            color: var(--color-link);
            font-weight: 500;
            font-size: 0.95em;
            transition: opacity 0.2s;
        }
        .link-return:hover {
            opacity: 0.8;
            text-decoration: underline;
        }

        /* Estils per errors de validació (opcional, si Laravel els gestiona) */
        .error {
            color: var(--color-danger);
            font-size: 0.85em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Crear Nou Responsable</h1>

        <!-- Mostra errors de validació -->
        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <strong>Hi ha errors de validació:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('responsable.store') }}" method="POST">
            @csrf
            
            <div>
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required>
                @error('nom')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div>
                <label for="cognom">Cognom:</label>
                <input type="text" id="cognom" name="cognom" value="{{ old('cognom') }}" required>
                @error('cognom')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div>
                <label for="edat">Edat:</label>
                <!-- L'edat és un input type number per coherència amb la validació d'integer -->
                <input type="number" id="edat" name="edat" value="{{ old('edat') }}" required min="18">
                @error('edat')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="primary-btn">Guardar Responsable</button>
        </form>

        <div style="text-align: center;">
            <a href="{{ route('responsable.index') }}" class="link-return">← Tornar a la Llista</a>
        </div>
    </div>
</body>
</html>