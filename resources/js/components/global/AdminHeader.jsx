import { Link } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';

export default function AdminHeader() {
    const { user } = useAuth();

    return (
        <header className="bg-white border-b-4 border-sena-green shadow-sm py-2">
            <div className="container mx-auto px-4 flex items-center justify-between">
                <div className="flex items-center gap-3">
                    <img src="/images/sena_2.png" alt="Logo SENA" className="h-14" />
                    <div>
                        <h1 className="text-lg font-bold text-sena-dark">Servicio Nacional de Aprendizaje</h1>
                        <small className="text-gray-500 font-medium text-sm">Sistema de Gestión Institucional</small>
                    </div>
                </div>
                <div className="hidden md:flex items-center gap-4">
                    <span className="bg-green-100 text-sena-green px-3 py-1 rounded-full text-sm font-semibold">
                        Sistema Activo
                    </span>
                    {user && (
                        <span className="text-sm text-gray-600">{user.name}</span>
                    )}
                </div>
            </div>
        </header>
    );
}
