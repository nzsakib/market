<template>
  <div>
    <table class="table">
      <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Price</th>
        <th>Total Quantity</th>
        <th>Status</th>
      </tr>

      <tr v-for="product in products" :key="product.id">
        <td>{{ product.id }}</td>
        <td>{{ product.title }}</td>
        <td>{{ product.price }}</td>
        <td>{{ product.quantity }}</td>
        <td>{{ product.status }}</td>
      </tr>
    </table>

    <button
      class="btn btn-primary btn-sn mr-3"
      @click="prev"
      :disabled="links.prev == null ? true : false"
    >Previous</button>
    <button
      class="btn btn-primary btn-sn"
      @click="next"
      :disabled="links.next == null ? true : false"
    >Next</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      products: [],
      links: {},
      path: '/api/vendor/product',
      meta: null,
      loading: false,
    };
  },

  methods: {
    next() {
      this.path = this.links.next;
      this.callApi();
    },
    prev() {
      this.path = this.links.prev;
      this.callApi();
    },

    callApi() {
      this.loading = true;
      axios.get(this.path).then(res => {
        // console.log(res.data);
        this.products = res.data.data;
        this.meta = res.data.meta;
        this.links = res.data.links;
        this.loading = false;
      });
    }
  },

  mounted() {
      this.callApi();
  }
};
</script>
