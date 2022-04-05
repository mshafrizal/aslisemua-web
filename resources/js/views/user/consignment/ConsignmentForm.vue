<template>
  <v-form v-model="form.valid" ref="consignmentFormRefs" @submit.prevent="submit">
      <v-text-field
        v-model="form.name"
        label="Your name"
        :rules="[ requiredRules, notBlankRules ]"
        outlined
        dense
        color="black"
      />
      <v-text-field
        v-model="form.email"
        label="Email"
        :rules="[ requiredRules, emailRules ]"
        type="email"
        outlined
        dense
        color="black"
      />
      <v-text-field
        v-model="form.phone"
        label="Phone Number"
        :rules="[ requiredRules, phoneRules ]"
        type="tel"
        outlined
        dense
        color="black"
      />
      <v-text-field
        v-model="form.goods_type"
        label="Goods type"
        :rules="[ requiredRules ]"
        placeholder="Bag, flatshoes, scarf, etc..."
        outlined
        dense
        color="black"
      />
      <v-text-field
        v-model="form.kondisi"
        label="Condition"
        :rules="[ requiredRules ]"
        outlined
        dense
        color="black"
      />
      <v-file-input
        v-model="form.image"
        label="Photos"
        :rules="[ requiredRules ]"
        accept="image/png, image/jpeg, image/bmp"
        outlined
        multiple
        dense
        color="black"
      />
      <v-btn color="black" block class="white--text" type="submit" :loading="form.loading">Submit</v-btn>
  </v-form>
</template>

<script>
export default {
    name: "ConsignmentForm",
    data: function () {
        return {
            form: {
                valid: true,
                loading: false,
                name: "",
                phone: "",
                email: "",
                goods_type: "",
                kondisi: "",
                image: null,
            },
            requiredRules: v => !!v || "This field is required",
            notBlankRules: v => v.trim() !== "" || "This field cannot be blank",
            emailRules: v => /.+@.+\..+/.test(v) || 'E-mail invalid',
            phoneRules: v => /^08[0-9]{9,}$/.test(v) || 'Phone number invalid',
        }
    },
    methods: {
        cancel() {
            this.$emit('cancel')
            this.$refs.consignmentFormRefs.reset()
            this.$refs.consignmentFormRefs.resetValidation()
        },
        submit() {
            this.form.loading = true
            const formData = new FormData()
            formData.append("name", this.form.name)
            formData.append("phone", this.form.phone)
            formData.append("email", this.form.email)
            formData.append("goods_type", this.form.goods_type)
            formData.append("kondisi", this.form.kondisi)
            if (this.form.image) {
              this.form.image.forEach(image => {
                formData.append("images[]", image, image.name)
              });
            }
            this.$axios({
                url: '/api/v1/consignments/public/',
                baseURL: process.env.APP_URL,
                method: "POST",
                data: formData,
                headers: { "Content-Type": "multipart/form-data" },
            })
            .then((response) => {
                if (response.status < 400) {
                  this.$store.dispatch('showSnackbar', {
                      message: "Thank you! Your form has been submitted",
                      color: 'success'
                  })
                  this.$emit("success")
                } else {
                  this.$emit("failed")
                }
            })
            .catch(error => {
                this.$store.dispatch('showSnackbar', {
                    message: error,
                    color: 'error'
                })
            })
            .finally(() => this.form.loading = false)
        }
    }
}       
</script>

<style lang="sss" scoped>

</style>>

</style>                                    