import api from './api';

const computersService = {
    list: ()      => api.get('/api/computers'),
    get: (id)     => api.get(`/api/computers/${id}`),
    create: (data) => api.post('/api/computers', data),
    update: (id, data) => api.put(`/api/computers/${id}`, data),
    delete: (id)  => api.delete(`/api/computers/${id}`),
};

export default computersService;
