<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban Tasques</title>
    <!-- Font de Google: Poppins per un aspecte més modern -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Colors principals segons la teva petició */
            --color-primary-gold: #FFD700; /* Daurat/Gold per accions principals i Mitjana prioritat */
            --color-secondary-pink: #ff69b4; /* Rosa/Pink per Alta prioritat i accents */
            --color-text-dark: #1a1a1a; /* Negre molt fosc */
            
            /* Fons i contenidors */
            --color-bg: #b6f6ffff; /* Blau Cel molt clar */
            --color-column-bg: #ffffff; /* Fons de columna blanc pur per contrast */
            --color-shadow: rgba(0, 0, 0, 0.15); /* Ombra suau */
            
            /* Textos */
            --color-card-text-light: #ffffff; /* Text clar (per fons fosc com el negre i rosa) */
            --color-card-text-dark: var(--color-text-dark); /* Text fosc (per fons clar com el daurat) */
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
            /* Fons blanc per contrastar amb el blau cel i donar un efecte d'elevació */
            background-color: #ffffff; 
            padding: 15px 30px;
            margin: -30px -30px 30px -30px; /* Estendre a les vores de l'àrea de visualització */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border-radius: 0 0 15px 15px; 
        }

        h1 {
            font-weight: 700;
            color: var(--color-text-dark);
            margin: 0;
        }

        /* Estil del botó d'acció primària (Crear Tasca) - Daurat */
        .primary-btn {
            background-color: var(--color-primary-gold);
            color: var(--color-card-text-dark); /* Text negre sobre daurat */
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.2s, transform 0.1s, box-shadow 0.2s;
            box-shadow: 0 4px 6px rgba(255, 215, 0, 0.4);
            border: none;
            cursor: pointer;
            display: inline-block;
        }
        .primary-btn:hover {
            background-color: #e0c500; /* Daurat fosc */
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(255, 215, 0, 0.5);
        }
        
        /* Estils per al botó secundari (Usat al Modal) - Rosa */
        .secondary-btn {
            background-color: var(--color-secondary-pink);
            color: var(--color-card-text-light); /* Text blanc sobre rosa */
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

        /* Contenidor Kanban */
        .kanban {
            display: flex;
            gap: 25px; /* Més espai entre columnes */
            overflow-x: auto;
            padding-bottom: 15px; 
        }

        /* Estil de Columna */
        .column {
            background: var(--color-column-bg); /* Blanc */
            padding: 20px;
            min-width: 300px; 
            flex-shrink: 0; 
            border-radius: 15px; /* Molt arrodonit */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); 
        }
        .column h3 {
            text-align: center;
            font-weight: 800; /* Més gruixut */
            font-size: 1.4em; /* Més gran */
            margin-top: 0;
            margin-bottom: 25px;
            color: var(--color-secondary-pink); /* Títols de columna en Rosa */
            border-bottom: 3px solid var(--color-primary-gold); /* Subratllat en Daurat */
            padding-bottom: 10px;
        }
        .column ul {
            list-style: none;
            padding: 0;
            min-height: 50px;
            margin: 0;
        }

        /* Estil de la Targeta (Task) */
        .column li {
            margin: 15px 0;
            padding: 18px;
            padding-left: 15px; /* Espai per a la vora d'indicador de prioritat */
            border-radius: 12px; 
            /* Afegit border-left per la transició de la vora */
            transition: box-shadow 0.3s, opacity 0.3s, transform 0.1s, border-left 0.3s;
            cursor: grab;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1); 
            border-left: 5px solid transparent; /* Vora inicial transparent */
        }
        .column li:hover {
            /* Nova ombra amb un toc daurat i un lift més gran */
            box-shadow: 0 10px 20px rgba(255, 215, 0, 0.25), 0 0 0 2px var(--color-primary-gold);
            transform: translateY(-5px); 
        }
        .column li.deleting { 
            opacity: 0.4; /* Més transparent per un efecte més dramàtic */
            transform: scale(0.95); /* Una mica d'escala */
        }

        /* Contingut de la Targeta */
        .column li strong {
            display: block;
            font-weight: 700; /* Més gruixut */
            font-size: 1.2em; /* Més gran */
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
            /* El color de la vora es defineix per variable segons la prioritat */
            border-top: 1px solid var(--card-border-color, rgba(255, 255, 255, 0.4)); 
        }
        
        /* Estils del botó Eliminar */
        .delete-btn {
            background: none; 
            border: none; 
            color: var(--card-delete-color); /* Utilitza la variable de color definida per prioritat */
            cursor: pointer; 
            padding: 5px;
            font-size: 0.85em;
            text-decoration: underline;
            transition: color 0.2s;
        }
        /* El color del hover es gestiona dins de cada classe de prioritat (Baixa, Alta) */
        
        /* Enllaç d'edició dins la targeta */
        .card-actions a {
            color: var(--card-link-color); /* Utilitza la variable de color definida per prioritat */
            text-decoration: none;
            font-size: 0.95em;
            font-weight: 700; /* Més gruixut */
            transition: opacity 0.2s;
        }
        .card-actions a:hover {
            opacity: 0.8;
        }

        /* Colores por prioridad (Black, Gold, Pink) */
        .Baixa { 
            background-color: #343a40; /* Negre fosc */
            color: var(--color-card-text-light); /* Text blanc */
            /* Variables per accions i vora */
            --card-link-color: var(--color-primary-gold);
            --card-delete-color: rgba(255, 255, 255, 0.9);
            --card-border-color: rgba(255, 255, 255, 0.4);
            border-left-color: #5a5a5a; /* Gris fosc per indicador Baixa */
        }
        .Baixa .delete-btn:hover { color: #ff0000; } /* Vermell subtil en hover per eliminar */
        
        .Mitjana { 
            background-color: var(--color-primary-gold); /* Daurat */
            color: var(--color-text-dark); /* Text negre */
            /* Variables per accions i vora */
            --card-link-color: #007bff; /* Blau clàssic per contrast amb Daurat */
            --card-delete-color: #4a4a4a; 
            --card-border-color: rgba(0, 0, 0, 0.2); /* Vora fosca sobre fons Daurat */
            border-left-color: #e0c500; /* Daurat fosc per indicador Mitjana */
        }   
        .Mitjana .delete-btn { color: var(--card-delete-color); } 
        .Mitjana .delete-btn:hover { color: #000000; } 
        .Mitjana .card-actions a { color: var(--card-link-color); }
        .Mitjana .card-actions a:hover { color: #0056b3; }

        .Alta { 
            background-color: var(--color-secondary-pink); /* Rosa */
            color: var(--color-card-text-light); /* Text blanc */
            /* Variables per accions i vora */
            --card-link-color: var(--color-primary-gold);
            --card-delete-color: rgba(255, 255, 255, 0.9);
            --card-border-color: rgba(255, 255, 255, 0.4);
            border-left-color: var(--color-secondary-pink); /* Rosa per indicador Alta */
        }
        .Alta .delete-btn:hover { color: #ff0000; }

        /* Els estils de missatges i modals romanen per assegurar funcionalitat */
        .message { 
            padding: 15px; 
            margin-bottom: 25px; 
            border-radius: 6px; 
            font-weight: 600;
            box-shadow: 0 2px 4px var(--color-shadow);
        }
        .message.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .message.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .message.warning { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }
        .modal-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            color: var(--color-text-dark);
            text-align: center;
            transform: translateY(-20px);
            transition: transform 0.3s ease-out;
        }
        .modal-overlay.open .modal-content {
            transform: translateY(0);
        }
        #confirm-message {
            font-size: 1.1em;
            margin-bottom: 25px;
            font-weight: 500;
        }
        .modal-actions {
            display: flex;
            justify-content: space-around;
            gap: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Kanban de Tasques</h1>
        <nav>
            <!-- NOU BOTÓ: Crear Responsable -->
            <a href="{{ route('responsable.create') }}" class="primary-btn" style="margin-right: 10px;">Crear Responsable</a>
            <!-- Botó existent: Crear Tasca -->
            <a href="{{ route('tasca.create') }}" class="primary-btn">Crear Tasca</a>
        </nav>
    </header>

    <!-- Àrea de missatges per a feedback AJAX -->
    <div id="status-message" class="message" style="display: none;"></div>

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
                            <!-- Botó d'Eliminar -->
                            <button class="delete-btn" data-id="{{ $tasca->id_tasca }}" data-titol="{{ $tasca->titol }}">Eliminar</button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
    </div>

    <!-- Custom Confirmation Modal Structure (Reemplaça window.confirm()) -->
    <div id="custom-confirm-modal" class="modal-overlay">
        <div class="modal-content">
            <p id="confirm-message">Estàs segur que vols eliminar aquesta tasca?</p>
            <div class="modal-actions">
                <!-- Botó d'acció (Sí, Eliminar) en Daurat -->
                <button id="confirm-yes" class="primary-btn">Sí, Eliminar</button>
                <!-- Botó de Cancel·lar en Rosa -->
                <button id="confirm-no" class="secondary-btn">Cancel·lar</button>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        // La lògica de JavaScript es manté intacta ja que només es van demanar canvis estètics.
        const statusMessage = document.getElementById('status-message');
        
        // Variables per al modal de confirmació
        const customConfirmModal = document.getElementById('custom-confirm-modal');
        const confirmMessage = document.getElementById('confirm-message');
        const confirmYesBtn = document.getElementById('confirm-yes');
        const confirmNoBtn = document.getElementById('confirm-no');
        let pendingAction = null; // Funció de callback per a l'acció

        // Funció per mostrar el modal de confirmació
        function showCustomConfirm(message, callback) {
            confirmMessage.textContent = message;
            pendingAction = callback;
            customConfirmModal.classList.add('open');
        }

        // Handler pel botó Sí del modal
        confirmYesBtn.addEventListener('click', () => {
            customConfirmModal.classList.remove('open');
            if (pendingAction) {
                pendingAction();
                pendingAction = null; 
            }
        });

        // Handler pel botó No del modal
        confirmNoBtn.addEventListener('click', () => {
            customConfirmModal.classList.remove('open');
            pendingAction = null;
        });

        // Funció per mostrar missatges de feedback
        function showMessage(type, text) {
            statusMessage.className = `message ${type}`;
            statusMessage.textContent = text;
            statusMessage.style.display = 'block';
            setTimeout(() => {
                statusMessage.style.display = 'none';
            }, 3000);
        }

        // Funció per gestionar l'eliminació
        function handleDelete(id, listItem) {
            showMessage('warning', `Eliminant la tasca ${id}...`);

            listItem.classList.add('deleting');
            
            // Simulem l'eliminació amb Fetch API (assumint que la ruta Laravel existeix)
            fetch("{{ url('tasca') }}/" + id, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}", // Protecció CSRF
                    "Content-Type": "application/json"
                }
            })
            .then(res => {
                listItem.classList.remove('deleting');
                if (!res.ok) {
                    throw new Error('La petició DELETE ha fallat amb codi d\'estat: ' + res.status);
                }
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    // Eliminació de l'element de la llista (DOM)
                    listItem.remove();
                    showMessage('success', `Tasca eliminada correctament. Recarregant la pàgina per reordenar...`);
                    
                    // Recàrrega de la pàgina per assegurar-nos que l'ordenació es manté coherent al backend
                    setTimeout(() => {
                        location.reload();
                    }, 1000); 
                    
                } else {
                    showMessage('error', 'Error del servidor: No s\'ha pogut eliminar la tasca.');
                    console.error('Error al eliminar la tasca:', data);
                }
            })
            .catch(err => {
                showMessage('error', `Error de xarxa o servidor: ${err.message}`);
                console.error('Error:', err);
                listItem.classList.remove('deleting'); // Desfer la transparència si falla
            });
        }
        
        // Inicialització de Sortable (Drag & Drop)
        document.querySelectorAll('.sortable').forEach(list => {
            new Sortable(list, {
                group: 'kanban', 
                animation: 150,
                onEnd: function(evt) {
                    const id = evt.item.dataset.id;
                    const estat = evt.to.dataset.estat;
                    const posicio = Array.from(evt.to.children).indexOf(evt.item);

                    // Lògica d'actualització de Kanban
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
                        if(data.success){
                            // *** CANVI AQUÍ: S'ha eliminat la crida a showMessage('success', ...) ***
                        } else {
                            console.error('Error al actualizar la tasca (Drag/Drop):', data);
                            showMessage('error', 'Error en l\'actualització del Kanban.');
                        }
                    })
                    .catch(err => {
                        showMessage('error', `Error de xarxa en actualitzar el Kanban: ${err.message}`);
                        console.error('Error:', err);
                    });
                }
            });
        });

        // Associació de la funció d'esborrat als botons (utilitzant el modal personalitzat)
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                const id = this.dataset.id;
                const titol = this.dataset.titol;
                const listItem = this.closest('li');
                
                // Utilitzem el modal personalitzat en lloc de window.confirm()
                showCustomConfirm(
                    `Estàs segur que vols eliminar la tasca "${titol}"?`,
                    () => {
                        // Callback que s'executa si l'usuari prem "Sí, Eliminar"
                        handleDelete(id, listItem);
                    }
                );
            });
        });
    </script>
</body>
</html>