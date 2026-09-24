import { useState, useEffect } from 'react';
import publicService from '../../services/publicService';

export default function Contact() {
    const [config, setConfig] = useState(null);
    const [form, setForm] = useState({ name: '', email: '', subject: '', message: '' });
    const [msg, setMsg] = useState('');
    const [errors, setErrors] = useState({});
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        publicService.getConfig().then(res => setConfig(res.data)).catch(() => {});
    }, []);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setMsg('');
        setErrors({});
        setLoading(true);
        try {
            const res = await publicService.contact(form);
            setMsg(res.data.message);
            setForm({ name: '', email: '', subject: '', message: '' });
        } catch (err) {
            if (err.response?.data?.errors) {
                setErrors(err.response.data.errors);
            }
        } finally {
            setLoading(false);
        }
    };

    const contact = config?.contact ?? {};

    return (
        <>
            <section className="bg-sena-dark text-white py-16">
                <div className="container mx-auto px-4">
                    <p className="text-sena-green font-semibold text-sm mb-2">Atención al ciudadano</p>
                    <h1 className="text-4xl font-bold mb-2">Contacto</h1>
                    <p className="text-gray-300">Escríbenos y recibe respuesta en un máximo de dos días hábiles.</p>
                </div>
            </section>

            <section className="py-12">
                <div className="container mx-auto px-4 grid md:grid-cols-2 gap-12">
                    <div>
                        <h2 className="text-xl font-bold text-sena-dark mb-6">Envíanos un mensaje</h2>

                        {msg && <div className="bg-green-50 text-green-700 p-3 rounded-lg mb-4 text-sm">{msg}</div>}

                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
                                    <input type="text" required value={form.name} onChange={e => setForm({...form, name: e.target.value})} className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sena-green focus:outline-none" />
                                    {errors.name && <p className="text-red-500 text-xs mt-1">{errors.name[0]}</p>}
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                                    <input type="email" required value={form.email} onChange={e => setForm({...form, email: e.target.value})} className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sena-green focus:outline-none" />
                                    {errors.email && <p className="text-red-500 text-xs mt-1">{errors.email[0]}</p>}
                                </div>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">Asunto</label>
                                <input type="text" required value={form.subject} onChange={e => setForm({...form, subject: e.target.value})} className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sena-green focus:outline-none" />
                                {errors.subject && <p className="text-red-500 text-xs mt-1">{errors.subject[0]}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">Mensaje</label>
                                <textarea required rows={6} minLength={20} value={form.message} onChange={e => setForm({...form, message: e.target.value})} className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sena-green focus:outline-none"></textarea>
                                <p className="text-gray-400 text-xs mt-1">Mínimo 20 caracteres.</p>
                                {errors.message && <p className="text-red-500 text-xs mt-1">{errors.message[0]}</p>}
                            </div>
                            <button type="submit" disabled={loading} className="w-full bg-sena-green text-white py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors disabled:opacity-50">
                                {loading ? 'Enviando...' : 'Enviar mensaje'}
                            </button>
                        </form>
                    </div>

                    <aside>
                        <h2 className="text-xl font-bold text-sena-dark mb-6">Otros canales</h2>
                        <div className="space-y-4">
                            <div className="flex items-start gap-3 bg-gray-50 p-4 rounded-xl">
                                <span className="text-xl">☎</span>
                                <div><strong className="text-sena-dark">Línea gratuita nacional</strong><br/><span className="text-gray-500 text-sm">{contact.phone}</span></div>
                            </div>
                            <div className="flex items-start gap-3 bg-gray-50 p-4 rounded-xl">
                                <span className="text-xl">✉</span>
                                <div><strong className="text-sena-dark">Correo institucional</strong><br/><span className="text-gray-500 text-sm">{contact.email}</span></div>
                            </div>
                            <div className="flex items-start gap-3 bg-gray-50 p-4 rounded-xl">
                                <span className="text-xl">⌂</span>
                                <div><strong className="text-sena-dark">Sede principal</strong><br/><span className="text-gray-500 text-sm">{contact.address}</span></div>
                            </div>
                            <div className="flex items-start gap-3 bg-gray-50 p-4 rounded-xl">
                                <span className="text-xl">◷</span>
                                <div><strong className="text-sena-dark">Horario de atención</strong><br/><span className="text-gray-500 text-sm">{contact.schedule}</span></div>
                            </div>
                        </div>
                    </aside>
                </div>
            </section>
        </>
    );
}
