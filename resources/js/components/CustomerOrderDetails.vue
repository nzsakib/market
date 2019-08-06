<template>
  <div class="order-details">
    <h3>Order ID: {{ order.id }}</h3>
    <hr />
    <div class="row">
        <div class="col-7">
            <h5>To: {{ order.name }}</h5>
            <h5>Phone: {{ order.phone }}</h5>
            <h5>Address: {{ order.address }}</h5>
            <h5>Order Placed: {{ order.created_at }}</h5>
        </div>
        <div class="col-5">
            <button class="btn btn-bg btn-outline-primary">{{ order.status }}</button>
        </div>
    </div>
    
    <br />
    <h5>Order items:</h5>
    <table class="table table-bordered">
      <tr>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price</th>
      </tr>
      
      <tr v-for="item in order.order_items" :key="item.id">
        <td>{{ item.product.title }}</td>
        <td>{{ item.quantity }}</td>
        <td>{{ item.price }}</td>
      </tr>

      <tr>
        <td></td>
        <th>Total</th>
        <td>{{ order.total }}</td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
    props: ['id'],
    data() {
        return {
            order: {},
            path: '/api/customer/orders/',
        };
    },

    methods: {
        refresh() {
            axios.get(this.path + this.id)
                .then(res => {
                    this.order = res.data;
                });
        }
    },

    mounted() {
        this.refresh();
    }
};
</script>

