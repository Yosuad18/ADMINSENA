import { Navigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

export default function ProtectedRoute({ children }) {
    const { user, loading } = useAuth();

    if (loading) {
        return (
            <div className="flex items-center justify-center min-h-screen">
                <div className="text-sena-dark text-lg">Cargando...</div>
            </div>
        );
    }

    if (!user) {
        return <Navigate to="/acceso" replace />;
    }

    return children;
}
