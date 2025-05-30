function marcarRealizada(id) {
    if(confirm('Tem certeza que deseja marcar esta tarefa como realizada?')) {
        const token = document.querySelector('meta[name="csrf-token"]').content;
        fetch('../Menezzes/recebe_tarefa.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': token
            },
            body: JSON.stringify({
                acao: 'marcarRealizada',
                id: id,
                pagina: 'index'
            })
        }).then(response => {
            if(response.ok) {
                window.location.reload();
            }
        });
    }
}

function removerTarefa(id) {
    if(confirm('Tem certeza que deseja remover esta tarefa?')) {
        const token = document.querySelector('meta[name="csrf-token"]').content;
        fetch('../Menezzes/recebe_tarefa.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': token
            },
            body: JSON.stringify({
                acao: 'remover',
                id: id,
                pagina: 'index'
            })
        }).then(response => {
            if(response.ok) {
                window.location.reload();
            }
        });
    }
}