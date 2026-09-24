import { Link } from 'react-router-dom';
import { useState, useEffect } from 'react';
import api from '../../services/api';

export default function Footer() {
    const [config, setConfig] = useState(null);

    useEffect(() => {
        api.get('/api/config').then(res => setConfig(res.data)).catch(() => {});
    }, []);

    const contact = config?.contact ?? { address: '', phone: '', email: '', schedule: '' };
    const appName = config?.app?.name ?? 'ADMISENA';
    const fullName = config?.app?.full_name ?? 'Servicio Nacional de Aprendizaje — SENA';

    return (
        <footer className="bg-sena-black text-white" role="contentinfo">
            <div className="container mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">
                <section aria-label="Identificación institucional">
                    <h2 className="font-bold text-lg mb-2">{fullName}</h2>
                    <p className="text-gray-400 text-sm">
                        {contact.address}<br />
                        Línea gratuita nacional: {contact.phone}
                    </p>
                </section>

                <nav aria-label="Enlaces del sitio">
                    <h2 className="font-bold text-lg mb-2">Sitio</h2>
                    <ul className="space-y-1 text-sm text-gray-400">
                        <li><Link to="/quienes-somos" className="hover:text-sena-green transition-colors">Quiénes somos</Link></li>
                        <li><Link to="/programas" className="hover:text-sena-green transition-colors">Programas</Link></li>
                        <li><Link to="/noticias" className="hover:text-sena-green transition-colors">Noticias</Link></li>
                        <li><Link to="/eventos" className="hover:text-sena-green transition-colors">Eventos</Link></li>
                    </ul>
                </nav>

                <section aria-label="Atención al ciudadano">
                    <h2 className="font-bold text-lg mb-2">Atención</h2>
                    <p className="text-gray-400 text-sm">
                        {contact.email}<br />
                        {contact.schedule}
                    </p>
                </section>
            </div>

            <div className="border-t border-gray-700 py-4 text-center text-sm text-gray-500">
                <div className="container mx-auto px-4">
                    &copy; {new Date().getFullYear()} {appName} — Todos los derechos reservados.
                </div>
            </div>
        </footer>
    );
}
