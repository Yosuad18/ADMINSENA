import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import publicService from '../../services/publicService';

export default function Home() {
    const [programs, setPrograms] = useState([]);
    const [latestNews, setLatestNews] = useState([]);
    const [upcomingEvent, setUpcomingEvent] = useState(null);

    useEffect(() => {
        publicService.getPrograms().then(res => {
            const all = res.data.locations.flatMap(l => l.programs);
            setPrograms(all);
        }).catch(() => {});

        publicService.getNews().then(res => {
            const sorted = [...res.data.news].sort((a, b) => b.date.localeCompare(a.date));
            setLatestNews(sorted.slice(0, 3));
        }).catch(() => {});

        publicService.getEvents().then(res => {
            const sorted = [...res.data.events].sort((a, b) => a.date.localeCompare(b.date));
            setUpcomingEvent(sorted[0] || null);
        }).catch(() => {});
    }, []);

    return (
        <>
            <section className="bg-sena-dark text-white py-20">
                <div className="container mx-auto px-4 text-center">
                    <p className="text-sena-green font-semibold mb-4">Formación técnica y tecnológica · Gratuita</p>
                    <h1 className="text-4xl md:text-5xl font-bold mb-4">
                        Aprende la profesión que <em className="text-sena-green not-italic">Colombia</em> necesita
                    </h1>
                    <p className="text-lg text-gray-300 max-w-2xl mx-auto mb-8">
                        Explora programas de tecnología con certificación oficial,
                        inscríbete a eventos abiertos y mantente al día con la agenda institucional.
                    </p>
                    <div className="flex flex-wrap justify-center gap-4 mb-12">
                        <Link to="/programas" className="bg-sena-green text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors">
                            Explorar programas
                        </Link>
                        <Link to="/eventos" className="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-sena-dark transition-colors">
                            Ver agenda de eventos
                        </Link>
                    </div>
                    <div className="flex justify-center gap-12 text-center">
                        <div><span className="block text-3xl font-bold text-sena-green">{programs.length}</span><span className="text-sm text-gray-400">Programas de tecnología</span></div>
                        <div><span className="block text-3xl font-bold text-sena-green">33</span><span className="text-sm text-gray-400">Centros de formación</span></div>
                        <div><span className="block text-3xl font-bold text-sena-green">100%</span><span className="text-sm text-gray-400">Formación gratuita</span></div>
                    </div>
                </div>
            </section>

            <section className="py-12 overflow-hidden">
                <div className="flex gap-6 animate-scroll whitespace-nowrap">
                    {[...programs, ...programs].map((p, i) => (
                        <div key={i} className="inline-block w-72 flex-shrink-0 bg-white rounded-xl shadow-md overflow-hidden">
                            {p.image && <img src={p.image} alt={p.name} className="w-full h-40 object-cover" />}
                            <div className="p-4">
                                <span className="text-xs font-bold text-sena-green bg-green-50 px-2 py-1 rounded">{p.course_number || p.code}</span>
                                <h3 className="font-bold mt-2 text-sena-dark">{p.name}</h3>
                            </div>
                        </div>
                    ))}
                </div>
                <p className="container mx-auto px-4 mt-4 text-right">
                    <Link to="/programas" className="text-sena-green font-semibold hover:underline">Ver todos los programas →</Link>
                </p>
            </section>

            <section className="py-16 bg-white">
                <div className="container mx-auto px-4 grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 className="text-3xl font-bold text-sena-dark mb-4">Educación pública que transforma regiones</h2>
                        <p className="text-gray-600 mb-6">
                            Desde 1957 formamos técnicos, tecnólogos y emprendedores en todos los rincones
                            del país. Nuestra formación es gratuita, pertinente al sector productivo
                            y certificada bajo estándares nacionales e internacionales.
                        </p>
                        <Link to="/quienes-somos" className="inline-block border-2 border-sena-dark text-sena-dark px-5 py-2 rounded-lg font-semibold hover:bg-sena-dark hover:text-white transition-colors">
                            Conoce nuestra historia
                        </Link>
                    </div>
                    <div className="space-y-4">
                        <div className="bg-gray-50 p-6 rounded-xl text-center"><span className="block text-4xl font-bold text-sena-green">+8M</span><span className="text-gray-500">Aprendices formados</span></div>
                        <div className="bg-gray-50 p-6 rounded-xl text-center"><span className="block text-4xl font-bold text-sena-green">100+</span><span className="text-gray-500">Programas activos</span></div>
                        <div className="bg-gray-50 p-6 rounded-xl text-center"><span className="block text-4xl font-bold text-sena-green">32</span><span className="text-gray-500">Departamentos cubiertos</span></div>
                    </div>
                </div>
            </section>

            <section className="py-16 bg-gray-50">
                <div className="container mx-auto px-4">
                    <div className="flex justify-between items-center mb-8">
                        <h2 className="text-2xl font-bold text-sena-dark">Últimas noticias</h2>
                        <Link to="/noticias" className="text-sena-green font-semibold hover:underline">Todas las noticias →</Link>
                    </div>
                    <div className="grid md:grid-cols-3 gap-6">
                        {latestNews.map((article, i) => (
                            <article key={i} className="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                                <div className="flex items-center gap-2 text-sm text-gray-500 mb-2">
                                    <span className="bg-sena-green/10 text-sena-green px-2 py-0.5 rounded text-xs font-semibold">{article.category}</span>
                                    <time>{new Date(article.date).toLocaleDateString('es-CO', { year: 'numeric', month: 'long', day: 'numeric' })}</time>
                                </div>
                                <h3 className="font-bold text-sena-dark mb-2">
                                    <Link to={`/noticias/${article.slug}`} className="hover:text-sena-green transition-colors">{article.title}</Link>
                                </h3>
                                <p className="text-gray-500 text-sm">{article.excerpt}</p>
                            </article>
                        ))}
                    </div>
                </div>
            </section>

            {upcomingEvent && (
                <section className="bg-sena-dark text-white py-12">
                    <div className="container mx-auto px-4 flex flex-col md:flex-row items-center gap-6">
                        <div className="bg-sena-green text-white px-6 py-4 rounded-xl text-center">
                            <span className="block text-3xl font-bold">{new Date(upcomingEvent.date).getDate()}</span>
                            <span className="text-sm uppercase">{new Date(upcomingEvent.date).toLocaleDateString('es-CO', { month: 'short' })}</span>
                        </div>
                        <div className="flex-1">
                            <p className="text-sena-green font-semibold text-sm mb-1">Próximo evento · {upcomingEvent.type}</p>
                            <h2 className="text-2xl font-bold mb-1">{upcomingEvent.title}</h2>
                            <p className="text-gray-300">{upcomingEvent.place} — {upcomingEvent.time}</p>
                        </div>
                        <Link to="/eventos" className="bg-white text-sena-dark px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                            Agenda completa
                        </Link>
                    </div>
                </section>
            )}
        </>
    );
}
