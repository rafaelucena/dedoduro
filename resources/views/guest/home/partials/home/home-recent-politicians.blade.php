<div class="ref-box brd-btm hreview">
    <div class="ref-avatar">
        <a href="{{ route('politician.show', ['slug' => $recentNewsPolitician['personUrn']]) }}" class="ref-link">
            <img alt=""
                 src="{{ asset('storage/' . $recentNewsPolitician['personImage']) }}"
                 class="avatar avatar-54 photo" height="54" width="54">
        <a>
    </div>

    <div class="ref-info">
        <a href="{{ route('politician.show', ['slug' => $recentNewsPolitician['personUrn']]) }}" class="ref-link">
            <div class="ref-author">
                <strong>{{ $recentNewsPolitician['personShort'] }}</strong>
                <span>{{ ($recentNewsPolitician['isRoleStill'] ? '' : 'Ex-') . $recentNewsPolitician['roleName'] }} ({{ $recentNewsPolitician['partyShort'] }})</span>
            </div>
        </a>

        <blockquote class="ref-cont clear-mrg">
            <p>{{ $recentNewsPolitician['newsTitle'] }}</p>
        </blockquote>
    </div>

    <div class="ref-footer">
        <a href="{{ $recentNewsPolitician['newsUrl'] }}" class="post-category">
            Fonte: <strong>{{ $recentNewsPolitician['sourceName'] }}</strong> |
            Publicado: <strong>{{ $recentNewsPolitician['newsPublishedAt']->format('Y-m-d') }}</strong>
        </a>
        {{--<a href="" class="post-comments">256 comments</a>--}}
    </div>
</div>