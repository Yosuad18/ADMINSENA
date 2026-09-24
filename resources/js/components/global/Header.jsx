import { useState } from 'react';
import { Link, useLocation, useNavigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';

export default function Header() {
    const [navOpen, setNavOpen] = useState(false);
    const [searchQuery, setSearchQuery] = useState('');
    const location = useLocation();
    const navigate = useNavigate();
    const { user } = useAuth();

    const isActive = (path) => location.pathname === path;

    const handleSearch = (e) => {
        e.preventDefault();
        if (searchQuery.trim()) {
            navigate(`/buscar?q=${encodeURIComponent(searchQuery.trim())}`);
        }
    };

    const navLinks = [
        { path: '/', label: 'Inicio' },
        { path: '/quienes-somos', label: 'Quiénes somos' },
        { path: '/programas', label: 'Programas' },
        { path: '/noticias', label: 'Noticias' },
        { path: '/eventos', label: 'Eventos' },
        { path: '/contacto', label: 'Contacto' },
    ];

    return (
        <header className="bg-sena-green border-b-4 border-sena-dark shadow-sm sticky top-0 z-50" role="banner">
            <div className="container mx-auto px-4 flex items-center justify-between h-16">
                <Link to="/" className="flex items-center gap-3" aria-label="ADMISENA — Inicio">
                    <img src="/images/sena_1.png" alt="Logo SENA" className="h-12" />
                    <div className="hidden sm:block">
                        <strong className="block text-white text-sm font-bold">ADMISENA</strong>
                        <span className="text-xs text-white">Formación técnica para transformar Colombia</span>
                    </div>
                </Link>

                <form onSubmit={handleSearch} className="hidden md:flex items-center gap-2" role="search">
                    <label htmlFor="header-search" className="sr-only">Buscar</label>
                    <input
                        id="header-search"
                        type="search"
                        value={searchQuery}
                        onChange={(e) => setSearchQuery(e.target.value)}
                        placeholder="Buscar programas, noticias…"
                        className="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-sena-green"
                    />
                    <button type="submit" className="text-gray-500 hover:text-sena-green" aria-label="Buscar">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" strokeWidth="2.4" strokeLinecap="round">
                            <circle cx="10.5" cy="10.5" r="6.5" />
                            <line x1="15.5" y1="15.5" x2="21" y2="21" />
                        </svg>
                    </button>
                </form>

                <button
                    className="md:hidden flex flex-col gap-1 p-2"
                    onClick={() => setNavOpen(!navOpen)}
                    aria-expanded={navOpen}
                    aria-controls="primary-nav"
                >
                    <span className="block w-6 h-0.5 bg-white"></span>
                    <span className="block w-6 h-0.5 bg-white"></span>
                    <span className="block w-6 h-0.5 bg-white"></span>
                </button>

                <nav
                    id="primary-nav"
                    className={`${navOpen ? 'block' : 'hidden'} md:flex md:items-center md:gap-1 absolute md:static top-16 left-0 right-0 bg-white md:bg-transparent shadow-md md:shadow-none z-40`}
                    aria-label="Navegación principal"
                >
                    <ul className="flex flex-col md:flex-row md:items-center gap-1 p-4 md:p-0">
                        {navLinks.map(({ path, label }) => (
                            <li key={path}>
                                <Link
                                    to={path}
                                    onClick={() => setNavOpen(false)}
                                    className={`block px-3 py-2 rounded-lg text-sm font-medium transition-colors ${
                                        isActive(path)
                                            ? 'bg-white text-sena-dark'
                                            : 'text-white hover:bg-sena-dark'
                                    }`}
                                >
                                    {label}
                                </Link>
                            </li>
                        ))}
                    </ul>
                    <div className="px-4 pb-4 md:pb-0">
                        {user ? (
                            <Link
                                to="/admin"
                                onClick={() => setNavOpen(false)}
                                className="block text-center bg-sena-dark text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-sena-black transition-colors"
                            >
                                Administración
                            </Link>
                        ) : (
                            <Link
                                to="/acceso"
                                onClick={() => setNavOpen(false)}
                                className="block text-center bg-sena-dark text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-sena-black transition-colors"
                            >
                                Ingresar
                            </Link>
                        )}
                    </div>
                </nav>
            </div>
        </header>
    );
}
