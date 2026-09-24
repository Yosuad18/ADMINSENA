import { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import areasService from '../../../services/areasService';
import FormField from '../../../components/admin/FormField';

export default function AreasEdit() {
    const { id } = useParams(); const navigate = useNavigate();
    const [name, setName] = useState(''); const [errors, setErrors] = useState({});
    const [loading, setLoading] = useState(true); const [saving, setSaving] = useState(false);

    useEffect(() => { areasService.get(id).then(r => setName(r.data.name)).catch(() => {}).finally(() => setLoading(false)); }, [id]);

    const handleSubmit = async (e) => {
        e.preventDefault(); setErrors({}); setSaving(true);
        try { await areasService.update(id, { name }); navigate('/admin/areas'); } catch (err) { setErrors(err.response?.data?.errors || {}); } finally { setSaving(false); }
    };

    if (loading) return <div className="text-center py-12 text-gray-400">Cargando...</div>;

    return (
        <div className="flex justify-center"><div className="w-full max-w-lg">
            <div className="bg-white rounded-xl shadow-sm p-6 border-t-4 border-sena-green">
                <h3 className="text-lg font-bold text-sena-dark mb-4"><i className="fas fa-edit text-sena-green mr-2"></i>Editar Área</h3>
                <form onSubmit={handleSubmit}>
                    <FormField label="Nombre del área" name="name" value={name} onChange={e => setName(e.target.value)} error={errors.name?.[0]} />
                    <div className="flex justify-end gap-2 mt-6">
                        <button type="button" onClick={() => navigate('/admin/areas')} className="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50">Cancelar</button>
                        <button type="submit" disabled={saving} className="px-4 py-2 rounded-lg bg-sena-green text-white text-sm font-semibold hover:bg-green-600 disabled:opacity-50"><i className="fas fa-save mr-1"></i> Actualizar</button>
                    </div>
                </form>
            </div>
        </div></div>
    );
}
