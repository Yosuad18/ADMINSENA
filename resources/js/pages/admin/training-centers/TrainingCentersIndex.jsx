import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import trainingCentersService from '../../../services/trainingCentersService';
import ConfirmDelete from '../../../components/admin/ConfirmDelete';

export default function TrainingCentersIndex() {
    const [centers, setCenters] = useState([]);
    const [loading, setLoading] = useState(true);
    const [deleteTarget, setDeleteTarget] = useState(null);

    const load = () => { setLoading(true); trainingCentersService.list().then(r => setCenters(r.data)).catch(() => {}).finally(() => setLoading(false)); };
    useEffect(load, []);
    const handleDelete = async () => { if (!deleteTarget) return; await trainingCentersService.delete(deleteTarget.id); setDeleteTarget(null); load(); };

    return (
        <div className="bg-white rounded-xl shadow-sm p-6 border-t-4 border-sena-green">
            <div className="flex justify-between items-center mb-4">
                <h3 className="text-lg font-bold text-sena-dark"><i className="fas fa-building text-sena-green mr-2"></i>Gestión de Centros de Formación</h3>
                <Link to="/admin/centros/crear" className="bg-sena-green text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-600 transition-colors"><i className="fas fa-plus-circle mr-1"></i> Nuevo Centro</Link>
            </div>
            {loading ? <div className="text-center py-8 text-gray-400">Cargando...</div> : (
                <div className="overflow-x-auto">
                    <table className="w-full text-sm">
                        <thead><tr className="bg-sena-dark text-white"><th className="px-4 py-3 text-left">ID</th><th className="px-4 py-3 text-left">Nombre</th><th className="px-4 py-3 text-left">Dirección</th><th className="px-4 py-3 text-center">Acciones</th></tr></thead>
                        <tbody>
                            {centers.length === 0 ? <tr><td colSpan="4" className="text-center text-gray-400 py-8">No hay centros.</td></tr> : centers.map(c => (
                                <tr key={c.id} className="border-b hover:bg-gray-50">
                                    <td className="px-4 py-3 font-bold">#{c.id}</td>
                                    <td className="px-4 py-3">{c.name}</td>
                                    <td className="px-4 py-3">{c.address || '—'}</td>
                                    <td className="px-4 py-3 text-center"><div className="flex justify-center gap-2"><Link to={`/admin/centros/${c.id}/editar`} className="text-yellow-600 hover:text-yellow-700"><i className="fas fa-edit"></i></Link><button onClick={() => setDeleteTarget(c)} className="text-red-600 hover:text-red-700"><i className="fas fa-trash"></i></button></div></td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            )}
            <ConfirmDelete open={!!deleteTarget} onConfirm={handleDelete} onCancel={() => setDeleteTarget(null)} message={`¿Eliminar el centro ${deleteTarget?.name}?`} />
        </div>
    );
}
