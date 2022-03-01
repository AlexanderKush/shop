<template>
    <div>
        <h1>{{ pageTitle }}</h1>
        <div class="row">
            <category-component
                v-for="category in categories"
                :key="category.id"
                :category="category"
                :route-category="routeCategory"
                @buttonClicked="buttonClicked"
            >
            </category-component>
        </div>
    </div>
</template>

<script>
    import CategoryComponent from './CategoryComponent.vue'

    export default {
        props: ['test', 'pageTitle', 'categories', 'routeCategory'],
        components: {CategoryComponent},
        mounted() {
            console.log(this.routeCategory)
        },
        methods: {
            buttonClicked(data) {
                console.log('Клик в дочернем компоненте (' + data + ')')
            }
        }
    }
</script>

<style scoped>

</style>