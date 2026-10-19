@extends('layouts.app')

@section('content')
<style>
    .panel-section {
        background: #ffffff;
        border: none;
        border-top: 4px solid #39A900;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        scroll-margin-top: 1rem;
    }

    .panel-section__head {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        background-color: #00324D;
        color: #ffffff;
    }

    .panel-section__title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
        margin: 0;
    }

    .panel-section__icon {
        width: 40px;
        height: 40px;
        border-radius: 0.6rem;
        background-color: rgba(57, 169, 0, 0.25);
        color: #8ee564;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .panel-section__body {
        padding: 1rem 1.25rem 1.25rem;
        overflow-x: auto;
    }

    .panel-section .table {
        margin-bottom: 0;
        min-width: 480px;
    }

    .panel-empty {
        color: #8a8a8a;
        text-align: center;
        padding: 1.5rem 0.5rem;
        font-size: 0.95rem;
    }

    .api-status {
        font-size: 0.85rem;
    }

    .modal-errors:empty {
        display: none;
    }

    .panel-toc {
        background: #ffffff;
        border: none;
        border-top: 4px solid #39A900;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        padding: 0.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .panel-toc a {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 0.8rem;
        border-radius: 999px;
        background-color: #f1f3f5;
        color: #333333;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .panel-toc a:hover {
        background-color: #39A900;
        color: #ffffff;
    }
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div>
        <h2 class="mb-1">Panel de administración</h2>
        <p class="text-muted mb-0">Desplázate de arriba a abajo y gestiona el CRUD de cada tabla.</p>
    </div>
    <span class="api-status badge {{ $online ? 'bg-success' : 'bg-secondary' }} p-2">
        <i class="fas {{ $online ? 'fa-link' : 'fa-plug-circle-xmark' }} me-1"></i>
        API del cliente: {{ $online ? 'conectada' : 'no disponible' }} ({{ $apiUrl }})
    </span>
</div>

<nav class="panel-toc" aria-label="Ir a tabla">
    @foreach ([
        ['areas', 'Áreas', 'fa-layer-group'],
        ['training-centers', 'Centros', 'fa-building'],
        ['computers', 'Equipos', 'fa-desktop'],
        ['teachers', 'Instructores', 'fa-chalkboard-user'],
        ['courses', 'Cursos', 'fa-book-open'],
        ['apprentices', 'Aprendices', 'fa-user-graduate'],
        ['admins', 'Admins', 'fa-user-shield'],
    ] as [$id, $label, $icon])
        <a href="#section-{{ $id }}"><i class="fas {{ $icon }}"></i> {{ $label }}</a>
    @endforeach
</nav>

