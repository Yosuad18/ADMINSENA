import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import apprenticesService from '../../../services/apprenticesService';
import ConfirmDelete from '../../../components/admin/ConfirmDelete';

export default function ApprenticesIndex() {
    const [apprentices, setApprentices] = useState([]);
    const [loading, setLoading] = useState(true);
    const [deleteTarget, setDeleteTarget] = useState(null);

    const load = () => {
        setLoading(true);
        apprenticesService.list().then(r => setApprentices(r.data)).catch(() => {}).finally(() => setLoading(false));
    };
    useEffect(load, []);

    const handleDelete = async () => {
        if (!deleteTarget) return;
        await apprenticesService.delete(deleteTarget.id);
        setDeleteTarget(null);
        load();
    };

    return (
        <div className="bg-white rounded-xl shadow-sm p-6 border-t-4 border-sena-green">
            <div className="flex justify-between items-center mb-4">
                <h3 className="text-lg font-bold text-sena-dark">
                    <i className="fas fa-user-graduate text-sena-green mr-2"></i>Gestión de Aprendices
                </h3>
                <Link to="/admin/aprendices/crear" className="bg-sena-green text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-600 transition-colors">
                    <i className="fas fa-user-plus mr-1"></i> Registrar Aprendiz
                </Link>
            </div>
            {loading ? <div className="text-center py-8 text-gray-400">Cargando...</div> : (
                <div className="overflow-x-auto">
                    <table className="w-full text-sm">
                        <thead>
                            <tr className="bg-sena-dark text-white">
                                <th className="px-4 py-3 text-left">ID</th>
                                <th className="px-4 py-3 text-left">Nombre</th>
                                <th className="px-4 py-3 text-left">Documento</th>
                                <th className="px-4 py-3 text-left">Correo</th>
                                <th className="px-4 py-3 text-left">Estrato</th>
                                <th className="px-4 py-3 text-left">Curso</th>
                                <th className="px-4 py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {apprentices.length === 0 ? (
                                <tr><td colSpan="7" className="text-center text-gray-400 py-8">No hay aprendices registrados.</td></tr>
                            ) : apprentices.map(a => (
                                <tr key={a.id} className="border-b hover:bg-gray-50">
                                    <td className="px-4 py-3 font-bold">#{a.id}</td>
                                    <td className="px-4 py-3">{a.name} {a.surname}</td>
                                    <td className="px-4 py-3">{a.document || '—'}</td>
                                    <td className="px-4 py-3">{a.email}</td>
                                    <td className="px-4 py-3">{a.estrato ? `Estrato ${a.estrato}` : '—'}</td>
                                    <td className="px-4 py-3"><span className="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">{a.course?.course_number || 'Sin curso'}</span></td>
                                    <td className="px-4 py-3 text-center">
                                        <div className="flex justify-center gap-2">
                                            <Link to={`/admin/aprendices/${a.id}/editar`} className="text-yellow-600 hover:text-yellow-700"><i className="fas fa-edit"></i></Link>
                                            <button onClick={() => setDeleteTarget(a)} className="text-red-600 hover:text-red-700"><i className="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            )}
            <ConfirmDelete open={!!deleteTarget} onConfirm={handleDelete} onCancel={() => setDeleteTarget(null)} message={`¿Eliminar al aprendiz ${deleteTarget?.name} ${deleteTarget?.surname}?`} />
        </div>
    );
}
