document.addEventListener('DOMContentLoaded', function() {
    // Enhanced Intersection Observer
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

        // Parallax effect for hero section
        const heroSection = document.querySelector('.hero-section');
        const heroIllustration = document.querySelector('.hero-illustration');
    
        if (heroSection && heroIllustration) {
            heroSection.addEventListener('mousemove', function(e) {
                const centerX = window.innerWidth / 2;
                const centerY = window.innerHeight / 2;
    
                const mouseX = e.clientX;
                const mouseY = e.clientY;
    
                const angleX = (centerY - mouseY) / 40;
                const angleY = (mouseX - centerX) / 40;
    
                heroIllustration.style.transform = `
                    scale(1.05) 
                    rotateX(${angleX}deg) 
                    rotateY(${angleY}deg)
                `;
            });
    
            heroSection.addEventListener('mouseleave', function() {
                heroIllustration.style.transform = 'scale(1.05)';
            });
        }
    
        // Typing effect for subtitle
        const subtitleElement = document.querySelector('.hero-subtitle');
        if (subtitleElement) {
            const text = subtitleElement.textContent;
            subtitleElement.textContent = '';
            
            let index = 0;
            function typeText() {
                if (index < text.length) {
                    subtitleElement.textContent += text.charAt(index);
                    index++;
                    setTimeout(typeText, 30);
                }
            }
            
            // Use Intersection Observer to trigger typing only when visible
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        typeText();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
    
            observer.observe(subtitleElement);
        }

    // Add parallax effect to system cards
    const systemCards = document.querySelectorAll('.system-card');

    systemCards.forEach(card => {
        card.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = (y - centerY) / 20;
            const rotateY = -(x - centerX) / 20;

            this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale(1)';
        });
    });


    // Add hover effect parallax for feature cards
    const featureCards = document.querySelectorAll('.feature-card');

    featureCards.forEach(card => {
        card.addEventListener('mousemove', function(e) {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const deltaX = (x - centerX) / centerX;
            const deltaY = (y - centerY) / centerY;
            
            const inner = card.querySelector('.feature-card-inner');
            const icon = card.querySelector('.feature-icon-wrapper');
            
            inner.style.transform = `
                perspective(1000px)
                rotateY(${deltaX * 5}deg)
                rotateX(${-deltaY * 5}deg)
                translateY(-10px)
            `;
            
            icon.style.transform = `
                translate(${deltaX * 10}px, ${deltaY * 10}px)
            `;
        });
        
        card.addEventListener('mouseleave', function() {
            const inner = card.querySelector('.feature-card-inner');
            const icon = card.querySelector('.feature-icon-wrapper');
            
            inner.style.transform = '';
            icon.style.transform = '';
        });
    });

    // Add this new function for number animation
    function animateNumbers() {
        const numbers = document.querySelectorAll('.stat-number');
        
        numbers.forEach(number => {
            const targetValue = parseInt(number.dataset.value);
            const duration = 2000; // 2 seconds
            const steps = 60;
            const stepValue = targetValue / steps;
            let currentValue = 0;
            let currentStep = 0;

            const animation = setInterval(() => {
                currentStep++;
                currentValue = Math.min(Math.round(stepValue * currentStep), targetValue);
                number.textContent = currentValue;

                if (currentStep >= steps) {
                    clearInterval(animation);
                }
            }, duration / steps);
        });
    }

    // Observe statistics section for animation
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateNumbers();
                statsObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.2
    });

    const statsSection = document.querySelector('.statistics-section');
    if (statsSection) {
        statsObserver.observe(statsSection);
    }

    const adjustGridLayout = () => {
        const grid = document.querySelector('.about-icon-grid');
        if (!grid) return;

        const cards = grid.querySelectorAll('.about-icon-card');
        const totalCards = cards.length;
        const columns = window.innerWidth > 991 ? 3 : (window.innerWidth > 768 ? 2 : 1);

        cards.forEach(card => (card.style.gridColumn = ''));

        if (columns === 3 && totalCards % 3 === 2) {
            cards[totalCards - 2].style.gridColumn = '2 / 3';
            cards[totalCards - 1].style.gridColumn = '3 / 4';
        } else if (columns === 2 && totalCards % 2 === 1) {
            cards[totalCards - 1].style.gridColumn = '1 / -1';
        }
    };

    adjustGridLayout();
    window.addEventListener('resize', adjustGridLayout);

    const adjustLastRow = () => {
        const grid = document.querySelector('.about-icon-grid');
        if (!grid) return;

        const cards = grid.querySelectorAll('.about-icon-card');
        const totalCards = cards.length;
        const columns = window.innerWidth > 991 ? 3 : (window.innerWidth > 768 ? 2 : 1);

        // Reset all cards first
        cards.forEach(card => card.style.gridColumn = '');

        if (totalCards % columns !== 0) {
            const lastCard = cards[totalCards - 1];
            if (columns === 3) {
                lastCard.style.gridColumn = '2 / 3'; // Center for 3 columns
            } else if (columns === 2) {
                lastCard.style.gridColumn = '1 / -1'; // Center for 2 columns
            } else {
                lastCard.style.gridColumn = 'auto'; // Single column, no change needed
            }
        }
    };

    // Run on load and resize
    adjustLastRow();
    window.addEventListener('resize', adjustLastRow);

    const revealAboutIcons = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const iconCards = entry.target.querySelectorAll('.about-icon-card');
                
                iconCards.forEach((card, index) => {
                    setTimeout(() => {
                        card.classList.add('show');
                    }, index * 200); // Staggered animation
                });

                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe the about section
    const aboutSection = document.querySelector('.about-section');
    if (aboutSection) {
        revealAboutIcons.observe(aboutSection);
    }

    // Interactive Hover Effect for Icon Cards
    const iconCards = document.querySelectorAll('.about-icon-card');
    iconCards.forEach(card => {
        card.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            // Create a subtle 3D tilt effect
            this.style.transform = `perspective(1000px) 
                                    rotateX(${(y - rect.height / 2) / 20}deg) 
                                    rotateY(${-(x - rect.width / 2) / 20}deg) 
                                    scale(1.05)`;
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)';
        });
    });

    const animateOnScroll = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                
                // Add appropriate animation class based on data attribute
                if (element.dataset.animation) {
                    element.classList.add('fade-in-' + element.dataset.animation);
                } else {
                    element.classList.add('fade-in');
                }
                
                animateOnScroll.unobserve(element);
            }
        });
    }, observerOptions);

    // Observe elements with animation classes
    document.querySelectorAll('.stat-card, .system-card, .section-title, .feature-icon').forEach(element => {
        animateOnScroll.observe(element);
    });

    // Smooth Hover Effects
    const cards = document.querySelectorAll('.stat-card, .system-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            this.style.setProperty('--x', `${x}px`);
            this.style.setProperty('--y', `${y}px`);
        });
    });

    // Smooth Scroll for Navigation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
    });
});