{{-- Áreas --}}
<section class="panel-section" id="section-areas">
    <div class="panel-section__head">
        <h3 class="panel-section__title">
            <span class="panel-section__icon"><i class="fas fa-layer-group"></i></span>
            Áreas tecnológicas
            <span class="badge bg-secondary rounded-pill">{{ $areas->count() }}</span>
        </h3>
        <button type="button" class="btn btn-sena btn-sm" onclick="openCreate('areas')">
            <i class="fas fa-plus me-1"></i> Nuevo
        </button>
    </div>
    <div class="panel-section__body">
        @if ($areas->isEmpty())
            <div class="panel-empty">No hay áreas registradas.</div>
        @else
            <table class="table table-sena table-hover align-middle">
                <thead><tr><th>#</th><th>Nombre</th><th class="text-end">Acciones</th></tr></thead>
                <tbody>
                    @foreach ($areas as $area)
                        <tr>
                            <td>{{ $area->id }}</td>
                            <td>{{ $area->name }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                        onclick="openEdit('areas', {{ $area->id }}, @json(['name' => $area->name]) )">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="destroy('areas', {{ $area->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>

{{-- Centros de formación --}}
<section class="panel-section" id="section-training-centers">
    <div class="panel-section__head">
        <h3 class="panel-section__title">
            <span class="panel-section__icon"><i class="fas fa-building"></i></span>
            Centros de formación
            <span class="badge bg-secondary rounded-pill">{{ $trainingCenters->count() }}</span>
        </h3>
        <button type="button" class="btn btn-sena btn-sm" onclick="openCreate('training-centers')">
            <i class="fas fa-plus me-1"></i> Nuevo
        </button>
    </div>
    <div class="panel-section__body">
        @if ($trainingCenters->isEmpty())
            <div class="panel-empty">No hay centros registrados.</div>
        @else
            <table class="table table-sena table-hover align-middle">
                <thead><tr><th>#</th><th>Nombre</th><th>Dirección</th><th class="text-end">Acciones</th></tr></thead>
                <tbody>
                    @foreach ($trainingCenters as $tc)
                        <tr>
                            <td>{{ $tc->id }}</td>
                            <td>{{ $tc->name }}</td>
                            <td>{{ $tc->address }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                        onclick="openEdit('training-centers', {{ $tc->id }}, @json(['name' => $tc->name, 'address' => $tc->address]) )">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="destroy('training-centers', {{ $tc->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>

{{-- Equipos de cómputo --}}
<section class="panel-section" id="section-computers">
    <div class="panel-section__head">
        <h3 class="panel-section__title">
            <span class="panel-section__icon"><i class="fas fa-desktop"></i></span>
            Equipos de cómputo
            <span class="badge bg-secondary rounded-pill">{{ $computers->count() }}</span>
        </h3>
        <button type="button" class="btn btn-sena btn-sm" onclick="openCreate('computers')">
            <i class="fas fa-plus me-1"></i> Nuevo
        </button>
    </div>
    <div class="panel-section__body">
        @if ($computers->isEmpty())
            <div class="panel-empty">No hay equipos registrados.</div>
        @else
            <table class="table table-sena table-hover align-middle">
                <thead><tr><th>#</th><th>Número</th><th>Marca</th><th class="text-end">Acciones</th></tr></thead>
                <tbody>
                    @foreach ($computers as $computer)
                        <tr>
                            <td>{{ $computer->id }}</td>
                            <td>{{ $computer->number }}</td>
                            <td>{{ $computer->brand }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                        onclick="openEdit('computers', {{ $computer->id }}, @json(['number' => $computer->number, 'brand' => $computer->brand]) )">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="destroy('computers', {{ $computer->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>

{{-- Instructores --}}
<section class="panel-section" id="section-teachers">
    <div class="panel-section__head">
        <h3 class="panel-section__title">
            <span class="panel-section__icon"><i class="fas fa-chalkboard-user"></i></span>
            Instructores
            <span class="badge bg-secondary rounded-pill">{{ $teachers->count() }}</span>
        </h3>
        <button type="button" class="btn btn-sena btn-sm" onclick="openCreate('teachers')">
            <i class="fas fa-plus me-1"></i> Nuevo
        </button>
    </div>
    <div class="panel-section__body">
        @if ($teachers->isEmpty())
            <div class="panel-empty">No hay instructores registrados.</div>
        @else
            <table class="table table-sena table-hover align-middle">
                <thead><tr><th>#</th><th>Nombre</th><th>Email</th><th>Área</th><th>Centro</th><th class="text-end">Acciones</th></tr></thead>
                <tbody>
                    @foreach ($teachers as $teacher)
                        <tr>
                            <td>{{ $teacher->id }}</td>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->area?->name }}</td>
                            <td>{{ $teacher->trainingCenter?->name }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                    onclick="openEdit('teachers', {{ $teacher->id }}, {{ json_encode(['name' => $teacher->name, 'email' => $teacher->email, 'area_id' => $teacher->area_id, 'training_center_id' => $teacher->training_center_id]) }})">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="destroy('teachers', {{ $teacher->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>

{{-- Cursos / Fichas --}}
<section class="panel-section" id="section-courses">
    <div class="panel-section__head">
        <h3 class="panel-section__title">
            <span class="panel-section__icon"><i class="fas fa-book-open"></i></span>
            Cursos / Fichas
            <span class="badge bg-secondary rounded-pill">{{ $courses->count() }}</span>
        </h3>
        <button type="button" class="btn btn-sena btn-sm" onclick="openCreate('courses')">
            <i class="fas fa-plus me-1"></i> Nuevo
        </button>
    </div>
    <div class="panel-section__body">
        @if ($courses->isEmpty())
            <div class="panel-empty">No hay cursos registrados.</div>
        @else
            <table class="table table-sena table-hover align-middle">
                <thead><tr><th>#</th><th>Número</th><th>Nombre</th><th>Día</th><th>Límite</th><th>Área</th><th>Centro</th><th class="text-end">Acciones</th></tr></thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $course->id }}</td>
                            <td>{{ $course->course_number }}</td>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->day }}</td>
                            <td>{{ $course->deadline?->format('d/m/Y') }}</td>
                            <td>{{ $course->area?->name }}</td>
                            <td>{{ $course->trainingCenter?->name }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                    onclick="openEdit('courses', {{ $course->id }}, {{ json_encode([
                                        'course_number' => $course->course_number,
                                        'name' => $course->name,
                                        'day' => $course->day,
                                        'deadline' => $course->deadline ? $course->deadline->format('Y-m-d') : null,
                                        'area_id' => $course->area_id,
                                        'training_center_id' => $course->training_center_id
                                    ]) }})">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="destroy('courses', {{ $course->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>

{{-- Aprendices --}}
<section class="panel-section" id="section-apprentices">
    <div class="panel-section__head">
        <h3 class="panel-section__title">
            <span class="panel-section__icon"><i class="fas fa-user-graduate"></i></span>
            Aprendices
            <span class="badge bg-secondary rounded-pill">{{ $apprentices->count() }}</span>
        </h3>
        <button type="button" class="btn btn-sena btn-sm" onclick="openCreate('apprentices')">
            <i class="fas fa-plus me-1"></i> Nuevo
        </button>
    </div>
    <div class="panel-section__body">
        @if ($apprentices->isEmpty())
            <div class="panel-empty">No hay aprendices registrados.</div>
        @else
            <table class="table table-sena table-hover align-middle">
                <thead><tr><th>#</th><th>Nombre</th><th>Email</th><th>Celular</th><th>Curso</th><th>Equipo</th><th class="text-end">Acciones</th></tr></thead>
                <tbody>
                    @foreach ($apprentices as $apprentice)
                        <tr>
                            <td>{{ $apprentice->id }}</td>
                            <td>{{ trim(($apprentice->name ?? '') . ' ' . ($apprentice->surname ?? '')) }}</td>
                            <td>{{ $apprentice->email }}</td>
                            <td>{{ $apprentice->cell }}</td>
                            <td>{{ $apprentice->course?->name ?? $apprentice->course?->course_number }}</td>
                            <td>{{ $apprentice->computer?->number }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                    onclick="openEdit('apprentices', {{ $apprentice->id }}, {{ json_encode([
                                        'name' => $apprentice->name,
                                        'surname' => $apprentice->surname,
                                        'document' => $apprentice->document,
                                        'address' => $apprentice->address,
                                        'estrato' => $apprentice->estrato
                                    ]) }})">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="destroy('apprentices', {{ $apprentice->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>

{{-- Administradores --}}
<section class="panel-section" id="section-admins">
    <div class="panel-section__head">
        <h3 class="panel-section__title">
            <span class="panel-section__icon"><i class="fas fa-user-shield"></i></span>
            Administradores
            <span class="badge bg-secondary rounded-pill">{{ $admins->count() }}</span>
        </h3>
        <button type="button" class="btn btn-sena btn-sm" onclick="openCreate('admins')">
            <i class="fas fa-plus me-1"></i> Nuevo
        </button>
    </div>
    <div class="panel-section__body">
        @if ($admins->isEmpty())
            <div class="panel-empty">No hay administradores registrados.</div>
        @else
            <table class="table table-sena table-hover align-middle">
                <thead><tr><th>#</th><th>Nombre</th><th class="text-end">Acciones</th></tr></thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->name }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                        onclick="openEdit('admins', {{ $admin->id }}, @json(['name' => $admin->name]) )">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="destroy('admins', {{ $admin->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>

{{-- Modal genérico crear / editar --}}
<div class="modal fade" id="crudModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#00324D;color:#fff;">
                <h5 class="modal-title" id="crudModalTitle">Registro</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="crudForm" novalidate>
                <div class="modal-body">
                    <div class="alert alert-danger modal-errors" id="modalErrors"></div>
                    <div id="modalFields" class="d-flex flex-column gap-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sena" id="crudSubmit">
                        <i class="fas fa-save me-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const CSRF = '{{ csrf_token() }}';

const LISTS = {
    areas: @json($areas->map(fn ($a) => ['id' => $a->id, 'name' => $a->name])->values()),
    trainingCenters: @json($trainingCenters->map(fn ($t) => ['id' => $t->id, 'name' => $t->name])->values()),
    courses: @json($courses->map(fn ($c) => ['id' => $c->id, 'label' => ($c->name ?: $c->course_number)])->values()),
    computers: @json($computers->map(fn ($c) => ['id' => $c->id, 'label' => $c->number])->values()),
};

const TABLES = {
    'areas': {
        title: 'Área tecnológica',
        route: '/areas',
        fields: [
            { name: 'name', label: 'Nombre', type: 'text', required: true },
        ],
    },
    'training-centers': {
        title: 'Centro de formación',
        route: '/training-centers',
        fields: [
            { name: 'name', label: 'Nombre', type: 'text', required: true },
            { name: 'address', label: 'Dirección', type: 'text', required: false },
        ],
    },
    'computers': {
        title: 'Equipo de cómputo',
        route: '/computers',
        fields: [
            { name: 'number', label: 'Número', type: 'text', required: true },
            { name: 'brand', label: 'Marca', type: 'text', required: true },
        ],
    },
    'teachers': {
        title: 'Instructor',
        route: '/teachers',
        fields: [
            { name: 'name', label: 'Nombre', type: 'text', required: true },
            { name: 'email', label: 'Email', type: 'email', required: true },
            { name: 'area_id', label: 'Área', type: 'select', required: true, options: 'areas', optionLabel: 'name' },
            { name: 'training_center_id', label: 'Centro de formación', type: 'select', required: true, options: 'trainingCenters', optionLabel: 'name' },
        ],
    },
    'courses': {
        title: 'Curso / Ficha',
        route: '/courses',
        fields: [
            { name: 'course_number', label: 'Número de curso', type: 'text', required: true },
            { name: 'name', label: 'Nombre', type: 'text', required: false },
            { name: 'day', label: 'Día', type: 'text', required: true },
            { name: 'deadline', label: 'Fecha límite', type: 'date', required: false },
            { name: 'area_id', label: 'Área', type: 'select', required: true, options: 'areas', optionLabel: 'name' },
            { name: 'training_center_id', label: 'Centro de formación', type: 'select', required: true, options: 'trainingCenters', optionLabel: 'name' },
        ],
    },
    'apprentices': {
        title: 'Aprendiz',
        route: '/apprentices',
        fields: [
            { name: 'name', label: 'Nombre', type: 'text', required: true },
            { name: 'surname', label: 'Apellido', type: 'text', required: false },
            { name: 'document', label: 'Documento', type: 'text', required: false },
            { name: 'address', label: 'Dirección', type: 'text', required: false },
            { name: 'estrato', label: 'Estrato (1-6)', type: 'number', required: false, min: 1, max: 6 },
            { name: 'email', label: 'Email', type: 'email', required: true },
            { name: 'cell', label: 'Celular', type: 'text', required: false },
            { name: 'course_id', label: 'Curso', type: 'select', required: true, options: 'courses', optionLabel: 'label' },
            { name: 'computer_id', label: 'Equipo (opcional)', type: 'select', required: false, options: 'computers', optionLabel: 'label', allowEmpty: true },
        ],
    },
    'admins': {
        title: 'Administrador',
        route: '/admins',
        fields: [
            { name: 'name', label: 'Nombre', type: 'text', required: true },
        ],
    },
};

let currentKey = null;
let currentId = null;

const modalEl = document.getElementById('crudModal');
let crudModal = null;
const crudForm = document.getElementById('crudForm');
const modalFields = document.getElementById('modalFields');
const modalErrors = document.getElementById('modalErrors');
const crudModalTitle = document.getElementById('crudModalTitle');

function showCrudModal() {
    if (!crudModal) crudModal = new bootstrap.Modal(modalEl);
    crudModal.show();
}

function buildField(field, value) {
    const wrap = document.createElement('div');
    wrap.className = 'form-floating';

    let input;

    if (field.type === 'select') {
        input = document.createElement('select');
        input.className = 'form-select';
        input.name = field.name;
        input.id = 'field_' + field.name;

        if (!field.required || field.allowEmpty) {
            const empty = document.createElement('option');
            empty.value = '';
            empty.textContent = '— Selecciona —';
            input.appendChild(empty);
        }

        (LISTS[field.options] || []).forEach(opt => {
            const option = document.createElement('option');
            option.value = opt.id;
            option.textContent = opt[field.optionLabel];
            input.appendChild(option);
        });
    } else {
        input = document.createElement('input');
        input.className = 'form-control';
        input.type = field.type;
        input.name = field.name;
        input.id = 'field_' + field.name;
        if (field.min !== undefined) input.min = field.min;
        if (field.max !== undefined) input.max = field.max;
    }

    if (field.required) input.required = true;
    if (value !== undefined && value !== null) input.value = value;

    const label = document.createElement('label');
    label.htmlFor = input.id;
    label.textContent = field.label + (field.required ? ' *' : '');

    wrap.appendChild(input);
    wrap.appendChild(label);
    return wrap;
}

function openCreate(key) {
    currentKey = key;
    currentId = null;
    const config = TABLES[key];

    crudModalTitle.textContent = 'Nuevo: ' + config.title;
    modalErrors.textContent = '';
    modalFields.innerHTML = '';
    config.fields.forEach(f => modalFields.appendChild(buildField(f, '')));

    showCrudModal();
}

function openEdit(key, id, data) {
    currentKey = key;
    currentId = id;
    const config = TABLES[key];

    crudModalTitle.textContent = 'Editar: ' + config.title + ' #' + id;
    modalErrors.textContent = '';
    modalFields.innerHTML = '';
    config.fields.forEach(f => modalFields.appendChild(buildField(f, data[f.name])));

    showCrudModal();
}

crudForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const config = TABLES[currentKey];
    let url = config.route;
    const method = currentId ? 'PUT' : 'POST';
    if (currentId) url += '/' + currentId;

    const fd = new FormData(crudForm);

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: fd,
        });

        if (response.ok) {
            window.location.reload();
            return;
        }

        if (response.status === 422) {
            const payload = await response.json();
            modalErrors.textContent = Object.values(payload.errors || {}).flat().join(' ');
        } else {
            modalErrors.textContent = 'Error inesperado (' + response.status + '). Intenta de nuevo.';
        }
    } catch (err) {
        modalErrors.textContent = 'No fue posible conectar con el servidor.';
    }
});

async function destroy(key, id) {
    const config = TABLES[key];
    if (!confirm('¿Eliminar este registro de "' + config.title + '"? Esta acción no se puede deshacer.')) return;

    try {
        const response = await fetch(config.route + '/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
        });

        if (response.ok) {
            window.location.reload();
        } else {
            alert('No fue posible eliminar el registro (' + response.status + ').');
        }
    } catch (err) {
        alert('No fue posible conectar con el servidor.');
    }
}
</script>
@endsection
