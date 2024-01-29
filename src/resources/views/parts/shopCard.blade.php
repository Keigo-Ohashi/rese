<div class="card">
  <a href="/detail/{{ $shop->id }}">
    <div class="shop-image"><img src="{{ $images[$shop->id] }}" alt=""></div>
    <div class="card--description">
      <h2 class="shop-name">{{ $shop->name }}</h2>
      <div class="shop-tag">#{{ $shop->area_name }} #{{ $shop->genre_name }}</div>
      <div class="card--footer">
        <div class="detail">詳しく見る</div>
        @if (Auth::check())
          <form method="post" class="shop-like">
            @csrf
            @if (is_null($shop->like_id))
              <button formaction="/like" name="shopId" value="{{ $shop->id }}">
                <img src="/image/shop/not-like.png" alt="">
              </button>
            @else
              <button formaction="/unlike"name="shopId" value="{{ $shop->id }}">
                <img src="/image/shop/like.png" alt="">
              </button>
            @endif
            <input type="hidden" name="referrer" value="{{ $referrer }}">
          </form>
        @endif
      </div>
    </div>
  </a>
</div>
