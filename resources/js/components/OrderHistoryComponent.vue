<template>
    <div>
        <br>
        <br>
        <h2>История заказов</h2>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>#</th>
                    <th class="w-25">Адрес</th>
                    <th>Товары</th>
                    <th>Дата</th>
                    <th></th>
                </tr>

                <tr v-for="order in orders" :key="order.id">
                    <td>{{ order.id }}</td>
                    <td>{{ order.address }}</td>
                    <td>
                        <ul v-for="product in order.products" :key="product.id">
                            <li>{{ product.name }}</li>
                        </ul>
                    </td>
                    <td>{{ new Date(order.created_at).toLocaleDateString() }} {{ new Date(order.created_at).toLocaleTimeString() }}</td>
                    <td class="text-center">
                        <form method="post" :action="repeatOrder">
                            <input type="hidden" name="_token" :value="csrf">
                            <button type="submit" class="btn btn-primary">
                                <input type="hidden" name="id" :value="order.id">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"></path>
                                    <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"></path>
                                </svg>
                                Повторить заказ
                            </button>
                        </form>
                    </td>
                </tr>

                <tr v-if="!orders.length">
                    <td colspan="3">Список заказов пуст</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                summ: 0,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        props: ['orders', 'repeatOrder'],
        mounted() {
            console.log(this.orders)
        }
    }
</script>

<style scoped>

</style>