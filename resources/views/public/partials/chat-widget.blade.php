<div class="chatbot" data-chatbot>

    <section class="chatbot__panel" data-chat-panel role="dialog"
             aria-label="Asistente virtual SenaBot"
             aria-modal="false"
             hidden>
        <header class="chatbot__head">
            <div class="chatbot__identity">
                <span class="chatbot__avatar" aria-hidden="true">SB</span>
                <div>
                    <p class="chatbot__name">SenaBot</p>
                    <p class="chatbot__status">
                        <span class="chatbot__dot" aria-hidden="true"></span> En línea
                    </p>
                </div>
            </div>
            <button type="button" class="chatbot__close" data-chat-close aria-label="Cerrar el asistente">
                <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" focusable="false">
                    <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                </svg>
            </button>
        </header>

        <div class="chatbot__log" data-chat-log role="log" aria-live="polite" aria-label="Historial de conversación">
            <div class="chat-msg chat-msg--bot">
                <p>¡Hola! Soy SenaBot. Pregúntame por programas de tecnología, inscripciones o eventos.</p>
            </div>
        </div>

        <form class="chatbot__form" data-chat-form>
            <label class="visually-hidden" for="chat-input">Escribe tu pregunta</label>
            <input id="chat-input" type="text" data-chat-input
                   placeholder="Escribe tu pregunta…"
                   maxlength="1000"
                   autocomplete="off">
            <button type="submit" class="chatbot__send" aria-label="Enviar mensaje">
                <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" focusable="false">
                    <path d="M3 11.5 21 3l-8.5 18-2.4-7.1L3 11.5z" fill="currentColor"/>
                </svg>
            </button>
        </form>
    </section>

    <button type="button" class="chatbot__launcher btn-pulse" data-chat-toggle
            aria-expanded="false" aria-controls="chat-panel-region">
        <svg viewBox="0 0 24 24" width="26" height="26" aria-hidden="true" focusable="false">
            <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5v8a2.5 2.5 0 0 1-2.5 2.5H9l-4.2 3.6c-.5.4-.8.1-.8-.4V5.5z" fill="currentColor"/>
        </svg>
        <span class="visually-hidden">Abrir el asistente virtual</span>
    </button>
</div>
