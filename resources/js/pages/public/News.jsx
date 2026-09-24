import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import publicService from '../../services/publicService';

export default function News() {
    const [news, setNews] = useState([]);

    useEffect(() => {
        publicService.getNews().then(res => {
            setNews([...res.data.news].sort((a, b) => b.date.localeCompare(a.date)));
        }).catch(() => {});
    }, []);

    return (
        <>
            <section className="bg-sena-dark text-white py-16">
                <div className="container mx-auto px-4">
                    <p className="text-sena-green font-semibold text-sm mb-2">Sala de prensa</p>
                    <h1 className="text-4xl font-bold mb-2">Noticias</h1>
                    <p className="text-gray-300">Convocatorias, alianzas y logros de la comunidad formativa.</p>
                </div>
            </section>

            <section className="py-12">
                <div className="container mx-auto px-4 space-y-6">
                    {news.map((article, i) => {
                        const d = new Date(article.date);
                        return (
                            <article key={i} className="flex gap-6 bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                <div className="text-center flex-shrink-0 w-16">
                                    <span className="block text-3xl font-bold text-sena-dark">{d.getDate()}</span>
                                    <span className="text-sm text-gray-500 uppercase">{d.toLocaleDateString('es-CO', { month: 'short' })}</span>
                                </div>
                                <div className="flex-1">
                                    <div className="flex items-center gap-2 mb-2">
                                        <span className="bg-sena-green/10 text-sena-green px-2 py-0.5 rounded text-xs font-semibold">{article.category}</span>
                                        <time className="text-sm text-gray-500">{d.toLocaleDateString('es-CO', { year: 'numeric', month: 'long', day: 'numeric' })}</time>
                                    </div>
                                    <h2 className="text-xl font-bold text-sena-dark mb-2">
                                        <Link to={`/noticias/${article.slug}`} className="hover:text-sena-green transition-colors">{article.title}</Link>
                                    </h2>
                                    <p className="text-gray-500">{article.excerpt}</p>
                                </div>
                            </article>
                        );
                    })}
                </div>
            </section>
        </>
    );
}
