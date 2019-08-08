<template>
    <div>
        <div class="row images">
            <div class="col-3" v-for="image in product.images" :key="image.id">
                <img :src="image.image_path" alt="" class="img-fluid">
            </div>
        </div>
        <form action="" method="POST">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" v-model="product.title" class="form-control">
            </div>
            <div class="form-group">
                <label for="title">Price</label>
                <input type="text" name="price" v-model="product.price" class="form-control">
            </div>
            <div class="form-group">
                <label for="title">Quantity</label>
                <input type="text" name="title" v-model="product.quantity" class="form-control">
            </div>
            <div class="form-group">
                <label for="title">Description</label>
                <textarea name="description" id="description" cols="30" rows="10" v-model="product.description" class="form-control"></textarea>
            </div>

            <button class="btn btn-primary" @click.prevent="createProduct">Save</button>
        </form>
    </div>
</template>

<script>
export default {
    props: ['productid'],
    data() {
        return {
            product: {
                title: '',
                description: '',
                price: null,
                quantity: 1,
            }
        };
    },

    methods: {
        createProduct() {
            axios.post('/api/vendor/product', this.product)
                .then(res => {
                    if (res.data.success) {
                        console.log('Created product.');
                        this.product = {};
                        location.href='/vendor/products';
                    }
                });
        },

        getProductDetails() {
            axios.get('/api/vendor/product/' + this.productid)
                .then(res => {
                    this.product = res.data;
                })
        }
    },

    mounted() {
        if (this.productid) {
            this.getProductDetails();
        }
    }
}
</script>

