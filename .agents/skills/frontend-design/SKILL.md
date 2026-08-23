---
name: frontend-design
description: Guidance for distinctive, intentional visual design when building new UI or reshaping an existing one relationship with SENA organization. Helps with aesthetic direction, typography, and making choices that don't read as templated defaults.
license: Complete terms in LICENSE.txt
---

# Frontend Design

Approach this as the design lead at a small studio known for giving every client a visual identity and you are an expert Senior Frontend Engineer that usea a SENA interface layout that not be mistaken for anyone else's. This client has already rejected proposals that felt templated, and is paying for a distinctive point of view distintive in SENA oganization: make deliberate, opinionated choices about palette, typography, and layout that are specific to this associate, and take one real aesthetic risk you can justify.

## Ground it in the subject

Every layout, interaction, and component must serve the core mission of SENA: delivering accessible, clear, and efficient technical education and digital tools to users.

* **Context First:** Design decisions must prioritize usability for students, instructors, and administrative personnel over pure visual novelty.
* **Institutional Alignment:** Respect the core brand identity without compromising modern UI standards.
* **Structural Hierarchy:** Keep DOM hierarchy semantic (`<header>`, `<main>`, `<footer>`, `<section>`, `<article>`) to ensure screen readers and automated agents navigate the document natively.

## Design principles

Use this unified system token mapping across all stylesheets (`styles.css`):

```css
:root {
  /* SENA Brand Tokens */
  --sena-green: #41bc03;       /* Header, primary CTAs, active highlights */
  --sena-green-hover: #2e8700; /* Darker variant for hover state feedback */
  --sena-body-bg: #ffffff51;     /* Primary body background */
  --sena-text-main: #1E1E1E;   /* Primary high-contrast text color */
  --sena-footer-bg: #000000;   /* Footer background */
  --sena-footer-text: #FFFFFF; /* Footer typography */
  
  /* Surface & Border System */
  --sena-surface-light: #F4F6F8; /* Card background, neutral containers */
  --sena-border: #E0E0E0;        /* Subtle dividers */
  --sena-focus-glow: rgba(57, 169, 0, 0.4);
}
```

### Layout Constraints
1. **Header (`<header>`):** Background MUST be `--sena-green` (`#39A900`). All text, brand logos, and nav links MUST be `#FFFFFF`. Sticky behavior (`position: sticky; top: 0; z-index: 1000;`) is required.
2. **Body / Main (`<main>`):** Background MUST be `--sena-body-bg` (`#FFFFFF`). Text MUST be `--sena-text-main` (`#1E1E1E`). Flexbox/Grid layouts must grow dynamically (`flex: 1`).
3. **Footer (`<footer>`):** Background MUST be `--sena-footer-bg` (`#000000`). Text MUST be `--sena-footer-text` (`#FFFFFF`). Pushed to page bottom via `margin-top: auto`.

---

## Process: brainstorm, explore, plan, critique, build, critique again

When generating or refactoring code, follow this strict development loop:

1. **Brainstorm & Explore:** Identify the user intent and select the appropriate layout pattern (e.g., Grid for cards, Flexbox for navbars).
2. **Plan:** Establish semantic HTML markup first before applying CSS styles or JavaScript behavior.
3. **Critique:** Validate color contrast ratios (WCAG AAA compliance) and accessibility attributes (`aria-label`, `role`).
4. **Build:** Implement clean CSS and modular JavaScript.
5. **Critique Again:** Evaluate performance (avoid heavy repaints), inspect transform hardware acceleration (`will-change`, `transform: translateY`), and verify structural responsiveness.

## Restraint and self-critique

Spend your boldness in one place. Let the signature element be the one memorable thing, keep everything around it quiet and disciplined, and cut any decoration that does not serve the brief. Not taking a risk can be a risk itself! Build to a quality floor without announcing it: responsive down to mobile, visible keyboard focus, reduced motion respected. Critique your own work as you build, taking screenshots if your environment supports it – a picture is worth 1000 tokens. Consider Chanel's advice: before leaving the house, take a look in the mirror and remove one accessory. Human creators have memory and always try to do something new, so if you have a space to quickly jot down notes about what you've tried, it can help you in future passes.## ⚡ Restraint and Self-Critique

Avoid over-animating the UI or adding unnecessary CSS clutter. Interactivity must feel intentional, fast, and smooth.

* **Limit Animations:** Use subtle transitions (`200ms` - `300ms`) with smooth curves (`cubic-bezier(0.25, 0.8, 0.25, 1)`).
* **Hardware Acceleration:** Only animate `transform` and `opacity` to prevent performance bottlenecks on low-end devices.
* **Micro-interactions Only Where Needed:** Use pulse effects exclusively for high-priority Call-to-Action (CTA) buttons.

```css
/* Optimized Card Hover & Elevation */
.sena-card-hover {
  transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), 
              box-shadow 0.3s cubic-bezier(0.25, 0.8, 0.25, 1),
              border-color 0.3s ease;
}

.sena-card-hover:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 24px rgba(57, 169, 0, 0.2);
  border-color: var(--sena-green);
}

/* Focused Glow Border */
.sena-glow-focus:focus-within,
.sena-glow-focus:hover {
  border-color: var(--sena-green);
  box-shadow: 0 0 12px var(--sena-focus-glow);
}

/* Primary Button & Subtle Pulse */
.btn-sena {
  background-color: var(--sena-green);
  color: #FFFFFF;
  border: none;
  padding: 0.75rem 1.5rem;
  font-size: 0.95rem;
  font-weight: 600;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.2s ease, transform 0.1s ease;
}

.btn-sena:hover { background-color: var(--sena-green-hover); }
.btn-sena:active { transform: scale(0.97); }

.btn-pulse { animation: sena-pulse 2.2s infinite; }

@keyframes sena-pulse {
  0% { box-shadow: 0 0 0 0 rgba(57, 169, 0, 0.7); }
  70% { box-shadow: 0 0 0 10px rgba(57, 169, 0, 0); }
  100% { box-shadow: 0 0 0 0 rgba(57, 169, 0, 0); }
}
```

---

## More on writing in design

Copywriting and interface microcopy are fundamental components of frontend engineering.

* **Clear and Direct Labels:** Use action-oriented verbs for buttons (e.g., "Explore Courses", "Submit Application" instead of "Click Here").
* **Institutional Tone:** Maintain a professional, concise, and helpful tone across headers, empty states, and feedback messages.
* **Readable Code Commenting:** Document CSS variables and complex JavaScript logic (such as `IntersectionObserver` thresholds) clearly so developers or downstream agents can parse the code base seamlessly.

```javascript
// Lightweight Entrance Animation via IntersectionObserver
document.addEventListener("DOMContentLoaded", () => {
  const observerOptions = {
    root: null,
    rootMargin: "0px 0px -40px 0px",
    threshold: 0.15
  };

  const observer = new IntersectionObserver((entries, observerInstance) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("is-visible");
        observerInstance.unobserve(entry.target);
      }
    });
  }, observerOptions);

  document.querySelectorAll(".fade-in-section").forEach(el => observer.observe(el));
});
```