import { Outlet } from 'react-router-dom';
import Header from '../components/global/Header';
import Footer from '../components/global/Footer';
import ChatWidget from '../components/global/ChatWidget';

export default function PublicLayout() {
    return (
        <div className="min-h-screen flex flex-col">
            <Header />
            <main id="contenido" className="flex-1" role="main">
                <Outlet />
            </main>
            <Footer />
            <ChatWidget />
        </div>
    );
}
