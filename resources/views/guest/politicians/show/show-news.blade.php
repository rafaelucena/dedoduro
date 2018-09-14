<div id="news" class="crt-paper-layers">
    <div class="crt-paper clearfix">
        <div class="crt-paper-cont paper-padd clear-mrg">
            <section class="section padd-box">
                <h2 class="title-lg text-upper">notícias recentes</h2>
                <table id="recent-news" class="mdl-data-table table-responsive">
                    <thead>
                    <tr>
                        <th class="url" style="width: 20%">Fonte</th>
                        <th class="string" style="width: 64%">Titulo</th>
                        <th class="datetime" style="width: 16%">Publicação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($ninja->news as $news)
                        <tr>
                            <th data-title="Fonte"><a target="_blank" href="{{ $news['Url'] }}">{!! wordwrap($news['Source'], 15, "<br>\n") !!}</a></th>
                            <td data-title="Titulo">{{ $news['Title'] }}</td>
                            <td data-title="Publicação">{{ $news['Published']->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Não existem notícias disponíveis</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </section>
            <!-- .section -->

        </div>
        <!-- .crt-paper-cont -->
    </div>
    <!-- .crt-paper -->
</div>
