let currentPage = 1;
let isLoading = false;

function loadMoreItems() {
    if (isLoading) return;

    const loadMoreButton = document.getElementById('loadMoreButton');
    isLoading = true;
    loadMoreButton.disabled = true;
    loadMoreButton.textContent = 'Загрузка...';

    const xhr = new XMLHttpRequest();
    xhr.open('GET', `/catalog?page=${currentPage + 1}`, true);
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            
            if (response.items.length > 0) {
                const itemsList = document.getElementById('itemsList');
                
                response.items.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'item';
                    div.innerHTML = `
                        <div class="bg-gray-800 rounded-xl p-6 hover:scale-[1.02] transition-all h-full item">
                            <div class="aspect-[4/3] mb-4 relative">
                                <img src="/storage/${item.image}"
                                     alt="${item.name}"
                                     class="w-full h-full object-cover rounded-lg">
                                <div class="absolute top-2 right-2 bg-red-500 text-xs px-2 py-1 rounded-full">
                                    -20%
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 h-full">
                                <h3 class="font-semibold text-lg">${item.name}</h3>
                                <div class="flex items-center space-x-1 text-yellow-400">
                                    ${generateStars(item.rating)}
                                </div>
                                <p class="text-gray-400 text-sm overflow-hidden line-clamp-2">
                                    ${item.description}
                                </p>
                                <div class="flex items-center justify-between mt-auto">
                                    <div>
                                        <span class="text-xl font-bold">${item.discount_price} ₽</span>
                                        <span class="ml-2 text-gray-400 line-through">${item.price} ₽</span>
                                    </div>
                                    <button class="p-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    itemsList.appendChild(div);
                });

                // Обновляем номер страницы
                currentPage = response.nextPage;
                
                // Скрываем кнопку, если больше нет страниц
                if (!currentPage) {
                    loadMoreButton.style.display = 'none';
                }
            }
        } else {
            console.error('Ошибка загрузки:', xhr.statusText);
        }

        // Возвращаем состояние кнопки
        loadMoreButton.disabled = false;
        loadMoreButton.textContent = 'Показать еще';
        isLoading = false;
    };

    xhr.onerror = function() {
        console.error('Ошибка сети');
        loadMoreButton.disabled = false;
        loadMoreButton.textContent = 'Показать еще';
        isLoading = false;
    };

    xhr.send();
}

// Функция генерации звезд рейтинга
function generateStars(rating) {
    const fullStars = Math.floor(rating);
    const halfStar = rating % 1 >= 0.5 ? 1 : 0;
    const emptyStars = 5 - fullStars - halfStar;

    let starsHtml = '';
    
    // Полные звезды
    for (let i = 0; i < fullStars; i++) {
        starsHtml += `<svg class="w-5 h-5 text-yellow-400 fill-current" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"/>
        </svg>`;
    }

    // Половинная звезда
    if (halfStar) {
        starsHtml += `<svg class="w-5 h-5 text-yellow-400 fill-current" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" clip-path="url(#half-star-clip)"/>
            <defs>
                <clipPath id="half-star-clip">
                    <rect width="10" height="20" x="0" y="0"/>
                </clipPath>
            </defs>
        </svg>`;
    }

    // Пустые звезды
    for (let i = 0; i < emptyStars; i++) {
        starsHtml += `<svg class="w-5 h-5 text-gray-300 fill-current" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"/>
        </svg>`;
    }

    return starsHtml;
}

// Добавляем обработчик события после загрузки DOM
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreButton = document.getElementById('loadMoreButton');
    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', loadMoreItems);
    }
});