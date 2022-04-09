<template>
    <v-card>
        <v-card-title>Add Bank</v-card-title>
        <v-form ref="addBankRef" v-model="form.valid" @submit.prevent="submit">
        <v-card-text>
            <v-text-field label="Bank Name" v-model="form.name" />
            <v-file-input 
                v-model="form.file"
                label="Logo"
                accept="image/png, image/jpeg, image/svg+xml"
                prepend-icon="mdi-camera"
                :rules="rules"
            />
        </v-card-text>
            <v-card-actions>
                <v-btn :disabled="form.loading" @click="cancel" text>Cancel</v-btn>
                <v-btn :disabled="!form.valid" type="submit">Submit</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>

<script>
export default {
    name: "AddBank",
    props: {
        paymentType: {
            type: Object,
            default: null,
        }
    },
    data: function () {
        return {
            form: {
                valid: true,
                loading: false,
                alt_image: "",
                name: "",
                key_name: "",
                payment_type_id: "",
                file: null,
            },
            rules: [
                value => !value || value.size < 1000000 || 'Avatar size should be less than 1 MB!',
            ],
        }
    },
    mounted() {
        this.form.payment_type_id = this.paymentType.id
    },
    methods: {
        cancel() {
            this.$emit('cancel');
            this.$refs.addBankRef.reset();
            this.$refs.addBankRef.resetValidation();
        },
        submit() {
            this.form.loading = true
            this.form.key_name = this.form.name.trim().replace(' ', '-').toLowerCase()
            this.form.alt_image = `Logo ${this.form.name}`
            const formData = new FormData()
            formData.append('payment_type_id', this.paymentType.id)
            formData.append('name', this.form.name)
            formData.append('key_name', this.form.key_name)
            formData.append('alt_image', this.form.alt_image)
            formData.append('file', this.form.file)
            this.$store.dispatch('paymentType/storeBank', formData)
            .then(() => {
                this.$emit("success")
            }).catch(error => {
                this.$store.dispatch('showSnackbar', {
                    message: error,
                    type: 'error'
                })
            })
            .finally(() => this.form.loading = false)
        }
    }
}
</script>

<style>

</style>