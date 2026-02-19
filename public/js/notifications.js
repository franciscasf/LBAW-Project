document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.notification-mark-read').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const notificationId = this.dataset.id; 
            const listItem = this.closest('li'); 

            fetch(`/notifications/read/${notificationId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    
                    listItem.style.opacity = '0.5';
                    listItem.classList.add('text-muted');

                  
                    const badge = document.querySelector('.badge.badge-danger');
                    if (badge) {
                        let count = parseInt(badge.textContent, 10);
                        count = Math.max(0, count - 1);
                        badge.textContent = count;

                        if (count === 0) {
                            badge.style.display = 'none';
                        }
                    }
                }
            })
            .catch(error => console.error('Erro ao marcar notificação como lida:', error));
        });
    });

 
    const markAllReadButton = document.querySelector('#mark-all-read');
    if (markAllReadButton) {
        markAllReadButton.addEventListener('click', function (e) {
            e.preventDefault();

            fetch('/notifications/read-all', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    
                    document.querySelectorAll('.list-group-item').forEach(item => {
                        item.style.opacity = '0.5';
                        item.classList.add('text-muted');
                    });

                    
                    const badge = document.querySelector('.badge.badge-danger');
                    if (badge) {
                        badge.textContent = '0';
                        badge.style.display = 'none';
                    }
                }
            })
            .catch(error => console.error('Erro ao marcar todas as notificações como lidas:', error));
        });
    }
});
