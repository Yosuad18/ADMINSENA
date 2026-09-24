import { createContext, useContext, useState, useEffect } from 'react';
import api from '../services/api';

const AuthContext = createContext(null);

export function AuthProvider({ children }) {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        api.get('/api/user')
            .then(res => setUser(res.data))
            .catch(() => setUser(null))
            .finally(() => setLoading(false));
    }, []);

    const login = async (email, password, remember = false) => {
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        await api.post('/acceso', { email, password, remember }, {
            headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest' },
        });
        const res = await api.get('/api/user');
        setUser(res.data);
    };

    const logout = async () => {
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        await api.post('/salir', {}, {
            headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest' },
        });
        setUser(null);
    };

    return (
        <AuthContext.Provider value={{ user, loading, login, logout }}>
            {children}
        </AuthContext.Provider>
    );
}

export function useAuth() {
    const context = useContext(AuthContext);
    if (!context) throw new Error('useAuth debe usarse dentro de AuthProvider');
    return context;
}
