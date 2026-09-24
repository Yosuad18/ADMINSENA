import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import computersService from '../../../services/computersService';
import FormField from '../../../components/admin/FormField';

export default function ComputersCreate() {
    const navigate = useNavigate();
    const [form, setForm] = useState({ number: '', brand: '' });
    const [errors, setErrors] = useState({}); const [loading, setLoading] = useState(false);

    const handleChange = (e) => setForm(prev => ({ ...prev, [e.target.name]: e.target.value }));

    const handleSubmit = async (e) => {
        e.preventDefault(); setErrors({}); setLoading(true);
        try { await computersService.create(form); navigate('/admin/equipos'); } catch (err) { setErrors(err.response?.data?.errors || {}); } finally { setLoading(false); }
    };

    return (
        <div className="flex justify-center"><div className="w-full max-w-lg">
            <div className="bg-white rounded-xl shadow-sm p-6 border-t-4 border-sena-green">
                <h3 className="text-lg font-bold text-sena-dark mb-4"><i className="fas fa-plus-circle text-sena-green mr-2"></i>Crear Equipo</h3>
                <form onSubmit={handleSubmit}>
                    <FormField label="Número" name="number" value={form.number} onChange={handleChange} error={errors.number?.[0]} />
                    <FormField label="Marca" name="brand" value={form.brand} onChange={handleChange} error={errors.brand?.[0]} required={false} />
                    <div className="flex justify-end gap-2 mt-6">
                        <button type="button" onClick={() => navigate('/admin/equipos')} className="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50">Cancelar</button>
                        <button type="submit" disabled={loading} className="px-4 py-2 rounded-lg bg-sena-green text-white text-sm font-semibold hover:bg-green-600 disabled:opacity-50"><i className="fas fa-save mr-1"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div></div>
    );
}
