import api from './api';

const areasService = {
    list: ()      => api.get('/api/areas'),
    get: (id)     => api.get(`/api/areas/${id}`),
    create: (data) => api.post('/api/areas', data),
    update: (id, data) => api.put(`/api/areas/${id}`, data),
    delete: (id)  => api.delete(`/api/areas/${id}`),
};

export default areasService;
