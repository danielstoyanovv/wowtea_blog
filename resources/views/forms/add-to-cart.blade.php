<form action="{{ route('addProduct') }}" class="add-product-form">
    @csrf
    <input type="text" name="qty" class="qty" value="1">
    <input type="hidden" name="price" class="price" value="{{ $price }}">
    <input type="hidden" name="product_id" class="product_id" value="{{ $product }}">
    <input type="button" class="btn btn-primary form-control add-product-button" value="{{ 'Add to cart' }}">
</form>
