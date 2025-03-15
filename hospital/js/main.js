document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');

    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });

    // Cerrar el menú al hacer clic en un enlace
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('active');
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    // Cargar datos iniciales
    loadPacientes();
    loadMedicos();
    loadEquipos();

    // Eventos del formulario de pacientes
    const pacienteForm = document.getElementById('paciente-form');
    if (pacienteForm) {
        pacienteForm.addEventListener('submit', handlePacienteForm);
    }

    // Eventos del chat IA (se implementará posteriormente)
    setupChat();
});

// Cargar lista de pacientes
function loadPacientes() {
    fetch('php/pacientes_controller.php?action=list')
        .then(response => response.json())
        .then(data => {
            const pacientesList = document.getElementById('pacientes-list');
            if (pacientesList) {
                pacientesList.innerHTML = data.map(paciente => `
                    <div class="paciente-card">
                        <h3>${paciente.nombre} ${paciente.apellido1}</h3>
                        <p>DNI: ${paciente.DNI}</p>
                        <p>Teléfono: ${paciente.TLF}</p>
                        <p>Estado: ${paciente.estado}</p>
                        <button onclick="editPaciente(${paciente.id_paciente})">Editar</button>
                        <button onclick="deletePaciente(${paciente.id_paciente})">Eliminar</button>
                    </div>
                `).join('');
            }
        })
        .catch(error => console.error('Error cargando pacientes:', error));
}

// Cargar lista de médicos
function loadMedicos() {
    fetch('php/medicos_controller.php?action=list')
        .then(response => response.json())
        .then(data => {
            const medicosList = document.getElementById('medicos-list');
            if (medicosList) {
                medicosList.innerHTML = data.map(medico => `
                    <div class="medico-card">
                        <h3>${medico.nombre} ${medico.apellido1}</h3>
                        <p>Especialidad: ${medico.especialidad}</p>
                        <p>Turno: ${medico.turno}</p>
                    </div>
                `).join('');
            }
        })
        .catch(error => console.error('Error cargando médicos:', error));
}

// Cargar lista de equipos
function loadEquipos() {
    fetch('php/equipos_controller.php')
        .then(response => response.json())
        .then(data => {
            const equiposList = document.getElementById('equipos-list');
            if (equiposList) {
                equiposList.innerHTML = data.map(equipo => `
                    <div class="equipo-card">
                        <h3>${equipo.Nombre_Dispositivo}</h3>
                        <p>Función: ${equipo.Funcion}</p>
                        <p>Estado: ${equipo.Estado}</p>
                    </div>
                `).join('');
            }
        })
        .catch(error => console.error('Error cargando equipos:', error));
}

// Manejar el formulario de pacientes
function handlePacienteForm(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const pacienteData = {
        nombre: formData.get('nombre'),
        apellido1: formData.get('apellido1'),
        apellido2: formData.get('apellido2'),
        dni: formData.get('dni'),
        tlf: formData.get('tlf'),
        poliza: formData.get('poliza'),
        biometricos: formData.get('biometricos'),
        estado: formData.get('estado'),
        implante: formData.get('implante')
    };

    const pacienteId = formData.get('id_paciente');
    const url = pacienteId ? 'php/pacientes_controller.php?action=update' : 'php/pacientes_controller.php?action=create';

    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ...pacienteData, id: pacienteId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadPacientes();
            event.target.reset();
        }
    })
    .catch(error => console.error('Error guardando paciente:', error));
}

// Editar paciente
function editPaciente(id) {
    fetch(`php/pacientes_controller.php?action=list`)
        .then(response => response.json())
        .then(data => {
            const paciente = data.find(p => p.id_paciente == id);
            if (paciente) {
                const form = document.getElementById('paciente-form');
                form.querySelector('[name="nombre"]').value = paciente.nombre;
                form.querySelector('[name="apellido1"]').value = paciente.apellido1;
                form.querySelector('[name="apellido2"]').value = paciente.apellido2;
                form.querySelector('[name="dni"]').value = paciente.DNI;
                form.querySelector('[name="tlf"]').value = paciente.TLF;
                form.querySelector('[name="poliza"]').value = paciente.num_poliza;
                form.querySelector('[name="biometricos"]').value = paciente.datos_biometricos;
                form.querySelector('[name="estado"]').value = paciente.estado;
                form.querySelector('[name="implante"]').value = paciente.implante;
                form.querySelector('[name="id_paciente"]').value = paciente.id_paciente;
            }
        })
        .catch(error => console.error('Error cargando paciente:', error));
}

// Eliminar paciente
function deletePaciente(id) {
    if (confirm('¿Estás seguro de eliminar este paciente?')) {
        fetch('php/pacientes_controller.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=delete&id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadPacientes();
            }
        })
        .catch(error => console.error('Error eliminando paciente:', error));
    }
}

// Configurar el chat IA
function setupChat() {
    const chatBubble = document.querySelector('.chat-bubble');
    const chatWindow = document.querySelector('.chat-window');

    if (chatBubble && chatWindow) {
        chatBubble.addEventListener('click', () => {
            chatWindow.classList.toggle('hidden');
        });

        document.querySelector('.send-btn').addEventListener('click', async () => {
            const input = document.querySelector('.chat-input input');
            const message = input.value.trim();

            if (message) {
                const response = await fetch('http://localhost:3000/chat', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();
                appendMessage('user', message);
                appendMessage('bot', data.response);
                input.value = '';
            }
        });
    }
}

function appendMessage(sender, text) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${sender}`;
    messageDiv.textContent = text;
    document.querySelector('.chat-messages').appendChild(messageDiv);
}