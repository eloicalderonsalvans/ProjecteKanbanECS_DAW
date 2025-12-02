<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Responsable</title>
    <!-- Font de Google: Poppins per un aspecte modern i coherent -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --color-primary-create: #007bff; /* Blau per a la gestió d'usuaris */
            --color-bg: #f7f9fc; /* Fons clar */
            --color-card-bg: #ffffff; /* Fons del formulari */
            --color-shadow: rgba(0, 0, 0, 0.1);
            --color-text: #333;
            --color-link: #6c757d; /* Gris per a l'enllaç de retorn */
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
            border-color: var(--color-primary-create);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1); /* Ombra blava de focus */
            outline: none;
        }

        /* Missatges d'error i èxit */
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9em;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            font-weight: 600;
            text-align: center;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.85em;
            margin-top: 5px;
            font-weight: 500;
        }

        /* Botó d'acció primària (Crear Responsable) - Blau */
        .primary-btn {
            width: 100%;
            background-color: var(--color-primary-create);
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
            color: var(--color-link);
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
        <h1>Afegir Nou Responsable</h1>

        <!-- Mostra missatge d'èxit si existeix -->
        @if (session('success'))
            <div class="message success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Mostra errors de validació -->
        @if ($errors->any())
            <div class="message error">
                <strong>S'han trobat errors:</strong>
                <ul style="margin-top: 5px; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- El formulari apunta a la ruta 'responsable.store' -->
        <form action="{{ route('responsable.store') }}" method="POST">
            @csrf
            
            <div>
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required>
                @error('nom')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div>
                <label for="cognom">Cognom:</label>
                <input type="text" id="cognom" name="cognom" value="{{ old('cognom') }}" required>
                @error('cognom')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div>
                <label for="edat">Edat:</label>
                <input type="number" id="edat" name="edat" value="{{ old('edat') }}" required min="18">
                @error('edat')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="primary-btn">Crear Responsable</button>
        </form>

        <div style="text-align: center;">
            <!-- CANVI: Ara redirigeix al Kanban en lloc de la llista de responsables -->
            <a href="{{ route('tasca.index') }}" class="link-return">← Tornar al Kanban</a>
        </div>
    </div>
</body>
</html>