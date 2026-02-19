document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-answer-btn');


    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); 

            const answerId = button.getAttribute('data-answer-id');  
            const deleteUrl = '/answers/' + answerId; 

            
            fetch(deleteUrl, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                },
                body: JSON.stringify({
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                })
            })
            .then(response => response.json())  
            .then(data => {
                
                if (data.success) {
                    const answerElement = button.closest('.answer-item');
                    if (answerElement) {
                        
                        answerElement.style.transition = 'opacity 0.5s ease-out'; 
                        answerElement.style.opacity = '0'; 

                        
                        setTimeout(() => {
                            answerElement.remove(); 
                        }, 500); 
                    } else {
                        console.error('Answer container not found');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while trying to delete the answer.');
            });
        });
    });
});
