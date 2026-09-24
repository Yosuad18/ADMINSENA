import { useState, useEffect } from 'react';
import publicService from '../../services/publicService';

export default function Programs() {
    const [locations, setLocations] = useState([]);
    const [areas, setAreas] = useState([]);
    const [filter, setFilter] = useState('*');
    const [showModal, setShowModal] = useState(false);
    const [selectedCourse, setSelectedCourse] = useState(null);
    const [form, setForm] = useState({ name: '', surname: '', document: '', address: '', estrato: '', email: '' });
    const [msg, setMsg] = useState('');
    const [errors, setErrors] = useState({});

    useEffect(() => {
        publicService.getPrograms().then(res => {
            setLocations(res.data.locations);
            setAreas(res.data.areas);
        }).catch(() => {});
    }, []);

    const filteredLocations = locations.map(loc => ({
        ...loc,
        programs: filter === '*' ? loc.programs : loc.programs.filter(p => p.area === filter),
    })).filter(loc => loc.programs.length > 0);

    const totalResults = filteredLocations.reduce((acc, l) => acc + l.programs.length, 0);

    const openRegister = (course) => {
        setSelectedCourse(course);
        setShowModal(true);
        setMsg('');
        setErrors({});
    };

    const handleRegister = async (e) => {
        e.preventDefault();
        setMsg('');
        setErrors({});
        try {
            const res = await publicService.register({ ...form, course_id: selectedCourse.id });
            setMsg(res.data.message);
            setForm({ name: '', surname: '', document: '', address: '', estrato: '', email: '' });
        } catch (err) {
            if (err.response?.data?.message) {
                setErrors({ general: err.response.data.message });
            } else if (err.response?.data?.errors) {
                setErrors(err.response.data.errors);
            }
        }
    };

    return (
        <>
            <section className="bg-sena-dark text-white py-16">
                <div className="container mx-auto px-4">
                    <p className="text-sena-green font-semibold text-sm mb-2">Oferta académica</p>
                    <h1 className="text-4xl font-bold mb-4">Programas de tecnología</h1>
                    <p className="text-gray-300 max-w-2xl">
                        Titulaciones de nivel tecnológico con certificación oficial.
                        Todas las modalidades son gratuitas y cuentan con práctica productiva.
                    </p>
                </div>
            </section>

            <section className="py-8">
                <div className="container mx-auto px-4">
                    <h2 className="text-xl font-bold text-sena-dark mb-3">Explora por área</h2>
                    <div className="flex flex-wrap gap-2">
                        <button onClick={() => setFilter('*')} className={`px-4 py-2 rounded-full text-sm font-medium transition-colors ${filter === '*' ? 'bg-sena-green text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`}>
                            Todas
                        </button>
                        {areas.map(area => (
                            <button key={area.id} onClick={() => setFilter(area.name)} className={`px-4 py-2 rounded-full text-sm font-medium transition-colors ${filter === area.name ? 'bg-sena-green text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`}>
                                {area.name}
                            </button>
                        ))}
                    </div>
                    <p className="text-sm text-gray-500 mt-2" aria-live="polite">{totalResults} programa(s) disponible(s)</p>
                </div>
            </section>

            {filteredLocations.map((loc, li) => (
                <section key={li} className="py-10" style={{ '--accent': loc.accent }}>
                    <div className="container mx-auto px-4">
                        <p className="text-sena-green font-semibold text-sm mb-1">Centro de formación</p>
                        <h2 className="text-2xl font-bold text-sena-dark mb-2">{loc.name}</h2>
                        <p className="text-gray-500 mb-6">{loc.blurb}</p>
                        <div className="grid md:grid-cols-3 gap-6">
                            {loc.programs.map((prog, pi) => (
                                <article key={pi} className="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                                    <div className="h-48 bg-gray-200 flex items-center justify-center">
                                        {prog.image ? (
                                            <img src={prog.image} alt={prog.name} className="w-full h-full object-cover" />
                                        ) : (
                                            <span className="text-gray-400 text-sm">Sin imagen</span>
                                        )}
                                    </div>
                                    <div className="p-5">
                                        <p className="text-sena-green font-bold text-sm">{prog.course_number}</p>
                                        <h3 className="font-bold text-sena-dark text-lg mt-1">{prog.name}</h3>
                                        <ul className="text-sm text-gray-500 mt-2 space-y-1">
                                            <li className="flex items-center gap-2">
                                                <span className="w-2 h-2 rounded-full" style={{ backgroundColor: loc.accent }}></span>
                                                {prog.training_center}
                                            </li>
                                            <li>Cierra · {prog.deadline ? new Date(prog.deadline).toLocaleDateString('es-CO', { year: 'numeric', month: 'short', day: 'numeric' }) : '—'}</li>
                                        </ul>
                                        <span className="inline-block mt-3 text-xs font-semibold bg-gray-100 text-gray-600 px-2 py-1 rounded">{prog.area}</span>
                                        <button onClick={() => openRegister(prog)} className="mt-3 w-full bg-sena-green text-white py-2 rounded-lg font-semibold hover:bg-green-600 transition-colors">
                                            Inscribirme
                                        </button>
                                    </div>
                                </article>
                            ))}
                        </div>
                    </div>
                </section>
            ))}

            {showModal && selectedCourse && (
                <>
                    <div className="fixed inset-0 bg-black/50 z-50" onClick={() => setShowModal(false)}></div>
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
                        <div className="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-6">
                            <div className="flex justify-between items-start mb-4">
                                <div>
                                    <p className="text-sena-green font-semibold text-sm">Inscripción gratuita</p>
                                    <h2 className="text-xl font-bold text-sena-dark">Inscribirse al programa</h2>
                                </div>
                                <button onClick={() => setShowModal(false)} className="text-gray-400 hover:text-gray-600">
                                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" strokeWidth="2.2" strokeLinecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
                                </button>
                            </div>
                            <p className="text-gray-600 mb-4 font-medium">{selectedCourse.name}</p>

                            {msg && <div className="bg-green-50 text-green-700 p-3 rounded-lg mb-4 text-sm">{msg}</div>}
                            {errors.general && <div className="bg-red-50 text-red-700 p-3 rounded-lg mb-4 text-sm">{errors.general}</div>}

                            <form onSubmit={handleRegister} className="space-y-4">
                                <div className="grid grid-cols-2 gap-4">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                                        <input type="text" required value={form.name} onChange={e => setForm({...form, name: e.target.value})} className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sena-green focus:outline-none" />
                                        {errors.name && <p className="text-red-500 text-xs mt-1">{errors.name[0]}</p>}
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                                        <input type="text" required value={form.surname} onChange={e => setForm({...form, surname: e.target.value})} className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sena-green focus:outline-none" />
                                        {errors.surname && <p className="text-red-500 text-xs mt-1">{errors.surname[0]}</p>}
                                    </div>
                                </div>
                                <div className="grid grid-cols-2 gap-4">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-1">Cédula / TI</label>
                                        <input type="text" required value={form.document} onChange={e => setForm({...form, document: e.target.value})} className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sena-green focus:outline-none" />
                                        {errors.document && <p className="text-red-500 text-xs mt-1">{errors.document[0]}</p>}
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-1">Estrato</label>
                                        <select required value={form.estrato} onChange={e => setForm({...form, estrato: e.target.value})} className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sena-green focus:outline-none">
                                            <option value="">Seleccione…</option>
                                            {[1,2,3,4,5,6].map(n => <option key={n} value={n}>Estrato {n}</option>)}
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                    <input type="text" required value={form.address} onChange={e => setForm({...form, address: e.target.value})} className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sena-green focus:outline-none" />
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                                    <input type="email" required value={form.email} onChange={e => setForm({...form, email: e.target.value})} className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sena-green focus:outline-none" />
                                </div>
                                <button type="submit" className="w-full bg-sena-green text-white py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors">
                                    Enviar inscripción
                                </button>
                            </form>
                        </div>
                    </div>
                </>
            )}
        </>
    );
}
