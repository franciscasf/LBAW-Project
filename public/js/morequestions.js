document.addEventListener('DOMContentLoaded', function () {
    let offset = 10; 
    const limit = 10; 
    let isLoading = false;

    
    const loadMoreQuestions = async () => {
        if (isLoading) return;
        isLoading = true;
        document.getElementById('loader').style.display = 'block';

        try {
            const response = await fetch(`/load-more-questions?offset=${offset}`);
            if (response.ok) {
                const questions = await response.json();
                const questionList = document.getElementById('question-list');

                questions.forEach(question => {
                    const tags = question.tags.map(tag => `<span>${tag.acronym} (${tag.full_name})</span>`).join(' ');
                    
                   
                    const authorName = question.author && question.author.name ? question.author.name : 'Unknown';
                
                    const questionHTML = `
                    <li>
                        <div class="tags">${tags}</div>
                        <a href="/questions/${question.question_id}">
                            <h3>${question.title}</h3>
                        </a>
                        <p>${question.content.substring(0, 100)}...</p>
                        <small>Posted by ${authorName} on ${question.created_date ? new Date(question.created_date).toLocaleDateString() : 'Date not available'}</small>
                    </li>
                    `;
                    document.getElementById('question-list').insertAdjacentHTML('beforeend', questionHTML);
                });
                

             
                offset += limit;

                if (questions.length < limit) {
                    window.removeEventListener('scroll', handleScroll);
                }
            }
        } catch (error) {
            console.error('Error fetching questions:', error);
        } finally {
            isLoading = false;
            document.getElementById('loader').style.display = 'none';
        }
    };

    const handleScroll = () => {
        const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
        if (scrollTop + clientHeight >= scrollHeight - 50) {
            loadMoreQuestions();
        }
    };

    window.addEventListener('scroll', handleScroll);
});

