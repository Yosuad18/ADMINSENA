import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import coursesService from '../../services/coursesService';
import apprenticesService from '../../services/apprenticesService';
import areasService from '../../services/areasService';
import teachersService from '../../services/teachersService';

export default function Dashboard() {
    const [stats, setStats] = useState({ courses: 0, apprentices: 0, areas: 0, teachers: 0 });
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        Promise.all([
            coursesService.list().catch(() => ({ data: [] })),
            apprenticesService.list().catch(() => ({ data: [] })),
            areasService.list().catch(() => ({ data: [] })),
            teachersService.list().catch(() => ({ data: [] })),
        ]).then(([c, a, ar, t]) => {
            setStats({
                courses: Array.isArray(c.data) ? c.data.length : 0,
                apprentices: Array.isArray(a.data) ? a.data.length : 0,
                areas: Array.isArray(ar.data) ? ar.data.length : 0,
                teachers: Array.isArray(t.data) ? t.data.length : 0,
            });
        }).finally(() => setLoading(false));
    }, []);

    const cards = [
        { label: 'Cursos / Fichas', value: stats.courses, icon: 'fa-book-open', color: 'bg-blue-500', to: '/admin/cursos' },
        { label: 'Aprendices', value: stats.apprentices, icon: 'fa-user-graduate', color: 'bg-sena-green', to: '/admin/aprendices' },
        { label: 'Áreas', value: stats.areas, icon: 'fa-layer-group', color: 'bg-purple-500', to: '/admin/areas' },
        { label: 'Instructores', value: stats.teachers, icon: 'fa-chalkboard-teacher', color: 'bg-orange-500', to: '/admin/instructores' },
    ];

    if (loading) return <div className="text-center py-12 text-gray-400">Cargando dashboard...</div>;

    return (
        <div>
            <h2 className="text-2xl font-bold text-sena-dark mb-6">
                <i className="fas fa-tachometer-alt text-sena-green mr-2"></i>Panel de Administración
            </h2>
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {cards.map((card, i) => (
                    <Link key={i} to={card.to} className="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow border-t-4 border-sena-green">
                        <div className="flex items-center gap-4">
                            <div className={`${card.color} text-white w-12 h-12 rounded-lg flex items-center justify-center`}>
                                <i className={`fas ${card.icon} text-lg`}></i>
                            </div>
                            <div>
                                <p className="text-3xl font-bold text-sena-dark">{card.value}</p>
                                <p className="text-sm text-gray-500">{card.label}</p>
                            </div>
                        </div>
                    </Link>
                ))}
            </div>

            <div className="mt-8 bg-white rounded-xl shadow-sm p-6 border-t-4 border-sena-green">
                <h3 className="text-lg font-bold text-sena-dark mb-4">Accesos rápidos</h3>
                <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                    {[
                        { to: '/admin/cursos/crear', icon: 'fa-plus', label: 'Nuevo Curso' },
                        { to: '/admin/aprendices/crear', icon: 'fa-user-plus', label: 'Nuevo Aprendiz' },
                        { to: '/admin/areas/crear', icon: 'fa-plus', label: 'Nueva Área' },
                        { to: '/admin/instructores/crear', icon: 'fa-plus', label: 'Nuevo Instructor' },
                        { to: '/admin/centros/crear', icon: 'fa-plus', label: 'Nuevo Centro' },
                        { to: '/admin/equipos/crear', icon: 'fa-plus', label: 'Nuevo Equipo' },
                    ].map((link, i) => (
                        <Link key={i} to={link.to} className="flex items-center gap-2 bg-gray-50 hover:bg-sena-green hover:text-white text-sena-dark px-4 py-3 rounded-lg text-sm font-medium transition-colors">
                            <i className={`fas ${link.icon}`}></i> {link.label}
                        </Link>
                    ))}
                </div>
            </div>
        </div>
    );
}
