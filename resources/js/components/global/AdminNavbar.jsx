import { NavLink } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';

const links = [
    { to: '/admin/cursos', icon: 'fa-book-open', label: 'Cursos / Fichas' },
    { to: '/admin/aprendices', icon: 'fa-user-graduate', label: 'Aprendices' },
    { to: '/admin/areas', icon: 'fa-layer-group', label: 'Áreas' },
    { to: '/admin/instructores', icon: 'fa-chalkboard-teacher', label: 'Instructores' },
    { to: '/admin/centros', icon: 'fa-building', label: 'Centros' },
    { to: '/admin/equipos', icon: 'fa-desktop', label: 'Equipos' },
];

export default function AdminNavbar() {
    const { logout } = useAuth();

    const linkClass = ({ isActive }) =>
        `px-4 py-2.5 text-sm font-medium transition-colors ${
            isActive ? 'bg-sena-green text-white' : 'text-white hover:bg-sena-green'
        }`;

    return (
        <nav className="bg-sena-dark">
            <div className="container mx-auto px-4 flex items-center justify-between">
                <ul className="flex flex-wrap gap-0">
                    {links.map(({ to, icon, label }) => (
                        <li key={to}>
                            <NavLink to={to} className={linkClass}>
                                <i className={`fas ${icon} mr-1`}></i> {label}
                            </NavLink>
                        </li>
                    ))}
                </ul>
                <button
                    onClick={logout}
                    className="text-white text-sm px-4 py-2.5 hover:bg-red-600 transition-colors"
                >
                    <i className="fas fa-sign-out-alt mr-1"></i> Salir
                </button>
            </div>
        </nav>
    );
}
