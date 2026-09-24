import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';

export default function Login() {
    const { login } = useAuth();
    const navigate = useNavigate();
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [remember, setRemember] = useState(false);
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setError('');
        setLoading(true);
        try {
            await login(email, password, remember);
            navigate('/admin');
        } catch (err) {
            setError(err.response?.data?.errors?.auth?.[0] || 'Credenciales incorrectas. Verifica tu correo y contraseña.');
        } finally {
            setLoading(false);
        }
    };

    return (
        <section className="py-20 bg-gray-50">
            <div className="container mx-auto px-4 max-w-md">
                <div className="bg-white rounded-xl shadow-lg p-8">
                    <header className="text-center mb-6">
                        <img src="/images/Sena2.jpg" alt="" className="w-14 h-14 mx-auto mb-3 rounded" />
                        <h1 className="text-2xl font-bold text-sena-dark">Acceso institucional</h1>
                        <p className="text-gray-500 text-sm">Panel administrativo — uso exclusivo del personal autorizado.</p>
                    </header>

                    {error && (
                        <div className="bg-red-50 text-red-700 p-3 rounded-lg mb-4 text-sm text-center" role="alert">{error}</div>
                    )}

                    <form onSubmit={handleSubmit} className="space-y-4">
                        <div>
                            <label htmlFor="lg-email" className="block text-sm font-medium text-gray-700 mb-1">Correo institucional</label>
                            <input id="lg-email" type="email" required autoFocus autoComplete="username" value={email} onChange={e => setEmail(e.target.value)} className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sena-green focus:outline-none" />
                        </div>
                        <div>
                            <label htmlFor="lg-password" className="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                            <input id="lg-password" type="password" required autoComplete="current-password" value={password} onChange={e => setPassword(e.target.value)} className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sena-green focus:outline-none" />
                        </div>
                        <div className="flex items-center gap-2">
                            <input id="lg-remember" type="checkbox" checked={remember} onChange={e => setRemember(e.target.checked)} className="rounded border-gray-300 text-sena-green focus:ring-sena-green" />
                            <label htmlFor="lg-remember" className="text-sm text-gray-600">Mantener la sesión abierta</label>
                        </div>
                        <button type="submit" disabled={loading} className="w-full bg-sena-green text-white py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors disabled:opacity-50">
                            {loading ? 'Ingresando...' : 'Ingresar al panel'}
                        </button>
                    </form>

                    <footer className="text-center mt-6">
                        <Link to="/" className="text-sena-green text-sm hover:underline">← Volver al sitio público</Link>
                    </footer>
                </div>
            </div>
        </section>
    );
}
