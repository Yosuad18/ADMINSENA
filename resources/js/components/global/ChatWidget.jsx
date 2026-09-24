import { useState, useRef, useEffect } from 'react';
import api from '../../services/api';

export default function ChatWidget() {
    const [isOpen, setIsOpen] = useState(false);
    const [messages, setMessages] = useState([
        { role: 'assistant', content: '¡Hola! Soy SenaBot. Pregúntame por programas de tecnología, inscripciones o eventos.' },
    ]);
    const [input, setInput] = useState('');
    const [loading, setLoading] = useState(false);
    const logRef = useRef(null);

    useEffect(() => {
        if (logRef.current) {
            logRef.current.scrollTop = logRef.current.scrollHeight;
        }
    }, [messages]);

    const sendMessage = async (e) => {
        e.preventDefault();
        const text = input.trim();
        if (!text || loading) return;

        const userMsg = { role: 'user', content: text };
        setMessages(prev => [...prev, userMsg]);
        setInput('');
        setLoading(true);

        try {
            const history = messages.slice(-8).map(m => ({ role: m.role, content: m.content }));
            const res = await api.post('/api/chat', { message: text, history });
            setMessages(prev => [...prev, { role: 'assistant', content: res.data.reply }]);
        } catch {
            setMessages(prev => [...prev, { role: 'assistant', content: 'Tengo problemas de conexión. Inténtalo de nuevo.' }]);
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="fixed bottom-6 right-6 z-50">
            {isOpen && (
                <div className="bg-white rounded-xl shadow-2xl w-80 mb-3 flex flex-col overflow-hidden border border-gray-200">
                    <header className="bg-sena-dark text-white px-4 py-3 flex items-center justify-between">
                        <div className="flex items-center gap-2">
                            <span className="bg-sena-green text-white text-xs font-bold px-2 py-1 rounded">SB</span>
                            <div>
                                <p className="text-sm font-semibold">SenaBot</p>
                                <p className="text-xs text-gray-300 flex items-center gap-1">
                                    <span className="w-2 h-2 bg-green-400 rounded-full inline-block"></span> En línea
                                </p>
                            </div>
                        </div>
                        <button onClick={() => setIsOpen(false)} className="text-gray-300 hover:text-white" aria-label="Cerrar">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" strokeWidth="2.4" strokeLinecap="round">
                                <path d="M6 6l12 12M18 6L6 18" />
                            </svg>
                        </button>
                    </header>

                    <div ref={logRef} className="flex-1 overflow-y-auto p-3 space-y-3 max-h-72 bg-gray-50">
                        {messages.map((msg, i) => (
                            <div key={i} className={`flex ${msg.role === 'user' ? 'justify-end' : 'justify-start'}`}>
                                <div className={`max-w-[80%] px-3 py-2 rounded-lg text-sm ${
                                    msg.role === 'user'
                                        ? 'bg-sena-green text-white rounded-br-none'
                                        : 'bg-white text-gray-800 border border-gray-200 rounded-bl-none'
                                }`}>
                                    {msg.content}
                                </div>
                            </div>
                        ))}
                        {loading && (
                            <div className="flex justify-start">
                                <div className="bg-white text-gray-400 border border-gray-200 px-3 py-2 rounded-lg rounded-bl-none text-sm">
                                    Escribiendo...
                                </div>
                            </div>
                        )}
                    </div>

                    <form onSubmit={sendMessage} className="flex border-t border-gray-200">
                        <label htmlFor="chat-input" className="sr-only">Escribe tu pregunta</label>
                        <input
                            id="chat-input"
                            type="text"
                            value={input}
                            onChange={(e) => setInput(e.target.value)}
                            placeholder="Escribe tu pregunta…"
                            maxLength={1000}
                            className="flex-1 px-3 py-3 text-sm outline-none"
                            disabled={loading}
                        />
                        <button type="submit" className="px-4 text-sena-green hover:text-sena-dark disabled:opacity-50" disabled={loading || !input.trim()} aria-label="Enviar">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                <path d="M3 11.5 21 3l-8.5 18-2.4-7.1L3 11.5z" />
                            </svg>
                        </button>
                    </form>
                </div>
            )}

            <button
                onClick={() => setIsOpen(!isOpen)}
                className="ml-auto flex items-center justify-center w-14 h-14 bg-sena-green text-white rounded-full shadow-lg hover:bg-sena-dark transition-colors animate-pulse"
                aria-expanded={isOpen}
                aria-controls="chat-panel"
            >
                <svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor">
                    <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5v8a2.5 2.5 0 0 1-2.5 2.5H9l-4.2 3.6c-.5.4-.8.1-.8-.4V5.5z" />
                </svg>
            </button>
        </div>
    );
}
