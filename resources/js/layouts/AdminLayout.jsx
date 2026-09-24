import { Outlet } from 'react-router-dom';
import AdminHeader from '../components/global/AdminHeader';
import AdminNavbar from '../components/global/AdminNavbar';
import AdminFooter from '../components/global/AdminFooter';

export default function AdminLayout() {
    return (
        <div className="min-h-screen flex flex-col bg-gray-100">
            <AdminHeader />
            <AdminNavbar />
            <main className="container mx-auto px-4 py-6 flex-1">
                <Outlet />
            </main>
            <AdminFooter />
        </div>
    );
}
