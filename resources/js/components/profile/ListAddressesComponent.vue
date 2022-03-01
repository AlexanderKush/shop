<template>
  <div class="mb-3">
        <label class="form-label">Список адресов</label>
        <div v-for="address in addresses" :key="address.id" class="form-check">
            <input class="form-check-input" type="radio" :id="'address_' + address.id" name="address" :checked="address.main" :value="address.id">
            <label class="form-check-label" :for="'address_' + address.id">{{ address.address }}</label>
        </div>
        <div v-if="!addresses.length">
            Список адресов пуст
        </div>
    </div>
</template>

<script>
    export default {
        props: ['addresses']
    }
</script>

<style scoped>

</style>