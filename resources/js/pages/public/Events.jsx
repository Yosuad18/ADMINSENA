import { useState, useEffect } from 'react';
import publicService from '../../services/publicService';

export default function Events() {
    const [events, setEvents] = useState([]);

    useEffect(() => {
        publicService.getEvents().then(res => {
            setEvents([...res.data.events].sort((a, b) => a.date.localeCompare(b.date)));
        }).catch(() => {});
    }, []);

    return (
        <>
            <section className="bg-sena-dark text-white py-16">
                <div className="container mx-auto px-4">
                    <p className="text-sena-green font-semibold text-sm mb-2">Agenda institucional</p>
                    <h1 className="text-4xl font-bold mb-2">Eventos</h1>
                    <p className="text-gray-300">
                        Jornadas de inscripción, ferias, competencias y ceremonias abiertas al público.
                    </p>
                </div>
            </section>

            <section className="py-12">
                <div className="container mx-auto px-4 max-w-3xl">
                    <ol className="space-y-6">
                        {events.map((event, i) => {
                            const d = new Date(event.date);
                            return (
                                <li key={i} className="flex gap-6 bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                    <div className="text-center flex-shrink-0 w-16 border-2 border-sena-dark rounded-lg p-2">
                                        <span className="block text-2xl font-bold text-sena-dark">{d.getDate()}</span>
                                        <span className="text-xs text-gray-500 uppercase">{d.toLocaleDateString('es-CO', { month: 'short' })}</span>
                                    </div>
                                    <div className="flex-1">
                                        <span className="inline-block bg-sena-green/10 text-sena-green px-2 py-0.5 rounded text-xs font-semibold mb-2">{event.type}</span>
                                        <h2 className="text-lg font-bold text-sena-dark mb-2">{event.title}</h2>
                                        <p className="text-gray-600 text-sm mb-3">{event.detail}</p>
                                        <ul className="flex flex-wrap gap-4 text-sm text-gray-500">
                                            <li className="flex items-center gap-1">
                                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" strokeWidth="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2" strokeLinecap="round"/></svg>
                                                {event.time}
                                            </li>
                                            <li className="flex items-center gap-1">
                                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" strokeWidth="2"><path d="M12 21s-7-6.1-7-11a7 7 0 1 1 14 0c0 4.9-7 11-7 11z"/><circle cx="12" cy="10" r="2.6"/></svg>
                                                {event.place}
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            );
                        })}
                    </ol>
                </div>
            </section>
        </>
    );
}
