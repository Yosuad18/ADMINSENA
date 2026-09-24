import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import teachersService from '../../../services/teachersService';
import ConfirmDelete from '../../../components/admin/ConfirmDelete';

export default function TeachersIndex() {
    const [teachers, setTeachers] = useState([]);
    const [loading, setLoading] = useState(true);
    const [deleteTarget, setDeleteTarget] = useState(null);

    const load = () => { setLoading(true); teachersService.list().then(r => setTeachers(r.data)).catch(() => {}).finally(() => setLoading(false)); };
    useEffect(load, []);
    const handleDelete = async () => { if (!deleteTarget) return; await teachersService.delete(deleteTarget.id); setDeleteTarget(null); load(); };

    return (
        <div className="bg-white rounded-xl shadow-sm p-6 border-t-4 border-sena-green">
            <div className="flex justify-between items-center mb-4">
                <h3 className="text-lg font-bold text-sena-dark"><i className="fas fa-chalkboard-teacher text-sena-green mr-2"></i>Gestión de Instructores</h3>
                <Link to="/admin/instructores/crear" className="bg-sena-green text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-600 transition-colors"><i className="fas fa-plus-circle mr-1"></i> Nuevo Instructor</Link>
            </div>
            {loading ? <div className="text-center py-8 text-gray-400">Cargando...</div> : (
                <div className="overflow-x-auto">
                    <table className="w-full text-sm">
                        <thead><tr className="bg-sena-dark text-white"><th className="px-4 py-3 text-left">ID</th><th className="px-4 py-3 text-left">Nombre</th><th className="px-4 py-3 text-left">Correo</th><th className="px-4 py-3 text-left">Área</th><th className="px-4 py-3 text-center">Acciones</th></tr></thead>
                        <tbody>
                            {teachers.length === 0 ? <tr><td colSpan="5" className="text-center text-gray-400 py-8">No hay instructores.</td></tr> : teachers.map(t => (
                                <tr key={t.id} className="border-b hover:bg-gray-50">
                                    <td className="px-4 py-3 font-bold">#{t.id}</td>
                                    <td className="px-4 py-3">{t.name}</td>
                                    <td className="px-4 py-3">{t.email}</td>
                                    <td className="px-4 py-3">{t.area?.name || '—'}</td>
                                    <td className="px-4 py-3 text-center"><div className="flex justify-center gap-2"><Link to={`/admin/instructores/${t.id}/editar`} className="text-yellow-600 hover:text-yellow-700"><i className="fas fa-edit"></i></Link><button onClick={() => setDeleteTarget(t)} className="text-red-600 hover:text-red-700"><i className="fas fa-trash"></i></button></div></td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            )}
            <ConfirmDelete open={!!deleteTarget} onConfirm={handleDelete} onCancel={() => setDeleteTarget(null)} message={`¿Eliminar al instructor ${deleteTarget?.name}?`} />
        </div>
    );
}
