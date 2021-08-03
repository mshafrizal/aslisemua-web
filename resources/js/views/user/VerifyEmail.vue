<script>
export default {
  name: "VerifyEmail",
  created () {
    this.verify()
  },
  methods: {
    verify () {
      return this.$axios.put(`/api/v1/customers/verify/${this.$route.params.token}`).then(response => {
        if (response.status === 200) {
          this.$store.dispatch('showSnackbar', {
            value: true,
            message: 'Email verified',
            type: 'success'
          })
          this.$router.push('/login')
        }
      }).catch(error => {
        this.$store.dispatch('showSnackbar', {
          value: true,
          message: error.response.data.message,
          type: 'error'
        })
      })
    }
  }
}
</script>

<style scoped>

</style>
