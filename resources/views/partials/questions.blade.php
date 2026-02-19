@foreach ($latestQuestions as $question)
    <li>
        <div class="tags">
            @foreach ($question->tags as $tag)
                <span>{{ $tag->acronym }} ({{ $tag->full_name }})</span>
            @endforeach
        </div>
        <a href="{{ url('/questions/' . $question->question_id) }}">
            <h3>{{ $question->title }}</h3>
        </a>
        <p>{{ Str::limit($question->content, 100) }}</p>
        <small>Posted by
            {{ $question->author->name }}
            on
            {{ $question->created_date ? \Carbon\Carbon::parse($question->created_date)->format('M d, Y') : 'Date not available' }}
        </small>
    </li>
@endforeach