document.addEventListener('DOMContentLoaded', () => {
    const content = document.getElementById('content');

   
    document.getElementById('to-register')?.addEventListener('click', () => {
        loadPage('/register');
    });

  
    document.getElementById('to-login')?.addEventListener('click', () => {
        loadPage('/login');
    });

    function loadPage(url) {
        content.classList.add('hidden');
        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const newDoc = parser.parseFromString(html, 'text/html');
                const newContent = newDoc.getElementById('content');

                setTimeout(() => {
                    content.innerHTML = newContent.innerHTML;
                    content.classList.remove('hidden');
                }, 500);
            })
            .catch(error => console.error('Error loading page:', error));
    }
});
