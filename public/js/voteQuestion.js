document.addEventListener('DOMContentLoaded', function () {
    const questionVoteButtons = document.querySelectorAll('.vote-btn');

    questionVoteButtons.forEach(button => {
        button.addEventListener('click', async function (e) {
            e.preventDefault();

            const questionId = button.dataset.questionId;
            const voteType = button.dataset.vote;

            console.log('Question ID:', questionId);
            console.log('Vote Type:', voteType);

            try {
                const response = await fetch(`/questions/${questionId}/vote`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ vote_type: voteType }),
                });

                const result = await response.json();
                if (result.status === 'success') {
                    document.getElementById(`upvotes-${questionId}`).textContent = result.upvotes;
                    document.getElementById(`downvotes-${questionId}`).textContent = result.downvotes;
                } else {
                    alert(result.message || 'An error occurred.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error communicating with the server.');
            }
        });
    });

    const answerVoteButtons = document.querySelectorAll('.answer-vote-btn');

    answerVoteButtons.forEach(button => {
        button.addEventListener('click', async function (e) {
            e.preventDefault();

            const answerId = button.dataset.answerId;
            const voteType = button.dataset.voteType;

            try {
                const response = await fetch(`/answers/${answerId}/vote`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ vote_type: voteType }),
                });

                const result = await response.json();
                if (result.status === 'success') {
                    document.getElementById(`upvotes-answer-${answerId}`).textContent = result.upvotes;
                    document.getElementById(`downvotes-answer-${answerId}`).textContent = result.downvotes;
                } else {
                    alert(result.message || 'An error occurred.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error communicating with the server.');
            }
        });
    });
});

