/**
 * Brewly Main JS
 * Логика интерфейса: Меню, Фильтры, Избранное
 */

document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Мобильное меню (Бургер)
    const burgerBtn = document.querySelector('.burger');
    const navLinks = document.querySelector('.nav-links');

    if (burgerBtn && navLinks) {
        burgerBtn.addEventListener('click', () => {
            navLinks.classList.toggle('active-mobile');
            
            // Меняем иконку бургера на крестик или наоборот (опционально)
            const isOpen = navLinks.classList.contains('active-mobile');
            burgerBtn.setAttribute('aria-expanded', isOpen);
        });

        // Закрываем меню при клике вне его области
        document.addEventListener('click', (e) => {
            if (!navLinks.contains(e.target) && !burgerBtn.contains(e.target)) {
                navLinks.classList.remove('active-mobile');
                burgerBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // 2. Интерактивные фильтры (Чипы категорий)
    const chips = document.querySelectorAll('.chip');
    
    chips.forEach(chip => {
        chip.addEventListener('click', function() {
            // Убираем активный класс у всех чипов в этой группе
            const parentGroup = this.closest('.chips');
            if (parentGroup) {
                parentGroup.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
            }
            
            // Добавляем активный класс текущему чипу
            this.classList.add('active');
            
            // Здесь можно добавить логику фильтрации рецептов, 
            // когда вы подключите базу данных.
            console.log('Выбрана категория:', this.textContent);
        });
    });

    // 3. Кнопки "В избранное" (Сердечки)
    const favButtons = document.querySelectorAll('.card-fav, .fav-big, .fav-btn');
    
    favButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault(); // Предотвращаем переход по ссылке, если кнопка внутри <a>
            
            // Переключаем состояние "нажато"
            const isPressed = this.getAttribute('aria-pressed') === 'true';
            this.setAttribute('aria-pressed', !isPressed);
            
            // Визуальный эффект: меняем цвет сердца
            if (!isPressed) {
                this.style.color = '#C65D3C'; // Акцентный красный/оранжевый
                this.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="#C65D3C" stroke="#C65D3C" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>';
                
                // Анимация пульсации
                this.animate([
                    { transform: 'scale(1)' },
                    { transform: 'scale(1.3)' },
                    { transform: 'scale(1)' }
                ], { duration: 300, easing: 'ease-out' });
            } else {
                this.style.color = ''; // Сброс цвета
                this.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>';
            }
        });
    });

    // 4. Плавная прокрутка для якорных ссылок (если будут)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});