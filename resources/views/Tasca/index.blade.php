<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban Tasques</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* COLORS */
            --color-primary-gold: #FFD700;
            --color-secondary-pink: #ff69b4;
            --color-text-dark: #1a1a1a;
            
            --color-bg: #b6f6ffff;
            --color-column-bg: #ffffff;
            --color-shadow: rgba(0, 0, 0, 0.15);
            
            --color-card-text-light: #fffefeff;
            --color-card-text-dark: var(--color-text-dark);
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 30px;
            background-color: var(--color-bg);
            color: var(--color-text-dark);
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ffffff; 
            padding: 15px 30px;
            margin: -30px -30px 30px -30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border-radius: 0 0 15px 15px; 
        }

        h1 {
            font-weight: 700;
            color: var(--color-text-dark);
            margin: 0;
        }

        /* BOTONS */
        .primary-btn {
            background-color: var(--color-primary-gold);
            color: var(--color-card-text-dark);
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s;
            box-shadow: 0 4px 6px rgba(255, 215, 0, 0.4);
            border: none;
            cursor: pointer;
            display: inline-block;
        }
        .primary-btn:hover {
            background-color: #e0c500;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(255, 215, 0, 0.5);
        }
        
        .secondary-btn {
            background-color: var(--color-secondary-pink);
            color: var(--color-card-text-light);
            padding: 10px 20px;
            border: 1px solid #ff69b4;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.2s;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(255, 105, 180, 0.3);
        }
        .secondary-btn:hover {
            background-color: #f55598;
        }

        /* KANBAN LAYOUT */
        .kanban {
            display: flex;
            gap: 25px;
            overflow-x: auto;
            padding-bottom: 15px; 
            align-items: flex-start; /* Alinea les columnes i la llegenda a dalt */
        }

        .column {
            background: var(--color-column-bg);
            padding: 20px;
            min-width: 300px; 
            flex-shrink: 0; 
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); 
        }
        .column h3 {
            text-align: center;
            font-weight: 800;
            font-size: 1.4em;
            margin-top: 0;
            margin-bottom: 25px;
            color: var(--color-secondary-pink);
            border-bottom: 3px solid var(--color-primary-gold);
            padding-bottom: 10px;
        }
        .column ul {
            list-style: none;
            padding: 0;
            min-height: 50px;
            margin: 0;
        }

        /* TARGETES (CARDS) */
        .column li {
            margin: 15px 0;
            padding: 18px;
            padding-left: 15px;
            border-radius: 12px; 
            transition: box-shadow 0.3s, transform 0.1s;
            cursor: grab;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1); 
            border-left: 5px solid transparent;
        }
        .column li:hover {
            box-shadow: 0 10px 20px rgba(255, 215, 0, 0.25), 0 0 0 2px var(--color-primary-gold);
            transform: translateY(-5px); 
        }
        .column li.deleting { 
            opacity: 0.4;
            transform: scale(0.95);
        }

        .column li strong {
            display: block;
            font-weight: 700;
            font-size: 1.2em;
            margin-bottom: 8px;
            color: inherit; 
        }
        .card-prioritat, .card-responsable { 
            font-size: 0.9em; 
            opacity: 0.95;
            margin-bottom: 6px;
        }
        .card-actions { 
            margin-top: 15px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding-top: 10px;
            border-top: 1px solid var(--card-border-color, rgba(255, 255, 255, 0.4)); 
        }
        
        .delete-btn {
            background: none; 
            border: none; 
            color: var(--card-delete-color);
            cursor: pointer; 
            padding: 5px;
            font-size: 0.85em;
            text-decoration: underline;
            transition: color 0.2s;
        }
        
        .card-actions a {
            color: var(--card-link-color);
            text-decoration: none;
            font-size: 0.95em;
            font-weight: 700;
            transition: opacity 0.2s;
        }
        .card-actions a:hover { opacity: 0.8; }

        /* COLORS PER PRIORITAT */
        .Baixa { 
            background-color: #343a40; /* Negre */
            color: var(--color-card-text-light);
            --card-link-color: var( --color-card-text-light);
            --card-delete-color: rgba(255, 255, 255, 0.9);
            --card-border-color: rgba(255, 255, 255, 0.4);
            border-left-color: #5a5a5a;
        }
        .Baixa .delete-btn:hover { color: #ff0000; }
        
        .Mitjana { 
            background-color: var(--color-primary-gold); /* Daurat */
            color: var(--color-card-text-light);
            --card-link-color: var(  --color-card-text-light);
            --card-delete-color: rgba(255, 255, 255, 0.9);
            --card-border-color: rgba(255, 255, 255, 0.4);
            border-left-color: #e0c500;
        } 
        .Mitjana .delete-btn:hover { color: #000000; } 
        
        .Alta { 
            background-color: var(--color-secondary-pink); /* Rosa */
            color: var(--color-card-text-light);
            --card-link-color: var(  --color-card-text-light);
            --card-delete-color: rgba(255, 255, 255, 0.9);
            --card-border-color: rgba(255, 255, 255, 0.4);
            border-left-color: #ff1493; /* Rosa més fosc per la vora */
        }
        .Alta .delete-btn:hover { color: #ff0000; }

        /* --- ESTILS DE LA LLEGENDA (NOU) --- */
        .legend-container {
            background: #ffffff;
            padding: 20px;
            border-radius: 15px;
            min-width: 200px;
            max-width: 250px;
            flex-shrink: 0; /* Evita que s'encongeixi */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: sticky; /* Opcional: per si fas scroll, que es vegi */
            left: 0;
        }
        
        .legend-container h3 {
            text-align: center;
            font-weight: 800;
            font-size: 1.2em;
            margin-top: 0;
            margin-bottom: 15px;
            color: var(--color-text-dark);
            border-bottom: 2px solid var(--color-primary-gold);
            padding-bottom: 8px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 8px;
        }

        /* Cercles de color per la llegenda */
        .color-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 12px;
            border: 2px solid rgba(0,0,0,0.1);
        }
        .dot-alta { background-color: var(--color-secondary-pink); }
        .dot-mitjana { background-color: var(--color-primary-gold); }
        .dot-baixa { background-color: #343a40; }

        .legend-text {
            display: flex;
            flex-direction: column;
        }
        .legend-title {
            font-weight: 700;
            font-size: 0.95em;
        }
        .legend-desc {
            font-size: 0.8em;
            color: #666;
        }

        /* MISSATGES I MODALS */
        .message { 
            padding: 15px; margin-bottom: 25px; border-radius: 6px; font-weight: 600;
            box-shadow: 0 2px 4px var(--color-shadow); display: none;
        }
        .message.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .message.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .message.warning { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }

        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6); display: flex; justify-content: center;
            align-items: center; z-index: 1000; opacity: 0; pointer-events: none;
            transition: opacity 0.3s;
        }
        .modal-overlay.open { opacity: 1; pointer-events: auto; }
        .modal-content {
            background: white; padding: 30px; border-radius: 12px; width: 90%; max-width: 400px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3); color: var(--color-text-dark);
            text-align: center; transform: translateY(-20px); transition: transform 0.3s ease-out;
        }
        .modal-overlay.open .modal-content { transform: translateY(0); }
        .modal-actions { display: flex; justify-content: space-around; gap: 10px; margin-top: 20px;}
    </style>
