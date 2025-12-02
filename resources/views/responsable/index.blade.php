<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestió de Responsables</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary: #007bff; /* Blau per a botons d'acció */
            --color-success: #28a745; /* Verd per a missatges i botó Creació */
            --color-danger: #dc3545; /* Vermell per a eliminar */
            --color-bg: #f7f9fc;
            --color-card-bg: #ffffff;
            --color-text: #333;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 30px;
            background-color: var(--color-bg);
            color: var(--color-text);
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        h1 {
            font-weight: 700;
            color: #212529;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        /* Missatges d'estat (success) */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            font-weight: 600;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: background-color 0.2s;
            border: none;
            cursor: pointer;
            text-align: center;
        }
        
        /* Botó primari (Crear) */
        .btn-primary {
            background-color: var(--color-success);
            color: white;
            margin-bottom: 20px;
        }
        .btn-primary:hover {
            background-color: #1e7e34;
        }

        /* Botó d'acció (Taula) */
        .btn-edit {
            background-color: var(--color-primary);
            color: white;
            padding: 5px 10px;
            font-size: 0.9em;
        }
        .btn-edit:hover {
            background-color: #0056b3;
        }

        /* Botó d'esborrat (Taula) */
        .btn-delete {
            background-color: var(--color-danger);
            color: white;
            padding: 5px 10px;
            font-size: 0.9em;
            margin-left: 5px;
        }
        .btn-delete:hover {
            background-color: #bd2130;
        }

        /* Taula d'estil modern */
        .table-container {
            background-color: var(--color-card-bg);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f1f1f1;
            font-weight: 600;
            color: #555;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f0f8ff;
        }
        
        .actions {
            white-space: nowrap; /* Evita que els botons es trenquin */
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestió de Responsables</h1>

        <a href="{{ route('responsable.create') }}" class="btn btn-primary">Crear Nou Responsable</a>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom Complet</th>
                        <th>Edat</th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($responsables as $responsable)
                        <tr>
                            <td>{{ $responsable->id_resposable }}</td>
                            <td>{{ $responsable->nom_complet }}</td>
                            <td>{{ $responsable->edat }}</td>
                            <td class="actions">
                                <a href="{{ route('responsable.edit', $responsable->id_resposable) }}" class="btn btn-edit">Editar</a>
                                
                                <form action="{{ route('responsable.destroy', $responsable->id_resposable) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('Estàs segur que vols eliminar aquest responsable?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>