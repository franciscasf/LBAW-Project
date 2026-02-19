document.addEventListener('DOMContentLoaded', function () {
    const markReadButtons = document.querySelectorAll('.notification-mark-read');

    markReadButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.stopPropagation();
            const notificationId = this.getAttribute('data-id');
            const notificationItem = this.closest('.list-group-item');

            if (notificationItem) {
                notificationItem.classList.add('fade-out');
            }

            setTimeout(() => {
                fetch(`/notifications/read/${notificationId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (notificationItem) {
                                notificationItem.remove();
                            }

                            const badge = document.querySelector('.notifications-icon .badge');
                            if (badge) {
                                let count = parseInt(badge.textContent, 10) || 0;
                                if (count > 0) {
                                    count--;
                                    if (count === 0) {
                                        badge.remove();
                                    } else {
                                        badge.textContent = count;
                                    }
                                }
                            }
                        } else {
                            console.error(data.message || 'Failed to mark notification as read.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }, 500); 
        });
    });
});

