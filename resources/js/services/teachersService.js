import api from './api';

const teachersService = {
    list: ()      => api.get('/api/teachers'),
    get: (id)     => api.get(`/api/teachers/${id}`),
    create: (data) => api.post('/api/teachers', data),
    update: (id, data) => api.put(`/api/teachers/${id}`, data),
    delete: (id)  => api.delete(`/api/teachers/${id}`),
};

export default teachersService;
