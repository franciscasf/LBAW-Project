document.addEventListener('DOMContentLoaded', function () {
    function attachFollowEvent(button) {
        button.addEventListener('click', function () {
            const questionId = this.dataset.questionId;
            const action = this.classList.contains('btn-primary') ? 'follow' : 'unfollow';
            const url = action === 'follow'
                ? `/questions/${questionId}/follow`
                : `/questions/${questionId}/unfollow`;

            fetch(url, {
                method: action === 'follow' ? 'POST' : 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const container = document.querySelector(`#follow-question-container-${questionId}`);
                    container.innerHTML = data.action === 'follow'
                        ? `<button class="btn btn-danger follow-btn" data-question-id="${questionId}">Unfollow</button>`
                        : `<button class="btn btn-primary follow-btn" data-question-id="${questionId}">Follow</button>`;

                    // Re-anexar o evento ao novo botão
                    attachFollowEvent(container.querySelector('.follow-btn'));
                } else {
                    console.error(data.message || 'Action failed');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    document.querySelectorAll('.follow-btn').forEach(button => {
        attachFollowEvent(button);
    });
});
