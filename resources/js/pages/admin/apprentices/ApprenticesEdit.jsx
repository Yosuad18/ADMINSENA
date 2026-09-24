import { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import apprenticesService from '../../../services/apprenticesService';
import coursesService from '../../../services/coursesService';
import computersService from '../../../services/computersService';
import FormField from '../../../components/admin/FormField';

export default function ApprenticesEdit() {
    const { id } = useParams();
    const navigate = useNavigate();
    const [form, setForm] = useState({ name: '', surname: '', document: '', email: '', cell: '', address: '', estrato: '', course_id: '', computer_id: '' });
    const [courses, setCourses] = useState([]);
    const [computers, setComputers] = useState([]);
    const [errors, setErrors] = useState({});
    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);

    useEffect(() => {
        Promise.all([apprenticesService.get(id), coursesService.list(), computersService.list()])
            .then(([aRes, cRes, compRes]) => {
                const a = aRes.data;
                setForm({ name: a.name || '', surname: a.surname || '', document: a.document || '', email: a.email || '', cell: a.cell || '', address: a.address || '', estrato: a.estrato || '', course_id: a.course_id || '', computer_id: a.computer_id || '' });
                setCourses(cRes.data);
                setComputers(compRes.data);
            }).catch(() => {}).finally(() => setLoading(false));
    }, [id]);

    const handleChange = (e) => setForm(prev => ({ ...prev, [e.target.name]: e.target.value }));

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors({});
        setSaving(true);
        try { await apprenticesService.update(id, form); navigate('/admin/aprendices'); } catch (err) { setErrors(err.response?.data?.errors || {}); } finally { setSaving(false); }
    };

    if (loading) return <div className="text-center py-12 text-gray-400">Cargando...</div>;

    return (
        <div className="flex justify-center">
            <div className="w-full max-w-2xl">
                <div className="bg-white rounded-xl shadow-sm p-6 border-t-4 border-sena-green">
                    <h3 className="text-lg font-bold text-sena-dark mb-4"><i className="fas fa-edit text-sena-green mr-2"></i>Editar Aprendiz</h3>
                    <form onSubmit={handleSubmit}>
                        <div className="grid grid-cols-2 gap-4">
                            <FormField label="Nombre" name="name" value={form.name} onChange={handleChange} error={errors.name?.[0]} />
                            <FormField label="Apellido" name="surname" value={form.surname} onChange={handleChange} error={errors.surname?.[0]} />
                        </div>
                        <div className="grid grid-cols-2 gap-4">
                            <FormField label="Documento" name="document" value={form.document} onChange={handleChange} error={errors.document?.[0]} />
                            <FormField label="Correo" name="email" type="email" value={form.email} onChange={handleChange} error={errors.email?.[0]} />
                        </div>
                        <div className="grid grid-cols-2 gap-4">
                            <FormField label="Celular" name="cell" value={form.cell} onChange={handleChange} error={errors.cell?.[0]} />
                            <FormField label="Estrato" name="estrato" type="select" value={form.estrato} onChange={handleChange} options={[1,2,3,4,5,6].map(n => ({ value: n, label: `Estrato ${n}` }))} error={errors.estrato?.[0]} />
                        </div>
                        <FormField label="Dirección" name="address" value={form.address} onChange={handleChange} error={errors.address?.[0]} />
                        <FormField label="Curso / Ficha" name="course_id" type="select" value={form.course_id} onChange={handleChange} options={courses.map(c => ({ value: c.id, label: `${c.course_number} - ${c.name || 'Sin nombre'}` }))} error={errors.course_id?.[0]} />
                        <FormField label="Equipo Asignado" name="computer_id" type="select" value={form.computer_id} onChange={handleChange} options={computers.map(c => ({ value: c.id, label: `${c.number} - ${c.brand || 'Sin marca'}` }))} error={errors.computer_id?.[0]} required={false} />
                        <div className="flex justify-end gap-2 mt-6">
                            <button type="button" onClick={() => navigate('/admin/aprendices')} className="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50">Cancelar</button>
                            <button type="submit" disabled={saving} className="px-4 py-2 rounded-lg bg-sena-green text-white text-sm font-semibold hover:bg-green-600 disabled:opacity-50"><i className="fas fa-save mr-1"></i> Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}
