import api from './api';

const coursesService = {
    list: ()      => api.get('/api/courses'),
    get: (id)     => api.get(`/api/courses/${id}`),
    create: (data) => api.post('/api/courses', data),
    update: (id, data) => api.put(`/api/courses/${id}`, data),
    delete: (id)  => api.delete(`/api/courses/${id}`),
    uploadImage: (id, formData) => api.post(`/courses/${id}/image`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
    }),
};

export default coursesService;
