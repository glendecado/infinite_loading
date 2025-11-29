@props(['total' => 0, 'page' => 1])
<div>
    <div id="data-container">
        {{ $slot }}
    </div>

    <div  id="load-more">
        <x-infinite.load-more />
    </div>


</div>

@push('scrpts')
<script defer>
document.addEventListener('DOMContentLoaded', function () {
    const userList = document.getElementById('data-container');
    const target = document.getElementById('load-more');
    let page = parseInt("{{ $page }}");
    const total = parseInt("{{ $total }}");

    let visible = false;
    let isFetching = false;

    const fetchNext = async () => {
        if (!visible || isFetching) return; // stop if not visible or already fetching
        if (userList.children.length >= total) {
            target.style.display = 'none';
            return;
        }

        isFetching = true;
        page++;
        console.log('Fetching page', page);

        try {
            const res = await fetch(`?page=${page}`);
            const html = await res.text();

            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            const newData = tempDiv.querySelectorAll('#data-container > div');

            newData.forEach(u => userList.appendChild(u));

            if (userList.children.length >= total) {
                target.style.display = 'none';
            }
        } catch (err) {
            console.error('Fetch error:', err);
        } finally {
            isFetching = false;
            // Immediately fetch next if still visible and not done
            if (visible && userList.children.length < total) {
                fetchNext();
            }
        }
    };

    const observer = new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting) {
            // Became visible
            if (!visible) {
                visible = true;
                fetchNext(); // start ultra-fast continuous fetching
            }
        } else {
            // No longer visible
            if (visible) {
                visible = false;
                console.log("Load-more no longer visible, stopped fetching");
            }
        }
    }, { threshold: 0 }); // partially visible

    observer.observe(target);
});
</script>
@endpush
