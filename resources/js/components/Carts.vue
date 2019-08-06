<template>
        <div class="cart">
        <div class="row mb-2" v-for="cart in carts.cart_items" :key="cart.id">
          <div class="col-3">
            <img src="https://placeimg.com/200/200/arch" alt class="img-fluid" />
          </div>
          <div class="col-6">
            <h5>{{ cart.product.title }}</h5>
            <p>Shop name here</p>
            <form action="/cart/update" method="POST" class="form-inline">
              <input type="hidden" name="_token" :value="csrf">
              <input type="hidden" name="product_id" :value="cart.product_id" />
              <label for class="mr-1">Qty:</label>
              <input
                type="number"
                name="quantity"
                class="col-3 form-control mr-2"
                :value="cart.quantity"
              />
              <button class="btn btn-sm btn-outline-info">Update</button>
            </form>
          </div>
          <div class="col-3">
            {{ cart.product.price }} Tk
            <form action="/cart" method="POST">
              <input type="hidden" name="_token" :value="csrf">
              <input type="hidden" name="_method" value="DELETE" />
              <input type="hidden" name="product_id" :value="cart.product.id" />
              <button class="btn btn-lg">
                <i class="fa fa-trash" aria-hidden="true"></i>
              </button>
            </form>
          </div>
        </div>
    <!-- row -->

        </div>
</template>

<script>
export default {
    data() {
        return {
            carts: [],
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        };
    },
    mounted() {
        axios.get('/api/cart')
            .then(res => {
                this.carts = res.data;
            }); 
    }
};
</script>
