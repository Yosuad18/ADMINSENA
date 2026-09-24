import { useState, useEffect } from 'react';
import { useSearchParams, Link } from 'react-router-dom';
import publicService from '../../services/publicService';

export default function Search() {
    const [searchParams] = useSearchParams();
    const query = searchParams.get('q') || '';
    const [results, setResults] = useState({ programs: [], news: [], events: [] });
    const [total, setTotal] = useState(0);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        if (!query) return;
        setLoading(true);
        publicService.search(query)
            .then(res => {
                setResults(res.data.results);
                setTotal(res.data.total);
            })
            .catch(() => {})
            .finally(() => setLoading(false));
    }, [query]);

    return (
        <>
            <section className="bg-sena-dark text-white py-16">
                <div className="container mx-auto px-4">
                    <p className="text-sena-green font-semibold text-sm mb-2">Búsqueda</p>
                    <h1 className="text-4xl font-bold mb-2">
                        {query ? `Resultados para "${query}"` : 'Buscar'}
                    </h1>
                    {query && (
                        <p className="text-gray-300">
                            {total} resultado{total === 1 ? '' : 's'} encontrado{total === 1 ? '' : 's'} en programas, noticias y eventos.
                        </p>
                    )}
                </div>
            </section>

            <section className="py-12">
                <div className="container mx-auto px-4 max-w-3xl">
                    {!query ? (
                        <div className="text-center py-12">
                            <h2 className="text-2xl font-bold text-sena-dark mb-2">¿Qué estás buscando?</h2>
                            <p className="text-gray-500">Usa el buscador del encabezado o prueba con términos como "software", "inscripción" o "feria".</p>
                        </div>
                    ) : loading ? (
                        <div className="text-center py-12 text-gray-500">Buscando...</div>
                    ) : total === 0 ? (
                        <div className="text-center py-12">
                            <h2 className="text-2xl font-bold text-sena-dark mb-2">Sin coincidencias</h2>
                            <p className="text-gray-500 mb-4">No encontramos resultados para "{query}".</p>
                            <Link to="/programas" className="inline-block border-2 border-sena-dark text-sena-dark px-5 py-2 rounded-lg font-semibold hover:bg-sena-dark hover:text-white transition-colors">
                                Explorar programas
                            </Link>
                        </div>
                    ) : (
                        <div className="space-y-8">
                            {results.programs.length > 0 && (
                                <div>
                                    <h2 className="text-xl font-bold text-sena-dark mb-4">Programas <span className="text-gray-400 font-normal">({results.programs.length})</span></h2>
                                    <ul className="space-y-3">
                                        {results.programs.map((p, i) => (
                                            <li key={i} className="flex gap-4 bg-white p-4 rounded-xl shadow-sm">
                                                {p.image && <img src={p.image} alt="" className="w-16 h-12 object-cover rounded" />}
                                                <div>
                                                    <span className="text-xs bg-sena-green/10 text-sena-green px-2 py-0.5 rounded">{p.level}</span>
                                                    <h3 className="font-bold text-sena-dark"><Link to="/programas" className="hover:text-sena-green">{p.name}</Link></h3>
                                                    <p className="text-gray-500 text-sm">{p.summary}</p>
                                                </div>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            )}
                            {results.news.length > 0 && (
                                <div>
                                    <h2 className="text-xl font-bold text-sena-dark mb-4">Noticias <span className="text-gray-400 font-normal">({results.news.length})</span></h2>
                                    <ul className="space-y-3">
                                        {results.news.map((a, i) => (
                                            <li key={i} className="flex gap-4 bg-white p-4 rounded-xl shadow-sm">
                                                <div className="text-center flex-shrink-0 w-12">
                                                    <span className="block text-lg font-bold text-sena-dark">{new Date(a.date).getDate()}</span>
                                                    <span className="text-xs text-gray-500">{new Date(a.date).toLocaleDateString('es-CO', { month: 'short' })}</span>
                                                </div>
                                                <div>
                                                    <span className="text-xs bg-sena-green/10 text-sena-green px-2 py-0.5 rounded">{a.category}</span>
                                                    <h3 className="font-bold text-sena-dark"><Link to={`/noticias/${a.slug}`} className="hover:text-sena-green">{a.title}</Link></h3>
                                                    <p className="text-gray-500 text-sm">{a.excerpt}</p>
                                                </div>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            )}
                            {results.events.length > 0 && (
                                <div>
                                    <h2 className="text-xl font-bold text-sena-dark mb-4">Eventos <span className="text-gray-400 font-normal">({results.events.length})</span></h2>
                                    <ul className="space-y-3">
                                        {results.events.map((e, i) => (
                                            <li key={i} className="flex gap-4 bg-white p-4 rounded-xl shadow-sm">
                                                <div className="text-center flex-shrink-0 w-12">
                                                    <span className="block text-lg font-bold text-sena-dark">{new Date(e.date).getDate()}</span>
                                                    <span className="text-xs text-gray-500">{new Date(e.date).toLocaleDateString('es-CO', { month: 'short' })}</span>
                                                </div>
                                                <div>
                                                    <span className="text-xs bg-sena-green/10 text-sena-green px-2 py-0.5 rounded">{e.type}</span>
                                                    <h3 className="font-bold text-sena-dark"><Link to="/eventos" className="hover:text-sena-green">{e.title}</Link></h3>
                                                    <p className="text-gray-500 text-sm">{e.detail}</p>
                                                </div>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            )}
                        </div>
                    )}
                </div>
            </section>
        </>
    );
}
