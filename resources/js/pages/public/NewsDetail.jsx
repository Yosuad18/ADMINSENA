import { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import publicService from '../../services/publicService';

export default function NewsDetail() {
    const { slug } = useParams();
    const [article, setArticle] = useState(null);
    const [related, setRelated] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        setLoading(true);
        publicService.getNewsDetail(slug)
            .then(res => {
                setArticle(res.data.article);
                setRelated(res.data.related);
            })
            .catch(() => {})
            .finally(() => setLoading(false));
    }, [slug]);

    if (loading) return <div className="py-20 text-center text-gray-500">Cargando...</div>;
    if (!article) return <div className="py-20 text-center text-gray-500">Noticia no encontrada</div>;

    return (
        <>
            <header className="bg-sena-dark text-white py-16">
                <div className="container mx-auto px-4 max-w-3xl">
                    <p className="text-sena-green font-semibold text-sm mb-2">{article.category}</p>
                    <h1 className="text-3xl md:text-4xl font-bold mb-4">{article.title}</h1>
                    <p className="text-gray-400">
                        Publicada el {new Date(article.date).toLocaleDateString('es-CO', { year: 'numeric', month: 'long', day: 'numeric' })}
                    </p>
                </div>
            </header>

            <article className="py-12">
                <div className="container mx-auto px-4 max-w-3xl">
                    {article.body?.map((paragraph, i) => (
                        <p key={i} className="text-gray-700 leading-relaxed mb-4">{paragraph}</p>
                    ))}
                    <div className="mt-8">
                        <Link to="/noticias" className="inline-block border-2 border-sena-dark text-sena-dark px-5 py-2 rounded-lg font-semibold hover:bg-sena-dark hover:text-white transition-colors">
                            ← Volver a noticias
                        </Link>
                    </div>
                </div>
            </article>

            {related.length > 0 && (
                <section className="py-12 bg-gray-50">
                    <div className="container mx-auto px-4 max-w-4xl">
                        <h2 className="text-2xl font-bold text-sena-dark mb-6">Sigue leyendo</h2>
                        <div className="grid md:grid-cols-2 gap-6">
                            {related.map((item, i) => (
                                <article key={i} className="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                    <div className="flex items-center gap-2 text-sm text-gray-500 mb-2">
                                        <span className="bg-sena-green/10 text-sena-green px-2 py-0.5 rounded text-xs font-semibold">{item.category}</span>
                                        <time>{new Date(item.date).toLocaleDateString('es-CO', { year: 'numeric', month: 'long', day: 'numeric' })}</time>
                                    </div>
                                    <h3 className="font-bold text-sena-dark mb-2">
                                        <Link to={`/noticias/${item.slug}`} className="hover:text-sena-green transition-colors">{item.title}</Link>
                                    </h3>
                                    <p className="text-gray-500 text-sm">{item.excerpt}</p>
                                </article>
                            ))}
                        </div>
                    </div>
                </section>
            )}
        </>
    );
}
