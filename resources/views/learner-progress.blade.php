<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learner Progress Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hidden { display: none; }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <h1 class="text-3xl font-bold mb-8 text-center">Learner Progress Dashboard</h1>

        <div class="bg-white p-6 rounded-lg shadow-md mb-8 flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-64">
                <label for="course-filter" class="block text-sm font-medium text-gray-700 mb-2">
                    Filter by Course
                </label>
                <select id="course-filter" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->name }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="sort-progress" class="block text-sm font-medium text-gray-700 mb-2">
                    Sort by Progress
                </label>
                <select id="sort-progress" class="border-gray-300 rounded-md shadow-sm">
                    <option value="none">None</option>
                    <option value="asc">Lowest to Highest</option>
                    <option value="desc">Highest to Lowest</option>
                </select>
            </div>
        </div>

        
        <div id="learners-container">
    @foreach($learners as $learner)
        <div class="learner-card bg-white p-6 rounded-lg shadow-md mb-6"
             data-courses="{{ $learner->enrolments->pluck('course.name')->filter()->implode(',') }}">
            <h2 class="text-2xl font-semibold mb-4">
                {{ $learner->firstname }} {{ $learner->lastname }}
            </h2>

            @if($learner->enrolments->isEmpty())
                <p class="text-gray-500 italic">No courses enrolled.</p>
            @else
                <ul class="space-y-3">
                    @foreach($learner->enrolments as $enrolment)
                        <li class="flex justify-between items-center py-2 border-b border-gray-200 last:border-0">
                            <span class="font-medium">{{ $enrolment->course->name }}</span>
                            <span class="text-lg font-bold text-blue-600">{{ number_format($enrolment->progress, 2) }}%</span>
                        </li>
                    @endforeach
                </ul>

                
                <div class="hidden avg-progress">
                    {{ $learner->enrolments->avg('progress') ?? 0 }}
                </div>
            @endif
        </div>
    @endforeach

    @if($learners->isEmpty())
        <p class="text-gray-500 text-center">No learners found.</p>
    @endif
</div>
    <script>
    const courseFilter = document.getElementById('course-filter');
    const sortSelect = document.getElementById('sort-progress');
    const container = document.getElementById('learners-container');
    const cards = container.querySelectorAll('.learner-card');

    function applyFiltersAndSort() {
        const selectedCourse = courseFilter.value.trim(); 
        let visibleCards = Array.from(cards);

        
        if (selectedCourse) {
            visibleCards = visibleCards.filter(card => {
                const courses = card.dataset.courses.toLowerCase();
                return courses.includes(selectedCourse.toLowerCase());
            });
        }

        
        if (sortSelect.value !== 'none') {
            visibleCards.sort((a, b) => {
                let progressA, progressB;

                if (selectedCourse) {
                    
                    const liA = Array.from(a.querySelectorAll('li')).find(li => 
                        li.querySelector('span.font-medium').textContent.trim() === selectedCourse
                    );
                    const liB = Array.from(b.querySelectorAll('li')).find(li => 
                        li.querySelector('span.font-medium').textContent.trim() === selectedCourse
                    );
                    progressA = liA ? parseFloat(liA.querySelector('span.text-blue-600').textContent) : 0;
                    progressB = liB ? parseFloat(liB.querySelector('span.text-blue-600').textContent) : 0;
                } else {
                    
                    progressA = parseFloat(a.querySelector('.avg-progress')?.textContent || 0);
                    progressB = parseFloat(b.querySelector('.avg-progress')?.textContent || 0);
                }

                return sortSelect.value === 'desc' ? progressB - progressA : progressA - progressB;
            });
        }

        
        visibleCards.forEach(card => container.appendChild(card));
        cards.forEach(card => {
            card.style.display = visibleCards.includes(card) ? 'block' : 'none';
        });
    }

    courseFilter.addEventListener('change', applyFiltersAndSort);
    sortSelect.addEventListener('change', applyFiltersAndSort);

    
    applyFiltersAndSort();
</script>
</body>
</html>