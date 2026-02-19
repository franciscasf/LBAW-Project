document.addEventListener('DOMContentLoaded', function () {
    function toggleColumns(filter) {
        const questionsColumn = document.querySelector('.result-columns .column:nth-child(1)');
        const usersColumn = document.querySelector('.result-columns .column:nth-child(2)');
        const element = document.querySelector('.result-columns');

        if (filter === 'verified_answers') {
            questionsColumn.classList.remove('hidden');
            usersColumn.classList.add('hidden');
            questionsColumn.querySelector('h3').textContent = 'Questions with Verified Answers';
            element.style.display = 'block';
            console.log('Filter applied: verified_answers');
        } else if (filter === 'questions') {
            questionsColumn.classList.remove('hidden');
            usersColumn.classList.add('hidden');
            questionsColumn.querySelector('h3').textContent = 'Questions';
            element.style.display = 'block';
            console.log('Filter applied: questions');
        } else if (filter === 'users') {
            questionsColumn.classList.add('hidden');
            usersColumn.classList.remove('hidden');
            element.style.display = 'block';
            console.log('Filter applied: users');
        } else { // 'all'
            questionsColumn.classList.remove('hidden');
            usersColumn.classList.remove('hidden');
            element.style.display = 'flex';
            console.log('Filter applied: all');
        }

        
        updateActiveButton(filter);
    }

   
    function updateActiveButton(filter) {
        document.querySelectorAll('.filter-buttons .btn').forEach(button => {
            button.classList.remove('active');
        });

        const activeButton = document.querySelector(`.filter-buttons .btn[data-filter="${filter}"]`);
        if (activeButton) {
            activeButton.classList.add('active');
        }
    }

    document.querySelectorAll('.filter-buttons .btn').forEach((button) => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const urlParams = new URLSearchParams(this.getAttribute('href').split('?')[1]);
            const filter = urlParams.get('filter');
            toggleColumns(filter);
        });
    });

    const urlParams = new URLSearchParams(window.location.search);
    const filter = urlParams.get('filter') || 'all';
    toggleColumns(filter);
});