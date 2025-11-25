<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban Tasques</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .kanban { display: flex; gap: 20px; }
        .column { background: #f4f4f4; padding: 10px; width: 300px; border-radius: 5px; }
        .column h3 { text-align: center; }
        .column ul { list-style: none; padding: 0; min-height: 50px; }
        .column li { background: #fff; margin: 5px 0; padding: 10px; border-radius: 3px; cursor: grab; }
        nav a { margin-right: 10px; text-decoration: none; }
    </style>
</head>
<body>
    <header>
        <h1>Kanban de Tasques</h1>
        <nav>
            <a href="{{ route('tasca.index') }}">Kanban</a>
            <a href="{{ route('tasca.create') }}">Crear Tasca</a>
        </nav>
        <hr>
    </header>

    <div class="kanban">
        @foreach(['pendents','en_proces','completades'] as $estat)
        <div class="column">
            <h3>{{ ucfirst($estat) }}</h3>
            <ul id="{{ $estat }}" class="sortable" data-estat="{{ $estat }}">
                @foreach($tascas->where('estat', $estat)->sortBy('posicio') as $tasca)
                    <li data-id="{{ $tasca->id_tasca }}">{{ $tasca->nom }}</li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
    document.querySelectorAll('.sortable').forEach(list => {
        new Sortable(list, {
            group: 'kanban',
            animation: 150,
            onEnd: function(evt) {
                let id = evt.item.dataset.id;
                let estat = evt.to.dataset.estat;
                let posicio = Array.from(evt.to.children).indexOf(evt.item);

                fetch("{{ route('tasca.kanban.update') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ id_tasca: id, estat: estat, posicio: posicio })
                });
            }
        });
    });
    </script>
</body>
</html>
