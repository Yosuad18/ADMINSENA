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


    const cards        = document.querySelectorAll('.offer-card');
    const sections     = document.querySelectorAll('[data-location-section]');
    const emptyState   = document.querySelector('[data-empty-state]');
    const resultsCount = document.querySelector('[data-results-count]');
    const chips        = Array.from(document.querySelectorAll('[data-area-filter]'));

    const hideEl = (el, hidden) => el.toggleAttribute('hidden', hidden);

    const applyDeadlineCheck = () => {
        const now = new Date();
        const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());

        cards.forEach((card) => {
            const raw = card.dataset.deadline;
            if (!raw) return;
            const [y, m, d] = raw.split('-').map(Number);
            const deadline = new Date(y, m - 1, d);
            if (deadline < today) card.remove();
        });
    };

    const applyFilter = (area) => {
        let visible = 0;

        cards.forEach((card) => {
            const match = area === '*' || card.dataset.area === area;
            hideEl(card, !match);
            if (match) visible += 1;
        });

        sections.forEach((section) => {
            const sectionCards = Array.from(section.querySelectorAll('.offer-card'));
            const count = sectionCards.filter((card) => !card.hasAttribute('hidden')).length;
            const countEl = section.querySelector('.location-section__count');
            if (countEl) {
                countEl.textContent = `${count} ${count === 1 ? 'programa disponible' : 'programas disponibles'}`;
            }
            hideEl(section, count === 0);
        });

        hideEl(emptyState, visible !== 0);

        if (resultsCount) {
            resultsCount.textContent = `${visible} ${visible === 1 ? 'programa disponible' : 'programas disponibles'}`;
        }
    };

    chips.forEach((chip) => {
        chip.addEventListener('click', () => {
            chips.forEach((c) => {
                const active = c === chip;
                c.classList.toggle('is-active', active);
                c.setAttribute('aria-pressed', String(active));
            });
            applyFilter(chip.dataset.areaFilter);
        });
    });

    const modal         = document.querySelector('[data-modal]');
    const backdrop      = document.querySelector('[data-modal-backdrop]');
    const closeBtn      = document.querySelector('[data-modal-close]');
    const courseIdField = document.querySelector('[data-register-course-id]');
    const courseNameEl  = document.querySelector('[data-register-course-name]');
    const openButtons   = Array.from(document.querySelectorAll('[data-register-open]'));

    let lastFocused = null;

    const FOCUSABLE =
        'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

    const focusableIn = (root) =>
        Array.from(root.querySelectorAll(FOCUSABLE)).filter((el) => !el.closest('[hidden]'));

    const openModal = (courseId = null, courseName = '') => {
        if (courseId) {
            courseIdField.value = courseId;
            if (courseName) courseNameEl.textContent = `Programa: ${courseName}`;
        }

        modal.hidden = false;
        backdrop.hidden = false;
        lastFocused = document.activeElement;

        const firstField = focusableIn(modal)[0];
        if (firstField) firstField.focus();
    };

    const closeModal = () => {
        modal.hidden = true;
        backdrop.hidden = true;
        if (lastFocused && typeof lastFocused.focus === 'function') lastFocused.focus();
    };

    if (modal) {
        openButtons.forEach((btn) => {
            btn.addEventListener('click', () =>
                openModal(btn.dataset.courseId, btn.dataset.courseName),
            );
        });

        closeBtn.addEventListener('click', closeModal);
        backdrop.addEventListener('click', closeModal);

        modal.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
                return;
            }

            if (e.key !== 'Tab') return;
            const focusables = focusableIn(modal);
            if (focusables.length === 0) return;

            const first = focusables[0];
            const last  = focusables[focusables.length - 1];

            if (e.shiftKey && document.activeElement === first) {
                e.preventDefault();
                last.focus();
            } else if (!e.shiftKey && document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        });

        if (modal.hasAttribute('data-open-on-error')) {
            const errored = openButtons.find(
                (btn) => btn.dataset.courseId === courseIdField.value,
            );
            openModal(courseIdField.value, errored?.dataset.courseName ?? '');
        }
    }

    applyDeadlineCheck();
    applyFilter('*');
});
