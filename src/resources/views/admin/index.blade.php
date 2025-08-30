@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('header_actions')
    <nav class="hd-actions">
        <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn--sm">logout</button>
        </form>
    </nav>
@endsection


@section('content')
    @if(session('status'))
    <div class="card" style="margin-bottom:12px;color:#2563eb">{{ session('status') }}</div>
    @endif

    <div class="card">
    <form method="GET" class="filters">
        <input type="text" name="keyword" value="{{ $filters['keyword'] }}" placeholder="名前・メール・電話・住所・内容で検索">
        <select name="gender">
        <option value="">性別(すべて)</option>
        <option value="1" @selected($filters['gender']=='1')>男性</option>
        <option value="2" @selected($filters['gender']=='2')>女性</option>
        <option value="3" @selected($filters['gender']=='3')>その他</option>
        </select>
        <select name="category_id">
        <option value="">種類(すべて)</option>
        @foreach($categories as $id => $name)
            <option value="{{ $id }}" @selected($filters['category_id']==$id)>{{ $name }}</option>
        @endforeach
        </select>
        <input type="date" name="date_from" value="{{ $filters['date_from'] }}">
        <input type="date" name="date_to"   value="{{ $filters['date_to'] }}">
        <button class="btn" type="submit">検索</button>
        <a class="btn sub" href="{{ route('admin.contacts.index') }}">リセット</a>
        <a class="btn" href="{{ route('admin.contacts.export', request()->query()) }}">エクスポート</a>
    </form>

    {{-- 右上ページネーション --}}
        <div class="pager pager--top">
        <ul class="pagination">
            <li class="page-item {{ $contacts->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $contacts->previousPageUrl() ?? '#' }}" rel="prev" aria-label="Previous">‹</a>
            </li>

            @foreach ($contacts->getUrlRange(1, $contacts->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $contacts->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
            @endforeach

            <li class="page-item {{ $contacts->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $contacts->nextPageUrl() ?? '#' }}" rel="next" aria-label="Next">›</a>
            </li>
        </ul>
        </div>
    </div>

    <div class="card">
    <table class="tbl">
        <thead>
        <tr>
            <th>作成日</th>
            <th>お名前</th>
            <th>性別</th>
            <th>メール</th>
            <th>お問い合わせの種類</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @forelse($contacts as $c)
        <tr>
            <td>{{ $c->created_at->format('Y-m-d') }}</td>
            <td>{{ $c->last_name }} {{ $c->first_name }}</td>
            <td>{{ [1=>'男性',2=>'女性',3=>'その他'][$c->gender] ?? '' }}</td>
            <td>{{ $c->email }}</td>
            <td><span class="badge">{{ $c->category->content ?? '-' }}</span></td>
            <td>
            <button class="btn sub js-show" type="button" data-id="{{ $c->id }}">詳細</button>
            
            </td>
        </tr>
        @empty
        <tr><td colspan="6">該当データがありません。</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>

    {{-- モーダル --}}
    <div class="modal" id="modal">
    <div class="modal__card">
        <div class="modal__hd">
        <strong>お問い合わせ詳細</strong>
        <button class="modal__close" id="modalClose">×</button>
        </div>
        <div id="modalBody">読み込み中…</div>
    </div>
    </div>

    <script>
    const CSRF_TOKEN = '{{ csrf_token() }}';
    const modal = document.getElementById('modal');
    const modalBody = document.getElementById('modalBody');

    // 詳細ボタンにイベント付与
    document.querySelectorAll('.js-show').forEach(btn => {
        btn.addEventListener('click', async (e) => {
        modal.classList.add('is-open');

        const id = btn.dataset.id;
        modalBody.textContent = '読み込み中…';

        // 詳細のJSONを取得（あなたの詳細APIに合わせてURLを調整）
        const res = await fetch(`/admin/contacts/${id}`);
        const d = await res.json();

        // 削除アクションURL（ルート名を使う場合は data-url を使う方法に変えるか、下記のように直接パスでOK）
        const deleteUrl = `/admin/contacts/${id}`;

        modalBody.innerHTML = `
            <table class="tbl" style="width:100%">
            <tr><th>お名前</th><td>${d.name}</td></tr>
            <tr><th>性別</th><td>${d.gender}</td></tr>
            <tr><th>メールアドレス</th><td>${d.email}</td></tr>
            <tr><th>電話番号</th><td>${d.tel}</td></tr>
            <tr><th>住所</th><td>${d.address}</td></tr>
            <tr><th>建物名</th><td>${d.building ?? ''}</td></tr>
            <tr><th>お問い合わせの種類</th><td>${d.category}</td></tr>
            <tr><th>お問い合わせ内容</th><td style="white-space:pre-wrap">${d.detail}</td></tr>
            <tr><th>作成日</th><td>${d.created}</td></tr>
            </table>

            <form id="deleteForm" method="POST" action="${deleteUrl}" style="margin-top:16px; text-align:center">
            <input type="hidden" name="_token" value="${CSRF_TOKEN}">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn--danger" style="min-width:120px">削除</button>
            </form>
        `;

        // 削除時の確認ダイアログ
        const f = document.getElementById('deleteForm');
        f.addEventListener('submit', (ev) => {
            if (!confirm('このお問い合わせを削除します。よろしいですか？')) {
            ev.preventDefault();
            }
        });
        });
    });

    // × や背景クリックで閉じる処理は今のままでOK
    document.getElementById('modalClose').addEventListener('click', () => modal.classList.remove('is-open'));
    modal.addEventListener('click', (e) => { if (e.target === modal) modal.classList.remove('is-open') });
    </script>
    @endsection