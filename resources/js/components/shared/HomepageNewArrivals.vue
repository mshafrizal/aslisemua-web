<template>
  <section class="mb-10">
    <h1 v-if="!products.loading" class="text-3xl text-center mt-20 mb-10">NEW ARRIVALS</h1>
    <swiper  ref="mySwiper" :options="swiperOptions">
      <template v-if="products">
        <swiper-slide v-for="product in products.data" :key="product.id" >
          <product-item :product="product"/>
        </swiper-slide>
      </template>
      <div class="swiper-button-prev" slot="button-prev"></div>
      <div class="swiper-button-next" slot="button-next"></div>
    </swiper>
  </section>
</template>

<script>
import ProductItem from "./ProductItem";
export default {
  name: "HomepageNewArrivals",
  components: {ProductItem},
  data: function () {
    return {
      products: {
        data: [],
        loading: true
      },
      swiperOptions: {
        slidesPerView: 4,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        breakpoints: {
          1024: {
            slidesPerView: 4,
            spaceBetween: 40
          },
          768: {
            slidesPerView: 3,
            spaceBetween: 20
          },
          640: {
            slidesPerView: 2,
            spaceBetween: 16
          },
          320: {
            slidesPerView: 2,
            spaceBetween: 12
          }
        }
        // Some Swiper option/callback...
      }

    }
  },
  computed: {
    swiper() {
      return this.$refs.mySwiper.$swiper
    }
  },
  mounted () {
    this.getProducts()
  },
  methods: {
    getProducts () {
      this.$axios.get(`/api/v1/products/public/main?limit=8`).then(response => {
        if (response.status === 200) {
          this.products.data = response.data.data
        }
      }).catch(error => {
        let message = ''
        if (error.response) message = error.response.data.message
        else message = error.toString()
        this.$store.dispatch('showSnackbar', {
          value: true,
          message: message,
          type: 'error'
        })
      }).finally(() => this.products.loading = false)

    }
  }
}
</script>

<style scoped>

</style>
