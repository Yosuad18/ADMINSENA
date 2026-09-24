import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import computersService from '../../../services/computersService';
import ConfirmDelete from '../../../components/admin/ConfirmDelete';

export default function ComputersIndex() {
    const [computers, setComputers] = useState([]);
    const [loading, setLoading] = useState(true);
    const [deleteTarget, setDeleteTarget] = useState(null);

    const load = () => { setLoading(true); computersService.list().then(r => setComputers(r.data)).catch(() => {}).finally(() => setLoading(false)); };
    useEffect(load, []);
    const handleDelete = async () => { if (!deleteTarget) return; await computersService.delete(deleteTarget.id); setDeleteTarget(null); load(); };

    return (
        <div className="bg-white rounded-xl shadow-sm p-6 border-t-4 border-sena-green">
            <div className="flex justify-between items-center mb-4">
                <h3 className="text-lg font-bold text-sena-dark"><i className="fas fa-desktop text-sena-green mr-2"></i>Gestión de Equipos</h3>
                <Link to="/admin/equipos/crear" className="bg-sena-green text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-600 transition-colors"><i className="fas fa-plus-circle mr-1"></i> Nuevo Equipo</Link>
            </div>
            {loading ? <div className="text-center py-8 text-gray-400">Cargando...</div> : (
                <div className="overflow-x-auto">
                    <table className="w-full text-sm">
                        <thead><tr className="bg-sena-dark text-white"><th className="px-4 py-3 text-left">ID</th><th className="px-4 py-3 text-left">Número</th><th className="px-4 py-3 text-left">Marca</th><th className="px-4 py-3 text-center">Acciones</th></tr></thead>
                        <tbody>
                            {computers.length === 0 ? <tr><td colSpan="4" className="text-center text-gray-400 py-8">No hay equipos.</td></tr> : computers.map(c => (
                                <tr key={c.id} className="border-b hover:bg-gray-50">
                                    <td className="px-4 py-3 font-bold">#{c.id}</td>
                                    <td className="px-4 py-3">{c.number}</td>
                                    <td className="px-4 py-3">{c.brand || '—'}</td>
                                    <td className="px-4 py-3 text-center"><div className="flex justify-center gap-2"><Link to={`/admin/equipos/${c.id}/editar`} className="text-yellow-600 hover:text-yellow-700"><i className="fas fa-edit"></i></Link><button onClick={() => setDeleteTarget(c)} className="text-red-600 hover:text-red-700"><i className="fas fa-trash"></i></button></div></td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            )}
            <ConfirmDelete open={!!deleteTarget} onConfirm={handleDelete} onCancel={() => setDeleteTarget(null)} message={`¿Eliminar el equipo ${deleteTarget?.number}?`} />
        </div>
    );
}
