import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import teachersService from '../../../services/teachersService';
import areasService from '../../../services/areasService';
import trainingCentersService from '../../../services/trainingCentersService';
import FormField from '../../../components/admin/FormField';

export default function TeachersCreate() {
    const navigate = useNavigate();
    const [form, setForm] = useState({ name: '', email: '', area_id: '', training_center_id: '' });
    const [areas, setAreas] = useState([]); const [centers, setCenters] = useState([]);
    const [errors, setErrors] = useState({}); const [loading, setLoading] = useState(false);

    useEffect(() => {
        areasService.list().then(r => setAreas(r.data)).catch(() => {});
        trainingCentersService.list().then(r => setCenters(r.data)).catch(() => {});
    }, []);

    const handleChange = (e) => setForm(prev => ({ ...prev, [e.target.name]: e.target.value }));

    const handleSubmit = async (e) => {
        e.preventDefault(); setErrors({}); setLoading(true);
        try { await teachersService.create(form); navigate('/admin/instructores'); } catch (err) { setErrors(err.response?.data?.errors || {}); } finally { setLoading(false); }
    };

    return (
        <div className="flex justify-center"><div className="w-full max-w-lg">
            <div className="bg-white rounded-xl shadow-sm p-6 border-t-4 border-sena-green">
                <h3 className="text-lg font-bold text-sena-dark mb-4"><i className="fas fa-plus-circle text-sena-green mr-2"></i>Crear Instructor</h3>
                <form onSubmit={handleSubmit}>
                    <FormField label="Nombre" name="name" value={form.name} onChange={handleChange} error={errors.name?.[0]} />
                    <FormField label="Correo" name="email" type="email" value={form.email} onChange={handleChange} error={errors.email?.[0]} />
                    <FormField label="Área" name="area_id" type="select" value={form.area_id} onChange={handleChange} options={areas.map(a => ({ value: a.id, label: a.name }))} error={errors.area_id?.[0]} />
                    <FormField label="Centro de Formación" name="training_center_id" type="select" value={form.training_center_id} onChange={handleChange} options={centers.map(c => ({ value: c.id, label: c.name }))} error={errors.training_center_id?.[0]} />
                    <div className="flex justify-end gap-2 mt-6">
                        <button type="button" onClick={() => navigate('/admin/instructores')} className="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50">Cancelar</button>
                        <button type="submit" disabled={loading} className="px-4 py-2 rounded-lg bg-sena-green text-white text-sm font-semibold hover:bg-green-600 disabled:opacity-50"><i className="fas fa-save mr-1"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div></div>
    );
}
