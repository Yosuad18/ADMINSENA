import api from './api';

const apprenticesService = {
    list: ()      => api.get('/api/apprentices'),
    get: (id)     => api.get(`/api/apprentices/${id}`),
    create: (data) => api.post('/api/apprentices', data),
    update: (id, data) => api.put(`/api/apprentices/${id}`, data),
    delete: (id)  => api.delete(`/api/apprentices/${id}`),
};

export default apprenticesService;