</head>
<body>
    <header>
        <h1>Kanban de Tasques</h1>
        <nav>
            <a href="{{ route('responsable.create') }}" class="primary-btn" style="margin-right: 10px;">Crear Responsable</a>
            <a href="{{ route('tasca.create') }}" class="primary-btn">Crear Tasca</a>
        </nav>
    </header>

    <div id="status-message" class="message"></div>

    <div class="kanban">
        @foreach(['pendents','en_proces','completades'] as $estat)
        <div class="column">
            <h3>{{ ucfirst(str_replace('_',' ',$estat)) }}</h3>
            <ul id="{{ $estat }}" class="sortable" data-estat="{{ $estat }}">
                @foreach($tascas->where('estat', $estat)->sortBy('posicio') as $tasca)
                    <li data-id="{{ $tasca->id_tasca }}" class="{{ $tasca->prioritat }} card-handle">
                        <strong>{{ $tasca->titol }}</strong>
                        <div class="card-prioritat">Prioritat: {{ $tasca->prioritat }}</div>
                        <div class="card-responsable">Responsable: {{ $tasca->responsable }}</div>
                        
                        <div class="card-actions">
                            <a href="{{ route('tasca.edit', $tasca->id_tasca) }}">Editar</a>
                            <button class="delete-btn" data-id="{{ $tasca->id_tasca }}" data-titol="{{ $tasca->titol }}">Eliminar</button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        @endforeach

        <div class="legend-container">
            <h3>Llegenda</h3>
            
            <div class="legend-item">
                <div class="color-dot dot-alta"></div>
                <div class="legend-text">
                    <span class="legend-title">Alta</span>
                    <span class="legend-desc">Urgent / Crític</span>
                </div>
            </div>

            <div class="legend-item">
                <div class="color-dot dot-mitjana"></div>
                <div class="legend-text">
                    <span class="legend-title">Mitjana</span>
                    <span class="legend-desc">Important</span>
                </div>
            </div>

            <div class="legend-item">
                <div class="color-dot dot-baixa"></div>
                <div class="legend-text">
                    <span class="legend-title">Baixa</span>
                    <span class="legend-desc">Normal / En espera</span>
                </div>
            </div>
        </div>
        </div>

    <div id="custom-confirm-modal" class="modal-overlay">
        <div class="modal-content">
            <p id="confirm-message">Estàs segur que vols eliminar aquesta tasca?</p>
            <div class="modal-actions">
                <button id="confirm-yes" class="primary-btn">Sí, Eliminar</button>
                <button id="confirm-no" class="secondary-btn">Cancel·lar</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        const statusMessage = document.getElementById('status-message');
        const customConfirmModal = document.getElementById('custom-confirm-modal');
        const confirmMessage = document.getElementById('confirm-message');
        const confirmYesBtn = document.getElementById('confirm-yes');
        const confirmNoBtn = document.getElementById('confirm-no');
        let pendingAction = null;

        function showCustomConfirm(message, callback) {
            confirmMessage.textContent = message;
            pendingAction = callback;
            customConfirmModal.classList.add('open');
        }

        confirmYesBtn.addEventListener('click', () => {
            customConfirmModal.classList.remove('open');
            if (pendingAction) { pendingAction(); pendingAction = null; }
        });

        confirmNoBtn.addEventListener('click', () => {
            customConfirmModal.classList.remove('open');
            pendingAction = null;
        });

        function showMessage(type, text) {
            statusMessage.className = `message ${type}`;
            statusMessage.textContent = text;
            statusMessage.style.display = 'block';
            setTimeout(() => { statusMessage.style.display = 'none'; }, 3000);
        }

        function handleDelete(id, listItem) {
            showMessage('warning', `Eliminant la tasca ${id}...`);
            listItem.classList.add('deleting');
            
            fetch("{{ url('tasca') }}/" + id, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                }
            })
            .then(res => {
                listItem.classList.remove('deleting');
                if (!res.ok) throw new Error('Error: ' + res.status);
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    listItem.remove();
                    showMessage('success', `Tasca eliminada. Recarregant...`);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showMessage('error', 'Error del servidor.');
                }
            })
            .catch(err => {
                showMessage('error', `Error: ${err.message}`);
                listItem.classList.remove('deleting');
            });
        }
        
        document.querySelectorAll('.sortable').forEach(list => {
            new Sortable(list, {
                group: 'kanban', 
                animation: 150,
                onEnd: function(evt) {
                    const id = evt.item.dataset.id;
                    const estat = evt.to.dataset.estat;
                    const posicio = Array.from(evt.to.children).indexOf(evt.item);

                    fetch("{{ route('tasca.kanban.update') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}" 
                        },
                        body: JSON.stringify({ id_tasca: id, estat: estat, posicio: posicio })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(!data.success) showMessage('error', 'Error actualitzant Kanban.');
                    })
                    .catch(err => showMessage('error', err.message));
                }
            });
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const titol = this.dataset.titol;
                const listItem = this.closest('li');
                showCustomConfirm(`Eliminar "${titol}"?`, () => handleDelete(id, listItem));
            });
        });
    </script>
</body>
</html>