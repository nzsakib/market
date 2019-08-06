<template>
  <div class="table">
    <div class="d-flex justify-content-center" v-if="loading">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <table class="table table-bordered" v-else>
      <tr class="text-center">
        <th>Order Number</th>
        <th>Total Price</th>
        <th>Status</th>
        <th>Order date</th>
      </tr>

      <tr v-for="order in orders" :key="order.id">
        <td>{{ order.id }}</td>
        <td>{{ order.total }}</td>
        <td>
          <button class="btn btn-outline-primary">{{ order.status }}</button>
        </td>
        <td>{{ order.created_at }}</td>
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
      orders: [],
      meta: null,
      links: null,
      path: "/api/customer/orders",
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
        this.orders = res.data.data;
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

