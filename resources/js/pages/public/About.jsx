import { useState, useEffect } from 'react';
import publicService from '../../services/publicService';

export default function About() {
    const [programCount, setProgramCount] = useState(0);

    useEffect(() => {
        publicService.getPrograms().then(res => {
            const total = res.data.locations.reduce((acc, l) => acc + l.programs.length, 0);
            setProgramCount(total);
        }).catch(() => {});
    }, []);

    return (
        <>
            <section className="bg-sena-dark text-white py-16">
                <div className="container mx-auto px-4">
                    <p className="text-sena-green font-semibold text-sm mb-2">Institución</p>
                    <h1 className="text-4xl font-bold mb-4">Quiénes somos</h1>
                    <p className="text-gray-300 max-w-2xl">
                        El Servicio Nacional de Aprendizaje es la entidad del Estado colombiano
                        encargada de la formación técnica y tecnológica gratuita para el trabajo.
                    </p>
                </div>
            </section>

            <section className="py-16">
                <div className="container mx-auto px-4 grid md:grid-cols-2 gap-6">
                    <article className="bg-white p-8 rounded-xl shadow-sm border-t-4 border-sena-green">
                        <h2 className="text-2xl font-bold text-sena-dark mb-3">Misión</h2>
                        <p className="text-gray-600">
                            Formar ciudadanos con capacidades técnicas y valores éticos, contribuyendo al
                            desarrollo económico, social y tecnológico del país mediante formación profesional
                            integral gratuita, pertinente y de calidad.
                        </p>
                    </article>
                    <article className="bg-sena-dark text-white p-8 rounded-xl shadow-sm">
                        <h2 className="text-2xl font-bold mb-3">Visión</h2>
                        <p className="text-gray-300">
                            Ser la institución de formación para el trabajo referente en América Latina,
                            reconocida por la innovación de sus metodologías, la pertinencia de su oferta
                            y el impacto de sus egresados en las regiones.
                        </p>
                    </article>
                </div>
            </section>

            <section className="py-16 bg-gray-50">
                <div className="container mx-auto px-4">
                    <h2 className="text-2xl font-bold text-sena-dark mb-8 text-center">Nuestros principios</h2>
                    <div className="grid md:grid-cols-4 gap-6">
                        {[
                            { title: 'Gratuidad', desc: 'La educación pública técnica es un derecho, no un privilegio.' },
                            { title: 'Pertinencia', desc: 'Cada programa responde a las necesidades reales del sector productivo.' },
                            { title: 'Integralidad', desc: 'Formamos competencias técnicas y ciudadanas en igual medida.' },
                            { title: 'Innovación', desc: 'Ambientes de aprendizaje actualizados con tecnología de frontera.' },
                        ].map((v, i) => (
                            <div key={i} className="bg-white p-6 rounded-xl shadow-sm text-center">
                                <strong className="block text-sena-dark text-lg mb-2">{v.title}</strong>
                                <span className="text-gray-500 text-sm">{v.desc}</span>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            <section className="bg-sena-dark text-white py-12">
                <div className="container mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div><span className="block text-4xl font-bold text-sena-green">{programCount}</span><span className="text-gray-400 text-sm">Tecnologías activas</span></div>
                    <div><span className="block text-4xl font-bold text-sena-green">1957</span><span className="text-gray-400 text-sm">Año de fundación</span></div>
                    <div><span className="block text-4xl font-bold text-sena-green">33</span><span className="text-gray-400 text-sm">Centros regionales</span></div>
                    <div><span className="block text-4xl font-bold text-sena-green">116</span><span className="text-gray-400 text-sm">Municipios con presencia</span></div>
                </div>
            </section>
        </>
    );
}
