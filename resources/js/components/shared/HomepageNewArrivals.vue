<template>
  <section class="mb-10">
    <h1 v-if="products" class="text-3xl text-center mt-20 mb-10">NEW ARRIVALS</h1>
    <swiper  ref="mySwiper" :options="swiperOptions">
      <template v-if="products">
        <swiper-slide v-for="product in products" :key="product.id" >
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
      products: [
        {
          id: 1,
          products_images: [
            {
              image_path: '/images/dummyProduct/hermes-1.jpg'
            },
            {
              image_path: '/images/dummyProduct/hermes-2.jpg'
            },
            {
              image_path: '/images/dummyProduct/hermes-3.jpg'
            }
          ],
          brand: {
            name: 'Hermes'
          },
          name: 'Tote bag',
          size: 'Large',
          slug: 'tote-bag',
          final_price: 12500000
        },
        {
          id: 2,
          products_images: [
            {
              image_path: '/images/dummyProduct/ysl-1.jpg'
            },
            {
              image_path: '/images/dummyProduct/ysl-2.jpg'
            },
            {
              image_path: '/images/dummyProduct/ysl-3.jpg'
            }
          ],
          brand: {
            name: 'Yves Saint Lauren'
          },
          name: 'Le 5 À 7 Hobo Bag Croco.',
          size: 'Medium',
          slug: 'le-hobo-bag-croco',
          final_price: 22000000
        },
        {
          id: 3,
          products_images: [
            {
              image_path: '/images/dummyProduct/rolex-1.png'
            },
            {
              image_path: '/images/dummyProduct/rolex-2.png'
            },
            {
              image_path: '/images/dummyProduct/rolex-3.jpg'
            }
          ],
          brand: {
            name: 'Rolex'
          },
          name: 'Datejust',
          size: '40mm',
          slug: 'datejust',
          final_price: 105000000
        },
        {
          id: 4,
          products_images: [
            {
              image_path: '/images/dummyProduct/fendi-1.jpg'
            },
            {
              image_path: '/images/dummyProduct/fendi-2.jpg'
            },
            {
              image_path: '/images/dummyProduct/fendi-3.jpg'
            }
          ],
          brand: {
            name: 'Fendi'
          },
          name: 'Roma Clutch Tan',
          size: 'Large',
          slug: 'roma-clutch-tan',
          final_price: 51000000
        },
      ],
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
    // this.getProducts()
  },
  methods: {
    getProducts () {
      this.$axios.get(`${process.env.MIX_APP_URL}/api/v1/products/public/main?limit=8`).then(response => {
        console.log('getproducts', response)
        if (response.status === 200) {
          this.products = response.data
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
      })

    }
  }
}
</script>

<style scoped>

</style>
