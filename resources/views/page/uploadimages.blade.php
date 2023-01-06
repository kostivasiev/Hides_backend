
<ul class="list-group">
    @forelse ($imgfiles as $file)
        <li class="list-group-item">
            <a href="{{ route('downloadFile', basename($file)) }}">
                {{ basename($file) }}
            </a>
        </li>
    @empty
        <li class="list-group-item">You have no files</li>
    @endforelse
</ul>