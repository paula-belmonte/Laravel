<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Chocolates</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f1e7;
            color: #5b4e2f;
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            text-align: center;
            color: #6f4f28;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        .item {
            background-color: #e7d4b8;
            border-radius: 10px;
            margin: 10px 0;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .item h3 {
            color: #4f3b2f;
            margin: 0 0 10px 0;
        }

        .item button {
            background-color: #6f4f28;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin: 5px;
        }

        .item button:hover {
            background-color: #8f6a46;
        }

        form {
            background-color: #e7d4b8;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        form input, form select, form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #d4b57d;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        form input:focus, form select:focus {
            border-color: #6f4f28;
            outline: none;
        }

        form button {
            background-color: #6f4f28;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        form button:hover {
            background-color: #8f6a46;
        }

        .btn-center {
            text-align: center;
        }

        .hidden {
            display: none;
        }

        select {
            color: #4f3b2f;
            background-color: #f9f1e7;
        }
    </style>
</head>
<body>
    <h1>Gestión de Chocolates</h1>
    
    <h2>Tipos de Chocolates</h2>
    <div id="tipos"></div>

    <h2>Chocolates</h2>
    <div id="chocolates"></div>
    
    <h2>Agregar Nuevo Tipo de Chocolate</h2>
    <form id="tipoForm">
        <input type="text" id="descripcionTipo" placeholder="Descripción" required>
        <button type="submit">Agregar Tipo</button>
    </form>
    
    <h2>Agregar Nuevo Chocolate</h2>
    <form id="chocolateForm">
        <input type="text" id="nombreChocolate" placeholder="Nombre" required>
        <input type="text" id="marcaChocolate" placeholder="Marca" required>
        <input type="number" id="porcentajeCacao" placeholder="Porcentaje de cacao" required>
        <select id="tipoChocolate" required>
            <option value="">Seleccione un Tipo</option>
        </select>
        <button type="submit">Agregar Chocolate</button>
    </form>

    <h2>Actualizar Chocolate</h2>
    <form id="chocolateUpdateForm" style="display:none;">
        <input type="hidden" id="updateChocolateId">
        <input type="text" id="updateNombreChocolate" placeholder="Nuevo Nombre" required>
        <input type="text" id="updateMarcaChocolate" placeholder="Nueva Marca" required>
        <input type="number" id="updatePorcentajeCacao" placeholder="Nuevo Porcentaje de Cacao" required>
        <select id="updateTipoChocolate" required></select>
        <button type="submit">Actualizar Chocolate</button>
    </form>

    <script>
        let tipos = {};

        // Cargar tipos de chocolates
        fetch('/api/tipos')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('tipos');
                const tipoSelect = document.getElementById('tipoChocolate');
                data.forEach(tipo => {
                    tipos[tipo.id] = tipo.descripcion;
                    container.innerHTML += `
                        <div class="item" data-id="${tipo.id}">
                            <h3>${tipo.descripcion}</h3>
                            <button onclick="deleteTipo(${tipo.id})">Eliminar</button>
                        </div>`;
                    tipoSelect.innerHTML += `<option value="${tipo.id}">${tipo.descripcion}</option>`;
                });
                cargarChocolates();
            });

        // Cargar chocolates
        function cargarChocolates() {
            fetch('/api/chocolates')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('chocolates');
                    container.innerHTML = '';
                    data.forEach(chocolate => {
                        const tipoDescripcion = tipos[chocolate.codigotipo] || 'Desconocido';
                        container.innerHTML += `
                            <div class="item" data-id="${chocolate.id}">
                                <h3>${chocolate.nombre} - ${chocolate.marca} (${chocolate.porcentaje}% cacao, ${tipoDescripcion})</h3>
                                <button onclick="editChocolate(${chocolate.id})">Editar</button>
                                <button onclick="deleteChocolate(${chocolate.id})">Eliminar</button>
                            </div>`;
                    });
                });
        }

        // Agregar Tipo de Chocolate
        document.getElementById('tipoForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const descripcion = document.getElementById('descripcionTipo').value;
            fetch('/api/tipos', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ descripcion })
            }).then(response => response.json())
              .then(tipo => {
                  tipos[tipo.id] = tipo.descripcion;
                  document.getElementById('tipos').innerHTML += `
                      <div class="item" data-id="${tipo.id}">
                          <h3>${tipo.descripcion}</h3>
                          <button onclick="deleteTipo(${tipo.id})">Eliminar</button>
                      </div>`;
                  document.getElementById('tipoChocolate').innerHTML += `<option value="${tipo.id}">${tipo.descripcion}</option>`;
                  document.getElementById('tipoForm').reset();
              });
        });

        // Agregar Chocolate
        document.getElementById('chocolateForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const nombre = document.getElementById('nombreChocolate').value;
            const marca = document.getElementById('marcaChocolate').value;
            const porcentaje = document.getElementById('porcentajeCacao').value;
            const codigotipo = document.getElementById('tipoChocolate').value;
            fetch('/api/chocolates', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nombre, marca, porcentaje, codigotipo })
            }).then(response => response.json())
              .then(() => {
                  cargarChocolates();
                  document.getElementById('chocolateForm').reset();
              });
        });

        // Editar Chocolate
        function editChocolate(id) {
            const chocolateData = document.querySelector(`.item[data-id="${id}"]`);
            const nombre = chocolateData.querySelector('h3').textContent.split(' - ')[0];
            const marca = chocolateData.querySelector('h3').textContent.split(' - ')[1].split(' ')[0];
            const porcentaje = chocolateData.querySelector('h3').textContent.split('(')[1].split('%')[0];
            const tipoId = chocolateData.querySelector('h3').textContent.split('(')[1].split(')')[0].split(',')[1].trim();

            document.getElementById('updateChocolateId').value = id;
            document.getElementById('updateNombreChocolate').value = nombre;
            document.getElementById('updateMarcaChocolate').value = marca;
            document.getElementById('updatePorcentajeCacao').value = porcentaje;
            document.getElementById('updateTipoChocolate').innerHTML = '';

            for (const tipo in tipos) {
                document.getElementById('updateTipoChocolate').innerHTML += `<option value="${tipo}" ${tipo == tipoId ? 'selected' : ''}>${tipos[tipo]}</option>`;
            }

            document.getElementById('chocolateUpdateForm').style.display = 'block';
        }

        // Actualizar Chocolate
        document.getElementById('chocolateUpdateForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('updateChocolateId').value;
            const nombre = document.getElementById('updateNombreChocolate').value;
            const marca = document.getElementById('updateMarcaChocolate').value;
            const porcentaje = document.getElementById('updatePorcentajeCacao').value;
            const codigotipo = document.getElementById('updateTipoChocolate').value;
            fetch(`/api/chocolates/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nombre, marca, porcentaje, codigotipo })
            }).then(response => response.json())
              .then(chocolate => {
                  cargarChocolates();
                  document.getElementById('chocolateUpdateForm').style.display = 'none';
              });
        });

        // Eliminar Tipo de Chocolate
        function deleteTipo(id) {
            fetch(`/api/tipos/${id}`, { method: 'DELETE' })
                .then(() => {
                    document.querySelector(`.item[data-id="${id}"]`).remove();
                    document.querySelector(`#tipoChocolate option[value="${id}"]`).remove();
                    delete tipos[id];
                    cargarChocolates();
                });
        }

        // Eliminar Chocolate
        function deleteChocolate(id) {
            fetch(`/api/chocolates/${id}`, { method: 'DELETE' })
                .then(() => {
                    document.querySelector(`.item[data-id="${id}"]`).remove();
                });
        }
    </script>
</body>
</html>
