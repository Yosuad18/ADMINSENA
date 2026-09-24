import api from './api';

const publicService = {
    getConfig: ()  => api.get('/api/config'),
    getPrograms: () => api.get('/api/programs'),
    getNews: ()    => api.get('/api/news'),
    getNewsDetail: (slug) => api.get(`/api/news/${slug}`),
    getEvents: ()  => api.get('/api/events'),
    search: (q)    => api.get('/api/search', { params: { q } }),
    contact: (data) => api.post('/api/contact', data),
    register: (data) => api.post('/api/register', data),
};

export default publicService;
