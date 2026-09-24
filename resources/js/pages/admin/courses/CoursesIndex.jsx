import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import coursesService from '../../../services/coursesService';
import ConfirmDelete from '../../../components/admin/ConfirmDelete';

export default function CoursesIndex() {
    const [courses, setCourses] = useState([]);
    const [loading, setLoading] = useState(true);
    const [deleteTarget, setDeleteTarget] = useState(null);

    const load = () => {
        setLoading(true);
        coursesService.list().then(res => setCourses(res.data)).catch(() => {}).finally(() => setLoading(false));
    };

    useEffect(load, []);

    const handleDelete = async () => {
        if (!deleteTarget) return;
        await coursesService.delete(deleteTarget.id);
        setDeleteTarget(null);
        load();
    };

    return (
        <div className="bg-white rounded-xl shadow-sm p-6 border-t-4 border-sena-green">
            <div className="flex justify-between items-center mb-4">
                <h3 className="text-lg font-bold text-sena-dark">
                    <i className="fas fa-layer-group text-sena-green mr-2"></i>Gestión de Cursos y Fichas
                </h3>
                <Link to="/admin/cursos/crear" className="bg-sena-green text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-600 transition-colors">
                    <i className="fas fa-plus-circle mr-1"></i> Nuevo Curso
                </Link>
            </div>

            {loading ? (
                <div className="text-center py-8 text-gray-400">Cargando...</div>
            ) : (
                <div className="overflow-x-auto">
                    <table className="w-full text-sm">
                        <thead>
                            <tr className="bg-sena-dark text-white">
                                <th className="px-4 py-3 text-left">ID</th>
                                <th className="px-4 py-3 text-left">N° Ficha</th>
                                <th className="px-4 py-3 text-left">Programa</th>
                                <th className="px-4 py-3 text-left">Jornada</th>
                                <th className="px-4 py-3 text-left">Área</th>
                                <th className="px-4 py-3 text-left">Centro</th>
                                <th className="px-4 py-3 text-left">Fecha límite</th>
                                <th className="px-4 py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {courses.length === 0 ? (
                                <tr><td colSpan="8" className="text-center text-gray-400 py-8">No hay cursos registrados.</td></tr>
                            ) : courses.map(c => (
                                <tr key={c.id} className="border-b hover:bg-gray-50">
                                    <td className="px-4 py-3 font-bold">#{c.id}</td>
                                    <td className="px-4 py-3"><span className="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-semibold">{c.course_number}</span></td>
                                    <td className="px-4 py-3">{c.name || '—'}</td>
                                    <td className="px-4 py-3">{c.day}</td>
                                    <td className="px-4 py-3">{c.area?.name || 'Sin área'}</td>
                                    <td className="px-4 py-3">{c.trainingCenter?.name || 'Sin centro'}</td>
                                    <td className="px-4 py-3">
                                        {c.deadline ? (
                                            new Date(c.deadline) < new Date()
                                                ? <span className="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">{c.deadline}</span>
                                                : <span className="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">{c.deadline}</span>
                                        ) : '—'}
                                    </td>
                                    <td className="px-4 py-3 text-center">
                                        <div className="flex justify-center gap-2">
                                            <Link to={`/admin/cursos/${c.id}/editar`} className="text-yellow-600 hover:text-yellow-700" title="Editar">
                                                <i className="fas fa-edit"></i>
                                            </Link>
                                            <button onClick={() => setDeleteTarget(c)} className="text-red-600 hover:text-red-700" title="Eliminar">
                                                <i className="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            )}

            <ConfirmDelete open={!!deleteTarget} onConfirm={handleDelete} onCancel={() => setDeleteTarget(null)} message={`¿Eliminar el curso ${deleteTarget?.name || ''}?`} />
        </div>
    );
}
