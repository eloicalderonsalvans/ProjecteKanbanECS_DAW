<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban Tasques</title>
    <!-- Font de Google: Poppins per un aspecte més modern -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --color-primary: #007bff; /* Blau primari */
            --color-bg: #f7f9fc; /* Fons clar */
            --color-column-bg: #ebecf0; /* Fons de columna suau */
            --color-shadow: rgba(0, 0, 0, 0.1);
            --color-text: #333;
            --color-card-text: #ffffff; 
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 30px;
            background-color: var(--color-bg);
            color: var(--color-text);
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 15px;
        }

        h1 {
            font-weight: 700;
            color: #212529;
            margin: 0;
        }

        /* Estil del botó d'acció primària (Crear Tasca) */
        .primary-btn {
            background-color: var(--color-primary);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.2s, transform 0.1s;
            box-shadow: 0 4px 6px rgba(0, 123, 255, 0.2);
            border: none;
            cursor: pointer;
            display: inline-block;
        }
        .primary-btn:hover {
            background-color: #0056b3;
            transform: translateY(-1px);
        }
        
        /* Estils per al botó secundari (Usat al Modal) */
        .secondary-btn {
            background-color: #f0f0f0;
            color: var(--color-text);
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.2s;
            cursor: pointer;
        }
        .secondary-btn:hover {
            background-color: #e0e0e0;
        }

        /* Contenidor Kanban */
        .kanban {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding-bottom: 10px; /* Espai per scroll horitzontal */
        }

        /* Estil de Columna */
        .column {
            background: var(--color-column-bg);
            padding: 15px;
            min-width: 320px; /* Fila la columna lleugerament més ampla */
            flex-shrink: 0; /* Important per al layout horitzontal */
            flex-grow: 1;
            border-radius: 10px; /* Més arrodonit */
            box-shadow: 0 6px 12px var(--color-shadow); /* Ombra més profunda */
        }
        .column h3 {
            text-align: center;
            font-weight: 700;
            font-size: 1.25em;
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
            border-bottom: 1px solid #c9ccd0;
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
            margin: 12px 0;
            padding: 15px;
            border-radius: 8px; /* Targeta arrodonida */
            color: var(--color-card-text);
            transition: box-shadow 0.3s, opacity 0.3s, transform 0.1s;
            cursor: grab;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15); 
        }
        .column li:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25); 
            transform: translateY(-2px); /* Lleuger aixecament */
        }
        .column li.deleting { 
            opacity: 0.5; 
        }

        /* Contingut de la Targeta */
        .column li strong {
            display: block;
            font-weight: 600;
            font-size: 1.15em;
            margin-bottom: 8px;
            color: inherit; 
        }
        .card-prioritat, .card-responsable { 
            font-size: 0.85em; 
            opacity: 0.9;
            margin-bottom: 4px;
        }
        .card-actions { 
            margin-top: 15px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.3); 
        }
        
        /* Estils del botó Eliminar */
        .delete-btn {
            background: none; 
            border: none; 
            color: rgba(255, 255, 255, 0.8); /* Més subtil */
            cursor: pointer; 
            padding: 5px;
            font-size: 0.85em;
            text-decoration: underline;
            transition: color 0.2s;
        }
        .delete-btn:hover {
            color: #ffebeb;
        }
        
        /* Enllaç d'edició dins la targeta */
        .card-actions a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 0.9em;
            font-weight: 500;
            transition: opacity 0.2s;
        }
        .card-actions a:hover {
            opacity: 0.7;
        }

        /* Colores por prioridad */
        .Baixa { background-color: #6c757d; color: var(--color-card-text); } /* gris fosc */
        .Mitjana { 
            background-color: #ffc107; 
            color: #333; /* Forcem text fosc */
        }    
        .Mitjana .delete-btn { color: #856404; } 
        .Mitjana .card-actions a { color: #007bff; } 
        .Alta { background-color: #dc3545; color: var(--color-card-text); } /* vermell */

        /* Estils per al missatge de feedback */
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

        /* Estils del Modal de Confirmació Personalitzat (substitut de window.confirm) */
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
            color: var(--color-text);
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
                <button id="confirm-yes" class="primary-btn">Sí, Eliminar</button>
                <button id="confirm-no" class="secondary-btn">Cancel·lar</button>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
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
                             showMessage('success', `Estat de la tasca ${id} actualitzat.`);
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