// Efeitos visuais modernos para o site Control
document.addEventListener('DOMContentLoaded', function() {
    
    // Animação de contador para números nas estatísticas
    function animateCounters() {
        const counters = document.querySelectorAll('.stat-number');
        
        counters.forEach(counter => {
            const target = counter.innerText;
            let count = 0;
            let increment = 1;
            
            // Determinar o incremento baseado no valor final
            if (target.includes('k')) {
                increment = 50;
            } else if (target.includes('+')) {
                increment = 25;
            } else if (target.includes('%')) {
                increment = 5;
            }
            
            const timer = setInterval(() => {
                if (count < parseInt(target)) {
                    count += increment;
                    counter.innerText = count + (target.includes('k') ? 'k+' : 
                                                target.includes('+') ? '+' : 
                                                target.includes('%') ? '%' : '');
                } else {
                    counter.innerText = target;
                    clearInterval(timer);
                }
            }, 50);
        });
    }
    
    // Animação suave para cards ao entrar na viewport
    function animateOnScroll() {
        const cards = document.querySelectorAll('.feature-card');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });
        
        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    }
    
    // Efeito de paralax suave no hero
    function parallaxEffect() {
        const hero = document.querySelector('.hero-section');
        if (hero) {
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const rate = scrolled * -0.5;
                hero.style.transform = `translateY(${rate}px)`;
            });
        }
    }
    
    // Efeito de hover nos botões
    function enhanceButtons() {
        const buttons = document.querySelectorAll('.btn-modern');
        
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px) scale(1.02)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    }
    
    // Smooth scroll para links internos
    function smoothScroll() {
        const links = document.querySelectorAll('a[href^="#"]');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    }
    
    // Loader de página
    function pageLoader() {
        // Criar overlay de loading
        const loader = document.createElement('div');
        loader.innerHTML = `
            <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                        display: flex; justify-content: center; align-items: center; 
                        z-index: 9999; transition: opacity 0.5s ease;">
                <div style="text-align: center; color: white;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🚀</div>
                    <div style="font-size: 1.5rem; font-weight: 600;">Control</div>
                    <div style="margin-top: 1rem;">
                        <div style="width: 50px; height: 4px; background: rgba(255,255,255,0.3); 
                                   border-radius: 2px; overflow: hidden; margin: 0 auto;">
                            <div style="width: 100%; height: 100%; background: white; 
                                       border-radius: 2px; animation: loading 1.5s infinite;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                @keyframes loading {
                    0% { transform: translateX(-100%); }
                    100% { transform: translateX(100%); }
                }
            </style>
        `;
        
        document.body.appendChild(loader);
        
        // Remover o loader após o carregamento
        window.addEventListener('load', () => {
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.remove();
                }, 500);
            }, 500);
        });
    }
    
    // Inicializar todas as funcionalidades
    animateOnScroll();
    enhanceButtons();
    smoothScroll();
    
    // Executar animações específicas quando visíveis
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    statsObserver.unobserve(entry.target);
                }
            });
        });
        statsObserver.observe(statsSection);
    }
    
    // Inicializar paralax apenas se não for dispositivo móvel
    if (window.innerWidth > 768) {
        parallaxEffect();
    }
    
    // Adicionar classe para animações CSS
    document.body.classList.add('animations-ready');
});

// Adicionar estilos CSS para as animações via JavaScript
const animationStyles = `
    <style>
        .animations-ready .hero-content > * {
            animation-fill-mode: both;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }
        
        .btn-modern {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .navbar {
            transition: all 0.3s ease;
        }
        
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            width: 0;
            height: 2px;
            background: currentColor;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
`;

document.head.insertAdjacentHTML('beforeend', animationStyles);