import api from './api';

const trainingCentersService = {
    list: ()      => api.get('/api/training-centers'),
    get: (id)     => api.get(`/api/training-centers/${id}`),
    create: (data) => api.post('/api/training-centers', data),
    update: (id, data) => api.put(`/api/training-centers/${id}`, data),
    delete: (id)  => api.delete(`/api/training-centers/${id}`),
};

export default trainingCentersService;
