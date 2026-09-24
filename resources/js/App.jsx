import { Routes, Route } from 'react-router-dom';
import { AuthProvider } from './context/AuthContext';
import ProtectedRoute from './guards/ProtectedRoute';

import PublicLayout from './layouts/PublicLayout';
import AdminLayout from './layouts/AdminLayout';

import Home from './pages/public/Home';
import About from './pages/public/About';
import Programs from './pages/public/Programs';
import News from './pages/public/News';
import NewsDetail from './pages/public/NewsDetail';
import Events from './pages/public/Events';
import Contact from './pages/public/Contact';
import Search from './pages/public/Search';
import Login from './pages/public/Login';

import Dashboard from './pages/admin/Dashboard';
import CoursesIndex from './pages/admin/courses/CoursesIndex';
import CoursesCreate from './pages/admin/courses/CoursesCreate';
import CoursesEdit from './pages/admin/courses/CoursesEdit';
import ApprenticesIndex from './pages/admin/apprentices/ApprenticesIndex';
import ApprenticesCreate from './pages/admin/apprentices/ApprenticesCreate';
import ApprenticesEdit from './pages/admin/apprentices/ApprenticesEdit';
import AreasIndex from './pages/admin/areas/AreasIndex';
import AreasCreate from './pages/admin/areas/AreasCreate';
import AreasEdit from './pages/admin/areas/AreasEdit';
import TeachersIndex from './pages/admin/teachers/TeachersIndex';
import TeachersCreate from './pages/admin/teachers/TeachersCreate';
import TeachersEdit from './pages/admin/teachers/TeachersEdit';
import TrainingCentersIndex from './pages/admin/training-centers/TrainingCentersIndex';
import TrainingCentersCreate from './pages/admin/training-centers/TrainingCentersCreate';
import TrainingCentersEdit from './pages/admin/training-centers/TrainingCentersEdit';
import ComputersIndex from './pages/admin/computers/ComputersIndex';
import ComputersCreate from './pages/admin/computers/ComputersCreate';
import ComputersEdit from './pages/admin/computers/ComputersEdit';

export default function Router() {
    return (
        <AuthProvider>
            <Routes>
                <Route element={<PublicLayout />}>
                    <Route path="/" element={<Home />} />
                    <Route path="/quienes-somos" element={<About />} />
                    <Route path="/programas" element={<Programs />} />
                    <Route path="/noticias" element={<News />} />
                    <Route path="/noticias/:slug" element={<NewsDetail />} />
                    <Route path="/eventos" element={<Events />} />
                    <Route path="/contacto" element={<Contact />} />
                    <Route path="/buscar" element={<Search />} />
                    <Route path="/acceso" element={<Login />} />
                </Route>

                <Route
                    path="/admin"
                    element={
                        <ProtectedRoute>
                            <AdminLayout />
                        </ProtectedRoute>
                    }
                >
                    <Route index element={<Dashboard />} />
                    <Route path="cursos" element={<CoursesIndex />} />
                    <Route path="cursos/crear" element={<CoursesCreate />} />
                    <Route path="cursos/:id/editar" element={<CoursesEdit />} />
                    <Route path="aprendices" element={<ApprenticesIndex />} />
                    <Route path="aprendices/crear" element={<ApprenticesCreate />} />
                    <Route path="aprendices/:id/editar" element={<ApprenticesEdit />} />
                    <Route path="areas" element={<AreasIndex />} />
                    <Route path="areas/crear" element={<AreasCreate />} />
                    <Route path="areas/:id/editar" element={<AreasEdit />} />
                    <Route path="instructores" element={<TeachersIndex />} />
                    <Route path="instructores/crear" element={<TeachersCreate />} />
                    <Route path="instructores/:id/editar" element={<TeachersEdit />} />
                    <Route path="centros" element={<TrainingCentersIndex />} />
                    <Route path="centros/crear" element={<TrainingCentersCreate />} />
                    <Route path="centros/:id/editar" element={<TrainingCentersEdit />} />
                    <Route path="equipos" element={<ComputersIndex />} />
                    <Route path="equipos/crear" element={<ComputersCreate />} />
                    <Route path="equipos/:id/editar" element={<ComputersEdit />} />
                </Route>
            </Routes>
        </AuthProvider>
    );
}
