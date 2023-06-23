<form method="POST" action="{{ route('processTransaction') }}">
    @csrf
    <div class="mb-3 mt-3">
        <input type="hidden" name="price" value="{{ $price }}">
        <input type="hidden" name="product_id" value="{{ $product }}">
        <input type="submit" class="btn btn-primary form-control" value="{{ 'Pay' }}">
    </div>
</form>
