document.addEventListener('DOMContentLoaded', () => {


    const navToggle = document.querySelector('[data-nav-toggle]');
    const nav = document.querySelector('[data-nav]');

    if (navToggle && nav) {
        navToggle.addEventListener('click', () => {
            const isOpen = nav.classList.toggle('is-open');
            navToggle.setAttribute('aria-expanded', String(isOpen));
        });

        window.matchMedia('(min-width: 901px)').addEventListener('change', (e) => {
            if (e.matches) {
                nav.classList.remove('is-open');
                navToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }


    const revealTargets = document.querySelectorAll('.fade-in-section');

    if ('IntersectionObserver' in window && revealTargets.length > 0) {
        const observerOptions = {
            root: null,                 
            rootMargin: '0px 0px -40px 0px',
            threshold: 0.15,
        };

        const revealObserver = new IntersectionObserver((entries, observerInstance) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observerInstance.unobserve(entry.target); 
                }
            });
        }, observerOptions);

        revealTargets.forEach((el) => revealObserver.observe(el));
    } else {
        revealTargets.forEach((el) => el.classList.add('is-visible'));
    }


    const chatRoot = document.querySelector('[data-chatbot]');

    if (chatRoot) {
        const panel   = chatRoot.querySelector('[data-chat-panel]');
        const log     = chatRoot.querySelector('[data-chat-log]');
        const form    = chatRoot.querySelector('[data-chat-form]');
        const input   = chatRoot.querySelector('[data-chat-input]');
        const toggle  = chatRoot.querySelector('[data-chat-toggle]');
        const closeBtn = chatRoot.querySelector('[data-chat-close]');


        const history = [];
        const HISTORY_LIMIT = 8;


        const chatEndpoint =
            document.querySelector('meta[name="chat-endpoint"]')?.getAttribute('content') ?? '/chat';


        const openChat = () => {
            panel.hidden = false;
            toggle.setAttribute('aria-expanded', 'true');
            input.focus();
        };


        const closeChat = () => {
            panel.hidden = true;
            toggle.setAttribute('aria-expanded', 'false');
            toggle.focus();
        };

        toggle.addEventListener('click', () => (panel.hidden ? openChat() : closeChat()));
        closeBtn.addEventListener('click', closeChat);

        panel.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeChat();
        });


        const addBubble = (role, text = '') => {
            const bubble = document.createElement('div');
            bubble.className = `chat-msg chat-msg--${role === 'error' ? 'error' : role}`;
            bubble.setAttribute('role', role === 'user' ? 'status' : undefined);

            if (role === 'typing') {
                bubble.innerHTML = '<span></span><span></span><span></span>';
            } else {
                bubble.textContent = text;
            }

            log.appendChild(bubble);
            log.scrollTop = log.scrollHeight; 
            return bubble;
        };


        const sendMessage = async (message) => {
            addBubble('user', message);

            const typingBubble = addBubble('typing');

            try {
                const response = await fetch(chatEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ message, history }),
                });

                if (!response.ok) throw new Error(`HTTP ${response.status}`);

                const data = await response.json();
                typingBubble.remove();
                addBubble('bot', data.reply);

                history.push(
                    { role: 'user', content: message },
                    { role: 'assistant', content: data.reply },
                );
                if (history.length > HISTORY_LIMIT) history.splice(0, history.length - HISTORY_LIMIT);
            } catch (error) {
                typingBubble.remove();
                addBubble('error', 'No pude enviar tu mensaje. Revisa tu conexión e inténtalo de nuevo.');
            }
        };

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const message = input.value.trim();

            if (message === '') return;   
            input.value = '';             
            sendMessage(message);
        });
    }
});
