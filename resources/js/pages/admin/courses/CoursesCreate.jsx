import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import coursesService from '../../../services/coursesService';
import areasService from '../../../services/areasService';
import trainingCentersService from '../../../services/trainingCentersService';
import teachersService from '../../../services/teachersService';
import FormField from '../../../components/admin/FormField';

export default function CoursesCreate() {
    const navigate = useNavigate();
    const [form, setForm] = useState({ course_number: '', name: '', day: '', deadline: '', area_id: '', training_center_id: '', teachers: [] });
    const [areas, setAreas] = useState([]);
    const [centers, setCenters] = useState([]);
    const [teachers, setTeachers] = useState([]);
    const [errors, setErrors] = useState({});
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        areasService.list().then(r => setAreas(r.data)).catch(() => {});
        trainingCentersService.list().then(r => setCenters(r.data)).catch(() => {});
        teachersService.list().then(r => setTeachers(r.data)).catch(() => {});
    }, []);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setForm(prev => ({ ...prev, [name]: value }));
    };

    const handleTeacherToggle = (id) => {
        setForm(prev => ({
            ...prev,
            teachers: prev.teachers.includes(id) ? prev.teachers.filter(t => t !== id) : [...prev.teachers, id],
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors({});
        setLoading(true);
        try {
            await coursesService.create(form);
            navigate('/admin/cursos');
        } catch (err) {
            setErrors(err.response?.data?.errors || {});
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="flex justify-center">
            <div className="w-full max-w-2xl">
                <div className="bg-white rounded-xl shadow-sm p-6 border-t-4 border-sena-green">
                    <h3 className="text-lg font-bold text-sena-dark mb-4">
                        <i className="fas fa-plus-circle text-sena-green mr-2"></i>Crear Nuevo Curso
                    </h3>

                    <form onSubmit={handleSubmit}>
                        <FormField label="Número de Curso / Ficha" name="course_number" value={form.course_number} onChange={handleChange} error={errors.course_number?.[0]} placeholder="Ej. 2670123" />
                        <FormField label="Nombre del Programa" name="name" value={form.name} onChange={handleChange} error={errors.name?.[0]} placeholder="Ej. Análisis y Desarrollo de Software" />

                        <div className="grid grid-cols-2 gap-4">
                            <FormField label="Jornada / Días" name="day" value={form.day} onChange={handleChange} error={errors.day?.[0]} placeholder="Ej. Diurna - Lunes a Viernes" />
                            <FormField label="Fecha límite" name="deadline" type="date" value={form.deadline} onChange={handleChange} error={errors.deadline?.[0]} />
                        </div>

                        <FormField label="Área" name="area_id" type="select" value={form.area_id} onChange={handleChange} options={areas.map(a => ({ value: a.id, label: a.name }))} error={errors.area_id?.[0]} />
                        <FormField label="Centro de Formación" name="training_center_id" type="select" value={form.training_center_id} onChange={handleChange} options={centers.map(c => ({ value: c.id, label: c.name }))} error={errors.training_center_id?.[0]} />

                        <div className="mb-4">
                            <label className="block text-sm font-bold text-gray-700 mb-2">Instructores Asignados</label>
                            <div className="flex flex-wrap gap-2">
                                {teachers.map(t => (
                                    <label key={t.id} className={`flex items-center gap-1 bg-gray-100 px-3 py-1.5 rounded-lg cursor-pointer text-sm ${form.teachers.includes(t.id) ? 'bg-sena-green text-white' : ''}`}>
                                        <input type="checkbox" checked={form.teachers.includes(t.id)} onChange={() => handleTeacherToggle(t.id)} className="hidden" />
                                        {t.name}
                                    </label>
                                ))}
                            </div>
                        </div>

                        <div className="flex justify-end gap-2 mt-6">
                            <button type="button" onClick={() => navigate('/admin/cursos')} className="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50">Cancelar</button>
                            <button type="submit" disabled={loading} className="px-4 py-2 rounded-lg bg-sena-green text-white text-sm font-semibold hover:bg-green-600 disabled:opacity-50">
                                <i className="fas fa-save mr-1"></i> Guardar Curso
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}
